<?php

namespace App\Imports;

use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class LeaveSheetImport implements ToCollection
{
    /**
     * Nama sheet yang sedang diproses.
     * Penting karena CT 2026 punya struktur kolom yang berbeda dari CT 2024/2025.
     */
    private string $sheetName;

    /**
     * Mapping jenis cuti: teks bebas → nilai canonical di DB.
     */
    private const JENIS_MAP = [
        'cuti tahunan'        => 'Cuti Tahunan',
        'tahunan'             => 'Cuti Tahunan',
        'ct'                  => 'Cuti Tahunan',
        'cuti besar'          => 'Cuti Besar',
        'haji'                => 'Cuti Besar',
        'cuti sakit'          => 'Cuti Sakit',
        'sakit'               => 'Cuti Sakit',
        'cuti melahirkan'     => 'Cuti Melahirkan',
        'melahirkan'          => 'Cuti Melahirkan',
        'cuti alasan penting' => 'Cuti Karena Alasan Penting',
        'alasan penting'      => 'Cuti Karena Alasan Penting',
    ];

    /**
     * Mapping nama bulan Indonesia + singkatan 3 huruf → English.
     * Diurutkan dari terpanjang agar "desember" diproses sebelum "des".
     */
    private const BULAN_MAP = [
        // Nama penuh
        'januari'   => 'January',
        'februari'  => 'February',
        'maret'     => 'March',
        'april'     => 'April',
        'mei'       => 'May',
        'juni'      => 'June',
        'juli'      => 'July',
        'agustus'   => 'August',
        'september' => 'September',
        'oktober'   => 'October',
        'november'  => 'November',
        'desember'  => 'December',
        // Singkatan 3 huruf (ditemukan di CT 2024: Des, Okt, Jul, dll.)
        'jan'       => 'January',
        'feb'       => 'February',
        'mar'       => 'March',
        'apr'       => 'April',
        'jun'       => 'June',
        'jul'       => 'July',
        'agu'       => 'August',
        'sep'       => 'September',
        'okt'       => 'October',
        'nov'       => 'November',
        'des'       => 'December',
    ];

    public function __construct(string $sheetName)
    {
        $this->sheetName = $sheetName;
    }

    public function collection(Collection $rows)
    {
        if ($this->sheetName === 'CT 2026') {
            $this->importCT2026($rows);
        } else {
            $this->importCT2024Or2025($rows);
        }
    }

    // =========================================================================
    // CT 2024 & CT 2025
    //
    // Struktur kolom (0-indexed):
    //   [0]  No
    //   [1]  Tanggal Usul Cuti
    //   [2]  Nama
    //   [3]  NIP
    //   [4]  Unit Kerja/Bidang
    //   [5]  Alasan Cuti
    //   [6]  Jenis Cuti
    //   [7]  Tanggal Mulai Cuti
    //   [8]  Tanggal Akhir Cuti
    //   [9]  Lamanya cuti (hari)
    //   [10] Sisa Cuti Tahunan
    //   [11] Keterangan
    //
    // Header ada di Row[5], data mulai Row[6] → skip(6)
    // =========================================================================
    private function importCT2024Or2025(Collection $rows): void
    {
        foreach ($rows->skip(6) as $row) {
            if (empty($row[3])) {
                continue;
            }

            $nip  = $this->normalizeNip($row[3]);
            $user = User::where('nip', $nip)->first();

            if (!$user) {
                logger()->warning("[{$this->sheetName}] User tidak ditemukan", [
                    'nip'  => $nip,
                    'nama' => $row[2] ?? '-',
                ]);
                continue;
            }

            $jenisCuti   = $this->resolveJenisCuti($row[6]);
            $tanggalUsul = $this->parseFirstDate($row[1]);
            $duration    = is_numeric($row[9]) ? (int) $row[9] : 0;
            $startDates  = $this->parseDates($row[7]);
            $endDates    = $this->parseDates($row[8]);

            if (empty($startDates)) {
                logger()->warning("[{$this->sheetName}] Tanggal tidak dapat diparse", [
                    'nip'       => $nip,
                    'raw_start' => $row[7],
                    'raw_end'   => $row[8],
                ]);
                continue;
            }

            // Multiple dates dalam satu cell → tiap tanggal jadi 1 LeaveRequest (durasi=1)
            if (count($startDates) > 1) {
                foreach ($startDates as $singleDate) {
                    $this->createLeaveRequest(
                        $user, $jenisCuti, $singleDate, $singleDate, 1, $row[5], $tanggalUsul
                    );
                }
            } else {
                $startDate = $startDates[0];
                $endDate   = !empty($endDates) ? $endDates[0] : $startDate;
                $this->createLeaveRequest(
                    $user, $jenisCuti, $startDate, $endDate, $duration, $row[5], $tanggalUsul
                );
            }
        }
    }

    // =========================================================================
    // CT 2026
    //
    // Struktur kolom (0-indexed) — BERBEDA dari CT 2024/2025:
    //   [0]  NO
    //   [1]  Tanggal Usul Cuti
    //   [2]  Nama
    //   [3]  NIP
    //   [4]  Jabatan
    //   [5]  Masa Kerja
    //   [6]  Jenis Cuti          ← ada di sini (tidak seperti file sebelumnya)
    //   [7]  Alasan Cuti
    //   [8]  Tanggal Awal Cuti   ← geser 1 kolom dibanding CT 2024/2025
    //   [9]  Tanggal Akhir Cuti  ← geser 1 kolom dibanding CT 2024/2025
    //   [10] Jumlah cuti
    //   [11] Sisa Cuti
    //   [12] Alamat Menjalankan cuti
    //   [13] Nomor TLP
    //   [14] Nama Bidang
    //   [15] Atasan Langsung
    //   [16] NIP Atasan Langsung
    //
    // Header ada di Row[1], data mulai Row[2] → skip(2)
    // =========================================================================
    private function importCT2026(Collection $rows): void
    {
        foreach ($rows->skip(2) as $row) {
            if (empty($row[3])) {
                continue;
            }

            $nip  = $this->normalizeNip($row[3]);
            $user = User::where('nip', $nip)->first();

            if (!$user) {
                logger()->warning("[{$this->sheetName}] User tidak ditemukan", [
                    'nip'  => $nip,
                    'nama' => $row[2] ?? '-',
                ]);
                continue;
            }

            $jenisCuti   = $this->resolveJenisCuti($row[6]);
            $tanggalUsul = $this->parseFirstDate($row[1]);
            $duration    = is_numeric($row[10]) ? (int) $row[10] : 0;
            $startDates  = $this->parseDates($row[8]);
            $endDates    = $this->parseDates($row[9]);

            if (empty($startDates)) {
                logger()->warning("[{$this->sheetName}] Tanggal tidak dapat diparse", [
                    'nip'       => $nip,
                    'raw_start' => $row[8],
                    'raw_end'   => $row[9],
                ]);
                continue;
            }

            if (count($startDates) > 1) {
                foreach ($startDates as $singleDate) {
                    $this->createLeaveRequest(
                        $user, $jenisCuti, $singleDate, $singleDate, 1, $row[7], $tanggalUsul
                    );
                }
            } else {
                $startDate = $startDates[0];
                $endDate   = !empty($endDates) ? $endDates[0] : $startDate;
                $this->createLeaveRequest(
                    $user, $jenisCuti, $startDate, $endDate, $duration, $row[7], $tanggalUsul
                );
            }
        }
    }

    // =========================================================================
    // Buat satu LeaveRequest dan recalculate balance
    // =========================================================================
    private function createLeaveRequest(
        User    $user,
        string  $jenisCuti,
        string  $startDate,
        string  $endDate,
        int     $duration,
        mixed   $reasonRaw,
        ?string $tanggalUsul
    ): void {
        $now = $tanggalUsul ?? now()->toDateString();

        LeaveRequest::create([
            'user_id'       => $user->id,
            'supervisor_id' => null,
            'jenis_cuti'    => $jenisCuti,
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'duration'      => $duration,
            'reason'        => trim((string) ($reasonRaw ?? '')),
            'status'        => LeaveRequest::STATUS_APPROVED,
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);

        LeaveBalance::recalculateAnnualBalances($user->id, Carbon::parse($startDate)->year);

        logger()->info("[{$this->sheetName}] Leave request dibuat", [
            'user_id'    => $user->id,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'duration'   => $duration,
        ]);
    }

    // =========================================================================
    // Normalisasi NIP: hapus semua karakter non-digit dan spasi
    // =========================================================================
    private function normalizeNip(mixed $raw): string
    {
        return preg_replace('/[^0-9]/', '', (string) $raw);
    }

    // =========================================================================
    // Resolve jenis cuti dari teks bebas ke nilai canonical
    // =========================================================================
    private function resolveJenisCuti(mixed $raw): string
    {
        $key = strtolower(trim((string) ($raw ?? '')));
        return self::JENIS_MAP[$key] ?? ucwords($key);
    }

    // =========================================================================
    // parseDates: mengembalikan ARRAY tanggal dalam format 'Y-m-d'
    //
    // Format yang ditangani (semua ditemukan di data nyata):
    //   1. datetime object (dari PhpSpreadsheet/openpyxl)
    //   2. Numeric Excel serial date
    //   3. "07 , 13 , 20 Januari 2025"  → multiple dates koma-spasi
    //   4. "2,6,7,22 Oktober 2025"       → multiple dates koma tanpa spasi
    //   5. "05Juni 2025"                 → spasi hilang antara angka & bulan
    //   6. "05 Des 2024"                 → singkatan bulan 3 huruf
    //   7. "5 januari 2024"              → semua lowercase
    //   8. "'13 Mei 2026"                → leading apostrophe (Excel text-prefix)
    //   9. Formula "=..."                → diabaikan, return []
    // =========================================================================
    private function parseDates(mixed $raw): array
    {
        if (empty($raw)) {
            return [];
        }

        // datetime object (sudah diparse PhpSpreadsheet)
        if ($raw instanceof \DateTimeInterface) {
            return [$raw->format('Y-m-d')];
        }

        // Numeric Excel serial date
        if (is_numeric($raw)) {
            try {
                $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $raw);
                return [$dt->format('Y-m-d')];
            } catch (\Throwable) {
                return [];
            }
        }

        $s = trim((string) $raw);

        if (empty($s) || str_starts_with($s, '=')) {
            return [];
        }

        // Hapus leading apostrophe: "'13 Mei 2026" → "13 Mei 2026"
        // Ini artifact dari Excel saat cell diformat sebagai teks dengan prefix '
        $s = ltrim($s, "'");

        // Lowercase untuk normalisasi konsisten
        $s = mb_strtolower(trim($s));

        // Fix spasi hilang antara angka & huruf: "05Juni" → "05 Juni"
        $s = preg_replace('/(\d)([a-z])/i', '$1 $2', $s);

        // Ganti nama bulan Indonesia → English
        // Urutan dari terpanjang mencegah "des" menimpa bagian dari "desember"
        $bulanSorted = collect(self::BULAN_MAP)
            ->sortKeysDesc()
            ->keys()
            ->sortByDesc(fn($k) => strlen($k));

        foreach ($bulanSorted as $idMonth) {
            $enMonth = self::BULAN_MAP[$idMonth];
            $s = preg_replace('/\b' . preg_quote($idMonth, '/') . '\b/', $enMonth, $s);
        }

        // Multiple dates: "7 , 13 , 20 January 2025" atau "2,6,7,22 October 2025"
        if (preg_match('/^([\d\s,]+)\s+([A-Za-z]+)\s+(\d{4})$/', trim($s), $m)) {
            $month = ucfirst(strtolower($m[2]));
            $year  = $m[3];
            preg_match_all('/\d+/', $m[1], $dayMatches);

            $results = [];
            foreach ($dayMatches[0] as $day) {
                try {
                    $dt = \DateTime::createFromFormat('d F Y', sprintf('%02d %s %s', (int)$day, $month, $year));
                    if ($dt) {
                        $results[] = $dt->format('Y-m-d');
                    }
                } catch (\Throwable) {
                    // skip hari yang tidak valid
                }
            }
            if (!empty($results)) {
                return $results;
            }
        }

        // Single date — coba beberapa format
        $sTitled = implode(' ', array_map('ucfirst', explode(' ', trim($s))));
        foreach (['d F Y', 'j F Y'] as $fmt) {
            $dt = \DateTime::createFromFormat($fmt, $sTitled);
            if ($dt && $dt->format('Y') > 2000) {
                return [$dt->format('Y-m-d')];
            }
        }

        logger()->warning("[{$this->sheetName}] Format tanggal tidak dikenali", [
            'raw'        => $raw,
            'normalized' => $s,
        ]);
        return [];
    }

    // =========================================================================
    // parseFirstDate: ambil satu tanggal pertama saja (untuk Tanggal Usul Cuti)
    // =========================================================================
    private function parseFirstDate(mixed $raw): ?string
    {
        return $this->parseDates($raw)[0] ?? null;
    }
}
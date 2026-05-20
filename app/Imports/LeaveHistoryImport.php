<?php

namespace App\Imports;

use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class LeaveHistoryImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->skip(2) as $row) {

            // Skip jika NIP kosong
            if (empty($row[3])) {
                continue;
            }

            $nip = trim((string) $row[3]);

            $user = User::where('nip', $nip)->first();

            // Skip jika user tidak ditemukan
            if (!$user) {

                logger()->warning('User tidak ditemukan', [
                    'nip' => $nip
                ]);

                continue;
            }

            try {

                $jenisCuti = trim((string) $row[6]);

                $startDate = $this->parseIndonesianDate($row[8]);
                $endDate   = $this->parseIndonesianDate($row[9]);
                $tanggalUsul = $this->parseIndonesianDate($row[1]);

                $duration = (int) $row[10];

                // Cegah duplicate
                $exists = LeaveRequest::where('user_id', $user->id)
                    ->where('jenis_cuti', $jenisCuti)
                    ->where('start_date', $startDate)
                    ->where('end_date', $endDate)
                    ->exists();

                if ($exists) {
                    continue;
                }

                LeaveRequest::create([
                    'user_id'       => $user->id,
                    'supervisor_id' => null,

                    'jenis_cuti'    => $jenisCuti,

                    'start_date'    => $startDate,
                    'end_date'      => $endDate,

                    'duration'      => $duration,

                    'reason'        => trim((string) $row[7]),

                    'address'       => $row[12] ?? null,
                    'phone'         => $this->sanitizePhone($row[13] ?? null),

                    'notes'         => 'Import histori cuti lama',

                    'status'        => LeaveRequest::STATUS_APPROVED,

                    'created_at'    => $tanggalUsul,
                    'updated_at'    => $tanggalUsul,
                ]);

                // Recalculate hanya untuk cuti tahunan
                if ($jenisCuti === LeaveRequest::JENIS_TAHUNAN) {

                    LeaveBalance::recalculateAnnualBalances(
                        $user->id,
                        Carbon::parse($startDate)->year
                    );
                }

            } catch (\Throwable $e) {

                logger()->error('Import gagal', [
                    'nip' => $nip,
                    'error' => $e->getMessage(),
                ]);

                continue;
            }
        }
    }

    private function sanitizePhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        return preg_replace('/[^0-9]/', '', $phone);
    }

    private function parseIndonesianDate($date): string
    {
        $bulan = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        $date = strtr((string) $date, $bulan);

        return Carbon::parse($date)->format('Y-m-d');
    }
}
<?php

namespace App\Console\Commands;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FixZeroDuration extends Command
{
    protected $signature   = 'cuti:fix-duration
                                {--dry-run : Tampilkan preview tanpa ubah data}
                                {--id=    : Fix satu record spesifik berdasarkan ID}';

    protected $description = 'Fix duration = 0 atau null pada Cuti Melahirkan dan Cuti Sakit';

    // Cache hari libur per tahun agar tidak fetch berulang
    private array $holidayCache = [];

    // Jenis cuti yang akan diperbaiki
    private const JENIS_TARGET = ['Cuti Melahirkan', 'Cuti Sakit'];

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        $specificId = $this->option('id');

        if ($isDryRun) {
            $this->warn('⚠  DRY RUN — tidak ada data yang diubah.');
        }

        // Build query
        $query = LeaveRequest::query()
            ->whereIn('jenis_cuti', self::JENIS_TARGET)
            ->where(fn ($q) => $q->whereNull('duration')->orWhere('duration', 0))
            ->whereNotNull('start_date')
            ->whereNotNull('end_date');

        if ($specificId) {
            $query->where('id', $specificId);
        }

        $records = $query->orderBy('start_date')->get();

        if ($records->isEmpty()) {
            $this->info(' Tidak ada data yang perlu diperbaiki.');
            return self::SUCCESS;
        }

        $this->info("Ditemukan {$records->count()} record dengan duration kosong.\n");

        // Tabel preview
        $this->table(
            ['ID', 'Nama (user_id)', 'Jenis', 'Mulai', 'Selesai', 'Duration Lama', 'Duration Baru'],
            $records->map(fn ($r) => [
                $r->id,
                $r->user_id,
                $r->jenis_cuti,
                $r->start_date->format('d/m/Y'),
                Carbon::parse($r->end_date)->format('d/m/Y'),
                $r->duration ?? 'null',
                $this->countWorkDays(
                    Carbon::instance($r->start_date),
                    Carbon::instance(Carbon::parse($r->end_date))
                ),
            ])
        );

        if ($isDryRun) {
            $this->warn('DRY RUN selesai. Jalankan tanpa --dry-run untuk terapkan perubahan.');
            return self::SUCCESS;
        }

        if (!$this->confirm("Lanjutkan update {$records->count()} record?", true)) {
            $this->info('Dibatalkan.');
            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($records->count());
        $bar->start();

        $fixed   = 0;
        $skipped = 0;

        foreach ($records as $record) {
            $start = Carbon::instance($record->start_date);
            $end   = Carbon::instance(Carbon::parse($record->end_date));

            if ($end->lt($start)) {
                $this->newLine();
                $this->warn("  Skip ID {$record->id}: end_date lebih awal dari start_date.");
                $skipped++;
                $bar->advance();
                continue;
            }

            $workDays = $this->countWorkDays($start, $end);

            $record->duration = $workDays;
            $record->saveQuietly(); // Tidak trigger observer/event

            $fixed++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info(" Selesai: {$fixed} record diperbarui, {$skipped} dilewati.");

        return self::SUCCESS;
    }

    // =========================================================================
    // HITUNG HARI KERJA (skip Sabtu, Minggu, libur nasional)
    // =========================================================================

    private function countWorkDays(\DateTimeInterface $start, \DateTimeInterface $end): int
    {
        $workDays = 0;
        $cursor   = Carbon::instance($start)->startOfDay();
        $finish   = Carbon::instance($end)->startOfDay();

        // Ambil hari libur untuk semua tahun dalam rentang
        $years = range($cursor->year, $finish->year);
        foreach ($years as $year) {
            $this->loadHolidays($year);
        }

        while ($cursor->lte($finish)) {
            if ($this->isWorkDay($cursor)) {
                $workDays++;
            }
            $cursor->addDay();
        }

        return $workDays;
    }

    private function isWorkDay(Carbon $date): bool
    {
        if ($date->isSaturday() || $date->isSunday()) {
            return false;
        }

        $key = $date->toDateString();
        if (isset($this->holidayCache[$date->year])
            && in_array($key, $this->holidayCache[$date->year], true)) {
            return false;
        }

        return true;
    }

    private function loadHolidays(int $year): void
    {
        if (isset($this->holidayCache[$year])) {
            return; // Sudah di-cache
        }

        $this->holidayCache[$year] = []; // Default kosong jika gagal

        try {
            $response = Http::timeout(10)
                ->get("https://api-hari-libur.vercel.app/api", ['year' => $year]);

            if ($response->successful()) {
                $json = $response->json();
                // Response: { data: [ { date: "YYYY-MM-DD" }, ... ] }
                $dates = collect($json['data'] ?? $json)
                    ->pluck('date')
                    ->filter()
                    ->values()
                    ->toArray();

                $this->holidayCache[$year] = $dates;
                $this->line("  Loaded {$year}: " . count($dates) . " hari libur", null, 'v');
            }
        } catch (\Throwable $e) {
            $this->warn("  Gagal fetch hari libur {$year}: {$e->getMessage()}. Hanya skip Sabtu/Minggu.");
        }
    }
}
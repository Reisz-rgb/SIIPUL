<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanUnitKerja extends Command
{
    protected $signature   = 'unit:clean
                                {--dry-run : Preview tanpa mengubah data}
                                {--auto   : Otomatis pilih nama terpanjang sebagai canonical}';

    protected $description = 'Bersihkan duplikat dan typo pada bidang_unit (users) dan unit_kerja (supervisors)';

    // Kolom yang akan dibersihkan: [tabel => kolom]
    private const TARGETS = [
        'users'       => 'bidang_unit',
        'supervisors' => 'unit_kerja',
    ];

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        $isAuto   = $this->option('auto');

        if ($isDryRun) {
            $this->warn('⚠  DRY RUN — tidak ada data yang diubah.');
        }

        // =====================================================================
        // 1. Kumpulkan semua nilai unik dari semua tabel target
        // =====================================================================
        $allValues = collect();

        foreach (self::TARGETS as $table => $column) {
            $values = DB::table($table)
                ->whereNotNull($column)
                ->where($column, '!=', '')
                ->distinct()
                ->pluck($column);

            $allValues = $allValues->merge($values);
        }

        $allValues = $allValues->unique()->sort()->values();

        $this->info("\nTotal nilai unik ditemukan: {$allValues->count()}");
        $this->line(str_repeat('─', 60));

        // =====================================================================
        // 2. Deteksi duplikat — dua metode:
        //    a) Exact match setelah normalisasi (spasi, case)
        //    b) Fuzzy match: similarity >= 85% untuk tangkap typo karakter
        // =====================================================================
        $groups = [];

        foreach ($allValues as $val) {
            $normalized = $this->normalize($val);
            $groups[$normalized][] = $val;
        }

        // a) Grup exact-normalized
        $duplicates = array_filter($groups, fn ($g) => count($g) > 1);

        // b) Fuzzy: bandingkan semua pasangan nilai unik
        $uniqueVals  = $allValues->values()->toArray();
        $fuzzyGroups = [];
        $merged      = [];  // track nilai yang sudah digabung

        foreach ($uniqueVals as $i => $a) {
            if (in_array($a, $merged, true)) continue;

            $group = [$a];

            foreach ($uniqueVals as $j => $b) {
                if ($i === $j || in_array($b, $merged, true)) continue;

                // Hitung similarity (0-100)
                similar_text(
                    $this->normalize($a),
                    $this->normalize($b),
                    $pct
                );

                // Threshold 80%: cukup ketat untuk hindari false positive
                // tapi cukup longgar untuk tangkap typo 1-2 karakter
                if ($pct >= 80.0) {
                    $group[] = $b;
                    $merged[] = $b;
                }
            }

            if (count($group) > 1) {
                $key = $this->normalize($a);
                // Jangan duplikat dengan grup exact yang sudah ada
                if (!isset($duplicates[$key])) {
                    $fuzzyGroups[$key] = $group;
                }
                $merged[] = $a;
            }
        }

        // Gabungkan kedua hasil
        $duplicates = array_merge($duplicates, $fuzzyGroups);

        // =====================================================================
        // 3. Untuk setiap grup, tanya admin mana yang jadi canonical
        // =====================================================================
        $replacementMap = []; // ['nilai lama' => 'nilai canonical']

        foreach ($duplicates as $normalized => $variants) {
            $this->line('┌─ Grup: <fg=yellow>' . $normalized . '</>');
            foreach ($variants as $i => $v) {
                // Hitung berapa record pakai varian ini
                $count = $this->countUsage($v);
                $this->line("│  [{$i}] \"{$v}\" <fg=gray>({$count} record)</>");
            }
            $this->line('└' . str_repeat('─', 58));

            // Pilih canonical otomatis (nama terpanjang) atau tanya user
            if ($isAuto) {
                $canonical = collect($variants)->sortByDesc(fn ($v) => strlen($v))->first();
                $this->info("   → Auto-pilih: \"{$canonical}\"");
            } else {
                $choices   = array_values($variants);
                $choices[] = '[Skip grup ini]';

                $canonical = $this->choice(
                    '   Pilih nama yang BENAR sebagai standar:',
                    $choices,
                    0
                );

                if ($canonical === '[Skip grup ini]') {
                    $this->line("   ⏭  Dilewati.\n");
                    continue;
                }
            }

            // Daftarkan semua varian lain → canonical
            foreach ($variants as $variant) {
                if ($variant !== $canonical) {
                    $replacementMap[$variant] = $canonical;
                }
            }

            $this->newLine();
        }

        if (empty($replacementMap)) {
            $this->info('Tidak ada yang perlu diubah.');
            return self::SUCCESS;
        }

        // =====================================================================
        // 4. Preview semua perubahan
        // =====================================================================
        $this->line("\n" . str_repeat('═', 60));
        $this->info('RINGKASAN PERUBAHAN:');
        $this->line(str_repeat('═', 60));

        $tableRows = [];
        foreach ($replacementMap as $old => $new) {
            $count = $this->countUsage($old);
            $tableRows[] = [$old, '→', $new, "{$count} record"];
        }

        $this->table(['Nilai Lama', '', 'Canonical', 'Record Terdampak'], $tableRows);

        if ($isDryRun) {
            $this->warn('DRY RUN selesai. Jalankan tanpa --dry-run untuk terapkan.');
            return self::SUCCESS;
        }

        if (!$this->confirm('Terapkan semua perubahan di atas?', true)) {
            $this->info('Dibatalkan.');
            return self::SUCCESS;
        }

        // =====================================================================
        // 5. Terapkan perubahan
        // =====================================================================
        DB::transaction(function () use ($replacementMap) {
            $bar = $this->output->createProgressBar(
                count($replacementMap) * count(self::TARGETS)
            );
            $bar->start();

            foreach (self::TARGETS as $table => $column) {
                foreach ($replacementMap as $old => $canonical) {
                    DB::table($table)
                        ->where($column, $old)
                        ->update([$column => $canonical]);

                    $bar->advance();
                }
            }

            $bar->finish();
        });

        $this->newLine(2);
        $this->info(' Selesai! ' . count($replacementMap) . ' nilai berhasil distandarisasi.');

        // =====================================================================
        // 6. Laporan akhir — nilai unik setelah cleanup
        // =====================================================================
        $this->newLine();
        $this->line('Nilai bidang_unit yang tersisa di tabel users:');

        $remaining = DB::table('users')
            ->whereNotNull('bidang_unit')
            ->where('bidang_unit', '!=', '')
            ->distinct()
            ->orderBy('bidang_unit')
            ->pluck('bidang_unit');

        foreach ($remaining as $val) {
            $count = DB::table('users')->where('bidang_unit', $val)->count();
            $this->line("  • {$val} <fg=gray>({$count} pegawai)</>");
        }

        return self::SUCCESS;
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    /**
     * Normalisasi untuk deteksi duplikat:
     * lowercase + trim + kolaps spasi ganda + hapus tanda baca trailing
     */
    private function normalize(string $value): string
    {
        $v = mb_strtolower(trim($value));
        $v = preg_replace('/\s+/', ' ', $v);       // spasi ganda → satu
        $v = rtrim($v, '.,;:-');                    // hapus tanda baca di akhir
        return $v;
    }

    /**
     * Hitung total record yang pakai nilai ini di semua tabel target.
     */
    private function countUsage(string $value): int
    {
        $total = 0;
        foreach (self::TARGETS as $table => $column) {
            $total += DB::table($table)->where($column, $value)->count();
        }
        return $total;
    }
}
<?php
// app/Console/Commands/UpdateJoinDateFromNIP.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class UpdateJoinDateFromNIP extends Command
{
    protected $signature = 'user:update-join-date';
    protected $description = 'Update join_date dari NIP pegawai (multi format)';

    public function handle()
    {
        $this->info('Memulai update join_date dari NIP...');
        
        $users = User::whereNotNull('nip')
                     ->where('nip', '!=', '')
                     ->get();
        
        $updated = 0;
        $skipped = 0;
        $errors = [];

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $nip = str_replace(' ', '', $user->nip);
            $joinDate = $this->extractJoinDate($nip);
            
            if ($joinDate) {
                try {
                    $user->update(['join_date' => $joinDate]);
                    $updated++;
                } catch (\Exception $e) {
                    $skipped++;
                    $errors[] = "ID {$user->id}: Gagal update - {$e->getMessage()}";
                }
            } else {
                $skipped++;
                $errors[] = "ID {$user->id}: Format NIP tidak dikenali - [{$user->nip}] (length: " . strlen($nip) . ")";
            }

            $bar->advance();
        }

        $bar->finish();
        
        $this->newLine(2);
        $this->info("✅ Selesai!");
        $this->info("📊 Total: {$users->count()} | ✅ Update: $updated | ⏭️ Skip: $skipped");

        if (!empty($errors)) {
            $this->newLine();
            $this->warn("⚠️ Detail NIP yang tidak bisa diproses:");
            
            // Tampilkan maksimal 20 error
            $displayErrors = array_slice($errors, 0, 20);
            foreach ($displayErrors as $error) {
                $this->line("  - $error");
            }
            
            if (count($errors) > 20) {
                $this->line("  ... dan " . (count($errors) - 20) . " lainnya");
            }
            
            // Simpan ke file log
            $logContent = implode("\n", $errors);
            $logPath = storage_path('logs/nip_errors_' . date('Y-m-d_His') . '.txt');
            file_put_contents($logPath, $logContent);
            $this->info("📝 Error log lengkap disimpan di: $logPath");
        }
    }

    /**
     * Extract join date dari berbagai format NIP
     */
    private function extractJoinDate($nip)
    {
        $length = strlen($nip);
        
        // Format 1: NIP 18 digit (standar PNS)
        // Struktur: [8 digit tgl lahir][6 digit TMT YYYYMM][1 digit JK][3 digit urut]
        // Contoh: 197303231998021003
        if ($length == 18) {
            $tmt = substr($nip, 8, 6);
            $result = $this->parseTMT($tmt);
            if ($result) return $result;
        }
        
        // Format 2: NIP 22 digit (PPPK/format baru dengan tahun kontrak)
        // Struktur: [8 digit tgl lahir][4 digit tahun][2 digit kode?][2 digit kode?][2 digit tahun kontrak][4 digit?]
        // Contoh: 199607052023212025
        //          ^^^^^^^^ ^^^^ ^^ ^^ ^^^^
        //          tgl lahir thn kd kd thn kontrak
        if ($length == 22) {
            // Ambil tahun dari digit 8-11
            $tahun = (int) substr($nip, 8, 4);
            
            if ($tahun >= 1945 && $tahun <= (int) date('Y')) {
                // Set ke 1 Januari tahun tersebut
                return Carbon::createFromDate($tahun, 1, 1);
            }
        }
        
        // Format 3: NIP 20-21 digit
        if ($length >= 20 && $length <= 21) {
            $tahun = (int) substr($nip, 8, 4);
            
            if ($tahun >= 1945 && $tahun <= (int) date('Y')) {
                return Carbon::createFromDate($tahun, 1, 1);
            }
        }
        
        // Format 4: NIP 14-17 digit (variasi lainnya)
        if ($length >= 14 && $length <= 19) {
            // Coba beberapa posisi untuk TMT (6 digit: YYYYMM)
            for ($i = 8; $i <= $length - 6; $i++) {
                $tmt = substr($nip, $i, 6);
                $result = $this->parseTMT($tmt);
                if ($result) return $result;
            }
            
            // Fallback: ambil 4 digit tahun dari posisi 8-11
            if ($length >= 12) {
                $tahun = (int) substr($nip, 8, 4);
                if ($tahun >= 1945 && $tahun <= (int) date('Y')) {
                    return Carbon::createFromDate($tahun, 1, 1);
                }
            }
        }
        
        return null;
    }

    /**
     * Parse string TMT (YYYYMM) menjadi Carbon date
     */
    private function parseTMT($tmt)
    {
        if (strlen($tmt) != 6) {
            return null;
        }
        
        $tahun = (int) substr($tmt, 0, 4);
        $bulan = (int) substr($tmt, 4, 2);
        
        // Validasi tahun
        if ($tahun < 1945 || $tahun > (int) date('Y')) {
            return null;
        }
        
        // Validasi bulan
        if ($bulan < 1 || $bulan > 12) {
            return null;
        }
        
        return Carbon::createFromDate($tahun, $bulan, 1);
    }
}
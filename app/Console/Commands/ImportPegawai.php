<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\PegawaiImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

class ImportPegawai extends Command
{
    protected $signature = 'import:pegawai {file}';
    protected $description = 'Import data pegawai dari file Excel';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: {$file}");
            return 1;
        }

        $this->info('Memulai import pegawai...');
        $this->info('File: ' . $file);
        
        $countBefore = User::count();
        
        try {
            Excel::import(new PegawaiImport, $file);
            
            $countAfter = User::count();
            $imported = $countAfter - $countBefore;
            
            $this->info("Import selesai!");
            $this->info("Total pegawai sebelumnya: {$countBefore}");
            $this->info("Total pegawai sekarang: {$countAfter}");
            $this->info("Pegawai baru diimpor: {$imported}");
            
        } catch (\Exception $e) {
            $this->error('Error saat import: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
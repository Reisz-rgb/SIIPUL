<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TruncateUsers extends Command
{
    protected $signature = 'users:truncate';
    protected $description = 'Truncate users table (with foreign key handling)';

    public function handle()
    {
        if (!$this->confirm('Apakah Anda yakin ingin menghapus SEMUA data user?')) {
            $this->info('Dibatalkan.');
            return 0;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::table('cuti')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('✓ Semua user berhasil dihapus!');
        return 0;
    }
}
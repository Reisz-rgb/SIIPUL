<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeaveHistoryImport;

class ImportLeaveHistory extends Command
{
    protected $signature = 'import:leave-history {file}';

    protected $description = 'Import riwayat cuti dari Excel';

    public function handle()
    {
        $file = $this->argument('file');

        Excel::import(new LeaveHistoryImport, $file);

        $this->info('Import selesai.');
    }
}
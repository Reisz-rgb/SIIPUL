<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\LeaveBalance;
use Illuminate\Console\Command;

class RecalculateLeaveBalances extends Command
{
    protected $signature = 'leave:recalculate
                            {--years=2024,2025,2026 : Tahun yang akan di-recalculate, pisahkan dengan koma}
                            {--user= : ID user tertentu (opsional, default semua user)}';

    protected $description = 'Recalculate leave balances untuk semua user di tahun yang ditentukan';

    public function handle(): int
    {
        $years   = array_map('intval', explode(',', $this->option('years')));
        $userId  = $this->option('user');

        $users = $userId
            ? User::where('id', $userId)->get()
            : User::all();

        if ($users->isEmpty()) {
            $this->error('Tidak ada user ditemukan.');
            return self::FAILURE;
        }

        $this->info("Recalculate leave balances untuk {$users->count()} user, tahun: " . implode(', ', $years));
        $this->newLine();

        $bar = $this->output->createProgressBar($users->count() * count($years));
        $bar->start();

        $successCount = 0;
        $failCount    = 0;

        foreach ($users as $user) {
            foreach ($years as $year) {
                try {
                    LeaveBalance::recalculateAnnualBalances($user->id, $year);
                    $successCount++;
                } catch (\Throwable $e) {
                    $failCount++;
                    $this->newLine();
                    $this->error("Gagal — user_id={$user->id} ({$user->name}), tahun={$year}: {$e->getMessage()}");
                }
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Selesai. Berhasil: {$successCount}, Gagal: {$failCount}.");

        return $failCount === 0 ? self::SUCCESS : self::FAILURE;
    }
}
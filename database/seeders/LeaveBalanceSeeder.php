<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LeaveBalance;

class LeaveBalanceSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = now()->year;
        
        // Ambil semua user yang bukan admin
        $users = User::where('role', 'user')->get();
        
        foreach ($users as $user) {
            // Buat balance untuk N-2, N-1, N
            for ($i = 2; $i >= 0; $i--) {
                $year = $currentYear - $i;
                
                LeaveBalance::updateOrCreate(
                    ['user_id' => $user->id, 'year' => $year],
                    [
                        'quota' => 12,
                        'used' => 0,
                        'remaining' => 12,
                    ]
                );
            }
        }
        
        $this->command->info('Leave balances seeded successfully!');
    }
}
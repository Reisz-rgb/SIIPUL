<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'year',
        'quota',
        'used',
        'remaining',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================================
    // CORE: GET OR CREATE
    // =========================================================================

    public static function getOrCreateBalance(int $userId, int $year): self
    {
        return self::firstOrCreate(
            ['user_id' => $userId, 'year' => $year],
            ['quota' => 12, 'used' => 0, 'remaining' => 12]
        );
    }

    // =========================================================================
    // CORE: HITUNG TOTAL TERSEDIA
    //
    // Aturan bonus:
    //   - Bonus hanya diberikan jika KEDUA tahun (n-2 DAN n-1) used == 0
    //   - Jika salah satu saja pernah cuti → tidak ada bonus sama sekali
    //   - Besar bonus = floor(remaining_n2 / 2) + floor(remaining_n1 / 2)
    // =========================================================================

    public static function calculateTotalAvailable(int $userId, int $currentYear): array
    {
        $n2 = self::getOrCreateBalance($userId, $currentYear - 2);
        $n1 = self::getOrCreateBalance($userId, $currentYear - 1);
        $n  = self::getOrCreateBalance($userId, $currentYear);

        // Bonus hanya ada jika KEDUANYA belum pernah dipakai
        $bonusEligible = ($n2->used === 0 && $n1->used === 0);

        $bonusN2 = $bonusEligible ? (int) floor($n2->remaining / 2) : 0;
        $bonusN1 = $bonusEligible ? (int) floor($n1->remaining / 2) : 0;

        return [
            'n2' => [
                'year'      => $currentYear - 2,
                'quota'     => $n2->quota,
                'used'      => $n2->used,
                'remaining' => $n2->remaining,
                'bonus'     => $bonusN2,
            ],
            'n1' => [
                'year'      => $currentYear - 1,
                'quota'     => $n1->quota,
                'used'      => $n1->used,
                'remaining' => $n1->remaining,
                'bonus'     => $bonusN1,
            ],
            'n' => [
                'year'      => $currentYear,
                'quota'     => $n->quota,
                'used'      => $n->used,
                'remaining' => $n->remaining,
            ],
            'total_available' => $n->remaining + $bonusN1 + $bonusN2,
            'bonus_eligible'  => $bonusEligible,
        ];
    }

    // =========================================================================
    // CORE: RECALCULATE (dipanggil saat admin approve/reject)
    // =========================================================================

    public static function recalculateAnnualBalances(int $userId, int $year): array
    {
        return DB::transaction(function () use ($userId, $year) {

            // -----------------------------------------------------------------
            // 1. Refresh saldo n-2 dan n-1 dari data aktual
            // -----------------------------------------------------------------
            $n2 = self::getOrCreateBalance($userId, $year - 2);
            $n1 = self::getOrCreateBalance($userId, $year - 1);
            $n  = self::getOrCreateBalance($userId, $year);

            $n2->used      = self::sumApprovedAnnualDuration($userId, $year - 2);
            $n2->remaining = max(0, $n2->quota - $n2->used);
            $n2->save();

            $n1->used      = self::sumApprovedAnnualDuration($userId, $year - 1);
            $n1->remaining = max(0, $n1->quota - $n1->used);
            $n1->save();

            // -----------------------------------------------------------------
            // 2. Cek cuti besar tahun berjalan
            // -----------------------------------------------------------------
            $cutiBesar = LeaveRequest::query()
                ->where('user_id', $userId)
                ->where('jenis_cuti', 'Cuti Besar')
                ->where('status', LeaveRequest::STATUS_APPROVED)
                ->whereYear('start_date', $year)
                ->orderByDesc('start_date')
                ->first();

            if ($cutiBesar) {
                // Validasi cooldown 5 tahun
                $lastCutiBesar = LeaveRequest::query()
                    ->where('user_id', $userId)
                    ->where('jenis_cuti', 'Cuti Besar')
                    ->where('status', LeaveRequest::STATUS_APPROVED)
                    ->whereYear('start_date', '<', $year)
                    ->orderByDesc('start_date')
                    ->first();

                $allowed = true;
                if ($lastCutiBesar) {
                    $lastYear = Carbon::parse($lastCutiBesar->start_date)->year;
                    if (($year - $lastYear) < 5) {
                        $allowed = false;
                    }
                }

                if ($allowed) {
                    // Hanguskan seluruh kuota tahun berjalan (bonus tidak relevan)
                    $n->used      = $n->quota;
                    $n->remaining = 0;
                    $n->save();

                    return self::calculateTotalAvailable($userId, $year);
                }
                // Jika tidak allowed, lanjut hitung normal
                // (admin seharusnya menolak pengajuan ini, tapi kita handle gracefully)
            }

            // -----------------------------------------------------------------
            // 3. Reset tahun berjalan, lalu hitung ulang dari nol
            // -----------------------------------------------------------------
            $n->used      = 0;
            $n->remaining = $n->quota;

            // -----------------------------------------------------------------
            // 4. Tentukan apakah berhak bonus
            //    Syarat: n-2 DAN n-1 keduanya used == 0 (setelah refresh)
            // -----------------------------------------------------------------
            $bonusEligible  = ($n2->used === 0 && $n1->used === 0);
            $bonusPool      = 0;

            if ($bonusEligible) {
                $bonusPool = (int) floor($n2->remaining / 2)
                           + (int) floor($n1->remaining / 2);
            }

            // -----------------------------------------------------------------
            // 5. Potong saldo berdasarkan pengajuan approved tahun berjalan
            //    Urutan: kuota n dulu → bonus pool
            // -----------------------------------------------------------------
            $requests = self::getApprovedAnnualRequests($userId, $year);

            foreach ($requests as $req) {
                $due = (int) $req->duration;

                // Potong dari kuota tahun berjalan
                $takeFromN     = min($n->remaining, $due);
                $n->used      += $takeFromN;
                $n->remaining -= $takeFromN;
                $due          -= $takeFromN;

                // Sisanya potong dari bonus pool (jika eligible)
                if ($due > 0 && $bonusPool > 0) {
                    $takeFromBonus = min($bonusPool, $due);
                    $bonusPool    -= $takeFromBonus;
                    $due          -= $takeFromBonus;
                }

                // Jika masih ada sisa $due → saldo habis (biarkan; validasi ada di store())
            }

            $n->save();

            return self::calculateTotalAvailable($userId, $year);
        });
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private static function sumApprovedAnnualDuration(int $userId, int $year): int
    {
        return (int) DB::table('leave_requests')
            ->where('user_id', $userId)
            ->where('jenis_cuti', 'Cuti Tahunan')
            ->where('status', LeaveRequest::STATUS_APPROVED)
            ->whereYear('start_date', $year)
            ->sum('duration');
    }

    private static function getApprovedAnnualRequests(int $userId, int $year): \Illuminate\Support\Collection
    {
        return LeaveRequest::query()
            ->select(['id', 'duration', 'start_date', 'created_at'])
            ->where('user_id', $userId)
            ->annualLeave()
            ->approved()
            ->whereYear('start_date', $year)
            ->orderBy('start_date')
            ->orderBy('created_at')
            ->get();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nip',
        'phone',
        'email',
        'photo',
        'password',
        'role',
        'gender',
        'pangkat_golongan',
        'bidang_unit',
        'jabatan',
        'pendidikan',
        'usia',
        'join_date',
        'status',
        'annual_leave_quota',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'join_date'         => 'date',
        ];
    }

    // =========================================================================
    // RELATIONSHIPS
    // =========================================================================

    /** Relasi legacy ke tabel cuti (model lama). */
    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }

    /** Relasi ke tabel leave_requests (model baru). */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /** Relasi ke saldo cuti per tahun. */
    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return ($this->status ?? 'aktif') === 'aktif';
    }
  
    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /**
     * Mendapatkan masa kerja dalam tahun (real-time)
     */
    public function getMasaKerjaAttribute(): int
    {
        if ($this->join_date) {
            return (int) floor(\Carbon\Carbon::parse($this->join_date)->diffInYears(now()));
        }
        return 0;
    }

    /**
     * Mendapatkan masa kerja dalam format string
     */
    public function getMasaKerjaFormatAttribute(): string
    {
        if ($this->join_date) {
            $diff = \Carbon\Carbon::parse($this->join_date)->diff(now());
            return "{$diff->y} tahun {$diff->m} bulan";
        }
        return '0 tahun 0 bulan';
    }

     /**
     * Join date dari NIP (acuan utama)
     */
    public function getJoinDateFromNipAttribute()
    {
        if (empty($this->nip)) return null;
        
        $nip = str_replace(' ', '', $this->nip);
        $length = strlen($nip);
        
        // NIP 18 digit
        if ($length == 18) {
            $tahun = (int) substr($nip, 8, 4);
            $bulan = (int) substr($nip, 12, 2);
            
            if ($tahun >= 1945 && $tahun <= (int) date('Y') && $bulan >= 1 && $bulan <= 12) {
                // Start of day untuk menghilangkan timestamp
                return \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
            }
        }
        
        // NIP 22 digit
        if ($length == 22) {
            $tahun = (int) substr($nip, 8, 4);
            if ($tahun >= 1945 && $tahun <= (int) date('Y')) {
                return \Carbon\Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            }
        }
        
        return null;
    }

    /**
     * Masa kerja dari NIP (acuan resmi)
     */
    public function getMasaKerjaNipAttribute(): int
    {
        $joinFromNIP = $this->join_date_from_nip;
        
        if ($joinFromNIP) {
            return (int) floor($joinFromNIP->diffInYears(now()));
        }
        return 0;
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope untuk filter berdasarkan range masa kerja
     */
    public function scopeMasaKerjaBetween($query, $minYear, $maxYear)
    {
        $minDate = now()->subYears($maxYear)->startOfYear();
        $maxDate = now()->subYears($minYear)->endOfYear();
        
        return $query->whereBetween('join_date', [$minDate, $maxDate]);
    }
}
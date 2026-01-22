<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nip',
        'phone',
        'email',
        'password',
        'role',
        'gender',
        'pangkat_golongan',
        'bidang_unit',
        'jabatan',
        'pendidikan',
        'usia',
        'join_date',          // ← TAMBAHKAN
        'status',             // ← TAMBAHKAN
        'annual_leave_quota', // ← TAMBAHKAN
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'join_date' => 'date', // ← TAMBAHKAN
        ];
    }

    // Relasi ke Cuti
    public function cuti()
    {
        return $this->hasMany(Cuti::class);
    }

    // Helper method untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Helper method untuk cek status
    public function isActive()
    {
        return $this->status === 'aktif';
    }
}
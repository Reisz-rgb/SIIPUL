<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    // Nama tabel di database (opsional jika sesuai standar, tapi biar aman kita tulis)
    protected $table = 'leave_requests';

    // Kolom yang boleh diisi datanya
    protected $fillable = [
        'user_id',
        'jenis_cuti',
        'start_date',
        'end_date',
        'duration',
        'reason',
        'status',            // pending, approved, rejected
        'rejection_reason',
        'file_path'          // jika ada upload surat dokter
    ];

    // Agar kolom tanggal otomatis jadi objek Carbon (biar gampang diformat tgl-bln-thn)
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // --- RELASI PENTING ---
    // Ini biar kita bisa panggil $leaveRequest->user->name
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
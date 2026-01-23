<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'leave_requests';

    /* =====================
     * CONSTANT STATUS
     * ===================== */
    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'jenis_cuti',
        'start_date',
        'end_date',
        'duration',
        'reason',
        'status',
        'rejection_reason',
        'file_path',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /* =====================
     * DEFAULT ATTRIBUTE
     * ===================== */
    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];

    /* =====================
     * RELATIONSHIP
     * ===================== */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* =====================
     * QUERY SCOPES
     * ===================== */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    /* =====================
     * HELPER METHODS
     * ===================== */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
}

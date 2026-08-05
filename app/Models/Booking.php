<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'purpose',
        'player_count',
        'contact_phone',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'cancel_reason',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function primaryDetail()
    {
        return $this->hasOne(BookingDetail::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Chờ duyệt',
            'approved' => 'Đã duyệt',
            'rejected' => 'Từ chối',
            'cancelled' => 'Đã hủy',
            'completed' => 'Hoàn tất',
            default => 'Không xác định',
        };
    }
}

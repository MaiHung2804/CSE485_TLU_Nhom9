<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_detail_id',
        'checked_by',
        'used_status',
        'checked_in_at',
        'checked_out_at',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'checked_out_at' => 'datetime',
        ];
    }

    public function bookingDetail()
    {
        return $this->belongsTo(BookingDetail::class);
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function getUsedStatusLabelAttribute(): string
    {
        return match ($this->used_status) {
            'used' => 'Đã sử dụng',
            'no_show' => 'Không đến',
            'cancelled' => 'Đã hủy',
            default => 'Không xác định',
        };
    }
}

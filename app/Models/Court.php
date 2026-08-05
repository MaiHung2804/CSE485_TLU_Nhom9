<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport_type_id',
        'name',
        'code',
        'location',
        'capacity',
        'status',
        'description',
    ];

    public function sportType()
    {
        return $this->belongsTo(SportType::class);
    }

    public function schedules()
    {
        return $this->hasMany(CourtSchedule::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Đang hoạt động',
            'inactive' => 'Tạm ngưng',
            'maintenance' => 'Bảo trì',
            default => 'Không xác định',
        };
    }
}

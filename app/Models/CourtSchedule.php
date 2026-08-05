<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_id',
        'day_of_week',
        'time_slot_id',
        'is_open',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function getDayNameAttribute(): string
    {
        return [
            0 => 'Chủ nhật',
            1 => 'Thứ hai',
            2 => 'Thứ ba',
            3 => 'Thứ tư',
            4 => 'Thứ năm',
            5 => 'Thứ sáu',
            6 => 'Thứ bảy',
        ][$this->day_of_week] ?? 'Không xác định';
    }
}

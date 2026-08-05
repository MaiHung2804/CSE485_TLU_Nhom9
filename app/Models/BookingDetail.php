<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'court_id',
        'booking_date',
        'time_slot_id',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function usageLog()
    {
        return $this->hasOne(UsageLog::class);
    }
}

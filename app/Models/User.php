<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function approvedBookings()
    {
        return $this->hasMany(Booking::class, 'approved_by');
    }

    public function usageLogs()
    {
        return $this->hasMany(UsageLog::class, 'checked_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff'], true);
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin', 'staff' => 'Quản trị viên',
            'student' => 'Sinh viên',
            default => 'Không xác định',
        };
    }
}

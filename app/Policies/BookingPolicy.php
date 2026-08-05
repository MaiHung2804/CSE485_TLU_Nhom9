<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isStudent();
    }

    public function update(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id
            && ! in_array($booking->status, ['cancelled', 'completed'], true);
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id
            && ! in_array($booking->status, ['cancelled', 'completed'], true);
    }

    public function approve(User $user, Booking $booking): bool
    {
        return false;
    }

    public function reject(User $user, Booking $booking): bool
    {
        return false;
    }
}

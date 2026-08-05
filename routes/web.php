<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\CourtScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\UsageLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    Route::resource('bookings', BookingController::class)->except(['show']);
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    Route::middleware('role:admin')->group(function () {
        Route::resource('sport-types', SportTypeController::class)->except(['show']);
        Route::resource('courts', CourtController::class)->except(['show']);
        Route::resource('time-slots', TimeSlotController::class)->except(['show']);
        Route::resource('court-schedules', CourtScheduleController::class)->except(['show']);
        Route::post('bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
        Route::post('bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
        Route::get('usage-logs', [UsageLogController::class, 'index'])->name('usage-logs.index');
        Route::post('booking-details/{bookingDetail}/usage-log', [UsageLogController::class, 'store'])->name('usage-logs.store');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

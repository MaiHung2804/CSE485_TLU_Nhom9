<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Court;
use App\Models\UsageLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ], [
            'to.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        $from = Carbon::parse($validated['from'] ?? now()->subDays(30)->toDateString())->startOfDay();
        $to = Carbon::parse($validated['to'] ?? now()->toDateString())->endOfDay();
        $dateRange = [$from->toDateString(), $to->toDateString()];

        $bookingBaseQuery = Booking::query()->whereHas('bookingDetails', function ($query) use ($dateRange) {
            $query->whereBetween('booking_date', $dateRange);
        });

        $summary = [
            'total_bookings' => (clone $bookingBaseQuery)->count(),
            'pending_bookings' => (clone $bookingBaseQuery)->where('status', 'pending')->count(),
            'approved_bookings' => (clone $bookingBaseQuery)->where('status', 'approved')->count(),
            'completed_bookings' => (clone $bookingBaseQuery)->where('status', 'completed')->count(),
            'cancelled_bookings' => (clone $bookingBaseQuery)->where('status', 'cancelled')->count(),
        ];

        $statusCounts = (clone $bookingBaseQuery)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $usageCounts = UsageLog::query()
            ->select('used_status', DB::raw('COUNT(*) as total'))
            ->whereHas('bookingDetail', function ($query) use ($dateRange) {
                $query->whereBetween('booking_date', $dateRange);
            })
            ->groupBy('used_status')
            ->pluck('total', 'used_status');

        $topCourts = Court::with('sportType')
            ->withCount([
                'bookingDetails as booking_count' => function ($query) use ($dateRange) {
                    $query->whereBetween('booking_date', $dateRange);
                },
            ])
            ->orderByDesc('booking_count')
            ->orderBy('name')
            ->take(5)
            ->get();

        $topStudents = User::query()
            ->where('role', 'student')
            ->withCount([
                'bookings as booking_count' => function ($query) use ($dateRange) {
                    $query->whereHas('bookingDetails', function ($detailQuery) use ($dateRange) {
                        $detailQuery->whereBetween('booking_date', $dateRange);
                    });
                },
            ])
            ->orderByDesc('booking_count')
            ->orderBy('name')
            ->take(5)
            ->get();

        $dailyTrend = BookingDetail::query()
            ->selectRaw('booking_date, COUNT(*) as total')
            ->whereBetween('booking_date', $dateRange)
            ->groupBy('booking_date')
            ->orderBy('booking_date')
            ->get();

        $recentUsage = BookingDetail::with(['booking.user', 'court.sportType', 'timeSlot', 'usageLog.checker'])
            ->whereBetween('booking_date', $dateRange)
            ->latest('booking_date')
            ->take(10)
            ->get();

        return view('reports.index', [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'summary' => $summary,
            'statusCounts' => $statusCounts,
            'usageCounts' => $usageCounts,
            'topCourts' => $topCourts,
            'topStudents' => $topStudents,
            'dailyTrend' => $dailyTrend,
            'recentUsage' => $recentUsage,
        ]);
    }
}

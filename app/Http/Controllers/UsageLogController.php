<?php

namespace App\Http\Controllers;

use App\Models\BookingDetail;
use App\Models\UsageLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsageLogController extends Controller
{
    public function index()
    {
        $bookingDetails = BookingDetail::with(['booking.user', 'court.sportType', 'timeSlot', 'usageLog.checker'])
            ->whereHas('booking', function ($query) {
                $query->whereIn('status', ['approved', 'completed', 'cancelled']);
            })
            ->latest('booking_date')
            ->paginate(10);

        return view('usage-logs.index', compact('bookingDetails'));
    }

    public function store(Request $request, BookingDetail $bookingDetail)
    {
        $validated = $request->validate([
            'used_status' => ['required', Rule::in(['used', 'no_show', 'cancelled'])],
            'note' => ['nullable', 'string'],
        ], [
            'used_status.in' => 'Trạng thái sử dụng đã chọn không hợp lệ.',
        ]);

        UsageLog::updateOrCreate(
            ['booking_detail_id' => $bookingDetail->id],
            [
                'checked_by' => $request->user()->id,
                'used_status' => $validated['used_status'],
                'checked_in_at' => $validated['used_status'] === 'used' ? now() : null,
                'checked_out_at' => $validated['used_status'] === 'used' ? now()->addHours(2) : null,
                'note' => $validated['note'] ?? null,
            ]
        );

        $bookingDetail->booking->update([
            'status' => $validated['used_status'] === 'cancelled' ? 'cancelled' : 'completed',
        ]);

        return redirect()->route('usage-logs.index')
            ->with('success', 'Đã lưu nhật ký sử dụng thành công.');
    }
}

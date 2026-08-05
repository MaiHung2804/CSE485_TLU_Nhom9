<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Court;
use App\Models\CourtSchedule;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Booking::class);

        $query = Booking::with(['user', 'approver', 'primaryDetail.court.sportType', 'primaryDetail.timeSlot', 'primaryDetail.usageLog'])
            ->latest();

        if (! $request->user()->isStaff()) {
            $query->where('user_id', $request->user()->id);
        }

        return view('bookings.index', [
            'bookings' => $query->paginate(12),
            'isStaff' => $request->user()->isStaff(),
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Booking::class);

        return view('bookings.create', [
            'users' => $request->user()->isStaff()
                ? User::orderBy('name')->get()
                : collect([$request->user()]),
            'courts' => Court::with('sportType')->orderBy('name')->get(),
            'timeSlots' => TimeSlot::orderBy('start_time')->get(),
            'isStaff' => $request->user()->isStaff(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Booking::class);

        $validated = $this->validateBooking($request);
        $validated['user_id'] = $this->resolveBookingUserId($request, $validated);

        $this->ensureBookingRules($validated);

        DB::transaction(function () use ($validated) {
            $booking = Booking::create([
                'user_id' => $validated['user_id'],
                'purpose' => $validated['purpose'],
                'player_count' => $validated['player_count'],
                'contact_phone' => $validated['contact_phone'],
                'status' => 'pending',
            ]);

            $booking->bookingDetails()->create([
                'court_id' => $validated['court_id'],
                'booking_date' => $validated['booking_date'],
                'time_slot_id' => $validated['time_slot_id'],
            ]);
        });

        return redirect()->route('bookings.index')
            ->with('success', 'Đã tạo phiếu đặt sân thành công.');
    }

    public function show(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);

        $booking->load(['user', 'approver', 'bookingDetails.court.sportType', 'bookingDetails.timeSlot', 'bookingDetails.usageLog.checker']);

        return view('bookings.show', [
            'booking' => $booking,
            'isStaff' => $request->user()->isStaff(),
        ]);
    }

    public function edit(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $booking->load('primaryDetail');

        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return redirect()->route('bookings.index')
                ->with('error', 'Phiếu đã hoàn tất hoặc đã hủy thì không thể chỉnh sửa.');
        }

        return view('bookings.edit', [
            'booking' => $booking,
            'users' => $request->user()->isStaff()
                ? User::orderBy('name')->get()
                : collect([$request->user()]),
            'courts' => Court::with('sportType')->orderBy('name')->get(),
            'timeSlots' => TimeSlot::orderBy('start_time')->get(),
            'isStaff' => $request->user()->isStaff(),
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return redirect()->route('bookings.index')
                ->with('error', 'Phiếu đã hoàn tất hoặc đã hủy thì không thể chỉnh sửa.');
        }

        $validated = $this->validateBooking($request);
        $validated['user_id'] = $this->resolveBookingUserId($request, $validated);

        $this->ensureBookingRules($validated, $booking);

        DB::transaction(function () use ($validated, $booking) {
            $booking->update([
                'user_id' => $validated['user_id'],
                'purpose' => $validated['purpose'],
                'player_count' => $validated['player_count'],
                'contact_phone' => $validated['contact_phone'],
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'rejection_reason' => null,
                'cancel_reason' => null,
                'cancelled_at' => null,
            ]);

            $booking->primaryDetail()->update([
                'court_id' => $validated['court_id'],
                'booking_date' => $validated['booking_date'],
                'time_slot_id' => $validated['time_slot_id'],
            ]);
        });

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Đã cập nhật phiếu đặt và chuyển về trạng thái chờ duyệt.');
    }

    public function destroy(Request $request, Booking $booking)
    {
        $this->authorize('delete', $booking);

        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return redirect()->route('bookings.index')
                ->with('error', 'Phiếu này không còn cho phép hủy.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->input('cancel_reason', 'Người dùng hủy phiếu đặt.'),
            'cancelled_at' => now(),
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Đã hủy phiếu đặt sân thành công.');
    }

    public function approve(Request $request, Booking $booking)
    {
        $this->authorize('approve', $booking);

        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return redirect()->route('bookings.index')
                ->with('error', 'Phiếu này không thể duyệt thêm nữa.');
        }

        $booking->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Đã duyệt phiếu đặt sân thành công.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $this->authorize('reject', $booking);

        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return redirect()->route('bookings.index')
                ->with('error', 'Phiếu này không thể từ chối thêm nữa.');
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string'],
        ]);

        $booking->update([
            'status' => 'rejected',
            'approved_by' => $request->user()->id,
            'approved_at' => null,
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Đã từ chối phiếu đặt sân.');
    }

    private function validateBooking(Request $request): array
    {
        return $request->validate([
            'user_id' => $request->user()->isStaff()
                ? ['required', 'exists:users,id']
                : ['nullable', 'exists:users,id'],
            'court_id' => ['required', 'exists:courts,id'],
            'time_slot_id' => ['required', 'exists:time_slots,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'purpose' => ['required', 'string', 'max:255'],
            'player_count' => ['required', 'integer', 'min:1'],
            'contact_phone' => ['required', 'string', 'max:20'],
        ], [
            'booking_date.after_or_equal' => 'Ngày đặt phải từ hôm nay trở đi.',
            'player_count.min' => 'Số người chơi phải lớn hơn 0.',
        ]);
    }

    private function ensureBookingRules(array $validated, ?Booking $booking = null): void
    {
        $court = Court::findOrFail($validated['court_id']);

        if ($court->status !== 'active') {
            throw ValidationException::withMessages([
                'court_id' => 'Chỉ sân đang hoạt động mới được phép đặt.',
            ]);
        }

        if ($validated['player_count'] > $court->capacity) {
            throw ValidationException::withMessages([
                'player_count' => 'Số người chơi không được vượt quá sức chứa của sân đã chọn.',
            ]);
        }

        $dayOfWeek = Carbon::parse($validated['booking_date'])->dayOfWeek;

        $isOpen = CourtSchedule::query()
            ->where('court_id', $validated['court_id'])
            ->where('time_slot_id', $validated['time_slot_id'])
            ->where('day_of_week', $dayOfWeek)
            ->where('is_open', true)
            ->exists();

        if (! $isOpen) {
            throw ValidationException::withMessages([
                'booking_date' => 'Sân đã chọn không mở ở ngày và ca giờ này.',
            ]);
        }

        $conflictQuery = BookingDetail::query()
            ->where('court_id', $validated['court_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where('time_slot_id', $validated['time_slot_id'])
            ->whereHas('booking', function ($query) {
                $query->whereIn('status', ['pending', 'approved']);
            });

        if ($booking?->primaryDetail) {
            $conflictQuery->where('id', '!=', $booking->primaryDetail->id);
        }

        if ($conflictQuery->exists()) {
            throw ValidationException::withMessages([
                'time_slot_id' => 'Sân này đã có người đặt ở ngày và ca giờ bạn chọn.',
            ]);
        }
    }

    private function resolveBookingUserId(Request $request, array $validated): int
    {
        if ($request->user()->isStaff()) {
            return (int) $validated['user_id'];
        }

        return $request->user()->id;
    }
}

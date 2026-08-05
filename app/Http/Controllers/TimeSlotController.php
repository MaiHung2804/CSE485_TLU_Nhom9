<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TimeSlotController extends Controller
{
    public function index()
    {
        $timeSlots = TimeSlot::orderBy('start_time')->paginate(10);

        return view('time-slots.index', compact('timeSlots'));
    }

    public function create()
    {
        return view('time-slots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:50', 'unique:time_slots,label'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ], [
            'end_time.after' => 'Giờ kết thúc phải sau giờ bắt đầu.',
        ]);

        TimeSlot::create($validated);

        return redirect()->route('time-slots.index')->with('success', 'Đã thêm ca giờ thành công.');
    }

    public function show(TimeSlot $timeSlot)
    {
        return redirect()->route('time-slots.edit', $timeSlot);
    }

    public function edit(TimeSlot $timeSlot)
    {
        return view('time-slots.edit', compact('timeSlot'));
    }

    public function update(Request $request, TimeSlot $timeSlot)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:50', Rule::unique('time_slots', 'label')->ignore($timeSlot->id)],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ], [
            'end_time.after' => 'Giờ kết thúc phải sau giờ bắt đầu.',
        ]);

        $timeSlot->update($validated);

        return redirect()->route('time-slots.index')->with('success', 'Đã cập nhật ca giờ thành công.');
    }

    public function destroy(TimeSlot $timeSlot)
    {
        if ($timeSlot->schedules()->exists() || $timeSlot->bookingDetails()->exists()) {
            return redirect()->route('time-slots.index')->with('error', 'Không thể xóa ca giờ đang được dùng trong lịch mở hoặc phiếu đặt.');
        }

        $timeSlot->delete();

        return redirect()->route('time-slots.index')->with('success', 'Đã xóa ca giờ thành công.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\CourtSchedule;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourtScheduleController extends Controller
{
    public function index()
    {
        $courtSchedules = CourtSchedule::with(['court.sportType', 'timeSlot'])
            ->orderBy('court_id')
            ->orderBy('day_of_week')
            ->orderBy('time_slot_id')
            ->paginate(12);

        return view('court-schedules.index', [
            'courtSchedules' => $courtSchedules,
            'dayOptions' => $this->dayOptions(),
        ]);
    }

    public function create()
    {
        return view('court-schedules.create', [
            'courts' => Court::with('sportType')->orderBy('name')->get(),
            'timeSlots' => TimeSlot::orderBy('start_time')->get(),
            'dayOptions' => $this->dayOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSchedule($request);

        CourtSchedule::create($validated);

        return redirect()->route('court-schedules.index')->with('success', 'Đã thêm lịch mở sân thành công.');
    }

    public function show(CourtSchedule $courtSchedule)
    {
        return redirect()->route('court-schedules.edit', $courtSchedule);
    }

    public function edit(CourtSchedule $courtSchedule)
    {
        return view('court-schedules.edit', [
            'courtSchedule' => $courtSchedule,
            'courts' => Court::with('sportType')->orderBy('name')->get(),
            'timeSlots' => TimeSlot::orderBy('start_time')->get(),
            'dayOptions' => $this->dayOptions(),
        ]);
    }

    public function update(Request $request, CourtSchedule $courtSchedule)
    {
        $validated = $this->validateSchedule($request, $courtSchedule);

        $courtSchedule->update($validated);

        return redirect()->route('court-schedules.index')->with('success', 'Đã cập nhật lịch mở sân thành công.');
    }

    public function destroy(CourtSchedule $courtSchedule)
    {
        $courtSchedule->delete();

        return redirect()->route('court-schedules.index')->with('success', 'Đã xóa lịch mở sân thành công.');
    }

    private function validateSchedule(Request $request, ?CourtSchedule $courtSchedule = null): array
    {
        return $request->validate([
            'court_id' => ['required', 'exists:courts,id'],
            'day_of_week' => ['required', 'integer', 'between:0,6'],
            'time_slot_id' => [
                'required',
                'exists:time_slots,id',
                Rule::unique('court_schedules')->where(function ($query) use ($request) {
                    return $query
                        ->where('court_id', $request->court_id)
                        ->where('day_of_week', $request->day_of_week)
                        ->where('time_slot_id', $request->time_slot_id);
                })->ignore($courtSchedule?->id),
            ],
            'is_open' => ['required', 'boolean'],
        ], [
            'time_slot_id.unique' => 'Lịch mở cho sân, thứ và ca giờ này đã tồn tại.',
        ]);
    }

    private function dayOptions(): array
    {
        return [
            0 => 'Chủ nhật',
            1 => 'Thứ hai',
            2 => 'Thứ ba',
            3 => 'Thứ tư',
            4 => 'Thứ năm',
            5 => 'Thứ sáu',
            6 => 'Thứ bảy',
        ];
    }
}

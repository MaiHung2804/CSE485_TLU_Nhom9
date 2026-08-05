<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\SportType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourtController extends Controller
{
    public function index()
    {
        $courts = Court::with('sportType')->withCount('bookingDetails')->orderBy('name')->paginate(10);

        return view('courts.index', compact('courts'));
    }

    public function create()
    {
        $sportTypes = SportType::orderBy('name')->get();
        $statuses = ['active', 'inactive', 'maintenance'];

        return view('courts.create', compact('sportTypes', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_type_id' => ['required', 'exists:sport_types,id'],
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:50', 'unique:courts,code'],
            'location' => ['required', 'string', 'max:150'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
            'description' => ['nullable', 'string'],
        ]);

        Court::create($validated);

        return redirect()->route('courts.index')->with('success', 'Đã thêm sân thành công.');
    }

    public function show(Court $court)
    {
        return redirect()->route('courts.edit', $court);
    }

    public function edit(Court $court)
    {
        $sportTypes = SportType::orderBy('name')->get();
        $statuses = ['active', 'inactive', 'maintenance'];

        return view('courts.edit', compact('court', 'sportTypes', 'statuses'));
    }

    public function update(Request $request, Court $court)
    {
        $validated = $request->validate([
            'sport_type_id' => ['required', 'exists:sport_types,id'],
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:50', Rule::unique('courts', 'code')->ignore($court->id)],
            'location' => ['required', 'string', 'max:150'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
            'description' => ['nullable', 'string'],
        ]);

        $court->update($validated);

        return redirect()->route('courts.index')->with('success', 'Đã cập nhật sân thành công.');
    }

    public function destroy(Court $court)
    {
        if ($court->bookingDetails()->exists()) {
            $court->update(['status' => 'inactive']);

            return redirect()->route('courts.index')->with('warning', 'Sân đã có lịch sử đặt nên hệ thống chuyển sang trạng thái tạm ngưng thay vì xóa.');
        }

        $court->delete();

        return redirect()->route('courts.index')->with('success', 'Đã xóa sân thành công.');
    }
}

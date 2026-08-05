<?php

namespace App\Http\Controllers;

use App\Models\SportType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SportTypeController extends Controller
{
    public function index()
    {
        $sportTypes = SportType::withCount('courts')->orderBy('name')->paginate(10);

        return view('sport-types.index', compact('sportTypes'));
    }

    public function create()
    {
        return view('sport-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:sport_types,name'],
            'description' => ['nullable', 'string'],
        ]);

        SportType::create($validated);

        return redirect()->route('sport-types.index')->with('success', 'Đã thêm môn thể thao thành công.');
    }

    public function show(SportType $sportType)
    {
        return redirect()->route('sport-types.edit', $sportType);
    }

    public function edit(SportType $sportType)
    {
        return view('sport-types.edit', compact('sportType'));
    }

    public function update(Request $request, SportType $sportType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('sport_types', 'name')->ignore($sportType->id)],
            'description' => ['nullable', 'string'],
        ]);

        $sportType->update($validated);

        return redirect()->route('sport-types.index')->with('success', 'Đã cập nhật môn thể thao thành công.');
    }

    public function destroy(SportType $sportType)
    {
        if ($sportType->courts()->exists()) {
            return redirect()->route('sport-types.index')->with('error', 'Không thể xóa môn thể thao khi vẫn còn sân đang liên kết.');
        }

        $sportType->delete();

        return redirect()->route('sport-types.index')->with('success', 'Đã xóa môn thể thao thành công.');
    }
}

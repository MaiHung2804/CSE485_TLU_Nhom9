@extends('layouts.app')

@section('title', 'Thêm lịch mở')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white"><h1 class="h4 mb-0">Thêm lịch mở sân</h1></div>
        <div class="card-body">
            <form action="{{ route('court-schedules.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Sân</label>
                        <select name="court_id" class="form-select" required>
                            <option value="">Chọn sân</option>
                            @foreach ($courts as $court)
                                <option value="{{ $court->id }}" @selected(old('court_id') == $court->id)>{{ $court->name }} ({{ $court->sportType->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Thứ trong tuần</label>
                        <select name="day_of_week" class="form-select" required>
                            @foreach ($dayOptions as $key => $label)
                                <option value="{{ $key }}" @selected((string) old('day_of_week') === (string) $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ca giờ</label>
                        <select name="time_slot_id" class="form-select" required>
                            <option value="">Chọn ca giờ</option>
                            @foreach ($timeSlots as $timeSlot)
                                <option value="{{ $timeSlot->id }}" @selected(old('time_slot_id') == $timeSlot->id)>{{ $timeSlot->label }} ({{ substr($timeSlot->start_time, 0, 5) }} - {{ substr($timeSlot->end_time, 0, 5) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái mở đặt</label>
                        <select name="is_open" class="form-select" required>
                            <option value="1" @selected(old('is_open', '1') == '1')>Có</option>
                            <option value="0" @selected(old('is_open') == '0')>Không</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary">Lưu</button>
                    <a href="{{ route('court-schedules.index') }}" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

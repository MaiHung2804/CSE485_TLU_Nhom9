@extends('layouts.app')

@section('title', 'Sửa lịch mở')

@section('content')
    <section class="page-hero compact">
        <div>
            <span class="page-kicker">Điều chỉnh vận hành</span>
            <h1 class="page-title">Sửa lịch mở sân</h1>
            <p class="section-subtitle">Cập nhật thông tin lịch mở để khớp với thực tế vận hành của sân và workflow booking.</p>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu cập nhật</span>
                    <h2 class="section-title h4 mb-1">Thông tin lịch mở</h2>
                    <p class="section-subtitle mb-0">Chỉnh sửa trực tiếp quan hệ giữa sân, thứ trong tuần và ca giờ.</p>
                </div>
                <div class="panel-body">
                    <form action="{{ route('court-schedules.update', $courtSchedule) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Sân</label>
                                <select name="court_id" class="form-select" required>
                                    @foreach ($courts as $court)
                                        <option value="{{ $court->id }}" @selected(old('court_id', $courtSchedule->court_id) == $court->id)>{{ $court->name }} ({{ $court->sportType->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Thứ trong tuần</label>
                                <select name="day_of_week" class="form-select" required>
                                    @foreach ($dayOptions as $key => $label)
                                        <option value="{{ $key }}" @selected((string) old('day_of_week', $courtSchedule->day_of_week) === (string) $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ca giờ</label>
                                <select name="time_slot_id" class="form-select" required>
                                    @foreach ($timeSlots as $timeSlot)
                                        <option value="{{ $timeSlot->id }}" @selected(old('time_slot_id', $courtSchedule->time_slot_id) == $timeSlot->id)>{{ $timeSlot->label }} ({{ substr($timeSlot->start_time, 0, 5) }} - {{ substr($timeSlot->end_time, 0, 5) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Trạng thái mở đặt</label>
                                <select name="is_open" class="form-select" required>
                                    <option value="1" @selected((string) old('is_open', (int) $courtSchedule->is_open) === '1')>Có</option>
                                    <option value="0" @selected((string) old('is_open', (int) $courtSchedule->is_open) === '0')>Không</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-check2-circle me-2"></i>Cập nhật lịch mở
                            </button>
                            <a href="{{ route('court-schedules.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <div class="col-xl-4">
            <section class="surface-card side-note-card">
                <h2 class="section-title h5 mb-3">Gợi ý chỉnh sửa</h2>
                <ul class="rule-list">
                    <li><strong>Giữ lịch mở logic:</strong> tránh bật quá nhiều ca nếu sân không thật sự khai thác trong demo.</li>
                    <li><strong>Kiểm tra chéo với booking:</strong> nếu lịch bị tắt, booking mới ở ca đó sẽ không hợp lệ.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

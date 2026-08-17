@extends('layouts.app')

@section('title', 'Thêm lịch mở')

@section('content')
    <section class="page-hero compact">
        <div>
            <span class="page-kicker">Lịch vận hành</span>
            <h1 class="page-title">Thêm lịch mở sân</h1>
            <p class="section-subtitle">Khai báo sân được mở đặt theo ngày trong tuần và ca giờ để hệ thống kiểm tra booking đúng nghiệp vụ.</p>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu tạo mới</span>
                    <h2 class="section-title h4 mb-1">Thông tin lịch mở</h2>
                    <p class="section-subtitle mb-0">Module này thể hiện rõ mối liên hệ giữa sân, thứ trong tuần và ca giờ.</p>
                </div>
                <div class="panel-body">
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
                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-save2 me-2"></i>Lưu lịch mở
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
                <h2 class="section-title h5 mb-3">Lưu ý cấu hình</h2>
                <ul class="rule-list">
                    <li><strong>Chỉ mở đúng ca cần dùng:</strong> giúp demo rõ việc booking phải tuân thủ lịch mở sân.</li>
                    <li><strong>Kết hợp với trạng thái sân:</strong> dù lịch mở có bật, sân đang bảo trì vẫn không nên cho đặt.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

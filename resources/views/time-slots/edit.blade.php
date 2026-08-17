@extends('layouts.app')

@section('title', 'Sửa ca giờ')

@section('content')
    <section class="page-hero compact">
        <div>
            <span class="page-kicker">Cập nhật khung thời gian</span>
            <h1 class="page-title">Sửa ca giờ</h1>
            <p class="section-subtitle">Điều chỉnh lại khoảng thời gian để đồng bộ với lịch mở và quy trình đặt sân của hệ thống.</p>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu cập nhật</span>
                    <h2 class="section-title h4 mb-1">Thông tin ca giờ</h2>
                    <p class="section-subtitle mb-0">Các thay đổi có thể ảnh hưởng đến lịch mở sân, vì vậy nên cập nhật cẩn thận.</p>
                </div>
                <div class="panel-body">
                    <form action="{{ route('time-slots.update', $timeSlot) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tên ca</label>
                                <input type="text" name="label" class="form-control" value="{{ old('label', $timeSlot->label) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Giờ bắt đầu</label>
                                <input type="time" name="start_time" class="form-control" value="{{ old('start_time', substr($timeSlot->start_time, 0, 5)) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Giờ kết thúc</label>
                                <input type="time" name="end_time" class="form-control" value="{{ old('end_time', substr($timeSlot->end_time, 0, 5)) }}" required>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-check2-circle me-2"></i>Cập nhật ca giờ
                            </button>
                            <a href="{{ route('time-slots.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <div class="col-xl-4">
            <section class="surface-card side-note-card">
                <h2 class="section-title h5 mb-3">Lưu ý chỉnh sửa</h2>
                <ul class="rule-list">
                    <li><strong>Đảm bảo thứ tự thời gian hợp lệ:</strong> giờ bắt đầu phải nhỏ hơn giờ kết thúc.</li>
                    <li><strong>Kiểm tra lịch mở:</strong> sau khi đổi ca giờ, nên rà qua module lịch mở để đảm bảo dữ liệu trình bày nhất quán.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

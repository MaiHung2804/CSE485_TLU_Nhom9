@extends('layouts.app')

@section('title', 'Thêm ca giờ')

@section('content')
    <section class="page-hero compact">
        <div>
            <span class="page-kicker">Tạo khung thời gian</span>
            <h1 class="page-title">Thêm ca giờ</h1>
            <p class="section-subtitle">Thiết lập ca giờ chuẩn để áp dụng đồng nhất trong lịch mở sân và booking của người dùng.</p>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu tạo mới</span>
                    <h2 class="section-title h4 mb-1">Thông tin ca giờ</h2>
                    <p class="section-subtitle mb-0">Nên đặt tên ngắn, dễ hiểu và có thời lượng hợp lý để thuận tiện khi demo.</p>
                </div>
                <div class="panel-body">
                    <form action="{{ route('time-slots.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tên ca</label>
                                <input type="text" name="label" class="form-control" value="{{ old('label') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Giờ bắt đầu</label>
                                <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Giờ kết thúc</label>
                                <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-save2 me-2"></i>Lưu ca giờ
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
                <h2 class="section-title h5 mb-3">Mẹo cấu hình</h2>
                <ul class="rule-list">
                    <li><strong>Không để chồng lấn logic:</strong> các ca nên tách bạch để demo ràng buộc xung đột rõ hơn.</li>
                    <li><strong>Đặt tên dễ hiểu:</strong> ví dụ “Ca sáng”, “Ca chiều”, “Ca tối” hoặc “Ca 1”, “Ca 2”.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

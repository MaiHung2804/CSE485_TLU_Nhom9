@extends('layouts.app')

@section('title', 'Thêm sân')

@section('content')
    @php
        $statusLabels = [
            'active' => 'Đang hoạt động',
            'inactive' => 'Tạm ngưng',
            'maintenance' => 'Bảo trì',
        ];
    @endphp

    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Tài nguyên mới</span>
                <h1 class="page-title">Thêm sân thể thao</h1>
                <p class="section-subtitle">Khai báo sân mới với thông tin đầy đủ để sẵn sàng cho lịch mở và workflow booking.</p>
            </div>
            <div class="hero-actions">
                <span class="info-chip"><i class="bi bi-plus-square-fill"></i>Thiết lập tài nguyên ban đầu</span>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu tạo mới</span>
                    <h2 class="section-title h4 mb-1">Thông tin sân thể thao</h2>
                    <p class="section-subtitle mb-0">Sau khi tạo sân, bạn có thể cấu hình lịch mở theo ca và đưa sân vào quy trình đặt sân của hệ thống.</p>
                </div>

                <div class="panel-body">
                    <form action="{{ route('courts.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Môn thể thao</label>
                                <select name="sport_type_id" class="form-select" required>
                                    <option value="">Chọn môn thể thao</option>
                                    @foreach ($sportTypes as $sportType)
                                        <option value="{{ $sportType->id }}" @selected(old('sport_type_id') == $sportType->id)>{{ $sportType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" @selected(old('status', 'active') === $status)>{{ $statusLabels[$status] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tên sân</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mã sân</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vị trí</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sức chứa</label>
                                <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}" min="1" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-save2 me-2"></i>Lưu sân mới
                            </button>
                            <a href="{{ route('courts.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <div class="col-xl-4">
            <section class="surface-card side-note-card">
                <h2 class="section-title h5 mb-3">Lưu ý khai báo sân</h2>
                <ul class="rule-list">
                    <li><strong>Tên sân rõ ràng:</strong> nên gắn với vị trí thực tế như “Sân cầu lông A1”, “Sân bóng rổ nhà đa năng”.</li>
                    <li><strong>Mã sân duy nhất:</strong> giúp tìm kiếm và trình bày ERD, data dictionary rõ ràng hơn.</li>
                    <li><strong>Trạng thái phù hợp:</strong> sân bảo trì sẽ không cho phép booking, rất hữu ích khi demo ràng buộc nghiệp vụ.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

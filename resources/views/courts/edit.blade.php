@extends('layouts.app')

@section('title', 'Sửa sân')

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
                <span class="page-kicker">Cập nhật tài nguyên</span>
                <h1 class="page-title">Sửa thông tin sân</h1>
                <p class="section-subtitle">Điều chỉnh dữ liệu sân để đồng bộ với lịch mở, trạng thái vận hành và các booking phát sinh.</p>
            </div>
            <div class="hero-actions">
                <span class="info-chip"><i class="bi bi-pencil-square"></i>{{ $court->name }}</span>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu cập nhật</span>
                    <h2 class="section-title h4 mb-1">Chỉnh sửa thông tin sân</h2>
                    <p class="section-subtitle mb-0">Các thay đổi tại đây ảnh hưởng trực tiếp đến khả năng mở lịch và nhận booking của sân.</p>
                </div>

                <div class="panel-body">
                    <form action="{{ route('courts.update', $court) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Môn thể thao</label>
                                <select name="sport_type_id" class="form-select" required>
                                    @foreach ($sportTypes as $sportType)
                                        <option value="{{ $sportType->id }}" @selected(old('sport_type_id', $court->sport_type_id) == $sportType->id)>{{ $sportType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" @selected(old('status', $court->status) === $status)>{{ $statusLabels[$status] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tên sân</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $court->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mã sân</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code', $court->code) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vị trí</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', $court->location) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sức chứa</label>
                                <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $court->capacity) }}" min="1" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description', $court->description) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-check2-circle me-2"></i>Cập nhật sân
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
                <h2 class="section-title h5 mb-3">Gợi ý cập nhật</h2>
                <ul class="rule-list">
                    <li><strong>Khi bảo trì sân:</strong> nên chuyển trạng thái sang bảo trì để booking mới bị chặn đúng nghiệp vụ.</li>
                    <li><strong>Mã sân nên giữ ổn định:</strong> giúp báo cáo, dữ liệu mẫu và tài liệu thiết kế không bị lệch.</li>
                    <li><strong>Mô tả ngắn gọn nhưng hữu ích:</strong> có thể nêu chất liệu mặt sân, khu vực hoặc mục đích sử dụng chính.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

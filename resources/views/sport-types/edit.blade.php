@extends('layouts.app')

@section('title', 'Sửa môn thể thao')

@section('content')
    <section class="page-hero compact">
        <div>
            <span class="page-kicker">Cập nhật danh mục</span>
            <h1 class="page-title">Sửa môn thể thao</h1>
            <p class="section-subtitle">Điều chỉnh lại thông tin danh mục để đồng bộ với sân bãi và các báo cáo đã thiết kế.</p>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu cập nhật</span>
                    <h2 class="section-title h4 mb-1">Thông tin danh mục</h2>
                    <p class="section-subtitle mb-0">Chỉ nên sửa khi thật sự cần để tránh lệch dữ liệu mẫu và tài liệu báo cáo.</p>
                </div>
                <div class="panel-body">
                    <form action="{{ route('sport-types.update', $sportType) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Tên môn</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $sportType->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $sportType->description) }}</textarea>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-check2-circle me-2"></i>Cập nhật danh mục
                            </button>
                            <a href="{{ route('sport-types.index') }}" class="btn btn-outline-secondary">
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
                    <li><strong>Giữ tên ngắn gọn:</strong> giúp tiêu đề cột, combobox và báo cáo hiển thị đẹp hơn.</li>
                    <li><strong>Đồng nhất với sân:</strong> nếu đổi tên môn, nên rà lại các sân đang liên kết để tránh gây nhầm lẫn khi demo.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

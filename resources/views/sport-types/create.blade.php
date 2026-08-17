@extends('layouts.app')

@section('title', 'Thêm môn thể thao')

@section('content')
    <section class="page-hero compact">
        <div>
            <span class="page-kicker">Danh mục mới</span>
            <h1 class="page-title">Thêm môn thể thao</h1>
            <p class="section-subtitle">Tạo danh mục môn thể thao để liên kết với sân bãi và hoàn thiện cấu trúc dữ liệu đầu vào.</p>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu tạo mới</span>
                    <h2 class="section-title h4 mb-1">Thông tin danh mục</h2>
                    <p class="section-subtitle mb-0">Tên môn thể thao rõ ràng sẽ giúp phần danh mục và báo cáo dễ đọc hơn.</p>
                </div>
                <div class="panel-body">
                    <form action="{{ route('sport-types.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tên môn</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-save2 me-2"></i>Lưu danh mục
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
                <h2 class="section-title h5 mb-3">Lưu ý</h2>
                <ul class="rule-list">
                    <li><strong>Tên nhất quán:</strong> ví dụ “Cầu lông”, “Bóng rổ”, “Bóng đá mini”.</li>
                    <li><strong>Mô tả ngắn gọn:</strong> chỉ cần đủ để người xem hiểu phạm vi áp dụng của loại sân.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

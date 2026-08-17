@extends('layouts.app')

@section('title', 'Sân thể thao')

@section('content')
    @php
        $statusClasses = [
            'active' => 'bg-success-subtle text-success-emphasis',
            'inactive' => 'bg-secondary-subtle text-secondary-emphasis',
            'maintenance' => 'bg-warning-subtle text-warning-emphasis',
        ];

        $statusCounts = $courts->getCollection()->countBy('status');
    @endphp

    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Quản lý tài nguyên</span>
                <h1 class="page-title">Danh sách sân thể thao</h1>
                <p class="section-subtitle">Khai báo và theo dõi toàn bộ sân trong hệ thống, bao gồm sức chứa, vị trí, môn thể thao và tình trạng hoạt động.</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('courts.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Thêm sân
                </a>
                <span class="info-chip"><i class="bi bi-bounding-box-circles"></i>{{ $courts->total() }} sân đã khai báo</span>
            </div>
        </div>
    </section>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-icon text-success"><i class="bi bi-check2-circle"></i></div>
                <div>
                    <span class="metric-label">Đang hoạt động</span>
                    <h2>{{ $statusCounts['active'] ?? 0 }}</h2>
                    <p>Sân có thể tiếp nhận booking trong workflow hiện tại.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-icon text-warning"><i class="bi bi-tools"></i></div>
                <div>
                    <span class="metric-label">Bảo trì</span>
                    <h2>{{ $statusCounts['maintenance'] ?? 0 }}</h2>
                    <p>Những sân đang tạm khóa để tránh phát sinh booking mới.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-icon text-secondary"><i class="bi bi-pause-circle"></i></div>
                <div>
                    <span class="metric-label">Tạm ngưng</span>
                    <h2>{{ $statusCounts['inactive'] ?? 0 }}</h2>
                    <p>Dữ liệu vẫn được lưu nhưng chưa sẵn sàng cho khai thác.</p>
                </div>
            </div>
        </div>
    </div>

    <section class="surface-card table-card">
        <div class="table-toolbar">
            <div>
                <h2 class="section-title h4 mb-1">Thông tin sân bãi</h2>
                <p class="section-subtitle mb-0">Hiển thị {{ $courts->count() }} / {{ $courts->total() }} bản ghi trên trang hiện tại.</p>
            </div>
            <span class="info-chip"><i class="bi bi-geo-alt-fill"></i>Quản lý theo vị trí và sức chứa</span>
        </div>

        <div class="table-responsive">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>Tên sân</th>
                        <th>Môn thể thao</th>
                        <th>Mã sân</th>
                        <th>Vị trí</th>
                        <th>Sức chứa</th>
                        <th>Trạng thái</th>
                        <th>Lượt đặt</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courts as $court)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $court->name }}</div>
                                <div class="table-secondary-text">{{ $court->description ?: 'Chưa có mô tả ngắn cho sân này.' }}</div>
                            </td>
                            <td>{{ $court->sportType->name }}</td>
                            <td>{{ $court->code }}</td>
                            <td>{{ $court->location }}</td>
                            <td>{{ $court->capacity }}</td>
                            <td>
                                <span class="status-pill {{ $statusClasses[$court->status] ?? 'bg-light text-dark' }}">{{ $court->status_label }}</span>
                            </td>
                            <td>{{ $court->booking_details_count }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('courts.edit', $court) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i>Sửa
                                    </a>
                                    <form action="{{ route('courts.destroy', $court) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa hoặc tạm ngưng sân này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash3 me-1"></i>Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">Chưa có sân nào được khai báo. Hãy tạo dữ liệu mẫu để phần demo nhìn thuyết phục hơn.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-3">{{ $courts->links() }}</div>
@endsection

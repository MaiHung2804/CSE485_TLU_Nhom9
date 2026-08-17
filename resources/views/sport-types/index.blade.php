@extends('layouts.app')

@section('title', 'Môn thể thao')

@section('content')
    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Danh mục nền tảng</span>
                <h1 class="page-title">Danh mục môn thể thao</h1>
                <p class="section-subtitle">Quản lý danh sách môn thể thao đang sử dụng trong khuôn viên trường.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('sport-types.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Thêm môn thể thao
                </a>
                <span class="info-chip"><i class="bi bi-dribbble"></i>{{ $sportTypes->total() }} danh mục</span>
            </div>
        </div>
    </section>

    <section class="surface-card table-card">
        <div class="table-toolbar">
            <div>
                <h2 class="section-title h4 mb-1">Danh sách môn thể thao</h2>
                <p class="section-subtitle mb-0">Theo dõi và cập nhật các môn thể thao đang được khai báo.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>Tên môn</th>
                        <th>Mô tả</th>
                        <th>Số sân</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sportTypes as $sportType)
                        <tr>
                            <td class="fw-semibold">{{ $sportType->name }}</td>
                            <td>{{ $sportType->description ?: 'Chưa có mô tả' }}</td>
                            <td>{{ $sportType->courts_count }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('sport-types.edit', $sportType) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i>Sửa
                                    </a>
                                    <form action="{{ route('sport-types.destroy', $sportType) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa môn thể thao này?');">
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
                            <td colspan="4" class="empty-state">Chưa có môn thể thao nào. Bạn nên tạo vài danh mục thật để demo tự nhiên hơn.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-3">{{ $sportTypes->links() }}</div>
@endsection

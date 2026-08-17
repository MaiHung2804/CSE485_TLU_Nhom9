@extends('layouts.app')

@section('title', 'Ca giờ')

@section('content')
    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Khung thời gian</span>
                <h1 class="page-title">Danh sách ca giờ</h1>
                <p class="section-subtitle">Các ca giờ là nền tảng để tạo lịch mở và ràng buộc một sân không bị đặt trùng nhau.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('time-slots.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Thêm ca giờ
                </a>
            </div>
        </div>
    </section>

    <section class="surface-card table-card">
        <div class="table-toolbar">
            <div>
                <h2 class="section-title h4 mb-1">Khung giờ hoạt động</h2>
                <p class="section-subtitle mb-0">Mỗi booking sẽ gắn với đúng một ca giờ để đảm bảo dữ liệu lịch sử rõ ràng.</p>
            </div>
            <span class="info-chip"><i class="bi bi-clock-history"></i>{{ $timeSlots->total() }} ca giờ</span>
        </div>

        <div class="table-responsive">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>Tên ca</th>
                        <th>Giờ bắt đầu</th>
                        <th>Giờ kết thúc</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($timeSlots as $timeSlot)
                        <tr>
                            <td class="fw-semibold">{{ $timeSlot->label }}</td>
                            <td>{{ substr($timeSlot->start_time, 0, 5) }}</td>
                            <td>{{ substr($timeSlot->end_time, 0, 5) }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('time-slots.edit', $timeSlot) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i>Sửa
                                    </a>
                                    <form action="{{ route('time-slots.destroy', $timeSlot) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa ca giờ này?');">
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
                            <td colspan="4" class="empty-state">Chưa có ca giờ nào. Hãy tạo tối thiểu vài ca để mô phỏng booking thực tế.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-3">{{ $timeSlots->links() }}</div>
@endsection

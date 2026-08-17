@extends('layouts.app')

@section('title', 'Lịch mở sân')

@section('content')
    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Khai báo lịch mở</span>
                <h1 class="page-title">Lịch mở sân theo ca</h1>
                <p class="section-subtitle">Thiết lập sân nào được phép đặt vào ngày nào và ca giờ nào để làm rõ ràng nghiệp vụ mở tài nguyên.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('court-schedules.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Thêm lịch mở
                </a>
            </div>
        </div>
    </section>

    <section class="surface-card table-card">
        <div class="table-toolbar">
            <div>
                <h2 class="section-title h4 mb-1">Lịch mở theo ca</h2>
                <p class="section-subtitle mb-0">Dữ liệu này được dùng khi kiểm tra booking có hợp lệ với lịch vận hành của sân hay không.</p>
            </div>
            <span class="info-chip"><i class="bi bi-calendar3-week-fill"></i>{{ $courtSchedules->total() }} cấu hình lịch mở</span>
        </div>

        <div class="table-responsive">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>Sân</th>
                        <th>Môn thể thao</th>
                        <th>Thứ</th>
                        <th>Ca giờ</th>
                        <th>Mở đặt</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courtSchedules as $courtSchedule)
                        <tr>
                            <td class="fw-semibold">{{ $courtSchedule->court->name }}</td>
                            <td>{{ $courtSchedule->court->sportType->name }}</td>
                            <td>{{ $dayOptions[$courtSchedule->day_of_week] }}</td>
                            <td>{{ $courtSchedule->timeSlot->label }}</td>
                            <td>
                                <span class="status-pill {{ $courtSchedule->is_open ? 'bg-success-subtle text-success-emphasis' : 'bg-secondary-subtle text-secondary-emphasis' }}">
                                    {{ $courtSchedule->is_open ? 'Có' : 'Không' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('court-schedules.edit', $courtSchedule) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i>Sửa
                                    </a>
                                    <form action="{{ route('court-schedules.destroy', $courtSchedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa lịch mở này?');">
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
                            <td colspan="6" class="empty-state">Chưa có lịch mở nào. Đây là module rất quan trọng để demo ràng buộc booking hợp lệ.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-3">{{ $courtSchedules->links() }}</div>
@endsection

@extends('layouts.app')

@section('title', 'Đặt sân')

@section('content')
    @php
        $statusClasses = [
            'pending' => 'bg-warning-subtle text-warning-emphasis',
            'approved' => 'bg-info-subtle text-info-emphasis',
            'rejected' => 'bg-danger-subtle text-danger-emphasis',
            'cancelled' => 'bg-secondary-subtle text-secondary-emphasis',
            'completed' => 'bg-success-subtle text-success-emphasis',
        ];

        $bookingCollection = $bookings->getCollection();
        $summaryCards = [
            ['label' => 'Tổng phiếu', 'value' => $bookings->total(), 'icon' => 'bi bi-journal-check', 'class' => 'text-primary'],
            ['label' => 'Chờ duyệt', 'value' => $bookingCollection->where('status', 'pending')->count(), 'icon' => 'bi bi-hourglass-split', 'class' => 'text-warning'],
            ['label' => 'Đã duyệt', 'value' => $bookingCollection->where('status', 'approved')->count(), 'icon' => 'bi bi-patch-check-fill', 'class' => 'text-info'],
            ['label' => 'Hoàn tất / Hủy', 'value' => $bookingCollection->whereIn('status', ['completed', 'cancelled'])->count(), 'icon' => 'bi bi-flag-fill', 'class' => 'text-success'],
        ];
    @endphp

    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Workflow cốt lõi</span>
                <h1 class="page-title">{{ $isStaff ? 'Quản lý phiếu đặt sân' : 'Phiếu đặt sân của tôi' }}</h1>
                <p class="section-subtitle">{{ $isStaff ? 'Theo dõi, duyệt hoặc hủy booking trên cùng một màn hình quản trị. Mỗi yêu cầu đều gắn với sân, ngày sử dụng và ca giờ cụ thể.' : 'Xem lịch sử đặt sân cá nhân, trạng thái phê duyệt và thao tác nhanh trên những phiếu vẫn còn hiệu lực.' }}</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tạo phiếu đặt
                </a>
                <span class="info-chip"><i class="bi bi-list-check"></i>Hiển thị {{ $bookings->count() }} / {{ $bookings->total() }} phiếu</span>
            </div>
        </div>
    </section>

    <div class="row g-4 mb-4">
        @foreach ($summaryCards as $card)
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon {{ $card['class'] }}">
                        <i class="{{ $card['icon'] }}"></i>
                    </div>
                    <div>
                        <span class="metric-label">{{ $card['label'] }}</span>
                        <h2>{{ $card['value'] }}</h2>
                        <p>{{ $isStaff ? 'Theo dữ liệu đang quản lý trong hệ thống.' : 'Theo dữ liệu booking của tài khoản hiện tại.' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <section class="surface-card table-card">
        <div class="table-toolbar">
            <div>
                <h2 class="section-title h4 mb-1">Danh sách phiếu đặt sân</h2>
                <p class="section-subtitle mb-0">Nhấn vào từng dòng để xem chi tiết, chỉnh sửa hoặc xử lý theo trạng thái workflow.</p>
            </div>
            <div class="hero-actions">
                <span class="info-chip"><i class="bi bi-shield-lock"></i>Phân quyền theo vai trò</span>
                <span class="info-chip"><i class="bi bi-arrow-repeat"></i>Cập nhật theo thời gian thực</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>Người đặt</th>
                        <th>Sân</th>
                        <th>Ngày sử dụng</th>
                        <th>Ca giờ</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        @php($detail = $booking->primaryDetail)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $booking->user->name }}</div>
                                <div class="table-secondary-text">{{ $booking->user->email }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $detail?->court?->name ?? 'Không có' }}</div>
                                <div class="table-secondary-text">{{ $detail?->court?->sportType?->name ?? 'Chưa xác định môn' }}</div>
                            </td>
                            <td>{{ $detail?->booking_date?->format('d/m/Y') ?? 'Không có' }}</td>
                            <td>{{ $detail?->timeSlot?->label ?? 'Không có' }}</td>
                            <td>
                                <span class="status-pill {{ $statusClasses[$booking->status] ?? 'bg-light text-dark' }}">
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex flex-wrap justify-content-end gap-2">
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Xem
                                    </a>

                                    @if (!in_array($booking->status, ['cancelled', 'completed'], true))
                                        @can('update', $booking)
                                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-pencil-square me-1"></i>Sửa
                                            </a>
                                        @endcan
                                    @endif

                                    @if (!in_array($booking->status, ['cancelled', 'completed'], true))
                                        @can('delete', $booking)
                                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn hủy phiếu đặt này?');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="cancel_reason" value="Hủy từ danh sách phiếu đặt.">
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Hủy
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">Chưa có phiếu đặt nào. Bạn có thể tạo mới để bắt đầu demo workflow đặt sân.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-3">{{ $bookings->links() }}</div>
@endsection

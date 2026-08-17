@extends('layouts.app')

@section('title', 'Chi tiết phiếu đặt')

@section('content')
    @php
        $detail = $booking->bookingDetails->first();
        $usage = $detail?->usageLog;
        $statusClasses = [
            'pending' => 'bg-warning-subtle text-warning-emphasis',
            'approved' => 'bg-info-subtle text-info-emphasis',
            'rejected' => 'bg-danger-subtle text-danger-emphasis',
            'cancelled' => 'bg-secondary-subtle text-secondary-emphasis',
            'completed' => 'bg-success-subtle text-success-emphasis',
        ];
    @endphp

    <section class="page-hero">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Theo dõi booking</span>
                <h1 class="page-title">Chi tiết phiếu đặt sân #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</h1>
                <p class="section-subtitle">Màn hình này tập trung toàn bộ thông tin nghiệp vụ: người đặt, sân sử dụng, trạng thái phê duyệt và nhật ký sử dụng sau khi buổi chơi kết thúc.</p>

                <div class="hero-meta">
                    <span class="status-pill {{ $statusClasses[$booking->status] ?? 'bg-light text-dark' }}">{{ $booking->status_label }}</span>
                    <span class="info-chip"><i class="bi bi-person-badge"></i>{{ $booking->user->name }}</span>
                    <span class="info-chip"><i class="bi bi-bounding-box-circles"></i>{{ $detail?->court?->name ?? 'Không có sân' }}</span>
                </div>
            </div>

            <div class="hero-actions">
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Quay lại danh sách
                </a>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-7">
            <section class="surface-card form-panel mb-4">
                <div class="panel-header">
                    <span class="panel-kicker">Thông tin nghiệp vụ</span>
                    <h2 class="section-title h4 mb-1">Hồ sơ phiếu đặt</h2>
                    <p class="section-subtitle mb-0">Nhóm thông tin chính phục vụ đối chiếu dữ liệu và trình bày mô hình nghiệp vụ.</p>
                </div>

                <div class="panel-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Người đặt</span>
                            <div class="detail-value">{{ $booking->user->name }} ({{ $booking->user->role_label }})</div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Mục đích sử dụng</span>
                            <div class="detail-value">{{ $booking->purpose }}</div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Số người chơi</span>
                            <div class="detail-value">{{ $booking->player_count }}</div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Điện thoại liên hệ</span>
                            <div class="detail-value">{{ $booking->contact_phone }}</div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Sân</span>
                            <div class="detail-value">{{ $detail?->court?->name ?? 'Không có' }}</div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Ngày đặt</span>
                            <div class="detail-value">{{ $detail?->booking_date?->format('d/m/Y') ?? 'Không có' }}</div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Ca giờ</span>
                            <div class="detail-value">{{ $detail?->timeSlot?->label ?? 'Không có' }}</div>
                        </div>
                        @if ($booking->approver)
                            <div class="detail-item">
                                <span class="detail-label">Người duyệt</span>
                                <div class="detail-value">{{ $booking->approver->name }}</div>
                            </div>
                        @endif
                        @if ($booking->rejection_reason)
                            <div class="detail-item">
                                <span class="detail-label">Lý do từ chối</span>
                                <div class="detail-value">{{ $booking->rejection_reason }}</div>
                            </div>
                        @endif
                        @if ($booking->cancel_reason)
                            <div class="detail-item">
                                <span class="detail-label">Lý do hủy</span>
                                <div class="detail-value">{{ $booking->cancel_reason }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            @if ($usage)
                <section class="surface-card form-panel">
                    <div class="panel-header">
                        <span class="panel-kicker">Sau sử dụng</span>
                        <h2 class="section-title h4 mb-1">Nhật ký sử dụng</h2>
                        <p class="section-subtitle mb-0">Dữ liệu đối chiếu giữa booking đã duyệt và thực tế sử dụng sân.</p>
                    </div>

                    <div class="panel-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <span class="detail-label">Trạng thái sử dụng</span>
                                <div class="detail-value">{{ $usage->used_status_label }}</div>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Người xác nhận</span>
                                <div class="detail-value">{{ $usage->checker?->name ?? 'Không có' }}</div>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Giờ check-in</span>
                                <div class="detail-value">{{ $usage->checked_in_at?->format('d/m/Y H:i') ?? 'Không có' }}</div>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Ghi chú</span>
                                <div class="detail-value">{{ $usage->note ?: 'Chưa có ghi chú' }}</div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>

        <div class="col-xl-5">
            <section class="surface-card side-note-card">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <h2 class="section-title h5 mb-1">{{ $isStaff ? 'Xử lý phiếu đặt' : 'Thao tác của tôi' }}</h2>
                        <p class="section-subtitle mb-0">Các thao tác khả dụng phụ thuộc vào vai trò và trạng thái hiện tại của phiếu.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-diagram-3-fill"></i>Workflow</span>
                </div>

                @if ($isStaff)
                    @if (!in_array($booking->status, ['completed', 'cancelled']))
                        <form action="{{ route('bookings.approve', $booking) }}" method="POST" class="mb-3">
                            @csrf
                            <button class="btn btn-success w-100">
                                <i class="bi bi-check2-circle me-2"></i>Duyệt phiếu đặt
                            </button>
                        </form>

                        <form action="{{ route('bookings.reject', $booking) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Lý do từ chối</label>
                                <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Nhập lý do từ chối phiếu đặt này.">{{ old('rejection_reason', $booking->rejection_reason) }}</textarea>
                            </div>
                            <button class="btn btn-danger w-100">
                                <i class="bi bi-x-octagon me-2"></i>Từ chối phiếu đặt
                            </button>
                        </form>
                    @endif

                    @if (!in_array($booking->status, ['completed', 'cancelled'], true))
                        @can('delete', $booking)
                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="mb-2">
                                    <label class="form-label">Ghi chú hủy</label>
                                    <input type="text" name="cancel_reason" class="form-control" value="{{ old('cancel_reason', $booking->cancel_reason) }}" placeholder="Nhập lý do hủy nếu cần">
                                </div>
                                <button class="btn btn-outline-danger w-100">
                                    <i class="bi bi-trash3 me-2"></i>Hủy phiếu đặt
                                </button>
                            </form>
                        @endcan
                    @else
                        <div class="empty-state px-0 pb-0 text-start">
                            Phiếu này đã ở trạng thái cuối nên không còn thao tác workflow nào khả dụng.
                        </div>
                    @endif
                @else
                    @can('update', $booking)
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-pencil-square me-2"></i>Sửa phiếu đặt
                        </a>
                    @endcan

                    @can('delete', $booking)
                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mb-2">
                                <label class="form-label">Ghi chú hủy</label>
                                <input type="text" name="cancel_reason" class="form-control" value="{{ old('cancel_reason', $booking->cancel_reason) }}" placeholder="Nhập lý do hủy nếu cần">
                            </div>
                            <button class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle me-2"></i>Hủy phiếu đặt
                            </button>
                        </form>
                    @else
                        <div class="empty-state px-0 pb-0 text-start">
                            Phiếu này không còn cho phép chỉnh sửa hoặc hủy vì đã đi vào trạng thái cuối của workflow.
                        </div>
                    @endcan
                @endif
            </section>
        </div>
    </div>
@endsection

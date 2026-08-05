@extends('layouts.app')

@section('title', 'Chi tiết phiếu đặt')

@section('content')
    @php
        $detail = $booking->bookingDetails->first();
        $usage = $detail?->usageLog;
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title mb-0">Chi tiết phiếu đặt sân</h1>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h2 class="h5 mb-0">Thông tin phiếu đặt</h2></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Người đặt</dt>
                        <dd class="col-sm-8">{{ $booking->user->name }} ({{ $booking->user->role_label }})</dd>

                        <dt class="col-sm-4">Mục đích</dt>
                        <dd class="col-sm-8">{{ $booking->purpose }}</dd>

                        <dt class="col-sm-4">Số người chơi</dt>
                        <dd class="col-sm-8">{{ $booking->player_count }}</dd>

                        <dt class="col-sm-4">Điện thoại</dt>
                        <dd class="col-sm-8">{{ $booking->contact_phone }}</dd>

                        <dt class="col-sm-4">Trạng thái</dt>
                        <dd class="col-sm-8">{{ $booking->status_label }}</dd>

                        <dt class="col-sm-4">Sân</dt>
                        <dd class="col-sm-8">{{ $detail?->court?->name ?? 'Không có' }}</dd>

                        <dt class="col-sm-4">Ngày đặt</dt>
                        <dd class="col-sm-8">{{ $detail?->booking_date?->format('d/m/Y') ?? 'Không có' }}</dd>

                        <dt class="col-sm-4">Ca giờ</dt>
                        <dd class="col-sm-8">{{ $detail?->timeSlot?->label ?? 'Không có' }}</dd>

                        @if ($booking->approver)
                            <dt class="col-sm-4">Người duyệt</dt>
                            <dd class="col-sm-8">{{ $booking->approver->name }}</dd>
                        @endif

                        @if ($booking->rejection_reason)
                            <dt class="col-sm-4">Lý do từ chối</dt>
                            <dd class="col-sm-8">{{ $booking->rejection_reason }}</dd>
                        @endif

                        @if ($booking->cancel_reason)
                            <dt class="col-sm-4">Lý do hủy</dt>
                            <dd class="col-sm-8">{{ $booking->cancel_reason }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            @if ($usage)
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white"><h2 class="h5 mb-0">Nhật ký sử dụng</h2></div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Trạng thái:</strong> {{ $usage->used_status_label }}</p>
                        <p class="mb-2"><strong>Người xác nhận:</strong> {{ $usage->checker?->name ?? 'Không có' }}</p>
                        <p class="mb-2"><strong>Giờ check-in:</strong> {{ $usage->checked_in_at?->format('d/m/Y H:i') ?? 'Không có' }}</p>
                        <p class="mb-0"><strong>Ghi chú:</strong> {{ $usage->note ?: 'Chưa có ghi chú' }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h2 class="h5 mb-0">{{ $isStaff ? 'Xử lý phiếu đặt' : 'Thao tác của tôi' }}</h2></div>
                <div class="card-body">
                    @if ($isStaff)
                        @if (!in_array($booking->status, ['completed', 'cancelled']))
                            <form action="{{ route('bookings.approve', $booking) }}" method="POST" class="mb-3">
                                @csrf
                                <button class="btn btn-success w-100">Duyệt phiếu đặt</button>
                            </form>

                            <form action="{{ route('bookings.reject', $booking) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label">Lý do từ chối</label>
                                    <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Nhập lý do từ chối phiếu đặt này.">{{ old('rejection_reason', $booking->rejection_reason) }}</textarea>
                                </div>
                                <button class="btn btn-danger w-100">Từ chối phiếu đặt</button>
                            </form>
                        @endif

                        @if (!in_array($booking->status, ['completed', 'cancelled'], true))
                            @can('delete', $booking)
                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="mb-2">
                                        <label class="form-label">Ghi chú hủy</label>
                                        <input type="text" name="cancel_reason" class="form-control" value="{{ old('cancel_reason', $booking->cancel_reason) }}">
                                    </div>
                                    <button class="btn btn-outline-danger w-100">Hủy phiếu đặt</button>
                                </form>
                            @endcan
                        @else
                            <p class="text-muted mb-0">Phiếu này đã ở trạng thái cuối nên không còn thao tác workflow nào khả dụng.</p>
                        @endif
                    @else
                        @can('update', $booking)
                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary w-100 mb-3">Sửa phiếu đặt</a>
                        @endcan

                        @can('delete', $booking)
                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="mb-2">
                                    <label class="form-label">Ghi chú hủy</label>
                                    <input type="text" name="cancel_reason" class="form-control" value="{{ old('cancel_reason', $booking->cancel_reason) }}">
                                </div>
                                <button class="btn btn-outline-danger w-100">Hủy phiếu đặt</button>
                            </form>
                        @else
                            <p class="text-muted mb-0">Phiếu này không còn cho phép chỉnh sửa hoặc hủy.</p>
                        @endcan
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

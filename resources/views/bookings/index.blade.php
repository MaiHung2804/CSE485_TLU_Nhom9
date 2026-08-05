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
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="page-title mb-0">{{ $isStaff ? 'Quản lý phiếu đặt sân' : 'Phiếu đặt sân của tôi' }}</h1>
            <p class="section-subtitle mb-0">{{ $isStaff ? 'Theo dõi và xử lý toàn bộ booking trong hệ thống.' : 'Xem tiến độ phê duyệt và lịch sử các phiếu bạn đã tạo.' }}</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">Tạo phiếu đặt</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Người đặt</th>
                        <th>Sân</th>
                        <th>Ngày</th>
                        <th>Ca giờ</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        @php($detail = $booking->primaryDetail)
                        <tr>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $detail?->court?->name ?? 'Không có' }}</td>
                            <td>{{ $detail?->booking_date?->format('d/m/Y') ?? 'Không có' }}</td>
                            <td>{{ $detail?->timeSlot?->label ?? 'Không có' }}</td>
                            <td>
                                <span class="status-pill {{ $statusClasses[$booking->status] ?? 'bg-light text-dark' }}">
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">Xem</a>

                                @if (!in_array($booking->status, ['cancelled', 'completed'], true))
                                    @can('update', $booking)
                                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-secondary">Sửa</a>
                                    @endcan
                                @endif

                                @if (!in_array($booking->status, ['cancelled', 'completed'], true))
                                    @can('delete', $booking)
                                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn hủy phiếu đặt này?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="cancel_reason" value="Hủy từ danh sách phiếu đặt.">
                                            <button class="btn btn-sm btn-outline-danger">Hủy</button>
                                        </form>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có phiếu đặt nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $bookings->links() }}</div>
@endsection

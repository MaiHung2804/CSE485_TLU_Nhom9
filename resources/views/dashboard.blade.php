@extends('layouts.app')

@section('title', 'Tổng quan')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">{{ $pageHeading }}</h1>
            <p class="section-subtitle mb-0">{{ $pageSubtitle }}</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">Tạo phiếu đặt sân</a>
    </div>

    <div class="row g-3 mb-4">
        @foreach ($cards as $card)
            <div class="col-md-3">
                <div class="card card-stat">
                    <div class="card-body">
                        <p class="text-muted mb-1">{{ $card['label'] }}</p>
                        <h2 class="mb-1">{{ $card['value'] }}</h2>
                        <small class="text-muted">{{ $card['note'] }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">{{ $recentTitle }}</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Người đặt</th>
                                    <th>Sân</th>
                                    <th>Ngày</th>
                                    <th>Ca giờ</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning-subtle text-warning-emphasis',
                                        'approved' => 'bg-info-subtle text-info-emphasis',
                                        'rejected' => 'bg-danger-subtle text-danger-emphasis',
                                        'cancelled' => 'bg-secondary-subtle text-secondary-emphasis',
                                        'completed' => 'bg-success-subtle text-success-emphasis',
                                    ];
                                @endphp

                                @forelse ($recentBookings as $booking)
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Chưa có dữ liệu booking phù hợp.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">{{ $popularTitle }}</h2>
                </div>
                <div class="card-body">
                    @forelse ($popularCourts as $court)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <div class="fw-semibold">{{ $court->name }}</div>
                                <div class="text-muted small">{{ $court->sportType->name }}</div>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $court->booking_details_count }} lượt</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Chưa có dữ liệu thống kê sân.</p>
                    @endforelse
                </div>
            </div>

            @if (! $isStaff)
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white">
                        <h2 class="h5 mb-0">Gợi ý sử dụng</h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">Sinh viên chỉ được thao tác trên phiếu đặt của chính mình.</p>
                        <p class="mb-0 text-muted">Nếu cần duyệt, sửa danh mục hoặc cập nhật nhật ký sử dụng, hãy đăng nhập bằng tài khoản quản trị viên.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

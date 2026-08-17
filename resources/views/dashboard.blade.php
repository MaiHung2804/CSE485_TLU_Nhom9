@extends('layouts.app')

@section('title', 'Tổng quan')

@section('content')
    @php
        $iconPalette = [
            ['icon' => 'bi bi-calendar2-check-fill', 'class' => 'text-primary'],
            ['icon' => 'bi bi-activity', 'class' => 'text-success'],
            ['icon' => 'bi bi-bounding-box-circles', 'class' => 'text-info'],
            ['icon' => 'bi bi-people-fill', 'class' => 'text-warning'],
        ];

        $statusClasses = [
            'pending' => 'bg-warning-subtle text-warning-emphasis',
            'approved' => 'bg-info-subtle text-info-emphasis',
            'rejected' => 'bg-danger-subtle text-danger-emphasis',
            'cancelled' => 'bg-secondary-subtle text-secondary-emphasis',
            'completed' => 'bg-success-subtle text-success-emphasis',
        ];
    @endphp

    <section class="page-hero">
        <div class="page-hero-grid">
            <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
                <div>
                    <span class="page-kicker">Bảng điều khiển trung tâm</span>
                    <h1 class="page-title">{{ $pageHeading }}</h1>
                    <p class="section-subtitle">{{ $pageSubtitle }}</p>

                    <div class="hero-meta">
                        <span class="info-chip"><i class="bi bi-lightning-charge-fill"></i>{{ $isStaff ? 'Bạn đang ở chế độ quản trị hệ thống' : 'Bạn đang ở chế độ sinh viên' }}</span>
                    </div>
                </div>

                <div class="hero-actions">
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tạo phiếu đặt sân
                    </a>
                    @if ($isStaff)
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-bar-chart-line me-2"></i>Xem báo cáo
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4 mb-4">
        @foreach ($cards as $index => $card)
            @php($visual = $iconPalette[$index % count($iconPalette)])
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-icon {{ $visual['class'] }}">
                        <i class="{{ $visual['icon'] }}"></i>
                    </div>
                    <div>
                        <span class="metric-label">{{ $card['label'] }}</span>
                        <h2>{{ $card['value'] }}</h2>
                        <p>{{ $card['note'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card table-card">
                <div class="table-toolbar">
                    <div>
                        <h2 class="section-title h4 mb-1">{{ $recentTitle }}</h2>
                        <p class="section-subtitle mb-0">Danh sách booking mới nhất giúp theo dõi nhanh tiến độ xử lý từng yêu cầu đặt sân.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-clock-history"></i>Cập nhật theo dữ liệu hệ thống</span>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentBookings as $booking)
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">Chưa có dữ liệu booking phù hợp để hiển thị trên bảng điều khiển.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="col-xl-4">
            <section class="surface-card side-note-card mb-4">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <h2 class="section-title h5 mb-1">{{ $popularTitle }}</h2>
                        <p class="section-subtitle mb-0">Những sân được sử dụng nhiều nhất trong giai đoạn hiện tại.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-fire"></i>Top khai thác</span>
                </div>

                <div class="quick-list">
                    @forelse ($popularCourts as $court)
                        <div class="quick-item">
                            <div>
                                <div class="fw-semibold">{{ $court->name }}</div>
                                <div class="table-secondary-text">{{ $court->sportType->name }}</div>
                            </div>
                            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $court->booking_details_count }} lượt</span>
                        </div>
                    @empty
                        <div class="empty-state">Chưa có dữ liệu thống kê sân được đặt nhiều.</div>
                    @endforelse
                </div>
            </section>

            <section class="surface-card side-note-card">
                <h2 class="section-title h5 mb-3">{{ $isStaff ? 'Checklist quản trị' : 'Gợi ý cho sinh viên' }}</h2>

                @if ($isStaff)
                    <ol class="workflow-list">
                        <li><strong>Kiểm tra phiếu chờ duyệt:</strong> xác nhận sân, ca giờ và tình trạng tài nguyên trước khi duyệt.</li>
                        <li><strong>Cập nhật lịch mở:</strong> đảm bảo sân đang mở theo đúng ca và không ở trạng thái bảo trì.</li>
                        <li><strong>Ghi nhận sử dụng:</strong> sau khi hoàn tất buổi chơi, cập nhật nhật ký để số liệu báo cáo chính xác.</li>
                    </ol>
                @else
                    <ol class="workflow-list">
                        <li><strong>Tạo booking sớm:</strong> chọn sân phù hợp và tránh các ca cao điểm để tăng khả năng được duyệt.</li>
                        <li><strong>Theo dõi trạng thái:</strong> quay lại danh sách phiếu đặt để biết yêu cầu đang chờ duyệt hay đã được xác nhận.</li>
                        <li><strong>Chỉ thao tác trên phiếu của mình:</strong> hệ thống đã giới hạn quyền chỉnh sửa và hủy booking theo đúng vai trò.</li>
                    </ol>
                @endif
            </section>
        </div>
    </div>
@endsection

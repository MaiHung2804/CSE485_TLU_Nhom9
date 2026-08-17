@extends('layouts.app')

@section('title', 'Báo cáo')

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Chờ duyệt',
            'approved' => 'Đã duyệt',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
            'rejected' => 'Từ chối',
        ];

        $usageLabels = [
            'used' => 'Đã sử dụng',
            'no_show' => 'Không đến',
            'cancelled' => 'Đã hủy',
        ];

        $statusTotal = collect($statusCounts)->sum();
        $usageTotal = collect($usageCounts)->sum();
        $summaryCards = [
            ['label' => 'Tổng booking', 'value' => $summary['total_bookings'], 'icon' => 'bi bi-journal-check', 'class' => 'text-primary'],
            ['label' => 'Chờ duyệt', 'value' => $summary['pending_bookings'], 'icon' => 'bi bi-hourglass-split', 'class' => 'text-warning'],
            ['label' => 'Đã duyệt', 'value' => $summary['approved_bookings'], 'icon' => 'bi bi-patch-check-fill', 'class' => 'text-info'],
            ['label' => 'Hoàn tất / Đã hủy', 'value' => $summary['completed_bookings'] . ' / ' . $summary['cancelled_bookings'], 'icon' => 'bi bi-flag-fill', 'class' => 'text-success'],
        ];
    @endphp

    <section class="page-hero">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Phân tích vận hành</span>
                <h1 class="page-title">Báo cáo và thống kê hệ thống</h1>
                <p class="section-subtitle">Theo dõi tổng quan booking, tình trạng sử dụng sân và xu hướng khai thác tài nguyên để minh họa rõ giá trị quản lý của đề tài.</p>
            </div>

            <div class="hero-actions">
                <span class="info-chip"><i class="bi bi-calendar-range"></i>Từ {{ \Illuminate\Support\Carbon::parse($from)->format('d/m/Y') }} đến {{ \Illuminate\Support\Carbon::parse($to)->format('d/m/Y') }}</span>
            </div>
        </div>
    </section>

    <section class="surface-card form-panel mb-4">
        <div class="panel-header">
            <span class="panel-kicker">Bộ lọc thời gian</span>
            <h2 class="section-title h4 mb-1">Lọc khoảng báo cáo</h2>
            <p class="section-subtitle mb-0">Thay đổi mốc thời gian để quan sát biến động booking và mức độ sử dụng sân theo từng giai đoạn.</p>
        </div>

        <div class="panel-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="from" class="form-control" value="{{ $from }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="to" class="form-control" value="{{ $to }}">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill me-2"></i>Lọc báo cáo
                    </button>
                </div>
            </form>
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
                        <p>Tổng hợp trực tiếp từ dữ liệu booking và nhật ký sử dụng trong khoảng đã lọc.</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-6">
            <section class="surface-card side-note-card h-100">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <h2 class="section-title h5 mb-1">Phân bố trạng thái booking</h2>
                        <p class="section-subtitle mb-0">Nhìn nhanh tỷ trọng phiếu chờ duyệt, đã duyệt, hoàn tất hoặc bị từ chối.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-bar-chart-steps"></i>{{ $statusTotal }} bản ghi</span>
                </div>

                <div class="quick-list">
                    @forelse ($statusCounts as $status => $total)
                        @php($percent = $statusTotal > 0 ? round(($total / $statusTotal) * 100) : 0)
                        <div class="quick-item d-block">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fw-semibold">{{ $statusLabels[$status] ?? $status }}</div>
                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $total }} • {{ $percent }}%</span>
                            </div>
                            <div class="progress-soft">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Chưa có dữ liệu trạng thái booking trong khoảng thời gian đã chọn.</div>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="col-xl-6">
            <section class="surface-card side-note-card h-100">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <h2 class="section-title h5 mb-1">Phân bố trạng thái sử dụng</h2>
                        <p class="section-subtitle mb-0">Phản ánh mức độ sử dụng thực tế của các booking đã phát sinh.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-clipboard2-pulse-fill"></i>{{ $usageTotal }} bản ghi</span>
                </div>

                <div class="quick-list">
                    @forelse ($usageCounts as $status => $total)
                        @php($percent = $usageTotal > 0 ? round(($total / $usageTotal) * 100) : 0)
                        <div class="quick-item d-block">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fw-semibold">{{ $usageLabels[$status] ?? $status }}</div>
                                <span class="badge bg-success rounded-pill px-3 py-2">{{ $total }} • {{ $percent }}%</span>
                            </div>
                            <div class="progress-soft">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Chưa có dữ liệu nhật ký sử dụng trong khoảng thời gian đã chọn.</div>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="col-xl-6">
            <section class="surface-card table-card">
                <div class="table-toolbar">
                    <div>
                        <h2 class="section-title h5 mb-1">Top sân được đặt nhiều</h2>
                        <p class="section-subtitle mb-0">Các tài nguyên nổi bật cho thấy nhu cầu sử dụng cao trong hệ thống.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-trophy"></i>Top khai thác</span>
                </div>

                <div class="table-responsive">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>Sân</th>
                                <th>Môn</th>
                                <th>Lượt đặt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topCourts as $court)
                                <tr>
                                    <td class="fw-semibold">{{ $court->name }}</td>
                                    <td>{{ $court->sportType->name }}</td>
                                    <td>{{ $court->booking_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state">Chưa có dữ liệu top sân trong khoảng thời gian đã chọn.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="col-xl-6">
            <section class="surface-card table-card">
                <div class="table-toolbar">
                    <div>
                        <h2 class="section-title h5 mb-1">Top sinh viên đặt sân</h2>
                        <p class="section-subtitle mb-0">Cho thấy nhóm người dùng tích cực sử dụng tài nguyên thể thao của trường.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-people-fill"></i>Người dùng nổi bật</span>
                </div>

                <div class="table-responsive">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>Sinh viên</th>
                                <th>Email</th>
                                <th>Lượt đặt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topStudents as $student)
                                <tr>
                                    <td class="fw-semibold">{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->booking_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state">Chưa có dữ liệu top sinh viên trong khoảng thời gian đã chọn.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="col-xl-5">
            <section class="surface-card table-card">
                <div class="table-toolbar">
                    <div>
                        <h2 class="section-title h5 mb-1">Xu hướng booking theo ngày</h2>
                        <p class="section-subtitle mb-0">Biểu hiện nhịp sử dụng hệ thống theo từng ngày trong khoảng lọc.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-graph-up-arrow"></i>Xu hướng</span>
                </div>

                <div class="table-responsive">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Số booking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dailyTrend as $trend)
                                <tr>
                                    <td>{{ \Illuminate\Support\Carbon::parse($trend->booking_date)->format('d/m/Y') }}</td>
                                    <td>{{ $trend->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="empty-state">Chưa có dữ liệu xu hướng booking trong khoảng thời gian đã chọn.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="col-xl-7">
            <section class="surface-card table-card">
                <div class="table-toolbar">
                    <div>
                        <h2 class="section-title h5 mb-1">Nhật ký sử dụng gần nhất</h2>
                        <p class="section-subtitle mb-0">Đối chiếu giữa phiếu đã duyệt và tình trạng sử dụng thực tế của từng buổi chơi.</p>
                    </div>
                    <span class="info-chip"><i class="bi bi-clock-history"></i>Dữ liệu gần nhất</span>
                </div>

                <div class="table-responsive">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>Người đặt</th>
                                <th>Sân</th>
                                <th>Ngày</th>
                                <th>Ca giờ</th>
                                <th>Sử dụng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsage as $detail)
                                <tr>
                                    <td>{{ $detail->booking->user->name }}</td>
                                    <td>{{ $detail->court->name }}</td>
                                    <td>{{ $detail->booking_date->format('d/m/Y') }}</td>
                                    <td>{{ $detail->timeSlot->label }}</td>
                                    <td>{{ $detail->usageLog?->used_status_label ?? 'Chưa cập nhật' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">Chưa có dữ liệu nhật ký sử dụng.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection

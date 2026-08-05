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
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="page-title mb-0">Báo cáo và thống kê</h1>
            <p class="section-subtitle mb-0">Theo dõi số lượng booking, trạng thái sử dụng và các sân được khai thác nhiều nhất.</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
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
                    <button class="btn btn-primary w-100">Lọc báo cáo</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-stat">
                <div class="card-body">
                    <p class="text-muted mb-1">Tổng booking</p>
                    <h2 class="mb-0">{{ $summary['total_bookings'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat">
                <div class="card-body">
                    <p class="text-muted mb-1">Chờ duyệt</p>
                    <h2 class="mb-0">{{ $summary['pending_bookings'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat">
                <div class="card-body">
                    <p class="text-muted mb-1">Đã duyệt</p>
                    <h2 class="mb-0">{{ $summary['approved_bookings'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat">
                <div class="card-body">
                    <p class="text-muted mb-1">Hoàn tất / Đã hủy</p>
                    <h2 class="mb-0">{{ $summary['completed_bookings'] }} / {{ $summary['cancelled_bookings'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h2 class="h5 mb-0">Phân bố trạng thái booking</h2></div>
                <div class="card-body">
                    @forelse ($statusCounts as $status => $total)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span>{{ $statusLabels[$status] ?? $status }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $total }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Chưa có dữ liệu trạng thái booking trong khoảng thời gian đã chọn.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h2 class="h5 mb-0">Phân bố trạng thái sử dụng</h2></div>
                <div class="card-body">
                    @forelse ($usageCounts as $status => $total)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span>{{ $usageLabels[$status] ?? $status }}</span>
                            <span class="badge bg-success rounded-pill">{{ $total }}</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Chưa có dữ liệu nhật ký sử dụng trong khoảng thời gian đã chọn.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h2 class="h5 mb-0">Top sân được đặt nhiều</h2></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sân</th>
                                    <th>Môn</th>
                                    <th>Lượt đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topCourts as $court)
                                    <tr>
                                        <td>{{ $court->name }}</td>
                                        <td>{{ $court->sportType->name }}</td>
                                        <td>{{ $court->booking_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Chưa có dữ liệu top sân.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h2 class="h5 mb-0">Top sinh viên đặt sân</h2></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sinh viên</th>
                                    <th>Email</th>
                                    <th>Lượt đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topStudents as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->booking_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Chưa có dữ liệu top sinh viên.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h2 class="h5 mb-0">Xu hướng booking theo ngày</h2></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
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
                                        <td colspan="2" class="text-center py-4 text-muted">Chưa có dữ liệu xu hướng trong khoảng thời gian đã chọn.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h2 class="h5 mb-0">Nhật ký sử dụng gần nhất</h2></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
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
                                        <td colspan="5" class="text-center py-4 text-muted">Chưa có dữ liệu nhật ký sử dụng.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Nhật ký sử dụng')

@section('content')
    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Theo dõi sau đặt sân</span>
                <h1 class="page-title">Nhật ký sử dụng sân</h1>
                <p class="section-subtitle">Cập nhật tình trạng thực tế sau khi booking được duyệt để tạo dữ liệu cho báo cáo sử dụng và đối soát nghiệp vụ.</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-journal-check me-2"></i>Xem phiếu đặt
                </a>
                <span class="info-chip"><i class="bi bi-clipboard2-data-fill"></i>{{ $bookingDetails->total() }} dòng theo dõi</span>
            </div>
        </div>
    </section>

    <section class="surface-card table-card">
        <div class="table-toolbar">
            <div>
                <h2 class="section-title h4 mb-1">Danh sách check-in và sử dụng</h2>
                <p class="section-subtitle mb-0">Mỗi dòng đại diện cho một booking detail cần được xác nhận tình trạng sử dụng thực tế.</p>
            </div>
            <span class="info-chip"><i class="bi bi-check2-square"></i>Cập nhật trực tiếp trên bảng</span>
        </div>

        <div class="table-responsive">
            <table class="table data-table align-middle">
                <thead>
                    <tr>
                        <th>Người đặt</th>
                        <th>Sân</th>
                        <th>Ngày</th>
                        <th>Ca giờ</th>
                        <th>Trạng thái phiếu</th>
                        <th>Cập nhật sử dụng</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookingDetails as $bookingDetail)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $bookingDetail->booking->user->name }}</div>
                                <div class="table-secondary-text">{{ $bookingDetail->booking->user->email }}</div>
                            </td>
                            <td>{{ $bookingDetail->court->name }}</td>
                            <td>{{ $bookingDetail->booking_date->format('d/m/Y') }}</td>
                            <td>{{ $bookingDetail->timeSlot->label }}</td>
                            <td>{{ $bookingDetail->booking->status_label }}</td>
                            <td>
                                <form action="{{ route('usage-logs.store', $bookingDetail) }}" method="POST" class="row g-2">
                                    @csrf
                                    <div class="col-md-4">
                                        <select name="used_status" class="form-select form-select-sm">
                                            @php $currentStatus = old('used_status', $bookingDetail->usageLog->used_status ?? 'used'); @endphp
                                            <option value="used" @selected($currentStatus === 'used')>Đã sử dụng</option>
                                            <option value="no_show" @selected($currentStatus === 'no_show')>Không đến</option>
                                            <option value="cancelled" @selected($currentStatus === 'cancelled')>Đã hủy</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="note" class="form-control form-control-sm" value="{{ old('note', $bookingDetail->usageLog->note ?? '') }}" placeholder="Ghi chú thêm nếu cần">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-sm btn-primary w-100">
                                            <i class="bi bi-save2 me-1"></i>Lưu
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">Chưa có phiếu phù hợp để theo dõi nhật ký sử dụng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-3">{{ $bookingDetails->links() }}</div>
@endsection

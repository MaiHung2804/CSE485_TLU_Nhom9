@extends('layouts.app')

@section('title', 'Nhật ký sử dụng')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title mb-0">Nhật ký sử dụng sân</h1>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Xem phiếu đặt</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
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
                            <td>{{ $bookingDetail->booking->user->name }}</td>
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
                                        <button class="btn btn-sm btn-primary w-100">Lưu</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có phiếu phù hợp để theo dõi nhật ký sử dụng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $bookingDetails->links() }}</div>
@endsection

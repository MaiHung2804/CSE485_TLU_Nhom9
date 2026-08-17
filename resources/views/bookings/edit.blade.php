@extends('layouts.app')

@section('title', 'Sửa phiếu đặt')

@section('content')
    @php($detail = $booking->primaryDetail)

    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Điều chỉnh booking</span>
                <h1 class="page-title">Sửa phiếu đặt sân</h1>
                <p class="section-subtitle">Cập nhật thông tin booking trước khi phiếu đi vào trạng thái cuối. Những thay đổi sẽ được kiểm tra lại theo ràng buộc lịch mở và xung đột ca giờ.</p>
            </div>

            <div class="hero-actions">
                <span class="info-chip"><i class="bi bi-pencil-square"></i>Đang chỉnh sửa phiếu #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu cập nhật</span>
                    <h2 class="section-title h4 mb-1">Thông tin cần điều chỉnh</h2>
                    <p class="section-subtitle mb-0">Sửa đúng các trường cần thiết để giữ dữ liệu nhất quán và đúng workflow đã thiết kế.</p>
                </div>

                <div class="panel-body">
                    <form action="{{ route('bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            @if ($isStaff)
                                <div class="col-md-6">
                                    <label class="form-label">Người đặt</label>
                                    <select name="user_id" class="form-select" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id', $booking->user_id) == $user->id)>{{ $user->name }} ({{ $user->role_label }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <label class="form-label">Người đặt</label>
                                    <input type="text" class="form-control" value="{{ $users->first()->name }} ({{ $users->first()->role_label }})" disabled>
                                    <input type="hidden" name="user_id" value="{{ $users->first()->id }}">
                                </div>
                            @endif

                            <div class="col-md-6">
                                <label class="form-label">Sân</label>
                                <select name="court_id" class="form-select" required>
                                    @foreach ($courts as $court)
                                        <option value="{{ $court->id }}" @selected(old('court_id', $detail?->court_id) == $court->id)>{{ $court->name }} - {{ $court->sportType->name }} ({{ $court->status_label }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ngày đặt</label>
                                <input type="date" name="booking_date" class="form-control" value="{{ old('booking_date', optional($detail?->booking_date)->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ca giờ</label>
                                <select name="time_slot_id" class="form-select" required>
                                    @foreach ($timeSlots as $timeSlot)
                                        <option value="{{ $timeSlot->id }}" @selected(old('time_slot_id', $detail?->time_slot_id) == $timeSlot->id)>{{ $timeSlot->label }} ({{ substr($timeSlot->start_time, 0, 5) }} - {{ substr($timeSlot->end_time, 0, 5) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Số người chơi</label>
                                <input type="number" name="player_count" class="form-control" value="{{ old('player_count', $booking->player_count) }}" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại liên hệ</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $booking->contact_phone) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Mục đích sử dụng</label>
                                <input type="text" name="purpose" class="form-control" value="{{ old('purpose', $booking->purpose) }}" required>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-check2-circle me-2"></i>Cập nhật phiếu đặt
                            </button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <div class="col-xl-4">
            <section class="surface-card side-note-card mb-4">
                <h2 class="section-title h5 mb-3">Tóm tắt hiện tại</h2>
                <div class="quick-list">
                    <div class="quick-item">
                        <div>
                            <div class="fw-semibold">Mã phiếu</div>
                            <div class="table-secondary-text">Nhận diện nhanh khi demo</div>
                        </div>
                        <span class="badge bg-primary rounded-pill px-3 py-2">#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="quick-item">
                        <div>
                            <div class="fw-semibold">Trạng thái</div>
                            <div class="table-secondary-text">Theo workflow hiện tại</div>
                        </div>
                        <span class="badge bg-light text-dark border px-3 py-2">{{ $booking->status_label }}</span>
                    </div>
                    <div class="quick-item">
                        <div>
                            <div class="fw-semibold">Sân đang chọn</div>
                            <div class="table-secondary-text">{{ $detail?->court?->sportType?->name ?? 'Chưa xác định môn' }}</div>
                        </div>
                        <span class="badge bg-info-subtle text-info-emphasis border px-3 py-2">{{ $detail?->court?->name ?? 'Không có' }}</span>
                    </div>
                </div>
            </section>

            <section class="surface-card side-note-card">
                <h2 class="section-title h5 mb-3">Lưu ý chỉnh sửa</h2>
                <ul class="rule-list">
                    <li><strong>Không đổi tùy tiện khi đã gần ngày sử dụng:</strong> giúp việc kiểm soát lịch mở và báo cáo nhất quán hơn.</li>
                    <li><strong>Ca giờ phải hợp lệ:</strong> nếu chọn sang ca khác, hệ thống vẫn kiểm tra xung đột booking cho cùng tài nguyên.</li>
                    <li><strong>Giữ thông tin liên hệ chính xác:</strong> quản trị viên cần dữ liệu này khi xử lý phiếu trong lúc demo nghiệp vụ.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

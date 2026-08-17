@extends('layouts.app')

@section('title', 'Tạo phiếu đặt')

@section('content')
    <section class="page-hero compact">
        <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">
            <div>
                <span class="page-kicker">Khởi tạo booking mới</span>
                <h1 class="page-title">Tạo phiếu đặt sân</h1>
                <p class="section-subtitle">Điền thông tin cần thiết để gửi yêu cầu đặt sân.</p>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-xl-8">
            <section class="surface-card form-panel">
                <div class="panel-header">
                    <span class="panel-kicker">Biểu mẫu nhập liệu</span>
                    <h2 class="section-title h4 mb-1">Thông tin phiếu đặt</h2>
                    <p class="section-subtitle mb-0">Chọn đúng sân, ngày và ca giờ phù hợp với nhu cầu sử dụng.</p>
                </div>

                <div class="panel-body">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            @if ($isStaff)
                                <div class="col-md-6">
                                    <label class="form-label">Người đặt</label>
                                    <select name="user_id" class="form-select" required>
                                        <option value="">Chọn người đặt</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} ({{ $user->role_label }})</option>
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
                                    <option value="">Chọn sân</option>
                                    @foreach ($courts as $court)
                                        <option value="{{ $court->id }}" @selected(old('court_id') == $court->id)>{{ $court->name }} - {{ $court->sportType->name }} ({{ $court->status_label }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ngày đặt</label>
                                <input type="date" name="booking_date" class="form-control" value="{{ old('booking_date') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ca giờ</label>
                                <select name="time_slot_id" class="form-select" required>
                                    <option value="">Chọn ca giờ</option>
                                    @foreach ($timeSlots as $timeSlot)
                                        <option value="{{ $timeSlot->id }}" @selected(old('time_slot_id') == $timeSlot->id)>{{ $timeSlot->label }} ({{ substr($timeSlot->start_time, 0, 5) }} - {{ substr($timeSlot->end_time, 0, 5) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Số người chơi</label>
                                <input type="number" name="player_count" class="form-control" value="{{ old('player_count') }}" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại liên hệ</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}" placeholder="Ví dụ: 09xxxxxxxx" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Mục đích sử dụng</label>
                                <input type="text" name="purpose" class="form-control" value="{{ old('purpose') }}" placeholder="Ví dụ: Luyện tập CLB cầu lông lớp K63" required>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-save2 me-2"></i>Lưu phiếu đặt
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
                <h2 class="section-title h5 mb-3">Quy trình xử lý</h2>
                <ol class="workflow-list">
                    <li><strong>Khởi tạo yêu cầu:</strong> nhập đủ người đặt, sân, ca giờ và thông tin liên hệ.</li>
                    <li><strong>Kiểm tra ràng buộc:</strong> hệ thống chặn booking trùng ca hoặc sân đang bảo trì.</li>
                    <li><strong>Phê duyệt:</strong> quản trị viên duyệt hoặc từ chối với lý do cụ thể.</li>
                    <li><strong>Ghi nhận sử dụng:</strong> sau buổi chơi, dữ liệu sẽ đi tiếp sang nhật ký sử dụng và báo cáo.</li>
                </ol>
            </section>

            <section class="surface-card side-note-card">
                <h2 class="section-title h5 mb-3">Lưu ý khi nhập liệu</h2>
                <ul class="rule-list">
                    <li><strong>Chọn sân đang hoạt động:</strong> các sân tạm ngưng hoặc bảo trì sẽ không phù hợp cho booking mới.</li>
                    <li><strong>Ca giờ phải thuộc lịch mở:</strong> nên đối chiếu với module lịch mở sân nếu bạn đang demo vai trò quản trị.</li>
                    <li><strong>Mục đích sử dụng rõ ràng:</strong> giúp phần trình bày nghiệp vụ của đề tài thuyết phục hơn khi vấn đáp.</li>
                </ul>
            </section>
        </div>
    </div>
@endsection

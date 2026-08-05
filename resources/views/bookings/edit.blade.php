@extends('layouts.app')

@section('title', 'Sửa phiếu đặt')

@section('content')
    @php($detail = $booking->primaryDetail)

    <div class="card shadow-sm">
        <div class="card-header bg-white"><h1 class="h4 mb-0">Sửa phiếu đặt sân</h1></div>
        <div class="card-body">
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
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

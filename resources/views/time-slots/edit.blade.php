@extends('layouts.app')

@section('title', 'Sửa ca giờ')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white"><h1 class="h4 mb-0">Sửa ca giờ</h1></div>
        <div class="card-body">
            <form action="{{ route('time-slots.update', $timeSlot) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tên ca</label>
                        <input type="text" name="label" class="form-control" value="{{ old('label', $timeSlot->label) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Giờ bắt đầu</label>
                        <input type="time" name="start_time" class="form-control" value="{{ old('start_time', substr($timeSlot->start_time, 0, 5)) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Giờ kết thúc</label>
                        <input type="time" name="end_time" class="form-control" value="{{ old('end_time', substr($timeSlot->end_time, 0, 5)) }}" required>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('time-slots.index') }}" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Sửa sân')

@section('content')
    @php
        $statusLabels = [
            'active' => 'Đang hoạt động',
            'inactive' => 'Tạm ngưng',
            'maintenance' => 'Bảo trì',
        ];
    @endphp

    <div class="card shadow-sm">
        <div class="card-header bg-white"><h1 class="h4 mb-0">Sửa thông tin sân</h1></div>
        <div class="card-body">
            <form action="{{ route('courts.update', $court) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Môn thể thao</label>
                        <select name="sport_type_id" class="form-select" required>
                            @foreach ($sportTypes as $sportType)
                                <option value="{{ $sportType->id }}" @selected(old('sport_type_id', $court->sport_type_id) == $sportType->id)>{{ $sportType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', $court->status) === $status)>{{ $statusLabels[$status] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tên sân</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $court->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mã sân</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $court->code) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Vị trí</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $court->location) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sức chứa</label>
                        <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $court->capacity) }}" min="1" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $court->description) }}</textarea>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('courts.index') }}" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Thêm môn thể thao')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white"><h1 class="h4 mb-0">Thêm môn thể thao</h1></div>
        <div class="card-body">
            <form action="{{ route('sport-types.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tên môn</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Lưu</button>
                    <a href="{{ route('sport-types.index') }}" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection

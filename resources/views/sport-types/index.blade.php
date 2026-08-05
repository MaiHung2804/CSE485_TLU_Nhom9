@extends('layouts.app')

@section('title', 'Môn thể thao')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title mb-0">Danh mục môn thể thao</h1>
        <a href="{{ route('sport-types.create') }}" class="btn btn-primary">Thêm môn thể thao</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên môn</th>
                        <th>Mô tả</th>
                        <th>Số sân</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sportTypes as $sportType)
                        <tr>
                            <td class="fw-semibold">{{ $sportType->name }}</td>
                            <td>{{ $sportType->description ?: 'Chưa có mô tả' }}</td>
                            <td>{{ $sportType->courts_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('sport-types.edit', $sportType) }}" class="btn btn-sm btn-outline-secondary">Sửa</a>
                                <form action="{{ route('sport-types.destroy', $sportType) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa môn thể thao này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Chưa có môn thể thao nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $sportTypes->links() }}
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Sân thể thao')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title mb-0">Danh sách sân thể thao</h1>
        <a href="{{ route('courts.create') }}" class="btn btn-primary">Thêm sân</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên sân</th>
                        <th>Môn thể thao</th>
                        <th>Mã sân</th>
                        <th>Vị trí</th>
                        <th>Sức chứa</th>
                        <th>Trạng thái</th>
                        <th>Lượt đặt</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courts as $court)
                        <tr>
                            <td class="fw-semibold">{{ $court->name }}</td>
                            <td>{{ $court->sportType->name }}</td>
                            <td>{{ $court->code }}</td>
                            <td>{{ $court->location }}</td>
                            <td>{{ $court->capacity }}</td>
                            <td>{{ $court->status_label }}</td>
                            <td>{{ $court->booking_details_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('courts.edit', $court) }}" class="btn btn-sm btn-outline-secondary">Sửa</a>
                                <form action="{{ route('courts.destroy', $court) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa hoặc tạm ngưng sân này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Chưa có sân nào được khai báo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $courts->links() }}</div>
@endsection

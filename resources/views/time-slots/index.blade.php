@extends('layouts.app')

@section('title', 'Ca giờ')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title mb-0">Danh sách ca giờ</h1>
        <a href="{{ route('time-slots.create') }}" class="btn btn-primary">Thêm ca giờ</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên ca</th>
                        <th>Giờ bắt đầu</th>
                        <th>Giờ kết thúc</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($timeSlots as $timeSlot)
                        <tr>
                            <td class="fw-semibold">{{ $timeSlot->label }}</td>
                            <td>{{ substr($timeSlot->start_time, 0, 5) }}</td>
                            <td>{{ substr($timeSlot->end_time, 0, 5) }}</td>
                            <td class="text-end">
                                <a href="{{ route('time-slots.edit', $timeSlot) }}" class="btn btn-sm btn-outline-secondary">Sửa</a>
                                <form action="{{ route('time-slots.destroy', $timeSlot) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa ca giờ này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Chưa có ca giờ nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $timeSlots->links() }}</div>
@endsection

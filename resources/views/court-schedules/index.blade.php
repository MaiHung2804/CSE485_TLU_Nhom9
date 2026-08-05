@extends('layouts.app')

@section('title', 'Lịch mở sân')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title mb-0">Lịch mở sân theo ca</h1>
        <a href="{{ route('court-schedules.create') }}" class="btn btn-primary">Thêm lịch mở</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sân</th>
                        <th>Môn thể thao</th>
                        <th>Thứ</th>
                        <th>Ca giờ</th>
                        <th>Mở đặt</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courtSchedules as $courtSchedule)
                        <tr>
                            <td class="fw-semibold">{{ $courtSchedule->court->name }}</td>
                            <td>{{ $courtSchedule->court->sportType->name }}</td>
                            <td>{{ $dayOptions[$courtSchedule->day_of_week] }}</td>
                            <td>{{ $courtSchedule->timeSlot->label }}</td>
                            <td>{{ $courtSchedule->is_open ? 'Có' : 'Không' }}</td>
                            <td class="text-end">
                                <a href="{{ route('court-schedules.edit', $courtSchedule) }}" class="btn btn-sm btn-outline-secondary">Sửa</a>
                                <form action="{{ route('court-schedules.destroy', $courtSchedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa lịch mở này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có lịch mở nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $courtSchedules->links() }}</div>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use App\Models\SportType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $isStaff = $user->isStaff();

        if ($isStaff) {
            $cards = [
                ['label' => 'Môn thể thao', 'value' => SportType::count(), 'note' => 'Danh mục đang quản lý'],
                ['label' => 'Tổng sân / Đang mở', 'value' => Court::count().' / '.Court::where('status', 'active')->count(), 'note' => 'Theo trạng thái sân'],
                ['label' => 'Chờ duyệt / Đã duyệt', 'value' => Booking::where('status', 'pending')->count().' / '.Booking::where('status', 'approved')->count(), 'note' => 'Theo workflow booking'],
                ['label' => 'Hoàn tất', 'value' => Booking::where('status', 'completed')->count(), 'note' => 'Đã sử dụng xong'],
            ];

            $recentBookings = Booking::with(['user', 'primaryDetail.court.sportType', 'primaryDetail.timeSlot'])
                ->latest()
                ->take(6)
                ->get();

            $popularCourts = Court::with('sportType')
                ->withCount('bookingDetails')
                ->orderByDesc('booking_details_count')
                ->take(5)
                ->get();

            return view('dashboard', [
                'isStaff' => true,
                'cards' => $cards,
                'recentBookings' => $recentBookings,
                'popularCourts' => $popularCourts,
                'pageHeading' => 'Bảng điều khiển đặt sân thể thao',
                'pageSubtitle' => 'Theo dõi tổng quan sân, phiếu đặt và tiến độ phê duyệt trên toàn hệ thống.',
                'recentTitle' => 'Phiếu đặt gần đây',
                'popularTitle' => 'Sân được sử dụng nhiều',
            ]);
        }

        $myBookings = Booking::query()->where('user_id', $user->id);

        $cards = [
            ['label' => 'Phiếu của tôi', 'value' => (clone $myBookings)->count(), 'note' => 'Tổng số phiếu đã tạo'],
            ['label' => 'Chờ duyệt', 'value' => (clone $myBookings)->where('status', 'pending')->count(), 'note' => 'Đang chờ quản trị viên xử lý'],
            ['label' => 'Đã duyệt', 'value' => (clone $myBookings)->where('status', 'approved')->count(), 'note' => 'Sẵn sàng sử dụng sân'],
            ['label' => 'Hoàn tất / Đã hủy', 'value' => (clone $myBookings)->where('status', 'completed')->count().' / '.(clone $myBookings)->where('status', 'cancelled')->count(), 'note' => 'Kết quả cuối của booking'],
        ];

        $recentBookings = Booking::with(['user', 'primaryDetail.court.sportType', 'primaryDetail.timeSlot'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(6)
            ->get();

        $popularCourts = Court::with('sportType')
            ->withCount([
                'bookingDetails as booking_details_count' => function ($query) use ($user) {
                    $query->whereHas('booking', function ($bookingQuery) use ($user) {
                        $bookingQuery->where('user_id', $user->id);
                    });
                },
            ])
            ->orderByDesc('booking_details_count')
            ->take(5)
            ->get();

        return view('dashboard', [
            'isStaff' => false,
            'cards' => $cards,
            'recentBookings' => $recentBookings,
            'popularCourts' => $popularCourts,
            'pageHeading' => 'Bảng điều khiển cá nhân',
            'pageSubtitle' => 'Theo dõi phiếu đặt sân của bạn, trạng thái phê duyệt và lịch sử sử dụng.',
            'recentTitle' => 'Phiếu đặt của tôi gần đây',
            'popularTitle' => 'Sân tôi đặt nhiều',
        ]);
    }
}

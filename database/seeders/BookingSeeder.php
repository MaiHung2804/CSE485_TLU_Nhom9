<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Court;
use App\Models\TimeSlot;
use App\Models\UsageLog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $student = User::where('role', 'student')->first();
        $admin = User::where('role', 'admin')->first();
        $footballCourt = Court::where('code', 'FB-A')->first();
        $volleyballCourt = Court::where('code', 'VB-B')->first();
        $basketballCourt = Court::where('code', 'BK-C')->first();
        $firstSlot = TimeSlot::find(1);
        $secondSlot = TimeSlot::find(3);

        if (! $student || ! $admin || ! $footballCourt || ! $volleyballCourt || ! $basketballCourt || ! $firstSlot || ! $secondSlot) {
            return;
        }

        $pendingBooking = Booking::updateOrCreate(
            ['purpose' => 'Tập bóng đá sinh viên năm nhất'],
            [
                'user_id' => $student->id,
                'player_count' => 12,
                'contact_phone' => '0900123456',
                'status' => 'pending',
            ]
        );

        $pendingBooking->bookingDetails()->updateOrCreate(
            ['booking_id' => $pendingBooking->id],
            [
                'court_id' => $footballCourt->id,
                'booking_date' => Carbon::now()->next(Carbon::MONDAY)->toDateString(),
                'time_slot_id' => $firstSlot->id,
            ]
        );

        $approvedBooking = Booking::updateOrCreate(
            ['purpose' => 'Buổi tập định kỳ của câu lạc bộ bóng chuyền'],
            [
                'user_id' => $student->id,
                'player_count' => 10,
                'contact_phone' => '0900234567',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ]
        );

        $approvedBooking->bookingDetails()->updateOrCreate(
            ['booking_id' => $approvedBooking->id],
            [
                'court_id' => $volleyballCourt->id,
                'booking_date' => Carbon::now()->next(Carbon::TUESDAY)->toDateString(),
                'time_slot_id' => $secondSlot->id,
            ]
        );

        $completedBooking = Booking::updateOrCreate(
            ['purpose' => 'Buổi tập kỹ thuật bóng rổ'],
            [
                'user_id' => $student->id,
                'player_count' => 8,
                'contact_phone' => '0900345678',
                'status' => 'completed',
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(2),
            ]
        );

        $completedDetail = $completedBooking->bookingDetails()->updateOrCreate(
            ['booking_id' => $completedBooking->id],
            [
                'court_id' => $basketballCourt->id,
                'booking_date' => Carbon::now()->subDay()->toDateString(),
                'time_slot_id' => $secondSlot->id,
            ]
        );

        UsageLog::updateOrCreate(
            ['booking_detail_id' => $completedDetail->id],
            [
                'checked_by' => $admin->id,
                'used_status' => 'used',
                'checked_in_at' => now()->subDay(),
                'checked_out_at' => now()->subDay()->addHours(2),
                'note' => 'Dữ liệu mẫu phục vụ báo cáo sử dụng sân trên bảng điều khiển.',
            ]
        );
    }
}

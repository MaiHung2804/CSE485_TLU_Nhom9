<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $slots = [
            ['id' => 1, 'label' => 'Ca sáng 1', 'start_time' => '07:00', 'end_time' => '09:00'],
            ['id' => 2, 'label' => 'Ca sáng 2', 'start_time' => '09:00', 'end_time' => '11:00'],
            ['id' => 3, 'label' => 'Ca chiều 1', 'start_time' => '13:00', 'end_time' => '15:00'],
            ['id' => 4, 'label' => 'Ca chiều 2', 'start_time' => '15:00', 'end_time' => '17:00'],
            ['id' => 5, 'label' => 'Ca tối', 'start_time' => '17:00', 'end_time' => '19:00'],
        ];

        foreach ($slots as $slot) {
            TimeSlot::updateOrCreate(['id' => $slot['id']], $slot);
        }
    }
}

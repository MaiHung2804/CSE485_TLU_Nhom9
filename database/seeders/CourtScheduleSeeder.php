<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\CourtSchedule;
use App\Models\TimeSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourtScheduleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $timeSlots = TimeSlot::all();

        Court::all()->each(function (Court $court) use ($timeSlots) {
            foreach (range(1, 6) as $dayOfWeek) {
                foreach ($timeSlots as $timeSlot) {
                    CourtSchedule::updateOrCreate(
                        [
                            'court_id' => $court->id,
                            'day_of_week' => $dayOfWeek,
                            'time_slot_id' => $timeSlot->id,
                        ],
                        [
                            'is_open' => $court->status !== 'maintenance',
                        ]
                    );
                }
            }
        });
    }
}

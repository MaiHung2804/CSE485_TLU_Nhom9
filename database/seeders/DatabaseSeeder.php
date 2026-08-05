<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SportTypeSeeder::class,
            TimeSlotSeeder::class,
            CourtSeeder::class,
            CourtScheduleSeeder::class,
            BookingSeeder::class,
        ]);
    }
}

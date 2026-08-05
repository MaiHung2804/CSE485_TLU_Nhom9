<?php

namespace Database\Seeders;

use App\Models\Court;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $courts = [
            [
                'sport_type_id' => 1,
                'name' => 'Sân bóng đá A',
                'code' => 'FB-A',
                'location' => 'Khuôn viên phía Bắc',
                'capacity' => 14,
                'status' => 'active',
                'description' => 'Sân cỏ nhân tạo dành cho các trận bóng đá 7 người.',
            ],
            [
                'sport_type_id' => 2,
                'name' => 'Sân bóng chuyền B',
                'code' => 'VB-B',
                'location' => 'Trung tâm sinh viên',
                'capacity' => 12,
                'status' => 'active',
                'description' => 'Sân ngoài trời dành cho luyện tập và sinh hoạt câu lạc bộ.',
            ],
            [
                'sport_type_id' => 3,
                'name' => 'Sân cầu lông 01',
                'code' => 'BD-01',
                'location' => 'Nhà thi đấu',
                'capacity' => 4,
                'status' => 'maintenance',
                'description' => 'Sân trong nhà đang tạm đóng để bảo trì mặt sàn.',
            ],
            [
                'sport_type_id' => 4,
                'name' => 'Sân bóng rổ C',
                'code' => 'BK-C',
                'location' => 'Khuôn viên phía Tây',
                'capacity' => 10,
                'status' => 'active',
                'description' => 'Nửa sân đa năng phục vụ tập luyện và giao lưu.',
            ],
        ];

        foreach ($courts as $court) {
            Court::updateOrCreate(['code' => $court['code']], $court);
        }
    }
}

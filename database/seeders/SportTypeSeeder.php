<?php

namespace Database\Seeders;

use App\Models\SportType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SportTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $sportTypes = [
            ['id' => 1, 'name' => 'Bóng đá', 'description' => 'Các sân bóng đá mini phục vụ đội sinh viên và hoạt động phong trào trong trường.'],
            ['id' => 2, 'name' => 'Bóng chuyền', 'description' => 'Sân bóng chuyền ngoài trời gần khu dịch vụ sinh viên.'],
            ['id' => 3, 'name' => 'Cầu lông', 'description' => 'Sân cầu lông trong nhà có đèn chiếu sáng cơ bản.'],
            ['id' => 4, 'name' => 'Bóng rổ', 'description' => 'Khu sân nửa sân và toàn sân phục vụ tập luyện, giao lưu.'],
        ];

        foreach ($sportTypes as $sportType) {
            SportType::updateOrCreate(['id' => $sportType['id']], $sportType);
        }
    }
}

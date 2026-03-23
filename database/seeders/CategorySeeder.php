<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Vi điều khiển & Nhúng',
                'description' => 'Các họ vi điều khiển AVR, PIC, STM32, Arduino...',
                'slug' => Str::slug('Vi điều khiển & Nhúng'),
            ],
            [
                'name' => 'Cảm biến & Module',
                'description' => 'Các loại cảm biến ánh sáng, nhiệt độ, siêu âm...',
                'slug' => Str::slug('Cảm biến & Module'),
            ],
            [
                'name' => 'Linh kiện Thụ động',
                'description' => 'Điện trở, tụ điện, cuộn cảm...',
                'slug' => Str::slug('Linh kiện Thụ động'),
            ],
            [
                'name' => 'IC Chức năng & Logic',
                'description' => 'IC nguồn, IC logic 74xx, 40xx...',
                'slug' => Str::slug('IC Chức năng & Logic'),
            ],
            [
                'name' => 'Thiết bị Thực hành',
                'description' => 'Mỏ hàn, thiếc hàn, đồng hồ đo...',
                'slug' => Str::slug('Thiết bị Thực hành'),
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}

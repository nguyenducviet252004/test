<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name_color' => 'Đỏ'],
            ['name_color' => 'Xanh dương'],
            ['name_color' => 'Xanh lá'],
            ['name_color' => 'Vàng'],
            ['name_color' => 'Đen'],
            ['name_color' => 'Trắng'],
            ['name_color' => 'Hồng'],
            ['name_color' => 'Tím'],
            ['name_color' => 'Cam'],
            ['name_color' => 'Nâu'],
        ];

        foreach ($colors as $colorData) {
            Color::create($colorData);
        }

        echo "Created " . count($colors) . " colors.\n";
    }
}

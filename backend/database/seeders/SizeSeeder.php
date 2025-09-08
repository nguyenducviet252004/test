<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['size' => 'XS'],
            ['size' => 'S'],
            ['size' => 'M'],
            ['size' => 'L'],
            ['size' => 'XL'],
            ['size' => 'XXL'],
            ['size' => '35'],
            ['size' => '36'],
            ['size' => '37'],
            ['size' => '38'],
            ['size' => '39'],
            ['size' => '40'],
            ['size' => '41'],
            ['size' => '42'],
            ['size' => '43'],
        ];

        foreach ($sizes as $sizeData) {
            Size::create($sizeData);
        }

        echo "Created " . count($sizes) . " sizes.\n";
    }
}

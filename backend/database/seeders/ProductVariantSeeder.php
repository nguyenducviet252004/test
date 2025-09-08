<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Color;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy all products, sizes và colors
        $products = Product::all();
        $sizes = Size::all();
        $colors = Color::all();

        if ($products->isEmpty() || $sizes->isEmpty() || $colors->isEmpty()) {
            $this->command->info('Vui lòng tạo products, sizes và colors trước khi chạy seeder này.');
            return;
        }

        $this->command->info('Đang tạo product variants...');

        foreach ($products as $product) {
            // Tạo random 3-6 variants cho mỗi product
            $variantCount = rand(3, 6);
            $usedCombinations = [];

            for ($i = 0; $i < $variantCount; $i++) {
                $size = $sizes->random();
                $color = $colors->random();

                // Đảm bảo không trùng combination
                $combination = $size->id . '-' . $color->id;
                if (in_array($combination, $usedCombinations)) {
                    continue;
                }

                $usedCombinations[] = $combination;

                // Tạo variant với giá random
                $basePrice = rand(100000, 500000); // 100k - 500k
                $salePrice = rand(0, 1) ? $basePrice * 0.8 : null; // 20% sale chance

                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                    'color_id' => $color->id,
                    'quantity' => rand(0, 100),
                    'price' => $basePrice,
                    'price_sale' => $salePrice,
                ]);
            }

            $this->command->info("Đã tạo variants cho product: {$product->name}");
        }

        $this->command->info('Hoàn thành tạo product variants!');
    }
}

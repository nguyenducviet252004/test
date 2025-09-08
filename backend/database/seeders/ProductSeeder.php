<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh mục đầu tiên
        $category = Category::first();
        
        if (!$category) {
            echo "No category found. Please run CategorySeeder first.\n";
            return;
        }

        $products = [
            [
                'name' => 'Áo thun nam basic',
                'slug' => 'ao-thun-nam-basic',
                'img_thumb' => 'product_images/ao-thun-1.jpg',
                'description' => 'Áo thun nam chất liệu cotton 100%, thoáng mát, dễ mặc',
                'category_id' => $category->id,
                'sell_quantity' => 50,
            ],
            [
                'name' => 'Quần jean nam slim fit',
                'slug' => 'quan-jean-nam-slim-fit',
                'img_thumb' => 'product_images/quan-jean-1.jpg',
                'description' => 'Quần jean nam slim fit, chất liệu denim cao cấp',
                'category_id' => $category->id,
                'sell_quantity' => 30,
            ],
            [
                'name' => 'Giày sneaker unisex',
                'slug' => 'giay-sneaker-unisex',
                'img_thumb' => 'product_images/giay-sneaker-1.jpg',
                'description' => 'Giày sneaker unisex, thiết kế hiện đại, thoải mái',
                'category_id' => $category->id,
                'sell_quantity' => 25,
            ],
            [
                'name' => 'Túi xách nữ thời trang',
                'slug' => 'tui-xach-nu-thoi-trang',
                'img_thumb' => 'product_images/tui-xach-1.jpg',
                'description' => 'Túi xách nữ thời trang, chất liệu da tổng hợp',
                'category_id' => $category->id,
                'sell_quantity' => 20,
            ],
            [
                'name' => 'Đồng hồ nam dây da',
                'slug' => 'dong-ho-nam-day-da',
                'img_thumb' => 'product_images/dong-ho-1.jpg',
                'description' => 'Đồng hồ nam dây da, thiết kế thanh lịch',
                'category_id' => $category->id,
                'sell_quantity' => 15,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        echo "Created " . count($products) . " sample products.\n";
    }
}

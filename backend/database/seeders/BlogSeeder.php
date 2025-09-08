<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Category;

class BlogSeeder extends Seeder
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

        $blogs = [
            [
                'title' => 'Xu hướng thời trang mùa hè 2024',
                'content' => 'Mùa hè 2024 sẽ chứng kiến sự trở lại của những xu hướng thời trang cổ điển với những cải tiến hiện đại. Từ áo sơ mi trắng đến quần jean ống rộng, đây là những item không thể thiếu trong tủ đồ của bạn.',
                'image' => 'blog_images/xu-huong-mua-he.jpg',
                'description' => 'Khám phá những xu hướng thời trang nổi bật trong mùa hè 2024',
                'is_active' => 1,
                'category_id' => $category->id,
            ],
            [
                'title' => 'Cách chọn giày phù hợp với từng dáng người',
                'content' => 'Việc chọn giày phù hợp không chỉ giúp bạn thoải mái mà còn tôn lên vẻ đẹp của đôi chân. Bài viết này sẽ hướng dẫn bạn cách chọn giày phù hợp với từng dáng người khác nhau.',
                'image' => 'blog_images/chon-giay.jpg',
                'description' => 'Hướng dẫn chi tiết cách chọn giày phù hợp với dáng người',
                'is_active' => 1,
                'category_id' => $category->id,
            ],
            [
                'title' => 'Bảo quản quần áo đúng cách',
                'content' => 'Bảo quản quần áo đúng cách không chỉ giúp chúng bền đẹp hơn mà còn tiết kiệm chi phí thay thế. Hãy cùng tìm hiểu những bí quyết bảo quản quần áo hiệu quả.',
                'image' => 'blog_images/bao-quan.jpg',
                'description' => 'Những bí quyết bảo quản quần áo hiệu quả',
                'is_active' => 1,
                'category_id' => $category->id,
            ],
            [
                'title' => 'Phong cách thời trang công sở',
                'content' => 'Thời trang công sở không chỉ cần lịch sự mà còn phải thoải mái và phù hợp với môi trường làm việc. Bài viết này sẽ gợi ý những outfit công sở đẹp và phù hợp.',
                'image' => 'blog_images/cong-so.jpg',
                'description' => 'Gợi ý những outfit công sở đẹp và phù hợp',
                'is_active' => 1,
                'category_id' => $category->id,
            ],
            [
                'title' => 'Mix & Match màu sắc trong thời trang',
                'content' => 'Việc phối màu đúng cách có thể tạo nên sự khác biệt lớn trong cách bạn xuất hiện. Hãy cùng tìm hiểu những nguyên tắc mix & match màu sắc cơ bản.',
                'image' => 'blog_images/mix-match.jpg',
                'description' => 'Nguyên tắc mix & match màu sắc trong thời trang',
                'is_active' => 1,
                'category_id' => $category->id,
            ],
        ];

        foreach ($blogs as $blogData) {
            Blog::create($blogData);
        }

        echo "Created " . count($blogs) . " sample blogs.\n";
    }
}

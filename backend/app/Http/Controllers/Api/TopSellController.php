<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopSellController extends Controller
{
    public function index()
    {
        try {
            // Lấy sản phẩm bán chạy nhất dựa trên tổng số lượng đã bán từ các đơn hàng đã hoàn thành (status = 3)
            $products = Product::select(
                'products.id',
                DB::raw('MAX(products.name) as name'),
                DB::raw('MAX(products.img_thumb) as img_thumb'),
                DB::raw('MAX(products.category_id) as category_id'),
                DB::raw('MAX(products.is_active) as is_active'),
                DB::raw('MAX(products.description) as description'),
                DB::raw('MAX(products.created_at) as created_at'),
                DB::raw('MAX(products.updated_at) as updated_at'),
                DB::raw('SUM(order_details.quantity) as total_sold')
            )
                ->join('order_details', 'products.id', '=', 'order_details.product_id')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->where('products.is_active', 1)
                ->where('orders.status', 3)
                ->whereNull('products.deleted_at')
                ->groupBy('products.id')
                ->orderByDesc('total_sold')
                ->limit(30)
                ->get();

            $allColors = Color::all();
            $allSizes = Size::all();

            // Chuyển đổi dữ liệu sản phẩm
            $products = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'avatar_url' => $product->img_thumb ? asset('storage/' . $product->img_thumb) : null,
                    'categories' => $product->categories,
                    'price' => $product->min_price,
                    'avatar' => $product->img_thumb,
                    'quantity' => $product->quantity,
                    'total_sold' => $product->total_sold,
                    'view' => $product->view,
                    'colors' => $product->colors,
                    'sizes' => $product->sizes,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ];
            });

            $response = [
                'products' => $products,
                'all_colors' => $allColors,
                'all_sizes' => $allSizes,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Không thể lấy danh sách sản phẩm. ' . $e->getMessage()], 500);
        }
    }
}

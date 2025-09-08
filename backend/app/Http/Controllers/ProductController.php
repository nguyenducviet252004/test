<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Gallery;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query with relations including variants for price calculation
        $query = Product::with(['galleries', 'categories', 'variants']);

        // Filter by is_active
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Filter by price range (using min price from variants)
        if ($request->filled('price_range')) {
            if ($request->price_range == 'under_200k') {
                $query->whereHas('variants', function($q) {
                    $q->where('price', '<', 200000);
                });
            } elseif ($request->price_range == '200k_500k') {
                $query->whereHas('variants', function($q) {
                    $q->whereBetween('price', [200000, 500000]);
                });
            } elseif ($request->price_range == 'over_500k') {
                $query->whereHas('variants', function($q) {
                    $q->where('price', '>', 500000);
                });
            }
        }

        // Sort by price order (using min price from variants)
        if ($request->filled('price_order')) {
            if ($request->price_order == 'asc') {
                $query->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->groupBy('products.id')
                      ->orderByRaw('MIN(product_variants.price) ASC');
            } else {
                $query->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->groupBy('products.id')
                      ->orderByRaw('MIN(product_variants.price) DESC');
            }
        }

        // Get paginated results
        $products = $query->latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.createproduct', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'img_thumb' => 'required|image|max:2048',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'image_path' => 'required|array|min:1',
            'image_path.*' => 'image|max:2048',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'img_thumb.required' => 'Ảnh đại diện là bắt buộc.',
            'img_thumb.image' => 'Ảnh đại diện phải là tệp ảnh.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'image_path.required' => 'Ảnh chi tiết là bắt buộc.',
            'image_path.*.image' => 'Mỗi ảnh chi tiết phải là một tệp ảnh.',
        ], [
            'name' => 'Tên sản phẩm',
            'img_thumb' => 'Ảnh đại diện',
            'description' => 'Mô tả',
            'category_id' => 'Danh mục',
            'image_path' => 'Ảnh chi tiết',
            'image_path.*' => 'Ảnh chi tiết',
        ]);

        try {
            DB::beginTransaction();

            // Xử lý ảnh đại diện
            $imgThumbPath = null;
            if ($request->hasFile('img_thumb')) {
                $imgThumbPath = $request->file('img_thumb')->store('ProductThumbs', 'public');
            }

            // Tạo slug từ tên sản phẩm
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            // Đảm bảo slug unique
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Tạo sản phẩm
            $product = Product::create([
                'name' => $request->name,
                'img_thumb' => $imgThumbPath,
                'slug' => $slug,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Xử lý gallery images
            if ($request->hasFile('image_path')) {
                foreach ($request->file('image_path') as $image) {
                    $imagePath = $image->store('ProductGalleries', 'public');
                    Gallery::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('products.index')
                           ->with('success', 'Sản phẩm đã được tạo thành công! Hãy thêm các biến thể (variants) cho sản phẩm.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating product: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo sản phẩm: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load(['galleries', 'categories', 'variants.size', 'variants.color']);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('galleries');

        return view('products.editproduct', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'img_thumb' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'delete_gallery' => 'array|nullable',
        ]);

        try {
            DB::beginTransaction();

            // Cập nhật slug nếu tên thay đổi
            $slug = $product->slug;
            if ($request->name !== $product->name) {
                $newSlug = Str::slug($request->name);
                $originalSlug = $newSlug;
                $counter = 1;

                while (Product::where('slug', $newSlug)->where('id', '!=', $product->id)->exists()) {
                    $newSlug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $slug = $newSlug;
            }

            // Xử lý ảnh đại diện
            if ($request->hasFile('img_thumb')) {
                // Xóa ảnh cũ
                if ($product->img_thumb) {
                    Storage::disk('public')->delete($product->img_thumb);
                }
                // Lưu ảnh mới
                $imgThumbPath = $request->file('img_thumb')->store('ProductThumbs', 'public');
                $product->img_thumb = $imgThumbPath;
            }

            // Cập nhật thông tin sản phẩm
            $product->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'is_active' => $request->boolean('is_active', true),
                'img_thumb' => $product->img_thumb,
            ]);

            // Xử lý gallery images mới
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('ProductGalleries', 'public');
                    $product->galleries()->create(['image_path' => $imagePath]);
                }
            }

            // Xóa gallery images được chọn
            if ($request->has('delete_gallery')) {
                $galleriesToDelete = $product->galleries()->whereIn('id', $request->delete_gallery)->get();
                foreach ($galleriesToDelete as $gallery) {
                    Storage::disk('public')->delete($gallery->image_path);
                    $gallery->delete();
                }
            }

            DB::commit();

            return redirect()->route('products.index')
                           ->with('success', 'Sản phẩm đã được cập nhật thành công!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating product: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        // Kiểm tra có variants trong đơn hàng đang xử lý không
        $hasActiveOrderVariants = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->where('product_variants.product_id', $product->id)
            ->whereIn('orders.status', [0, 1, 2])
            ->exists();

        if ($hasActiveOrderVariants) {
            return back()->with('error', 'Không thể xóa sản phẩm này vì có biến thể trong đơn hàng đang xử lý!');
        }

        try {
            DB::beginTransaction();

            // Cập nhật reviews liên quan
            DB::table('reviews')
                ->where('product_id', $product->id)
                ->update([
                    'product_id' => null,
                    'image_path' => null,
                    'comment' => null,
                    'is_reviews' => 0,
                ]);

            // Cập nhật order_details có variants của product này
            DB::table('order_details')
                ->whereIn('product_variant_id', function($query) use ($product) {
                    $query->select('id')->from('product_variants')
                          ->where('product_id', $product->id);
                })
                ->update([
                    'product_variant_id' => null,
                    'is_deleted' => true,
                ]);

            // Xóa tất cả cart_items liên quan đến sản phẩm này
            DB::table('cart_items')->where('product_id', $product->id)->delete();

            // Xóa product bằng method deleteProduct() đã có sẵn
            $product->deleteProduct();

            DB::commit();

            return redirect()->route('products.index')
                           ->with('success', 'Sản phẩm và tất cả biến thể đã được xóa thành công!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting product: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Product $product)
    {
        try {
            $oldStatus = $product->is_active;

            // Debug log
            Log::info("Toggle product {$product->id}: Old status = " . ($oldStatus ? 'active' : 'inactive'));

            $product->is_active = !$product->is_active;
            $product->save();

            // Debug log after save
            $product->refresh(); // Refresh to get latest data from DB
            Log::info("Toggle product {$product->id}: New status = " . ($product->is_active ? 'active' : 'inactive'));

            $statusText = $product->is_active ? 'hiển thị' : 'ẩn';
            $message = "Sản phẩm '{$product->name}' đã được chuyển sang trạng thái {$statusText}.";

            return redirect()->route('products.index')->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error toggling product status: ' . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi thay đổi trạng thái sản phẩm.');
        }
    }

    public function destroyGalleryImage(Product $product, Gallery $gallery)
    {
        try {
            // Kiểm tra xem ảnh gallery có thuộc về sản phẩm này không
            if ($gallery->product_id !== $product->id) {
                return response()->json(['success' => false, 'message' => 'Ảnh không thuộc về sản phẩm này.'], 403);
            }

            // Xóa file ảnh khỏi storage
            if (Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            // Xóa bản ghi khỏi cơ sở dữ liệu
            $gallery->delete();

            return response()->json(['success' => true, 'message' => 'Ảnh gallery đã được xóa thành công.']);
        } catch (\Exception $e) {
            Log::error('Error deleting gallery image: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi xóa ảnh gallery: ' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

      public function store(Request $request)
            {
               Log::info('CartController@store: Request received.', ['request_data' => $request->all()]);
                try {
                    // Xác thực dữ liệu đầu vào
                  $request->validate([
                       'product_variant_id' => 'required|exists:product_variants,id',
                       'quantity' => 'required|integer|min:1',
                   ]);
                  Log::info('CartController@store: Validation passed.');

                  // Tìm hoặc tạo giỏ hàng cho người dùng hiện tại
                  $cart = Cart::firstOrCreate([
                      'user_id' => Auth::id(),
                 ]);
                  Log::info('CartController@store: Cart retrieved/created.', ['cart_id' => $cart->id]);

                    // Lấy thông tin biến thể sản phẩm
                    $productVariant = ProductVariant::with(['product', 'color', 'size'])->findOrFail($request
      ->product_variant_id);
                  Log::info('CartController@store: ProductVariant retrieved.', ['product_variant_id' => $productVariant->id]);

                    // Kiểm tra số lượng có đủ không
              if ($request->quantity > $productVariant->quantity) {
                        Log::warning('CartController@store: Insufficient quantity.', ['requested_quantity' => $request->quantity,
      'available_quantity' => $productVariant->quantity]);
                        return response()->json(['message' => 'Số lượng yêu cầu vượt quá số lượng có sẵn trong kho.'], 400);
                    }
                    Log::info('CartController@store: Quantity check passed.');

                    // Kiểm tra sản phẩm với cùng biến thể trong giỏ hàng
                  $cartItem = CartItem::where('cart_id', $cart->id)
                     ->where('product_variant_id', $productVariant->id)
                    ->first();
                Log::info('CartController@store: CartItem check completed.', ['cart_item_found' => (bool)$cartItem]);
              if ($cartItem) {
                   // Cập nhật số lượng nếu vượt quá kho
                       if (($cartItem->quantity + $request->quantity) > $productVariant->quantity) {
                          Log::warning('CartController@store: Total quantity exceeds available stock.', ['current_quantity' =>
      $cartItem->quantity, 'requested_quantity' => $request->quantity, 'available_quantity' => $productVariant->quantity]);
                           return response()->json(['message' => 'Số lượng tổng cộng sau khi thêm vượt quá số lượng có sẵn trong
      kho.'], 400);
                       }

                  // Cập nhật giỏ hàng
                     $cartItem->quantity += $request->quantity;
                     $cartItem->total = $cartItem->quantity * $productVariant->effective_price;
                     $cartItem->save();
                     Log::info('CartController@store: CartItem updated.', ['cart_item_id' => $cartItem->id, 'new_quantity' =>
      $cartItem->quantity]);
                 } else {
                    // Thêm sản phẩm mới vào giỏ hàng với biến thể
                    $cartItem = CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $productVariant->product_id, // Lưu product_id gốc
                       'product_variant_id' => $productVariant->id,
                       'color_id' => $productVariant->color_id,
                       'size_id' => $productVariant->size_id,
                       'quantity' => $request->quantity,
                        'price' => $productVariant->effective_price,
                        'total' => $request->quantity * $productVariant->effective_price,
                    ]);
                    Log::info('CartController@store: New CartItem created.', ['cart_item_id' => $cartItem->id]);
                }

                 // Dữ liệu trả về
                $responseData = [
                'id' => $cartItem->id,
                     'product_id' => $productVariant->product_id,
                     'product_variant_id' => $productVariant->id,
                      'product_name' => $productVariant->product->name,
                       'color' => $productVariant->color->name_color,
                       'size' => $productVariant->size->size,
                       'quantity' => $cartItem->quantity,
                       'price' => $productVariant->effective_price,
                     'total' => $cartItem->total,
                       'message' => 'Sản phẩm đã được thêm vào giỏ hàng.',
                   ];
                   Log::info('CartController@store: Returning success response.', ['response_data' => $responseData]);

                   return response()->json($responseData, 201);
               } catch (\Exception $e) {
                   Log::error('CartController@store: An error occurred.', ['exception' => $e->getMessage(), 'file' => $e->
      getFile(), 'line' => $e->getLine()]);
                    return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
                }
          }


    public function show($userId)
{
    Log::info('CartController@show: Request received for user.', ['user_id' => $userId]);
    try {
        // Lấy giỏ hàng của người dùng
        $cart = Cart::where('user_id', $userId)->first();
        Log::info('CartController@show: Cart retrieved.', ['cart_found' => (bool)$cart]);

        // Kiểm tra xem người dùng có giỏ hàng không
        if (!$cart) {
            // Tạo giỏ hàng mới nếu chưa có
            $cart = Cart::create(['user_id' => $userId]);
            Log::info('CartController@show: New cart created for user.', ['user_id' => $userId]);
        }

        // Lấy tất cả các sản phẩm trong giỏ hàng, kèm theo thông tin biến thể, màu sắc và kích thước
        $cartItems = CartItem::with(['productVariant.product', 'productVariant.color', 'productVariant.size'])
            ->where('cart_id', $cart->id)
            ->get();
        Log::info('CartController@show: Cart items retrieved.', ['cart_items_count' => $cartItems->count()]);

        // Tạo dữ liệu trả về cho tất cả sản phẩm trong giỏ hàng
        $responseData = $cartItems->map(function ($cartItem) {
            $productVariant = $cartItem->productVariant;
            // Kiểm tra nếu productVariant hoặc product là null
            if (!$productVariant || !$productVariant->product) {
                Log::warning('CartController@show: Missing product variant or product for cart item.', [
                    'cart_item_id' => $cartItem->id
                ]);
                return null; // Bỏ qua mục giỏ hàng này hoặc xử lý lỗi
            }

            $product = $productVariant->product;
            $colorName = $productVariant->color ? $productVariant->color->name_color : null;
            $sizeName = $productVariant->size ? $productVariant->size->size : null;

            return [
                'id' => $cartItem->id,
                'product_id' => $product->id,
                'product_variant_id' => $productVariant->id,
                'product_name' => $product->name,
                'avatar' => $product->img_thumb, // Sử dụng img_thumb từ Product
                'color' => $colorName,
                'size' => $sizeName,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price, // Giá của cart item (đã là effective_price)
                'total' => $cartItem->total,
            ];
        })->filter()->values(); // Lọc bỏ các mục null và reset keys
        Log::info('CartController@show: Returning success response.', ['response_data_count' => $responseData->count()]);

        return response()->json([
            'status' => true,
            'cart_items' => $responseData,
            'message' => 'Thông tin giỏ hàng của người dùng.'
        ], 200);

    } catch (\Exception $e) {
        Log::error('CartController@show: An error occurred.', [
            'exception' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
        return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
    }
}


    public function update(Request $request, $itemId)
    {
        try {
            // Validate only the provided fields
            $validatedData = $request->validate([
                'quantity' => 'nullable|integer|min:1',
                'product_variant_id' => 'nullable|exists:product_variants,id',
            ]);

            // Find the cart item
            $cartItem = CartItem::with(['productVariant'])->findOrFail($itemId);
            $productVariant = $cartItem->productVariant; // Get the product variant

            // If product_variant_id is provided, update it
            if (isset($validatedData['product_variant_id'])) {
                $newProductVariant = ProductVariant::findOrFail($validatedData['product_variant_id']);
                $cartItem->product_id = $newProductVariant->product_id;
                $cartItem->product_variant_id = $newProductVariant->id;
                $cartItem->color_id = $newProductVariant->color_id;
                $cartItem->size_id = $newProductVariant->size_id;
                $cartItem->price = $newProductVariant->effective_price; // Update the price
                $productVariant = $newProductVariant; // Update productVariant for subsequent checks
            }

            // If quantity is provided, check if it's within the available stock
            if (isset($validatedData['quantity'])) {
                if ($validatedData['quantity'] > $productVariant->quantity) {
                    // Return error response if quantity is greater than available stock
                    return response()->json([
                        'message' => 'Số lượng yêu cầu vượt quá số lượng còn lại trong kho.',
                        'available_quantity' => $productVariant->quantity,
                    ], 400); // Bad Request response
                }

                $cartItem->quantity = $validatedData['quantity'];
                $cartItem->price = $productVariant->effective_price; // Update price based on new variant
                $cartItem->total = $cartItem->quantity * $cartItem->price;
            }

            $cartItem->save();

            // Get color and size names (if available)
            $colorName = $productVariant->color ? $productVariant->color->name_color : null;
            $sizeName = $productVariant->size ? $productVariant->size->size : null;

            // Return response data
            $responseData = [
                'id' => $cartItem->id,
                'product_id' => $cartItem->product_id,
                'product_variant_id' => $cartItem->product_variant_id,
                'product_name' => $productVariant->product->name,
                'color' => $colorName, // Color name
                'size' => $sizeName,   // Size name
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'total' => $cartItem->total,
                'message' => 'Giỏ hàng đã được cập nhật.',
                'available_quantity' => $productVariant->quantity, // Show available quantity
            ];

            return response()->json($responseData, 200); // Return OK response
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500); // Return error response
        }
    }




    public function destroy($itemId)
    {
        try {
            $cartItem = CartItem::findOrFail($itemId);
            $cartItem->delete();

            return response()->json(['message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.'], 200); // Trả về mã 200 OK
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500); // Trả về mã 500 Internal Server Error
        }
    }

    /**
     * Xóa toàn bộ giỏ hàng của người dùng
     */
    public function clearCart($userId)
    {
        try {
            Log::info('CartController@clearCart: Clearing cart for user.', ['user_id' => $userId]);

            $cart = Cart::where('user_id', $userId)->first();
            if (!$cart) {
                Log::warning('CartController@clearCart: Cart not found for user.', ['user_id' => $userId]);
                return response()->json(['message' => 'Không tìm thấy giỏ hàng.'], 404);
            }

            // Xóa tất cả items trong giỏ hàng
            $deletedCount = CartItem::where('cart_id', $cart->id)->delete();

            Log::info('CartController@clearCart: Cart cleared successfully.', [
                'user_id' => $userId,
                'cart_id' => $cart->id,
                'deleted_items_count' => $deletedCount
            ]);

            return response()->json([
                'message' => 'Giỏ hàng đã được xóa thành công.',
                'deleted_items_count' => $deletedCount
            ], 200);

        } catch (\Exception $e) {
            Log::error('CartController@clearCart: An error occurred.', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function getSelectedItems(Request $request)
    {
        Log::info('CartController@getSelectedItems: Request received to get selected items.', ['request_data' => $request->all()]);
        try {
            // 1. Validate request
            $validated = $request->validate([
                'cart_item_ids' => 'required|array|min:1',
                'cart_item_ids.*' => 'integer|exists:cart_items,id',
            ]);

            $cartItemIds = $validated['cart_item_ids'];
            $userId = Auth::id();

            // 2. Get selected cart items and verify ownership
            $cartItems = CartItem::with(['productVariant.product', 'productVariant.color', 'productVariant.size'])
                ->whereIn('id', $cartItemIds)
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            if ($cartItems->count() !== count($cartItemIds)) {
                Log::warning('CartController@getSelectedItems: Mismatch in requested and found cart items.', [
                    'user_id' => $userId,
                    'requested_ids' => $cartItemIds,
                    'found_ids' => $cartItems->pluck('id')->toArray()
                ]);
                return response()->json(['message' => 'Invalid cart items provided.'], 400);
            }

            // 3. Map to response data (similar to show method)
            $responseData = $cartItems->map(function ($cartItem) {
                $productVariant = $cartItem->productVariant;
                if (!$productVariant || !$productVariant->product) {
                    return null;
                }
                $product = $productVariant->product;
                return [
                    'id' => $cartItem->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $productVariant->id,
                    'product_name' => $product->name,
                    'avatar' => $product->img_thumb,
                    'color' => $productVariant->color->name_color ?? null,
                    'size' => $productVariant->size->size ?? null,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->total,
                ];
            })->filter()->values();

            Log::info('CartController@getSelectedItems: Returning selected items.', ['items_count' => $responseData->count()]);

            return response()->json([
                'status' => true,
                'cart_items' => $responseData,
                'message' => 'Thông tin các sản phẩm đã chọn trong giỏ hàng.'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('CartController@getSelectedItems: Validation failed.', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('CartController@getSelectedItems: An error occurred.', [
                'exception' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }
}

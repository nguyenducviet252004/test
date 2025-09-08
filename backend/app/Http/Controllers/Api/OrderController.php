<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Ship_address;
use App\Models\Voucher;
use App\Models\Voucher_usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        Log::info('OrderController@store: Bắt đầu xử lý đơn hàng.', ['request_data' => $request->all()]);
        try {
            // Kiểm tra đăng nhập
            if (!Auth::check()) {
                Log::warning('OrderController@store: Người dùng chưa đăng nhập.');
                return response()->json(['message' => 'User not logged in.'], 401);
            }
            $userId = Auth::id();
            // Lấy địa chỉ giao hàng mặc định hoặc mới nhất
            $shippingAddress = Ship_address::where('user_id', $userId)
                ->orderByDesc('is_default')
                ->orderByDesc('created_at')
                ->first();
            if (!$shippingAddress) {
                Log::error('OrderController@store: Không tìm thấy địa chỉ giao hàng.', ['user_id' => $userId]);
                return response()->json([
                    'message' => 'No shipping address found. Please add a new address.',
                    'redirect_url' => route('address.create')
                ], 400);
            }
            // Lấy giỏ hàng của người dùng
            $cart = Cart::where('user_id', $userId)->first();
            if (!$cart) {
                Log::error('OrderController@store: Không tìm thấy giỏ hàng cho người dùng.', ['user_id' => $userId]);
                return response()->json(['message' => 'No items in the cart.'], 400);
            }
            $cartItems = CartItem::with(['productVariant.product', 'productVariant.color', 'productVariant.size'])->where('cart_id', $cart->id)->get();
            if ($cartItems->isEmpty()) {
                Log::error('OrderController@store: Giỏ hàng trống.', ['cart_id' => $cart->id]);
                return response()->json(['message' => 'No items in the cart.'], 400);
            }
            Log::info('OrderController@store: Số lượng mặt hàng trong giỏ', ['cart_items_count' => $cartItems->count()]);

            // Tính tổng số lượng và tổng giá trị đơn hàng
            $totalQuantity = $cartItems->sum('quantity');
            $totalAmount = $cartItems->sum(fn($item) => $item->quantity * $item->price);
            Log::info('OrderController@store: Tổng số lượng và tổng tiền', ['total_quantity' => $totalQuantity, 'total_amount' => $totalAmount]);

            // Kiểm tra voucher và tính toán giảm giá (nếu có)
$voucherId = $request->input('voucher_id');
            $discountValue = 0;
            $voucher = null;
            if ($voucherId) {
                $voucher = Voucher::find($voucherId);
                Log::info('OrderController@store: Voucher ID được cung cấp', ['voucher_id' => $voucherId]);
                if ($voucher && $voucher->is_active == 1 && $voucher->quantity > 0) {
                    $currentDate = now();
                    // Kiểm tra nếu người dùng đã sử dụng voucher này
                    $voucherUsageExists = DB::table('voucher_usages')
                        ->where('user_id', auth()->id())
                        ->where('voucher_id', $voucherId)
                        ->exists();
                    if ($voucherUsageExists) {
                        Log::warning('OrderController@store: Người dùng đã sử dụng voucher này rồi.', ['user_id' => $userId, 'voucher_id' => $voucherId]);
                        return response()->json(['message' => 'Bạn đã sử dụng voucher này rồi.'], 400);
                    }
                    // Kiểm tra ngày bắt đầu và ngày kết thúc của voucher
                    if ($currentDate < $voucher->start_day || $currentDate > $voucher->end_day) {
                        Log::warning('OrderController@store: Voucher đã hết hạn hoặc chưa có hiệu lực.', ['voucher_id' => $voucherId, 'start_day' => $voucher->start_day, 'end_day' => $voucher->end_day]);
                        return response()->json(['message' => 'Phiếu giảm giá đã hết hạn hoặc chưa có hiệu lực.'], 400);
                    }
                    // Kiểm tra tổng tiền đơn hàng
                    if ($totalAmount <= $voucher->total_min) {
                        Log::warning('OrderController@store: Tổng tiền đơn hàng thấp hơn mức tối thiểu của voucher.', ['total_amount' => $totalAmount, 'min_amount' => $voucher->total_min]);
                        return response()->json(['message' => 'Tổng số tiền đặt hàng thấp hơn mức tối thiểu bắt buộc để được hưởng ưu đãi.'], 400);
                    }
                    if ($totalAmount >= $voucher->total_max) {
                        Log::warning('OrderController@store: Tổng tiền đơn hàng vượt quá mức tối đa của voucher.', ['total_amount' => $totalAmount, 'max_amount' => $voucher->total_max]);
                        return response()->json(['message' => 'Tổng số tiền đặt hàng vượt quá mức tối đa được phép hưởng ưu đãi.'], 400);
                    }
                    // Tính giá trị giảm giá và cập nhật số lượng voucher
                    $discountValue = min($voucher->discount_value, $totalAmount);
                    $voucher->increment('used_times');
                    $voucher->decrement('quantity');
                    Log::info('OrderController@store: Voucher được áp dụng.', ['voucher_id' => $voucherId, 'discount_value' => $discountValue]);
                } else {
Log::warning('OrderController@store: Voucher không hợp lệ hoặc không khả dụng.', ['voucher_id' => $voucherId]);
                    return response()->json(['message' => 'Phiếu mua hàng không hợp lệ'], 400);
                }
            }

            $totalAmount -= $discountValue;
            Log::info('OrderController@store: Tổng tiền sau giảm giá', ['final_total_amount' => $totalAmount]);
            $maxRetry = 20;
            $order = null;
            $orderId = null;
            $today = now()->format('dmY');
            for ($try = 0; $try < $maxRetry; $try++) {
                DB::beginTransaction();
                try {
                    $randomSuffix = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                    $orderId = $today . $randomSuffix;
                    if (Order::where('id', $orderId)->exists()) {
                        // Nếu trùng, thử lại
                        DB::rollBack();
                        usleep(100000);
                        continue;
                    }
                    $order = Order::create([
                        'id' => $orderId,
                        'user_id' => $userId,
                        'quantity' => $totalQuantity,
                        'total_amount' => $totalAmount,
                        'payment_method' => $request->input('payment_method', 1),
                        'ship_method' => $request->input('ship_method', 1),
                        'voucher_id' => $voucherId,
                        'ship_address_id' => $shippingAddress->id,
                        'discount_value' => $discountValue,
                        'status' => 0,
                    ]);
                    DB::commit();
                    break;
                } catch (\Illuminate\Database\QueryException $e) {
                    DB::rollBack();
                    if ($e->getCode() == '23000') {
                        usleep(100000); // Đợi 0.1s rồi thử lại
                        continue;
                    }
                    throw $e;
                }
            }
            if (!$order) {
                return response()->json(['message' => 'Không thể tạo đơn hàng, vui lòng thử lại.'], 500);
            }
            // Xử lý chi tiết đơn hàng
            $orderDetails = [];
            foreach ($cartItems as $cartItem) {
                $productVariant = $cartItem->productVariant;
                $product = $productVariant->product;
                $orderDetail = Order_detail::create([
                    'order_id' => $orderId,
                    'product_id' => $product->id,
                    'product_variant_id' => $productVariant->id,
                    'product_name' => $product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'price_sale' => $cartItem->price,
'total' => $cartItem->quantity * $cartItem->price,
                    'size_id' => $productVariant->size_id,
                    'size_name' => $productVariant->size->size ?? null,
                    'color_id' => $productVariant->color_id,
                ]);
                Log::info('OrderController@store: Chi tiết đơn hàng được tạo.', ['order_detail_id' => $orderDetail->id, 'product_name' => $product->name, 'quantity' => $cartItem->quantity, 'price' => $cartItem->price]);
                if ($productVariant) {
                    $productVariant->quantity -= $cartItem->quantity;
                    $productVariant->save();
                    Log::info('OrderController@store: Số lượng biến thể sản phẩm được cập nhật.', ['product_variant_id' => $productVariant->id, 'new_quantity' => $productVariant->quantity]);
                }
                $orderDetails[] = $orderDetail;
            }

            // Ghi thông tin vào bảng voucher_usages nếu có voucher
            if ($voucherId && $voucher) {
                Voucher_usage::create([
                    'user_id' => $userId,
                    'order_id' => $order->id,
                    'voucher_id' => $voucherId,
                    'discount_value' => $discountValue,
                ]);
                Log::info('OrderController@store: Voucher usage được ghi lại.', ['user_id' => $userId, 'voucher_id' => $voucherId]);
            }

            // Kiểm tra phương thức thanh toán: nếu là Online Payment (payment_method = 2)
            if ($request->input('payment_method') == 2) {
                Log::info('OrderController@store: Phương thức thanh toán là Online Payment.');
                $paymentResponse = $this->createPaymentUrl($request, $totalAmount, $order->id);
                $paymentData = $paymentResponse->getData(true);
                Log::info('OrderController@store: Phản hồi từ createPaymentUrl.', ['payment_response' => $paymentData]);
                if (isset($paymentData['payment_url'])) {
                    Log::info('OrderController@store: Trả về URL thanh toán.', ['payment_url' => $paymentData['payment_url']]);
                    return response()->json([
                        'status' => true,
                        'message' => 'Order created successfully, please complete your payment.',
                        'payment_url' => $paymentData['payment_url'],
                    ], 201);
                } else {
                    Log::error('OrderController@store: Không tạo được URL thanh toán.', ['payment_data' => $paymentData]);
                    return response()->json(['message' => 'Failed to create payment URL.'], 500);
                }
            }

            // Nếu là COD, xóa giỏ hàng và trả về kết quả đơn hàng đã được tạo
            Log::info('OrderController@store: Phương thức thanh toán là COD. Xóa giỏ hàng và trả về kết quả đơn hàng.');
CartItem::where('cart_id', $cart->id)->delete();
            Log::info('OrderController@store: Các mặt hàng trong giỏ hàng đã bị xóa (COD).', ['cart_id' => $cart->id]);
            return response()->json([
                'status' => true,
            'message' => 'Đơn hàng đã được tạo thành công.',
            'order_id' => $orderId,
            'total_amount' => $totalAmount,
            'order_details' => $orderDetails,
        ], 201);
        } catch (\Exception $e) {
            Log::error('OrderController@store: Đã xảy ra lỗi trong quá trình xử lý đơn hàng.', ['exception' => $e->getMessage()]);

            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }



    // Hàm để tạo URL thanh toán VNPay
    public function createPaymentUrl(Request $request, $totalAmount, $orderId)
    {
        // Kiểm tra cấu hình VNPay
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = env('VNP_URL');
        $vnp_ReturnUrl = env('VNP_RETURN_URL');

        // Validate cấu hình
        if (!$vnp_TmnCode || !$vnp_HashSecret || !$vnp_Url || !$vnp_ReturnUrl) {
            Log::error('VNPay configuration missing', [
                'VNP_TMN_CODE' => $vnp_TmnCode ? 'SET' : 'MISSING',
                'VNP_HASH_SECRET' => $vnp_HashSecret ? 'SET' : 'MISSING',
                'VNP_URL' => $vnp_Url ? 'SET' : 'MISSING',
                'VNP_RETURN_URL' => $vnp_ReturnUrl ? 'SET' : 'MISSING'
            ]);
            return response()->json(['error' => 'Cấu hình thanh toán chưa hoàn tất'], 500);
        }

        // Ghi log thông tin cấu hình
        Log::info('VNPay Config:', [
            'VNP_TMN_CODE' => $vnp_TmnCode,
            'VNP_HASH_SECRET' => $vnp_HashSecret ? 'SET' : 'MISSING',
            'VNP_URL' => $vnp_Url,
            'VNP_RETURN_URL' => $vnp_ReturnUrl
        ]);

        // Kiểm tra số tiền hợp lệ
        if ($totalAmount < 5000 || $totalAmount >= 1000000000) {
            Log::error('Invalid transaction amount:', ['amount' => $totalAmount]);
            return response()->json(['error' => 'Số tiền không hợp lệ, phải từ 5,000 VNĐ đến dưới 1 tỷ VNĐ.'], 400);
        }

        // Dữ liệu giao dịch
        $vnp_TxnRef = $orderId; // Mã giao dịch là order_id
        $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $orderId; // Nội dung thanh toán
        $vnp_OrderType = 'billpayment'; // Loại giao dịch
        $vnp_Amount = (int) ($totalAmount * 100); // Số tiền (VNĐ nhân 100)
        $vnp_Locale = 'vn'; // Ngôn ngữ
        $vnp_IpAddr = $request->ip(); // IP của người dùng

        // Ghi log dữ liệu đầu vào
        Log::info('VNPay Request Input:', $request->all());
        Log::info('Transaction Data:', [
            'TxnRef' => $vnp_TxnRef,
            'OrderInfo' => $vnp_OrderInfo,
            'OrderType' => $vnp_OrderType,
'Amount' => $vnp_Amount,
            'Locale' => $vnp_Locale,
            'IpAddr' => $vnp_IpAddr
        ]);

        try {
            // Tạo dữ liệu đầu vào cho VNPay
            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_ReturnUrl,
                "vnp_TxnRef" => $vnp_TxnRef,
            ];

            // Sắp xếp dữ liệu đầu vào theo thứ tự
            ksort($inputData);

            // Tạo chuỗi dữ liệu để mã hóa
            $query = "";
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                $hashdata .= ($hashdata ? '&' : '') . urlencode($key) . "=" . urlencode($value);
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            // Ghi log dữ liệu sau khi xử lý
            Log::info('VNPay Input Data Sorted:', $inputData);
            Log::info('Hash Data String:', ['hashdata' => $hashdata]);

            // Tính toán mã hash sử dụng chuỗi dữ liệu và secret key
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            Log::info('Generated Secure Hash:', ['secure_hash' => $vnpSecureHash]);

            // Tạo URL thanh toán
            $vnp_Url = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;
            Log::info('Generated VNPay URL:', ['url' => $vnp_Url]);

            return response()->json(['payment_url' => $vnp_Url]);

        } catch (\Exception $e) {
            Log::error('Error creating VNPay URL', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
                'amount' => $totalAmount
            ]);
            return response()->json(['error' => 'Lỗi khi tạo URL thanh toán: ' . $e->getMessage()], 500);
        }
    }

    public function createFromSelection(Request $request)
    {
        Log::info('OrderController@createFromSelection: Bắt đầu xử lý đơn hàng từ các mục đã chọn.', ['request_data' => $request->all()]);
        try {
            // 1. Validate request
            $validated = $request->validate([
                'cart_item_ids' => 'required|array|min:1',
                'cart_item_ids.*' => 'integer|exists:cart_items,id',
                'payment_method' => 'required|integer',
                'voucher_id' => 'nullable|integer|exists:vouchers,id',
            ]);

            $cartItemIds = $validated['cart_item_ids'];

            // 2. Check user authentication
if (!Auth::check()) {
Log::warning('OrderController@createFromSelection: Người dùng chưa đăng nhập.');
                return response()->json(['message' => 'User not logged in.'], 401);
            }
            $userId = Auth::id();

            // 3. Get shipping address
            $shippingAddress = Ship_address::where('user_id', $userId)
                ->orderByDesc('is_default')
                ->orderByDesc('created_at')
                ->first();
            if (!$shippingAddress) {
                Log::error('OrderController@createFromSelection: Không tìm thấy địa chỉ giao hàng.', ['user_id' => $userId]);
                return response()->json(['message' => 'No shipping address found. Please add a new address.'], 400);
            }

            // 4. Get selected cart items and verify ownership
            $cartItems = CartItem::with(['productVariant.product', 'productVariant.color', 'productVariant.size'])
                ->whereIn('id', $cartItemIds)
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            if ($cartItems->count() !== count($cartItemIds)) {
                Log::error('OrderController@createFromSelection: Một số mục trong giỏ hàng không hợp lệ hoặc không thuộc về người dùng.', ['user_id' => $userId, 'requested_ids' => $cartItemIds]);
                return response()->json(['message' => 'Invalid cart items provided.'], 400);
            }

            if ($cartItems->isEmpty()) {
                Log::error('OrderController@createFromSelection: Không có mục nào được chọn trong giỏ hàng.', ['user_id' => $userId]);
                return response()->json(['message' => 'No items selected from the cart.'], 400);
            }

            // 5. Calculate total amount and quantity
            $totalQuantity = $cartItems->sum('quantity');
            $totalAmount = $cartItems->sum(fn($item) => $item->quantity * $item->price);
            Log::info('OrderController@createFromSelection: Tổng số lượng và tổng tiền', ['total_quantity' => $totalQuantity, 'total_amount' => $totalAmount]);

            // Voucher logic (adapted from store method)
            $voucherId = $validated['voucher_id'] ?? null;
            $discountValue = 0;
                $voucher = null;
                if ($voucherId) {
                    $voucher = Voucher::find($voucherId);
                    Log::info('OrderController@createFromSelection: Voucher ID được cung cấp', ['voucher_id' => $voucherId]);
                    if ($voucher && $voucher->is_active == 1 && $voucher->quantity > 0) {
                        $currentDate = now();
                        $voucherUsageExists = DB::table('voucher_usages')
                            ->where('user_id', $userId)
                            ->where('voucher_id', $voucherId)
->exists();
                        if ($voucherUsageExists) {
                            Log::warning('OrderController@createFromSelection: Người dùng đã sử dụng voucher này rồi.', ['user_id' => $userId, 'voucher_id' => $voucherId]);
                            return response()->json(['message' => 'Bạn đã sử dụng voucher này rồi.'], 400);
                        }
                        if ($currentDate < $voucher->start_day || $currentDate > $voucher->end_day) {
                            Log::warning('OrderController@createFromSelection: Voucher đã hết hạn hoặc chưa có hiệu lực.', ['voucher_id' => $voucherId, 'start_day' => $voucher->start_day, 'end_day' => $voucher->end_day]);
                            return response()->json(['message' => 'Phiếu giảm giá đã hết hạn hoặc chưa có hiệu lực.'], 400);
                        }
                        if ($totalAmount <= $voucher->total_min) {
                            Log::warning('OrderController@createFromSelection: Tổng tiền đơn hàng thấp hơn mức tối thiểu của voucher.', ['total_amount' => $totalAmount, 'min_amount' => $voucher->total_min]);
                            return response()->json(['message' => 'Tổng số tiền đặt hàng thấp hơn mức tối thiểu bắt buộc để được hưởng ưu đãi.'], 400);
                        }
                        if ($totalAmount >= $voucher->total_max) {
                            Log::warning('OrderController@createFromSelection: Tổng tiền đơn hàng vượt quá mức tối đa của voucher.', ['total_amount' => $totalAmount, 'max_amount' => $voucher->total_max]);
                            return response()->json(['message' => 'Tổng số tiền đặt hàng vượt quá mức tối đa được phép hưởng ưu đãi.'], 400);
                        }
                        $discountValue = min($voucher->discount_value, $totalAmount);
                        $voucher->increment('used_times');
                        $voucher->decrement('quantity');
                        $voucher->save();
                        Log::info('OrderController@createFromSelection: Voucher được áp dụng.', ['voucher_id' => $voucherId, 'discount_value' => $discountValue]);
                    } else {
                        Log::warning('OrderController@createFromSelection: Voucher không hợp lệ hoặc không khả dụng.', ['voucher_id' => $voucherId]);
                        return response()->json(['message' => 'Phiếu mua hàng không hợp lệ'], 400);
                    }
                }
            $totalAmount -= $discountValue;
                $totalAmountBeforeDiscount = $cartItems->sum(fn($item) => $item->quantity * $item->price);
                $totalAmount -= $discountValue;

            // Create Order ID (random 6 digits for uniqueness)
            $today = now()->format('dmY');
            $maxRetry = 20;
            $orderId = null;
            for ($try = 0; $try < $maxRetry; $try++) {
$randomSuffix = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $orderId = $today . $randomSuffix;
if (!Order::where('id', $orderId)->exists()) {
                    break;
                }
                usleep(100000);
            }
            if (!$orderId) {
                return response()->json(['message' => 'Không thể tạo mã đơn hàng, vui lòng thử lại.'], 500);
            }

            $order = Order::create([
                'id' => $orderId,
                'user_id' => $userId,
                'quantity' => $totalQuantity,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'ship_method' => $request->input('ship_method', 1),
                'voucher_id' => $voucherId,
                'ship_address_id' => $shippingAddress->id,
                'discount_value' => $discountValue,
                'status' => 0, // Pending
            ]);

            // Create Order Details
                // Phân bổ giảm giá cho từng sản phẩm
                $discountRate = $totalAmountBeforeDiscount > 0 ? ($discountValue / $totalAmountBeforeDiscount) : 0;
                foreach ($cartItems as $cartItem) {
                    $productVariant = $cartItem->productVariant;
                    $product = $productVariant->product;
                    $price_sale = $cartItem->price * (1 - $discountRate);
                    Order_detail::create([
                        'order_id' => $orderId,
                        'product_id' => $product->id,
                        'product_variant_id' => $productVariant->id,
                        'product_name' => $product->name,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                        'price_sale' => round($price_sale, 0),
                        'total' => round($cartItem->quantity * $price_sale, 0),
                        'size_id' => $productVariant->size_id,
                        'size_name' => $productVariant->size->size ?? null,
                        'color_id' => $productVariant->color_id,
                    ]);
                    if ($productVariant) {
                        $productVariant->quantity -= $cartItem->quantity;
                        $productVariant->save();
                    }
                }

            // Record voucher usage
            if ($voucherId) {
                // ... (Voucher usage recording logic)
            }

            // Handle payment
            if ($validated['payment_method'] == 2) { // Online Payment
                $paymentResponse = $this->createPaymentUrl($request, $totalAmount, $order->id);
                $paymentData = $paymentResponse->getData(true);
                if (isset($paymentData['payment_url'])) {
                    // Don't delete cart items until payment is confirmed
                    return response()->json([
'status' => true,
                        'message' => 'Order created, please complete payment.',
                        'payment_url' => $paymentData['payment_url'],
                        'order_id' => $orderId,
                    ], 201);
                } else {
                    return response()->json(['message' => 'Failed to create payment URL.'], 500);
                }
            }
// For COD, clear selected items from cart
            CartItem::whereIn('id', $cartItemIds)->delete();
            Log::info('OrderController@createFromSelection: Các mục đã chọn trong giỏ hàng đã bị xóa (COD).', ['cart_item_ids' => $cartItemIds]);

            return response()->json([
                'status' => true,
                'message' => 'Đơn hàng đã được tạo thành công.',
                'order_id' => $orderId,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('OrderController@createFromSelection: Lỗi xác thực.', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('OrderController@createFromSelection: Đã xảy ra lỗi.', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
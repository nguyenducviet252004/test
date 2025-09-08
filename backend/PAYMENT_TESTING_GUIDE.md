# HƯỚNG DẪN TEST THANH TOÁN ONLINE VNPAY

## 1. Cấu hình môi trường

### Thêm vào file `.env`:
```env
# VNPay Configuration
VNP_TMN_CODE=WSYNHVZN
VNP_HASH_SECRET=HT3GU87KJQQEZ8V6XKFBNNCRBMM4SYBX
VNP_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNP_RETURN_URL=http://localhost:8000/api/payment/result
```

## 2. Luồng test thanh toán

### Bước 1: Tạo đơn hàng
- Truy cập: `http://localhost:3000/checkout/{user_id}`
- Chọn phương thức thanh toán: **Online Payment**
- Điền thông tin đầy đủ
- Click "Đặt hàng"

### Bước 2: Chuyển hướng đến VNPay
- Hệ thống sẽ tạo URL thanh toán VNPay
- Chuyển hướng đến trang thanh toán VNPay Sandbox

### Bước 3: Test thanh toán trên VNPay

#### Thẻ test thành công:
- **Ngân hàng:** NCB
- **Số thẻ:** 9704198526191432198
- **Tên chủ thẻ:** NGUYEN VAN A
- **Ngày phát hành:** 07/15
- **OTP:** 123456

#### Thẻ test thất bại:
- **Ngân hàng:** NCB
- **Số thẻ:** 9704198526191432199
- **Tên chủ thẻ:** NGUYEN VAN B
- **Ngày phát hành:** 07/15
- **OTP:** 123456

## 3. Kết quả test

### Thanh toán thành công:
- Chuyển hướng về: `http://localhost:3000/thank`
- Trạng thái đơn hàng: `1` (Đã thanh toán - đang xử lý)
- Giỏ hàng được xóa
- Tồn kho được cập nhật

### Thanh toán thất bại:
- Chuyển hướng về: `http://localhost:3000/order-error`
- Trạng thái đơn hàng: `4` (Hủy)
- Tồn kho được khôi phục
- Voucher được hoàn trả
- Giỏ hàng vẫn giữ nguyên

## 4. API Endpoints

### Tạo đơn hàng:
```
POST /api/orders
```

### Kiểm tra trạng thái thanh toán:
```
GET /api/payment/status/{orderId}
```

### Xử lý kết quả thanh toán:
```
GET /api/payment/result
```

## 5. Logs và Debug

### Kiểm tra logs:
```bash
tail -f storage/logs/laravel.log
```

### Các log quan trọng:
- `OrderController@store`: Tạo đơn hàng
- `createPaymentUrl`: Tạo URL thanh toán
- `Payment result received`: Nhận kết quả thanh toán
- `Payment successful/failed`: Kết quả thanh toán

## 6. Troubleshooting

### Lỗi thường gặp:

1. **"Cấu hình thanh toán chưa hoàn tất"**
   - Kiểm tra file `.env` có đầy đủ thông tin VNPay

2. **"Số tiền không hợp lệ"**
   - Số tiền phải từ 5,000 VNĐ đến dưới 1 tỷ VNĐ

3. **"Invalid secure hash"**
   - Kiểm tra `VNP_HASH_SECRET` có đúng không

4. **"Order not found"**
   - Kiểm tra `order_id` có tồn tại trong database

### Kiểm tra database:
```sql
-- Kiểm tra đơn hàng
SELECT * FROM orders WHERE id = 'order_id';

-- Kiểm tra thanh toán
SELECT * FROM payments WHERE order_id = 'order_id';

-- Kiểm tra chi tiết đơn hàng
SELECT * FROM order_details WHERE order_id = 'order_id';
```

## 7. Production Deployment

### Khi deploy lên production:
1. Đăng ký tài khoản VNPay thật
2. Cập nhật thông tin VNPay trong `.env`
3. Thay đổi `VNP_URL` thành URL production
4. Cập nhật `VNP_RETURN_URL` thành domain thật
5. Test kỹ trước khi go-live

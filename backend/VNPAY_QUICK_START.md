# 🚀 VNPAY TEST - HƯỚNG DẪN NHANH

## ⚡ CẤU HÌNH NHANH

### 1. Thêm vào `backend/.env`:
```env
VNP_TMN_CODE=WSYNHVZN
VNP_HASH_SECRET=HT3GU87KJQQEZ8V6XKFBNNCRBMM4SYBX
VNP_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNP_RETURN_URL=http://localhost:8000/api/payment/result
```

### 2. Khởi động server:
```bash
# Backend
cd backend && php artisan serve

# Frontend  
cd frontend && npm start
```

## 🎯 TEST NHANH

### Bước 1: Truy cập
```
http://localhost:3000/checkout/4
```

### Bước 2: Chọn Online Payment và đặt hàng

### Bước 3: Sử dụng thẻ test
```
🏦 Ngân hàng: NCB
💳 Số thẻ: 9704198526191432198 (thành công) / 9704198526191432199 (thất bại)
👤 Tên: NGUYEN VAN A / NGUYEN VAN B
📅 Ngày: 07/15
🔐 OTP: 123456
```

## 📊 KẾT QUẢ

### ✅ Thành công:
- Chuyển về: `http://localhost:3000/thank`
- Trạng thái: `1` (Đã thanh toán)
- Giỏ hàng: Đã xóa

### ❌ Thất bại:
- Chuyển về: `http://localhost:3000/order-error`
- Trạng thái: `4` (Hủy)
- Giỏ hàng: Vẫn giữ nguyên

## 🔍 KIỂM TRA

### Database:
```sql
SELECT * FROM orders ORDER BY created_at DESC LIMIT 1;
SELECT * FROM payments ORDER BY created_at DESC LIMIT 1;
```

### Logs:
```bash
tail -f storage/logs/laravel.log
```

## 🚨 LỖI THƯỜNG GẶP

| Lỗi | Nguyên nhân | Giải pháp |
|-----|-------------|-----------|
| "Cấu hình chưa hoàn tất" | Thiếu thông tin VNPay | Kiểm tra file .env |
| "Số tiền không hợp lệ" | < 5,000 VNĐ | Tăng số tiền đơn hàng |
| "Invalid secure hash" | Secret key sai | Kiểm tra VNP_HASH_SECRET |
| "Order not found" | Order ID không tồn tại | Kiểm tra database |

## 📞 HỖ TRỢ

- 📖 Xem hướng dẫn chi tiết: `VNPAY_SETUP.md`
- 🔄 Xem từng bước: `VNPAY_STEP_BY_STEP.md`
- 🧪 Xem test cases: `TEST_PAYMENT.md`

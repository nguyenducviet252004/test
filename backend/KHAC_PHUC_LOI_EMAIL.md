# KHẮC PHỤC LỖI EMAIL SMTP

## 🚨 LỖI HIỆN TẠI
```
Failed to authenticate on SMTP server with username "vietndph41653@fpt.edu.vn"
Expected response code "235" but got code "535"
Username and Password not accepted
```

## 🔧 CÁCH KHẮC PHỤC

### Bước 1: Kiểm tra cấu hình hiện tại
Truy cập: `http://localhost:8000/debug/email-config`

### Bước 2: Tạo App Password mới cho Gmail
1. Đăng nhập Gmail: `vietndph41653@fpt.edu.vn`
2. Vào **Google Account** → **Security**
3. Bật **2-Step Verification** (nếu chưa có)
4. Vào **App passwords** → **Select app: Mail** → **Select device: Other**
5. Nhập tên: "Laravel DATN"
6. **Copy mật khẩu 16 ký tự** (ví dụ: `abcd efgh ijkl mnop`)

### Bước 3: Cập nhật file .env
Mở file `.env` và thay đổi:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=vietndph41653@fpt.edu.vn
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=vietndph41653@fpt.edu.vn
MAIL_FROM_NAME="DATN WD110-45"
```

**LưU Ý:** 
- `MAIL_PASSWORD` phải là App Password 16 ký tự (không có khoảng trắng)
- KHÔNG dùng mật khẩu Gmail thường

### Bước 4: Clear cache và restart
```bash
cd backend
php artisan config:clear
php artisan cache:clear
php artisan serve
```

### Bước 5: Test email
#### Cách 1: Qua web
Truy cập: `http://localhost:8000/debug/test-email`

#### Cách 2: Qua command line
```bash
php artisan email:test
```

#### Cách 3: Test trực tiếp trong tinker
```bash
php artisan tinker
```
Trong tinker:
```php
Mail::raw('Test email', function($message) {
    $message->to('vietndph41653@fpt.edu.vn')->subject('Test');
});
```

## 🔄 NẾU VẪN LỖI

### Thử cấu hình SSL thay vì TLS:
```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

### Hoặc sử dụng Gmail cá nhân:
1. Tạo Gmail mới (ví dụ: `datn.wd110.45@gmail.com`)
2. Bật 2FA và tạo App Password
3. Cập nhật .env với Gmail mới

### Kiểm tra tài khoản FPT:
- Email FPT có thể có hạn chế bảo mật
- Liên hệ IT FPT để được hỗ trợ

## ✅ KIỂM TRA THÀNH CÔNG
Khi email hoạt động, bạn sẽ thấy:
- Xác thực email hoạt động bình thường
- Email thông báo đơn hàng được gửi
- Không còn lỗi SMTP

## 📞 HỖ TRỢ
Nếu vẫn gặp lỗi, hãy:
1. Chụp màn hình lỗi mới
2. Kiểm tra log Laravel: `storage/logs/laravel.log`
3. Thử với Gmail cá nhân thay vì email FPT

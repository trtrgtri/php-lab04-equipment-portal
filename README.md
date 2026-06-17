# Mini Equipment Borrow Request Portal

Cổng đăng ký mượn thiết bị, xây dựng bằng **PHP thuần** (không framework, không database). Dự án thuộc **Lab04 — PHP Secure Forms, PRG, Anti-spam & Session Login Flow**, tập trung vào xử lý form an toàn và luồng đăng nhập/phiên bảo mật.

## 1. Tính năng chính

- **Front Controller + Router:** mọi request qua `public/index.php`, phân loại GET/POST và bắt lỗi 404/405.
- **Form bảo mật 3 lớp:** đọc input an toàn (`?? ''`), chuẩn hóa (`trim()`), escape output chống XSS (`htmlspecialchars()`).
- **Validation server-side theo trình tự:** Required → Format → Logic (in-list, độ dài), lỗi hiển thị từng field, giữ dữ liệu cũ (sticky form).
- **PRG (Post-Redirect-Get):** chống bấm F5 gửi trùng.
- **Flash message:** thông báo chỉ hiện một lần.
- **Anti-spam:** honeypot và rate limit.
- **Bảo mật Session/Login:** cookie flags (HttpOnly, SameSite, Secure), `session_regenerate_id()` chống Session Fixation, idle timeout, clean logout.

## 2. Yêu cầu môi trường

- PHP >= 8.0
- Composer

## 3. Cài đặt & chạy

```bash
cd php-lab04-equipment-portal
composer dump-autoload
php -S localhost:8000 -t public
```

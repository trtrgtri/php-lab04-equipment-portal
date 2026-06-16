# Mini Equipment Borrow Portal (PHP Lab 04)

Hệ thống quản lý đăng ký mượn thiết bị được xây dựng bằng PHP thuần (Front Controller Pattern, Router, MVC Architecture). Dự án tập trung vào bảo mật luồng dữ liệu Form và Session.

## Tính năng nổi bật (Security Focus)

- **Secure Form:** Đọc input an toàn, chuẩn hóa `trim()`, escape output `htmlspecialchars()` chống XSS.
- **Validation & PRG:** Server-side validation, hiển thị lỗi chính xác từng field, giữ lại `old_input`. Áp dụng luồng Post-Redirect-Get để tránh lỗi submit trùng.
- **Anti-spam:** Tích hợp bẫy Honeypot ẩn và Rate limit giới hạn thời gian gửi (chặn spam liên tục dưới 5s).
- **Session Security:** Cấu hình Cookie flags (HttpOnly, SameSite=Lax), chống Session Fixation bằng `session_regenerate_id()`, Idle timeout (15 phút) và Clean Logout.

## Yêu cầu hệ thống

- PHP 8.0+
- Composer

## Hướng dẫn cài đặt và chạy dự án

1. Clone repository về máy:
   ```bash
   git clone [https://github.com/USERNAME/php-lab04-equipment-portal.git](https://github.com/trtrgtri/php-lab04-equipment-portal.git)
   cd php-lab04-equipment-portal
   ```

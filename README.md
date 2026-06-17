# Mini Equipment Borrow Request Portal

Ứng dụng mô phỏng quy trình đăng ký mượn thiết bị học tập (laptop, máy chiếu, bộ phát Wi-Fi,...) được xây dựng bằng **PHP thuần** (không framework, không database).

Dự án thuộc **Lab04 – PHP Secure Forms, PRG, Anti-spam & Session Login Flow**, tập trung vào xử lý form an toàn và quản lý session.

## Chức năng chính

- Đăng nhập bằng tài khoản mẫu.
- Gửi yêu cầu mượn thiết bị qua form.
- Validation phía server và hiển thị lỗi theo từng trường.
- Sticky form: giữ lại dữ liệu đã nhập khi validation thất bại.
- Áp dụng **PRG (Post-Redirect-Get)** để tránh gửi trùng khi refresh.
- Sử dụng **flash message** cho các thông báo ngắn hạn.
- Chống spam bằng **honeypot** và **rate limit**.
- Quản lý session an toàn với `session_regenerate_id()`, idle timeout và clean logout.

## Cài đặt và chạy

```bash
composer dump-autoload
php -S localhost:8000 -t public
```

Truy cập:

```text
http://localhost:8000
```

Tài khoản demo:

```text
Email: student@example.com
Password: 123456
```

> Lưu ý: chạy các lệnh trên tại thư mục gốc chứa `composer.json`.

## Các route chính

| Method | URL                 | Chức năng                  |
| ------ | ------------------- | -------------------------- |
| GET    | `/`                 | Trang chủ                  |
| GET    | `/equipment`        | Danh sách yêu cầu mượn     |
| GET    | `/equipment/create` | Form đăng ký mượn thiết bị |
| POST   | `/equipment`        | Gửi yêu cầu mượn           |
| POST   | `/equipment/delete` | Xóa yêu cầu                |
| GET    | `/login`            | Trang đăng nhập            |
| POST   | `/login`            | Xử lý đăng nhập            |
| POST   | `/logout`           | Đăng xuất                  |
| GET    | `/dashboard`        | Dashboard                  |

- URL không tồn tại → **404 Not Found**
- Route tồn tại nhưng sai method → **405 Method Not Allowed**

## Kiểm thử

Dự án được kiểm thử với **16 test case (T01–T16)**. Mô tả chi tiết và ảnh minh chứng được trình bày trong báo cáo PDF.

Có thể kiểm tra nhanh bằng `curl` hoặc Postman:

### Gửi form hợp lệ

```bash
curl -i -X POST http://localhost:8000/equipment \
  -d "name=Tran Trong Tri&email=student@example.com&phone=0912345678&equipment_type=laptop&purpose=Muon de thuyet trinh&website="
```

### Sai method (logout chỉ chấp nhận POST)

```bash
curl -i -X GET http://localhost:8000/logout
```

### Route không tồn tại

```bash
curl -i http://localhost:8000/khong-ton-tai
```

## Lưu trữ dữ liệu

Các yêu cầu mượn thiết bị được lưu tại:

```text
storage/equipment_requests.json
```

Dự án sử dụng `JSON_UNESCAPED_UNICODE` để đảm bảo dữ liệu tiếng Việt được lưu đúng định dạng.

Mật khẩu tài khoản được băm bằng `password_hash()` và xác thực bằng `password_verify()`.

## Hạn chế và hướng phát triển

Trong phạm vi Lab04, dự án sử dụng file JSON thay cho database và chưa triển khai CSRF token.

Nếu mở rộng thành hệ thống thực tế, có thể bổ sung:

- PDO/MySQL hoặc hệ quản trị cơ sở dữ liệu khác.
- CSRF token cho các form POST.
- Logging và theo dõi hoạt động người dùng.
- Phân quyền người dùng (RBAC).
- Quy trình duyệt, từ chối hoặc hoàn trả thiết bị.

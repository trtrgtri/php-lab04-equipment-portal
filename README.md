# Mini Equipment Borrow Request Portal

Ứng dụng mô phỏng quy trình đăng ký mượn thiết bị học tập (laptop, máy chiếu, bộ phát Wi-Fi,...) được xây dựng bằng **PHP thuần** (không framework, không database).
Dự án thuộc **Lab04 – PHP Secure Forms, PRG, Anti-spam & Session Login Flow**, tập trung vào xử lý form an toàn và quản lý session.

## 1. Chức năng chính

- **Đăng nhập:** Truy cập Dashboard bằng tài khoản mẫu.
- **Secure Form:** Gửi yêu cầu mượn thiết bị, validation phía server và hiển thị lỗi theo từng trường.
- **Sticky form:** Giữ lại dữ liệu đã nhập khi validation thất bại.
- **PRG (Post-Redirect-Get):** Tránh tình trạng gửi trùng dữ liệu khi refresh (F5).
- **Flash message:** Hiển thị các thông báo ngắn hạn (thành công/lỗi) và tự xóa sau 1 lần tải trang.
- **Anti-spam:** Bẫy bot bằng field ẩn (honeypot) và chặn gửi liên tục bằng rate limit.
- **Bảo mật Session:** Chống Session Fixation bằng `session_regenerate_id()`, tự động đăng xuất (idle timeout) và clean logout.

## 2. Cài đặt và chạy

Yêu cầu hệ thống: PHP >= 8.0 & Composer. Chạy các lệnh sau tại thư mục gốc chứa `composer.json`:

```bash
composer dump-autoload
php -S localhost:8000 -t public

```

Truy cập: `http://localhost:8000`
Tài khoản demo: **student@example.com** / **123456**

## 3. Danh sách Route

| Method | URL                 | Chức năng                       |
| ------ | ------------------- | ------------------------------- |
| `GET`  | `/`                 | Trang chủ                       |
| `GET`  | `/equipment`        | Danh sách yêu cầu mượn          |
| `GET`  | `/equipment/create` | Form đăng ký mượn thiết bị      |
| `POST` | `/equipment`        | Gửi yêu cầu mượn (Lưu JSON)     |
| `POST` | `/equipment/delete` | Xóa yêu cầu (Yêu cầu đăng nhập) |
| `GET`  | `/login`            | Trang đăng nhập                 |
| `POST` | `/login`            | Xử lý đăng nhập                 |
| `POST` | `/logout`           | Đăng xuất                       |
| `GET`  | `/dashboard`        | Dashboard (Yêu cầu đăng nhập)   |

_(URL không tồn tại → 404 Not Found; Route tồn tại nhưng sai method → 405 Method Not Allowed)_

## 4. Hướng dẫn kiểm thử nhanh (T01–T16)

| Mã  | Kịch bản                                                      | Kết quả mong đợi                             |
| --- | ------------------------------------------------------------- | -------------------------------------------- |
| T01 | Mở `/equipment/create` và submit form                         | `POST /equipment` được xử lý                 |
| T02 | Bỏ trống các trường bắt buộc                                  | Redirect về form, hiển thị lỗi               |
| T03 | Nhập email `abc@`                                             | Báo email không đúng định dạng               |
| T04 | Nhập phone `abc123`                                           | Báo lỗi số điện thoại                        |
| T05 | Dùng DevTools sửa `equipment_type` thành giá trị không hợp lệ | Bị chặn bởi validation                       |
| T06 | Điền field honeypot `website`                                 | Request bị từ chối                           |
| T07 | Submit 2 lần trong dưới 5 giây                                | Báo gửi quá nhanh                            |
| T08 | Submit hợp lệ rồi nhấn F5 ở trang danh sách                   | Không tạo dữ liệu trùng                      |
| T09 | Nhập `<script>alert(1)</script>`                              | Script được escape thành text                |
| T10 | Đăng nhập sai mật khẩu                                        | Redirect về login và báo lỗi                 |
| T11 | Đăng nhập đúng tài khoản demo                                 | Redirect dashboard, regenerate session       |
| T12 | Truy cập `/dashboard` khi chưa login                          | Redirect về `/login`                         |
| T13 | Logout bằng POST                                              | Session bị xóa, không truy cập lại dashboard |
| T14 | Giảm idle timeout rồi chờ quá hạn                             | Bị đăng xuất và báo hết phiên                |
| T15 | Kiểm tra cookie session bằng DevTools                         | Có HttpOnly, SameSite=Lax                    |
| T16 | Truy cập URL không tồn tại hoặc sai method                    | Trả về 404 hoặc 405                          |

## 5. Lưu trữ dữ liệu

- Yêu cầu mượn được lưu tại: `storage/equipment_requests.json`. Dự án sử dụng cờ `JSON_UNESCAPED_UNICODE` để đảm bảo lưu đúng font tiếng Việt.
- Mật khẩu tài khoản được băm an toàn bằng `password_hash()` và xác thực bằng `password_verify()`.

## 6. Hạn chế và hướng phát triển

Trong phạm vi Lab04, dự án cố tình sử dụng file JSON thay cho database và chưa triển khai CSRF token ẩn. Nếu mở rộng thành hệ thống thực tế, cần bổ sung:

- Chuyển đổi sang PDO/MySQL để tránh lỗi xung đột ghi file (Race Condition).
- Thêm CSRF Token cho mọi form `POST` để chống giả mạo request hoàn toàn.
- Phân quyền người dùng (RBAC) và bổ sung luồng duyệt/từ chối đơn mượn.

```

```

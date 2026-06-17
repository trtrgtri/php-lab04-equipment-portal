# Mini Equipment Borrow Request Portal

Cổng đăng ký mượn thiết bị, xây dựng bằng **PHP thuần** (không framework, không database).

Dự án thuộc **Lab04 — PHP Secure Forms, PRG, Anti-spam & Session Login Flow**, tập trung vào xử lý form an toàn và luồng đăng nhập/phiên bảo mật.

## 1. Tính năng chính

- **Front Controller + Router:** mọi request đi qua `public/index.php`, phân loại GET/POST và xử lý lỗi 404/405.
- **Form bảo mật 3 lớp:** đọc input an toàn (`?? ''`), chuẩn hóa (`trim()`), escape output chống XSS (`htmlspecialchars()`).
- **Validation server-side theo trình tự:** Required → Format → Logic (in-list, độ dài), hiển thị lỗi theo từng field và giữ lại dữ liệu đã nhập (sticky form).
- **PRG (Post-Redirect-Get):** chống gửi trùng khi nhấn F5.
- **Flash message:** thông báo chỉ hiển thị một lần.
- **Anti-spam:** honeypot và rate limit.
- **Bảo mật Session/Login:** cookie flags (`HttpOnly`, `SameSite`, `Secure`), `session_regenerate_id()` chống Session Fixation, idle timeout và clean logout.

## 2. Yêu cầu môi trường

- PHP >= 8.0
- Composer

## 3. Cài đặt và chạy

```bash
cd php-lab04-equipment-portal
composer dump-autoload
php -S localhost:8000 -t public
```

Mở trình duyệt tại:

```text
http://localhost:8000/
```

**Tài khoản demo:**

```text
Email: student@example.com
Password: 123456
```

> Lưu ý: chạy lệnh khởi động server tại thư mục gốc chứa file `composer.json`.

## 4. Danh sách Route

| Method | URL                 | Controller@Action                 |
| ------ | ------------------- | --------------------------------- |
| GET    | `/`                 | `HomeController@index`            |
| GET    | `/equipment`        | `EquipmentController@index`       |
| GET    | `/equipment/create` | `EquipmentController@create`      |
| POST   | `/equipment`        | `EquipmentController@store`       |
| POST   | `/equipment/delete` | `EquipmentController@delete`      |
| GET    | `/login`            | `AuthController@login`            |
| POST   | `/login`            | `AuthController@handleLogin`      |
| POST   | `/logout`           | `AuthController@logout`           |
| GET    | `/dashboard`        | `DashboardController@index`       |
| GET    | `/session-demo`     | `DashboardController@sessionDemo` |

- URL không tồn tại → **404 Not Found**
- Route tồn tại nhưng sai method → **405 Method Not Allowed**

## 5. Kỹ thuật bảo mật

| Kỹ thuật                    | Vị trí                                              | Mục đích                                      |
| --------------------------- | --------------------------------------------------- | --------------------------------------------- |
| Fallback `?? ''` + `trim()` | `EquipmentController::store()`                      | Đọc input an toàn, chuẩn hóa dữ liệu          |
| Escape `h()`                | Thư mục `views/`                                    | Chống XSS                                     |
| Validation theo trình tự    | `EquipmentController::validate()`                   | Required → Format → Logic                     |
| Honeypot + Rate limit       | `validate()`                                        | Chống bot spam, chống gửi liên tục            |
| PRG                         | `store()` gọi `redirect()`                          | Chống F5 submit trùng                         |
| Cookie flags                | `public/index.php`                                  | Cấu hình `HttpOnly`, `SameSite=Lax`, `Secure` |
| Session Fixation            | `session_regenerate_id(true)` trong `handleLogin()` | Đổi Session ID sau đăng nhập                  |
| Idle timeout                | `check_session_timeout()`                           | Tự động hết hạn phiên sau 15 phút             |
| Clean logout                | `logout_clean()`                                    | Xóa session và cookie                         |

## 6. Kiểm thử

Dự án được kiểm thử với **16 test case (T01–T16)** trên:

```text
http://localhost:8000
```

Ảnh minh chứng và mô tả chi tiết nằm trong báo cáo PDF.

Ví dụ kiểm thử bằng `curl`:

### Gửi form hợp lệ

```bash
curl -i -X POST http://localhost:8000/equipment \
  -d "name=Tran Trong Tri&email=student@example.com&phone=0912345678&equipment_type=laptop&purpose=Muon de thuyet trinh&website="
```

### Sai method (logout chỉ nhận POST)

```bash
curl -i -X GET http://localhost:8000/logout
```

### Route không tồn tại

```bash
curl -i http://localhost:8000/khong-ton-tai
```

## 7. Phạm vi (Giới hạn có chủ đích)

Lab04 sử dụng **file JSON** thay cho database và **chưa triển khai CSRF token**.

`SameSite=Lax` chỉ giúp giảm rủi ro CSRF, chưa thể ngăn chặn hoàn toàn.

Đây là các điểm sẽ được nâng cấp khi mở rộng thành dự án thực tế:

- Sử dụng PDO/MySQL.
- Thêm CSRF token vào các form.
- Bổ sung Logging.
- Áp dụng RBAC (Role-Based Access Control).

## 8. Ghi chú kỹ thuật

- Dữ liệu yêu cầu mượn thiết bị được lưu tại:

```text
storage/equipment_requests.json
```

- Sử dụng `JSON_UNESCAPED_UNICODE` để giữ nguyên tiếng Việt khi ghi file JSON.
- Mật khẩu đăng nhập được băm bằng `password_hash()` và xác thực bằng `password_verify()`.

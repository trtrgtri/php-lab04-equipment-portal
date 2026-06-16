<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Support\Response;

class EquipmentController
{
    // Danh sách thiết bị cho phép mượn (In-list validation)
    private array $allowedEquipment = ['laptop', 'projector', 'camera', 'cable'];

    public function index(): void
    {
        Response::view('equipment/index', [
            'title' => 'Danh sách yêu cầu mượn thiết bị',
            'items' => $this->loadRequests(),
        ]);
    }

    public function create(): void
    {
        // Lấy dữ liệu cũ và lỗi từ Flash Session (nếu có) để hiển thị lại
        $old = flash_get('old', []);
        $errors = flash_get('errors', []);

        Response::view('equipment/create', [
            'title' => 'Form đăng ký mượn thiết bị',
            'old' => $old,
            'errors' => $errors,
            'allowedEquipment' => $this->allowedEquipment,
        ]);
    }

    public function store(): void
    {
        // 1. Đọc và chuẩn hóa input an toàn
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'equipment_type' => trim($_POST['equipment_type'] ?? ''),
            'purpose' => trim($_POST['purpose'] ?? ''),
            'website' => trim($_POST['website'] ?? ''), // Trường Honeypot giăng bẫy bot
        ];

        // 2. Chạy Validation & Anti-spam
        $errors = $this->validate($data);

        // 3. Xử lý lỗi chuẩn PRG (Không render view trực tiếp, phải Redirect)
        if (!empty($errors)) {
            flash_set('errors', $errors);
            flash_set('old', [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'equipment_type' => $data['equipment_type'],
                'purpose' => $data['purpose'],
            ]);
            redirect('/equipment/create');
        }

        // 4. Nếu hợp lệ: Lưu JSON, cập nhật Rate Limit và Redirect
        $this->saveRequest($data);
        $_SESSION['last_equipment_submit_at'] = time();

        flash_set('success', 'Gửi yêu cầu mượn thiết bị thành công! Hệ thống đã redirect để chống submit trùng.');
        redirect('/equipment');
    }

    private function validate(array $data): array
    {
        $errors = [];

        // Anti-spam: Honeypot
        if ($data['website'] !== '') {
            $errors['_global'] = 'Yêu cầu bị từ chối do phát hiện hành vi tự động (bot).';
        }

        // Anti-spam: Rate limit (Chặn submit liên tục dưới 5 giây)
        $lastSubmit = $_SESSION['last_equipment_submit_at'] ?? 0;
        if ($lastSubmit && time() - $lastSubmit < 5) {
            $errors['_global'] = 'Bạn đang gửi yêu cầu quá nhanh. Vui lòng thử lại sau vài giây.';
        }

        // Validate định dạng và logic nghiệp vụ
        if ($data['name'] === '') {
            $errors['name'] = 'Vui lòng nhập họ tên.';
        } elseif (mb_strlen($data['name']) < 2) {
            $errors['name'] = 'Họ tên phải có ít nhất 2 ký tự.';
        }

        if ($data['email'] === '') {
            $errors['email'] = 'Vui lòng nhập email.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không đúng định dạng.';
        }

        if ($data['phone'] === '') {
            $errors['phone'] = 'Vui lòng nhập số điện thoại.';
        } elseif (!preg_match('/^[0-9+\-\s]{9,15}$/', $data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ (chỉ gồm số, khoảng trắng, +, -).';
        }

        // In-list validation
        if ($data['equipment_type'] === '' || !in_array($data['equipment_type'], $this->allowedEquipment, true)) {
            $errors['equipment_type'] = 'Vui lòng chọn loại thiết bị hợp lệ trong danh mục.';
        }

        if ($data['purpose'] !== '' && mb_strlen($data['purpose']) > 300) {
            $errors['purpose'] = 'Mục đích mượn không được trình bày vượt quá 300 ký tự.';
        }

        return $errors;
    }

    // --- Logic xử lý file JSON ---

    private function storageFile(): string
    {
        return dirname(__DIR__, 2) . '/storage/equipment_requests.json';
    }

    private function loadRequests(): array
    {
        $file = $this->storageFile();
        if (!file_exists($file)) {
            return [];
        }
        $json = file_get_contents($file);
        return json_decode($json, true) ?: [];
    }

    private function saveRequest(array $data): void
    {
        $items = $this->loadRequests();
        $items[] = [
            'id' => 'EQ' . str_pad((string) (count($items) + 1), 3, '0', STR_PAD_LEFT),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'equipment_type' => $data['equipment_type'],
            'purpose' => $data['purpose'],
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Lưu file JSON giữ nguyên tiếng Việt và fomat đẹp
        file_put_contents($this->storageFile(), json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

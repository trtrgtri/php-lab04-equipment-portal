<div class="page-header">
    <div>
        <h1><?= h($title) ?></h1>
        <p>Danh sách các yêu cầu mượn thiết bị được đọc từ <code>storage/equipment_requests.json</code>.</p>
    </div>
    <a class="button" href="/equipment/create">Tạo yêu cầu mượn</a>
</div>

<table class="table" style="width: 100%; border-collapse: collapse; background: white;">
    <thead>
        <tr style="background: #f1f5f9;">
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: left;">Mã YC</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: left;">Họ tên</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: left;">Email</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: left;">SĐT</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: left;">Thiết bị</th>
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: left;">Ngày mượn</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="6" style="padding: 12px; border: 1px solid #e2e8f0; text-align: center;">Chưa có yêu cầu mượn nào.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['id']) ?></td>
                    <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['name']) ?></td>
                    <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['email']) ?></td>
                    <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['phone']) ?></td>
                    <td style="padding: 12px; border: 1px solid #e2e8f0; font-weight: bold; color: #2563eb;"><?= h(ucfirst($item['equipment_type'])) ?></td>
                    <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
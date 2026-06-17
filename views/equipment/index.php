<?php

/**
 * @var string $title
 * @var array $items
 */
?>
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
            <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center;">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['id']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['name']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['email']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['phone']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0; font-weight: bold;"><?= h(ucfirst($item['equipment_type'])) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= h($item['created_at']) ?></td>

                <td style="padding: 12px; border: 1px solid #e2e8f0; text-align: center;">
                    <form method="post" action="/equipment/delete" onsubmit="return confirm('Bạn chắc chắn muốn xóa bản ghi này?');">
                        <input type="hidden" name="id" value="<?= h($item['id']) ?>">
                        <button type="submit" style="color: #dc2626; background: none; border: none; cursor: pointer; font-weight: bold;">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
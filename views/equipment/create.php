<?php

/**
 * @var string $title
 * @var array $old
 * @var array $errors
 * @var array $allowedEquipment
 */
?>

<div class="page-header">
    <div>
        <h1><?= h($title) ?></h1>
        <p>Form này submit an toàn đến <code>POST /equipment</code>.</p>
    </div>
</div>

<?php if (!empty($errors['_global'])): ?>
    <div class="alert danger"><?= h($errors['_global']) ?></div>
<?php endif; ?>

<form method="post" action="/equipment" class="form-card">
    <div class="form-group">
        <label>Họ và tên</label>
        <input name="name" value="<?= h($old['name'] ?? '') ?>" placeholder="Ví dụ: Nguyễn Văn A">
        <?php if (!empty($errors['name'])): ?><div style="color:#dc2626; font-size:14px; margin-top:4px;"><?= h($errors['name']) ?></div><?php endif; ?>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input name="email" value="<?= h($old['email'] ?? '') ?>" placeholder="student@example.com">
        <?php if (!empty($errors['email'])): ?><div style="color:#dc2626; font-size:14px; margin-top:4px;"><?= h($errors['email']) ?></div><?php endif; ?>
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input name="phone" value="<?= h($old['phone'] ?? '') ?>" placeholder="0901234567">
        <?php if (!empty($errors['phone'])): ?><div style="color:#dc2626; font-size:14px; margin-top:4px;"><?= h($errors['phone']) ?></div><?php endif; ?>
    </div>

    <div class="form-group">
        <label>Loại thiết bị</label>
        <select name="equipment_type" style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px;">
            <option value="">-- Chọn thiết bị cần mượn --</option>
            <?php foreach ($allowedEquipment as $eq): ?>
                <option value="<?= h($eq) ?>" <?= (($old['equipment_type'] ?? '') === $eq) ? 'selected' : '' ?>>
                    <?= h(ucfirst($eq)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['equipment_type'])): ?><div style="color:#dc2626; font-size:14px; margin-top:4px;"><?= h($errors['equipment_type']) ?></div><?php endif; ?>
    </div>

    <div class="form-group">
        <label>Mục đích mượn</label>
        <textarea name="purpose" rows="4" style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; font-family: inherit;"><?= h($old['purpose'] ?? '') ?></textarea>
        <?php if (!empty($errors['purpose'])): ?><div style="color:#dc2626; font-size:14px; margin-top:4px;"><?= h($errors['purpose']) ?></div><?php endif; ?>
    </div>

    <div style="display: none;" class="honeypot-field">
        <label for="website">Website (Để trống):</label>
        <input type="text" id="website" name="website" value="" tabindex="-1" autocomplete="off">
    </div>

    <button class="button" type="submit" style="margin-top: 10px;">Gửi yêu cầu mượn</button>
    <a class="button secondary" href="/equipment" style="margin-top: 10px;">Quay lại</a>
</form>
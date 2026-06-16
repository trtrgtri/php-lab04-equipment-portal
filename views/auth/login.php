<div class="page-header">
    <div>
        <h1><?= h($title ?? 'Đăng nhập') ?></h1>
        <p>Tài khoản demo: <strong>student@example.com</strong> / <strong>123456</strong></p>
    </div>
</div>

<form class="form-card" method="POST" action="/login" style="max-width: 400px;">
    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" value="<?= h($old['email'] ?? '') ?>" placeholder="student@example.com">
        <?php if (!empty($errors['email'])): ?><div style="color:#dc2626; font-size:14px; margin-top:4px;"><?= h($errors['email']) ?></div><?php endif; ?>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="123456">
        <?php if (!empty($errors['password'])): ?><div style="color:#dc2626; font-size:14px; margin-top:4px;"><?= h($errors['password']) ?></div><?php endif; ?>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <label style="font-weight: normal; cursor: pointer;">
            <input type="checkbox" name="remember_me" value="1"> Remember me
        </label>
        <small style="display:block; color:#64748b; margin-top:4px;">Lab 04 chỉ thảo luận rủi ro, không lưu password trong cookie.</small>
    </div>

    <button class="button" type="submit" style="margin-top: 15px;">Login</button>
</form>
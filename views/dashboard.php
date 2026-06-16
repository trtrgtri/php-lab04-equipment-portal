<div class="page-header">
    <div>
        <h1><?= h($title ?? 'Dashboard') ?></h1>
        <p>Khu vực yêu cầu đăng nhập. Bạn đang xem thông tin Session hiện tại.</p>
    </div>
</div>

<div class="card" style="max-width: 600px; background: white; border: 1px solid #e5e7eb; border-radius: 14px; padding: 24px;">
    <h2 style="margin-top: 0;">Xin chào, <?= h($userName ?? '') ?>!</h2>
    <p>Quyền hạn (Role): <strong><?= h($role ?? '') ?></strong></p>
    <p>Thời điểm đăng nhập: <code><?= h($loginAt ?? '') ?></code></p>
    <p>Hoạt động gần nhất: <code><?= h($lastActivity ?? '') ?></code></p>

    <hr style="border: 1px solid #e5e7eb; margin: 20px 0;">

    <a class="button secondary" href="/session-demo" target="_blank" style="background: #64748b; color: white; padding: 10px 14px; border-radius: 8px; text-decoration: none; display: inline-block;">
        Xem dữ liệu Session Debug (JSON)
    </a>
</div>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($title ?? 'Mini Equipment Portal') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>
    <nav class="topbar">
        <strong>Mini Equipment Portal</strong>
        <div>
            <a href="/">Home</a>
            <a href="/equipment">Danh sách mượn</a>
            <a href="/equipment/create">Đăng ký mượn</a>

            <?php if (is_logged_in()): ?>
                <a href="/dashboard">Dashboard</a>
                <form method="post" action="/logout" style="display:inline; margin-left: 18px;">
                    <button type="submit" style="background:none; border:none; color:#e5e7eb; cursor:pointer; font:inherit; padding:0;">Logout</button>
                </form>
            <?php else: ?>
                <a href="/login">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="container">
        <?php if ($success = flash_get('success')): ?>
            <div class="alert success"><?= h($success) ?></div>
        <?php endif; ?>

        <?php if ($error = flash_get('error')): ?>
            <div class="alert danger"><?= h($error) ?></div>
        <?php endif; ?>

        <?php
        /** @var string $viewPath */
        require $viewPath;
        ?>
    </main>
</body>

</html>
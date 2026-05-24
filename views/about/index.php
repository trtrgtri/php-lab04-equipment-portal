<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'About') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/equipments">Equipments</a></li>
            <li><a href="/about">About</a></li>
        </ul>
    </nav>

    <main>
        <h1><?= htmlspecialchars($title ?? 'About Us') ?></h1>
        <p>Đây là trang giới thiệu về ứng dụng PHP Mini Equipment Router.</p>
    </main>
</body>
</html>
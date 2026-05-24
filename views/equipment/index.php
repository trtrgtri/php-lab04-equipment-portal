<?php
$title     = $title ?? 'Equipment';
$equipment = $equipment ?? [];
$created   = $created ?? false;

function stockStatus(int $quantity): string
{
    if ($quantity <= 0) return 'Out of stock';
    if ($quantity <= 5) return 'Low stock';
    return 'Available';
}

function stockClass(int $quantity): string
{
    if ($quantity <= 0) return 'danger';
    if ($quantity <= 5) return 'warning';
    return 'success';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header class="topbar">
        <strong>PHP Mini Equipment Router</strong>
        <nav>
            <a href="/">Home</a>
            <a href="/equipment">Equipment</a>
            <a href="/equipment/create">Create Equipment</a>
            <a href="/health">Health</a>
            <a href="/login">Login</a>
            <a href="/about">About</a>
        </nav>
    </header>

    <main class="container">
        <?php if ($created): ?>
            <div class="alert success">
                Equipment form submitted successfully. Redirect response worked.
            </div>
        <?php endif; ?>

        <div class="page-header">
            <div>
                <h1>Equipment List</h1>
                <p>This page is handled by EquipmentController@index.</p>
            </div>
            <a class="button" href="/equipment/create">Create Equipment</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipment as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['sku']) ?></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['category']) ?></td>
                        <td><?= number_format($item['price']) ?> VND</td>
                        <td><?= htmlspecialchars((string) $item['quantity']) ?></td>
                        <td>
                            <span class="badge <?= stockClass((int) $item['quantity']) ?>">
                                <?= stockStatus((int) $item['quantity']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

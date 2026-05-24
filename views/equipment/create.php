<?php
$title = $title ?? 'Create Equipment';
$error = $error ?? null;
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
        <h1>Create Equipment</h1>
        <p>This form submits to <code>POST /equipment</code>.</p>

        <?php if ($error): ?>
            <div class="alert danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form class="form-card" method="POST" action="/equipment">
            <div class="form-group">
                <label>Equipment name</label>
                <input type="text" name="name" placeholder="Forklift 3-Ton">
            </div>

            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" placeholder="Heavy Machinery">
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" placeholder="450000000">
            </div>

            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" placeholder="5">
            </div>

            <button class="button" type="submit">Save Equipment</button>
            <a class="button secondary" href="/equipment">Back to Equipment</a>
        </form>
    </main>
</body>
</html>

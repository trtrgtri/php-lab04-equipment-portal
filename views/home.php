<?php
$title        = $title ?? 'Home';
$message      = $message ?? '';
$loginSuccess = ($_GET['login'] ?? '') === 'success';
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
            <a href="/logout">Logout</a>
            <a href="/about">About</a>
        </nav>
    </header>

    <main class="container">
        <?php if ($loginSuccess): ?>
            <div class="alert success">
                Login request processed successfully. You were redirected to Home.
            </div>
        <?php endif; ?>

        <section class="hero">
            <h1>Mini Equipment Routing App</h1>
            <p><?= htmlspecialchars($message) ?></p>
        </section>

        <section class="grid">
            <div class="card">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#4f8ef7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/>
                </svg>
                <h3>HTML Response</h3>
                <p>Visit <code>/</code> or <code>/equipment</code>.</p>
            </div>

            <div class="card">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#4f8ef7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
                </svg>
                <h3>JSON Response</h3>
                <p>Visit <code>/health</code> or <code>/api/equipment</code>.</p>
            </div>

            <div class="card">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#f5a623" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/>
                </svg>
                <h3>Redirect Response</h3>
                <p>Visit <code>/go-home</code> or login form.</p>
            </div>

            <div class="card">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <h3>404 / 405</h3>
                <p>Try <code>/unknown</code> or <code>POST /health</code>.</p>
            </div>
        </section>
    </main>
</body>
</html>
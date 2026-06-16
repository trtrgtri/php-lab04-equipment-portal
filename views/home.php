<style>
    /* CSS dành riêng cho trang Home (Dark Mode) */
    .home-wrapper {
        background-color: #050505;
        color: #ffffff;
        padding: 40px;
        border-radius: 12px;
        margin-top: -10px;
        /* Đẩy lên sát navbar hơn một chút */
    }

    .home-header h1 {
        font-size: 32px;
        font-weight: bold;
        margin-top: 0;
        margin-bottom: 8px;
    }

    .home-header p {
        color: #9ca3af;
        font-size: 16px;
        margin-bottom: 40px;
    }

    .home-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .home-card {
        background-color: #000000;
        border: 1px solid #1f2937;
        border-radius: 12px;
        padding: 24px;
        transition: transform 0.2s, border-color 0.2s;
    }

    .home-card:hover {
        transform: translateY(-4px);
        border-color: #374151;
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        color: #000000;
        margin-bottom: 20px;
    }

    .icon-1 {
        background-color: #0ea5e9;
    }

    /* Xanh dương */
    .icon-2 {
        background-color: #22c55e;
    }

    /* Xanh lá */
    .icon-3 {
        background-color: #d97706;
    }

    /* Cam */
    .icon-4 {
        background-color: #c084fc;
    }

    /* Tím */

    .home-card h3 {
        font-size: 20px;
        margin: 0 0 12px 0;
        color: #ffffff;
    }

    .home-card p {
        color: #9ca3af;
        font-size: 14px;
        line-height: 1.5;
        margin: 0;
    }
</style>

<div class="home-wrapper">
    <div class="home-header">
        <h1>Lab04 - Secure Forms & Session Login Flow</h1>
        <p>Week 4 + Week 5: GET/POST, Validation, PRG, Anti-spam, Session, Login/Logout</p>
    </div>

    <div class="home-grid">
        <div class="home-card">
            <div class="icon-box icon-1">1</div>
            <h3>Secure Form</h3>
            <p>Đọc input an toàn, escape output, giữ dữ liệu cũ khi lỗi.</p>
        </div>
        <div class="home-card">
            <div class="icon-box icon-2">2</div>
            <h3>Validation + PRG</h3>
            <p>Validate server-side, flash errors, redirect để tránh submit trùng.</p>
        </div>
        <div class="home-card">
            <div class="icon-box icon-3">3</div>
            <h3>Anti-spam</h3>
            <p>Honeypot và rate limit đơn giản bằng session.</p>
        </div>
        <div class="home-card">
            <div class="icon-box icon-4">4</div>
            <h3>Login/Session</h3>
            <p>Cookie flags, regenerate, timeout, logout sạch.</p>
        </div>
    </div>
</div>
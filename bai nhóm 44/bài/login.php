<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* CSS này sẽ dùng chung với trang register.php */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--color-background);
            color: var(--color-primary-text);
        }
        .auth-form {
            background: var(--color-surface);
            padding: 24px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
        }
        .auth-form h2 {
            text-align: center;
            margin-bottom: 24px;
        }
        .auth-form div {
            margin-bottom: 16px;
        }
        .auth-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .auth-form input[type="text"],
        .auth-form input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid var(--color-hover);
            background: var(--color-background);
            color: var(--color-primary-text);
        }
        .auth-form button {
            width: 100%;
            padding: 12px 20px;
            background: #1DB954;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
        }
        .auth-form .message {
            text-align: center;
            margin-bottom: 15px;
            color: #FF0000;
        }
        .auth-form .form-link {
            text-align: center;
            margin-top: 20px;
        }
        .auth-form .form-link a {
            color: #1DB954;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <form action="handle_login.php" method="POST" class="auth-form">
        <h2>Đăng Nhập</h2>

        <?php if (isset($_GET['message'])): ?>
            <p class="message" style="color: <?= (isset($_GET['success']) && $_GET['success'] == '1') ? '#1DB954' : '#FF0000'; ?>;">
                <?= htmlspecialchars($_GET['message']) ?>
            </p>
        <?php endif; ?>

        <div>
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit">Đăng Nhập</button>
        
        <div class="form-link">
            <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
        </div>
    </form>

</body>
</html>
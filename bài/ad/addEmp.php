<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db_connect.php';

// Chỉ cho phép Role = 2 (admin)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: firewall.php");
    exit();
}

$err = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email    = $_POST['email'];
    $role     = $_POST['role'];

    // Kiểm tra username tồn tại chưa
    $stmt = $conn->prepare("SELECT user_id FROM nguoi_dung WHERE ten_dang_nhap = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $err = "Tên đăng nhập đã tồn tại!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Thời gian tạo tài khoản
        $created_at = date("Y-m-d H:i:s");

        $stmt = $conn->prepare("
            INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, email, vai_tro, ngay_tao) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssis", $username, $hashed_password, $email, $role, $created_at);

        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Thêm nhân viên thành công!";
            header("Location: EmpMan.php");
            exit();
        } else {
            $err = "Lỗi thêm dữ liệu!";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm nhân viên</title>
    <link rel="icon" type="image/png" href="../img/logo.jpg">
    <link rel="stylesheet" href="style-Admin.css">
    <style>
         .content {
            margin-left: 260px;
            padding: 30px;
        }

        form {
            max-width: 650px;
            margin-left: 50px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px #ccc;
            border-radius: 8px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group label {
            width: 30%;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 70%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .msg-success {
            color: green;
            font-weight: bold;
        }

        .msg-error {
            color: red;
            font-weight: bold;
        }

        button {
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            background-color:rgb(74, 209, 81);
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color:rgb(37, 182, 44);
        }

    </style>
</head>
<body>

<div class="sidebar">
    <div class="user-info">
        <img src="avt_admin.png" alt="Avatar">
        <div class="username"><?= htmlspecialchars($_SESSION['username']) ?></div>
    </div>
    <?php include 'sidebar.php'; ?>
</div>

<div class="content">
    <h2>Thêm nhân viên mới</h2>

    <?php if ($err) echo "<p class='msg-error'>$err</p>"; ?>
    <?php if ($success) echo "<p class='msg-success'>$success</p>"; ?>

    <form method="post">

        <div class="form-group">
            <label>Tên đăng nhập:</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Mật khẩu:</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email">
        </div>

        <div class="form-group">
            <label>Vai trò:</label>
            <select name="role" required>
                <option value="1">Nhân viên</option>
                <option value="2">Quản trị</option>
            </select>
        </div>

        <button type="submit">Thêm nhân viên</button>
    </form>
</div>

</body>
</html>
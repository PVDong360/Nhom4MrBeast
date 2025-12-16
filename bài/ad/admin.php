<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
include '../db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: ad/firewall.php");    
    exit();
}
if (!isset($_SESSION['ten_dang_nhap'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT ten_dang_nhap FROM nguoi_dung WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($fullname);
    if ($stmt->fetch()) {
        $_SESSION['ten_dang_nhap'] = $fullname;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang quản trị</title>
    <link rel="stylesheet" href="style-Admin.css">  
</head>

<style>
        .content {
            margin-left: 260px;
            padding: 40px;
        }
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .box {
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px #ccc;
            border-radius: 8px;
            text-align: center;
        }
        .box h3 {
            margin: 0;
            font-size: 32px;
            color: #12263A;
        }
        .box p {
            margin: 5px 0 0;
            font-weight: bold;
            color: #666;
        }
    </style>
<body>
    <div class="welcome">
    <p>Xin chào, <?= htmlspecialchars($_SESSION['ten_dang_nhap']) ?>!</p>
</div>
       <div class="sidebar">
    <div class="user-info">
        <img src="avt_admin.png" alt="Avatar">
        <div class="username"><?= htmlspecialchars($_SESSION['username']) ?></div>
    </div>
    <?php include 'sidebar.php'; ?>
</div> 
</body>
</html>

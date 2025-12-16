<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db_connect.php';

// Kiểm tra phân quyền
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: firewall.php");
    exit();
}

// Lấy danh sách nhân viên
$sql = "SELECT user_id AS id, ten_dang_nhap AS username, email, ngay_tao
        FROM nguoi_dung 
        WHERE vai_tro = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhân viên</title>
    <link rel="icon" type="image/png" href="../img/logo.jpg">
    <link rel="stylesheet" href="style-Admin.css">
    <style>

    .user-info {
        padding: 30px 0;
    }

    .user-info img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 0 15px 3px #7ec6ff;
    }

    .username {
        font-size: 22px;
        font-weight: bold;
        margin-top: 10px;
        word-break: break-word;
    }

    .nav {
        list-style: none;
        padding: 0;
        margin: 30px 0 0 0;
    }

    .nav li {
        border-bottom: 1px solid white;
    }

    .nav li a {
        display: block;
        padding: 12px 0;
        color: white;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }

    .nav li a:hover {
        background-color: #1e3d59;
    }

    .content {
        margin-left: 260px;
        padding: 20px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #999;
        padding: 10px;
        text-align: center;
    }

    a.button {
        padding: 6px 12px;
        background: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin: 0 5px;
    }
    th {
        background-color: #12263A;
        color: white;
    }
    a.button:hover {
        background: #45a049;
    }
    </style>
<div class="sidebar">
    <div class="user-info">
        <img src="avt_admin.png" alt="Avatar">
        <div class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
    </div>
    <?php include 'sidebar.php' ?>
</div>

<div class="content">
    <h2>Danh sách nhân viên</h2>
    <div style="margin-bottom: 15px;">
        <a href="addEmp.php" class="button">+ Thêm nhân viên</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Tài khoản</th>
            <th>Email</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['ngay_tao']) ?></td>
        <td>
            <a href="delEmp.php?id=<?= htmlspecialchars($row['id']) ?>" class="button"
               onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
        </td>
    </tr>
<?php } ?>

    </table>
</div>

</body>
</html>
    
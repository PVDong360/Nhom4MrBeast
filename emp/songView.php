    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include '../db_connect.php';

    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        header("Location: firewall.php");
        exit();
    }

    $sql = "SELECT b.baihat_id, b.ten_bai_hat, b.ca_si, b.the_loai, b.file_mp3, 
                b.hinh_anh, b.user_id
            FROM bai_hat b
            INNER JOIN nguoi_dung u ON b.user_id = u.user_id
            WHERE u.vai_tro = 2";

    $result = $conn->query($sql);
    ?>

    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Danh sách bài viết</title>
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
    </head>
    <body>

    <div class="sidebar">
        <div class="user-info">
            <img src="avt_emp.png" alt="Avatar">
            <div class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
        </div>
        <?php include 'sidebar.php'; ?>
    </div>

    <div class="content">
    <h2>Danh sách bài hát</h2>

   <table>
    <tr>
        <th>ID</th>
        <th>Tên bài hát</th>
        <th>Ca sĩ</th>
        <th>Thể loại</th>
        <th>Hình ảnh</th>
        <th>Hành động</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['baihat_id'] ?></td>
        <td><?= $row['ten_bai_hat'] ?></td>
        <td><?= $row['ca_si'] ?></td>
        <td><?= $row['the_loai'] ?></td>

        <td>
    <?php if (!empty($row['hinh_anh'])): ?>
        <img src="../<?= $row['hinh_anh'] ?>?v=<?= time() ?>"
             alt=""
             style="width:70px; border-radius:6px;">
    <?php else: ?>
        Không có ảnh
    <?php endif; ?>
</td>


        <td>
            <a class="button" href="suaNhac.php?id=<?= $row['baihat_id'] ?>">Sửa</a>
            <a class="button" style="background:#e63946"
               onclick="return confirm('Bạn có chắc muốn xóa bài hát này?');"
               href="xoaNhac.php?id=<?= $row['baihat_id'] ?>">
               Xóa
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>


    </body>
    </html>












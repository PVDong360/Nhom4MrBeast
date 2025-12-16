<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db_connect.php';

// Chỉ cho phép vai trò = 2
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: firewall.php");
    exit();
}

$thongbao = "";
if (isset($_SESSION['thongbao'])) {
    $thongbao = $_SESSION['thongbao'];
    unset($_SESSION['thongbao']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $ten_bai_hat = $_POST['ten_bai_hat'];
    $ca_si       = $_POST['ca_si'];
    $the_loai    = $_POST['the_loai'];
    $user_id     = $_SESSION['user_id'];
    // XỬ LÝ UPLOAD FILE MP3
    $file_mp3_path = "";
    if (!empty($_FILES['file_mp3']['name'])) {

        $mp3_name = time() . "_" . basename($_FILES['file_mp3']['name']);
        $target_mp3 = "../uploads/music/" . $mp3_name;

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir("../uploads/music")) {
            mkdir("../uploads/music", 0777, true);
        }

        if (move_uploaded_file($_FILES['file_mp3']['tmp_name'], $target_mp3)) {
            $file_mp3_path = "uploads/music/" . $mp3_name;
        } else {
            $thongbao = "Lỗi khi tải file MP3!";
        }
    }
    // XỬ LÝ UPLOAD HÌNH ẢNH
    $hinh_anh_path = "";
    if (!empty($_FILES['hinh_anh']['name'])) {

        $img_name = time() . "_" . basename($_FILES['hinh_anh']['name']);
        $target_img = "../uploads/images/" . $img_name;

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir("../uploads/images")) {
            mkdir("../uploads/images", 0777, true);
        }

        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_img)) {
            $hinh_anh_path = "uploads/images/" . $img_name;
        } else {
            $thongbao = "Lỗi khi tải hình ảnh!";
        }
    }
    // LƯU VÀO DATABASE
    $stmt = $conn->prepare("INSERT INTO bai_hat (ten_bai_hat, ca_si, the_loai, file_mp3, hinh_anh, user_id)
                            VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssi",
        $ten_bai_hat,
        $ca_si,
        $the_loai,
        $file_mp3_path,
        $hinh_anh_path,
        $user_id
    );

    if ($stmt->execute()) {
        $_SESSION['thongbao'] = "Đăng bài hát thành công!";
        header("Location: songView.php");
        exit();
    } else {
        $thongbao = "Có lỗi xảy ra: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng bài hát</title>
<link rel="icon" type="image/png" href="../img/logo.jpg">
<link rel="stylesheet" href="style-Admin.css">
<style>
form {
    max-width: 600px;
    padding: 20px;
    background: #fff;
    margin: 50px auto;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}
input, select {
    width: 80%;
    padding: 10px;
    margin: 5px auto;
}
label {
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
}
button {
    padding: 10px 15px;
    background: #12263A;
    color: white;
    border: none;
    border-radius: 5px;
}
button:hover {
    background: #1e3d59;
}
.thongbao {
    padding: 10px;
    color: green;
    font-weight: bold;
}
</style>
</head>
<body>
<div class="sidebar">
    <div class="user-info">
        <img src="avt_emp.png" alt="Avatar">
        <div class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
    </div>
    <?php include 'sidebar.php' ?>
</div>

<div class="content">
    <h2>Đăng bài hát mới</h2>

    <?php if ($thongbao != "") echo "<div class='thongbao'>$thongbao</div>"; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Tên bài hát:</label>
        <input type="text" name="ten_bai_hat" required>

        <label>Ca sĩ:</label>
        <input type="text" name="ca_si" required>

        <label>Thể loại:</label>
        <input type="text" name="the_loai" required>

        <label>File MP3:</label>
        <input type="file" name="file_mp3" accept=".mp3" required>

        <label>Hình ảnh:</label>
        <input type="file" name="hinh_anh" accept="image/*">

        <button type="submit">Đăng bài hát</button>
    </form>
</div>

</body>
</html>

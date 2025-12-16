<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: firewall.php");
    exit();
}

// Lấy ID bài hát
if (!isset($_GET['id'])) {
    header("Location: songView.php");
    exit();
}

$baihat_id = intval($_GET['id']);
$thongbao = "";

$stmt = $conn->prepare("SELECT * FROM bai_hat WHERE baihat_id = ?");
$stmt->bind_param("i", $baihat_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: songView.php");
    exit();
}

$row = $result->fetch_assoc();

// XỬ LÝ KHI SUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $ten_bai_hat = $_POST['ten_bai_hat'];
    $ca_si       = $_POST['ca_si'];
    $the_loai    = $_POST['the_loai'];

    $file_mp3_path = $row['file_mp3'];
    $hinh_anh_path = $row['hinh_anh'];

    //CẬP NHẬT MP3 (NẾU CÓ)
    if (!empty($_FILES['file_mp3']['name'])) {

        $mp3_name = time() . "_" . basename($_FILES['file_mp3']['name']);
        $target_mp3 = "../uploads/music/" . $mp3_name;

        if (!is_dir("../uploads/music")) {
            mkdir("../uploads/music", 0777, true);
        }

        if (move_uploaded_file($_FILES['file_mp3']['tmp_name'], $target_mp3)) {
            $file_mp3_path = "uploads/music/" . $mp3_name;
        } else {
            $thongbao = "❌ Lỗi upload file MP3!";
        }
    }

    //CẬP NHẬT HÌNH ẢNH (NẾU CÓ)
    if (!empty($_FILES['hinh_anh']['name'])) {

        $img_name = time() . "_" . basename($_FILES['hinh_anh']['name']);
        $target_img = "../uploads/images/" . $img_name;

        if (!is_dir("../uploads/images")) {
            mkdir("../uploads/images", 0777, true);
        }

        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_img)) {
            $hinh_anh_path = "uploads/images/" . $img_name;
        } else {
            $thongbao = "❌ Lỗi upload hình ảnh!";
        }
    }
    // UPDATE DATABASE
    if ($thongbao == "") {
        $stmt = $conn->prepare(
            "UPDATE bai_hat 
             SET ten_bai_hat = ?, ca_si = ?, the_loai = ?, file_mp3 = ?, hinh_anh = ?
             WHERE baihat_id = ?"
        );

        $stmt->bind_param(
            "sssssi",
            $ten_bai_hat,
            $ca_si,
            $the_loai,
            $file_mp3_path,
            $hinh_anh_path,
            $baihat_id
        );

        if ($stmt->execute()) {
    header("Location: songView.php?id=" . $baihat_id);
    exit();
}
 else {
            $thongbao = "❌ Lỗi cập nhật dữ liệu!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa bài hát</title>
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
    <h2>Sửa bài hát</h2>

    <?php if ($thongbao != ""): ?>
        <div class="alert <?= strpos($thongbao,'❌') !== false ? 'error' : 'success' ?>">
            <?= $thongbao ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Tên bài hát:</label>
        <input type="text" name="ten_bai_hat" value="<?= htmlspecialchars($row['ten_bai_hat']) ?>" required>

        <label>Ca sĩ:</label>
        <input type="text" name="ca_si" value="<?= htmlspecialchars($row['ca_si']) ?>" required>

        <label>Thể loại:</label>
        <input type="text" name="the_loai" value="<?= htmlspecialchars($row['the_loai']) ?>" required>

        <label>File MP3 hiện tại:</label><br>
        <audio controls style="width:100%">
            <source src="../<?= $row['file_mp3'] ?>" type="audio/mpeg">
        </audio>

        <label>Đổi file MP3:</label>
        <input type="file" name="file_mp3" accept=".mp3">

        <label>Hình ảnh hiện tại:</label><br>
        <?php if ($row['hinh_anh']): ?>
            <img src="../<?= $row['hinh_anh'] ?>" width="120">
        <?php else: ?>3
            <p>Không có ảnh</p>
        <?php endif; ?>

        <label>Đổi hình ảnh:</label>
        <input type="file" name="hinh_anh" accept="image/*">

        <button type="submit">Cập nhật bài hát</button>
    </form>
</div>

</body>
</html>

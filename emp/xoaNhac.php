<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: firewall.php");
    exit();
}

$baihat_id = intval($_GET['id']);
// LẤY ĐƯỜNG DẪN FILE TRƯỚC KHI XÓA
$stmt = $conn->prepare("SELECT file_mp3, hinh_anh FROM bai_hat WHERE baihat_id = ?");
$stmt->bind_param("i", $baihat_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: songs_by_admin.php");
    exit();
}

$row = $result->fetch_assoc();
// XÓA FILE TRÊN SERVER (NẾU CÓ)
if (!empty($row['file_mp3']) && file_exists("../" . $row['file_mp3'])) {
    unlink("../" . $row['file_mp3']);
}

if (!empty($row['hinh_anh']) && file_exists("../" . $row['hinh_anh'])) {
    unlink("../" . $row['hinh_anh']);
}
// XÓA DỮ LIỆU TRONG DATABASE
$stmt = $conn->prepare("DELETE FROM bai_hat WHERE baihat_id = ?");
$stmt->bind_param("i", $baihat_id);

$stmt->execute();
header("Location: songView.php");
exit();

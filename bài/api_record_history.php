<?php
session_start();
require 'db_connect.php';

// Chỉ lưu khi đã đăng nhập và có ID bài hát
if (!isset($_SESSION['user_id']) || !isset($_POST['baihat_id'])) {
    exit(); 
}

$user_id = $_SESSION['user_id'];
$baihat_id = intval($_POST['baihat_id']);

// Thêm vào lịch sử
$stmt = $conn->prepare("INSERT INTO lich_su_nghe (user_id, baihat_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $baihat_id);
$stmt->execute();
?>
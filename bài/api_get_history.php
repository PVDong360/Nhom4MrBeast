<?php
session_start();
require 'db_connect.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy 50 bài nghe gần nhất (JOIN với bảng bai_hat để lấy tên, ảnh)
// Sắp xếp thời gian mới nhất lên đầu
$sql = "SELECT h.thoi_gian, b.* FROM lich_su_nghe h
        JOIN bai_hat b ON h.baihat_id = b.baihat_id
        WHERE h.user_id = ?
        ORDER BY h.thoi_gian DESC
        LIMIT 50";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$songs = [];
while ($row = $result->fetch_assoc()) {
    $songs[] = $row;
}

echo json_encode($songs);
?>
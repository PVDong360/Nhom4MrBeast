<?php
session_start();
require 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn chưa đăng nhập']);
    exit();
}

$user_id = $_SESSION['user_id'];
$songs = [];

// Lấy danh sách bài hát đã like
$sql = "SELECT b.* FROM bai_hat b 
        JOIN yeu_thich y ON b.baihat_id = y.baihat_id 
        WHERE y.user_id = ? 
        ORDER BY y.ngay_them DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}

$stmt->close();
$conn->close();

echo json_encode($songs);
?>
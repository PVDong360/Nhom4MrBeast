<?php
session_start();
require 'db_connect.php';

header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn chưa đăng nhập']);
    exit();
}

$user_id = $_SESSION['user_id'];
$playlists = [];

// Lấy danh sách playlist của user
// Giả sử bảng tên là 'playlist' và có cột 'user_id'
$sql = "SELECT * FROM playlist WHERE user_id = ? ORDER BY playlist_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $playlists[] = $row;
    }
}

$stmt->close();
$conn->close();

echo json_encode($playlists);
?>
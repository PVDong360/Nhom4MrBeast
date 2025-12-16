<?php
session_start();
require 'db_connect.php';

header('Content-Type: application/json');

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn chưa đăng nhập']);
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Lấy dữ liệu gửi lên (JSON)
$data = json_decode(file_get_contents("php://input"), true);
$playlist_name = isset($data['name']) ? trim($data['name']) : '';

if (empty($playlist_name)) {
    echo json_encode(['status' => 'error', 'message' => 'Tên playlist không được để trống']);
    exit();
}

// 3. Thêm vào CSDL
$stmt = $conn->prepare("INSERT INTO playlist (user_id, ten_playlist) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $playlist_name);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Tạo thành công']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
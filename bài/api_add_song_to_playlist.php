<?php
session_start();
require 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
    exit();
}

// Lấy dữ liệu JSON gửi lên
$data = json_decode(file_get_contents("php://input"), true);
$playlist_id = isset($data['playlist_id']) ? intval($data['playlist_id']) : 0;
$baihat_id = isset($data['baihat_id']) ? intval($data['baihat_id']) : 0;

if ($playlist_id == 0 || $baihat_id == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
    exit();
}

// 1. Kiểm tra xem bài hát đã có trong playlist chưa
$check = $conn->prepare("SELECT chitiet_id FROM chi_tiet_playlist WHERE playlist_id = ? AND baihat_id = ?");
$check->bind_param("ii", $playlist_id, $baihat_id);
$check->execute();
if ($check->get_result()->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Bài hát này đã có trong playlist rồi!']);
    exit();
}

// 2. Thêm vào bảng chi_tiet_playlist
$stmt = $conn->prepare("INSERT INTO chi_tiet_playlist (playlist_id, baihat_id) VALUES (?, ?)");
$stmt->bind_param("ii", $playlist_id, $baihat_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Thêm thành công']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
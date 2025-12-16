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
$baihat_id = isset($_REQUEST['baihat_id']) ? intval($_REQUEST['baihat_id']) : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($baihat_id == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu ID bài hát']);
    exit();
}

// 2. Xử lý hành động
if ($action == 'check') {
    // Chỉ kiểm tra xem đã like chưa
    $stmt = $conn->prepare("SELECT yeuthich_id FROM yeu_thich WHERE user_id = ? AND baihat_id = ?");
    $stmt->bind_param("ii", $user_id, $baihat_id);
    $stmt->execute();
    $stmt->store_result();
    
    echo json_encode(['status' => 'success', 'liked' => ($stmt->num_rows > 0)]);
    $stmt->close();

} elseif ($action == 'toggle') {
    // Like hoặc Unlike
    $stmt = $conn->prepare("SELECT yeuthich_id FROM yeu_thich WHERE user_id = ? AND baihat_id = ?");
    $stmt->bind_param("ii", $user_id, $baihat_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Đã like -> Xóa (Unlike)
        $del = $conn->prepare("DELETE FROM yeu_thich WHERE user_id = ? AND baihat_id = ?");
        $del->bind_param("ii", $user_id, $baihat_id);
        $del->execute();
        echo json_encode(['status' => 'success', 'liked' => false]);
    } else {
        // Chưa like -> Thêm (Like)
        $add = $conn->prepare("INSERT INTO yeu_thich (user_id, baihat_id) VALUES (?, ?)");
        $add->bind_param("ii", $user_id, $baihat_id);
        $add->execute();
        echo json_encode(['status' => 'success', 'liked' => true]);
    }
}

$conn->close();
?>
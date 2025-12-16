<?php
// Gọi đúng tên file kết nối của bạn
require_once 'db_connect.php'; 

header('Content-Type: application/json; charset=utf-8');

// 1. Kiểm tra kết nối
if (!isset($conn) || $conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi kết nối CSDL']);
    exit;
}

// 2. Kiểm tra tham số ID Playlist
if (!isset($_GET['playlist_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu ID Playlist']);
    exit;
}

$playlist_id = intval($_GET['playlist_id']);

// 3. Truy vấn dữ liệu
// Lưu ý: Đã dùng đúng tên bảng 'chi_tiet_playlist' khớp với CSDL của bạn
$sql = "SELECT b.* FROM bai_hat b
        JOIN chi_tiet_playlist ctp ON b.baihat_id = ctp.baihat_id
        WHERE ctp.playlist_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi câu lệnh SQL: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $playlist_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $songs = [];
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
    // Trả về kết quả JSON
    echo json_encode($songs);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi thực thi: ' . $stmt->error]);
}
?>
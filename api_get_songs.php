<?php
// Tệp: api_get_songs.php

require 'db_connect.php'; // Kết nối đến CSDL

$sql = "SELECT baihat_id, ten_bai_hat, ca_si, file_mp3, hinh_anh FROM bai_hat";
$result = $conn->query($sql);

$songs = [];

if ($result->num_rows > 0) {
    // Lấy dữ liệu từng hàng
    while($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}

// Đóng kết nối
$conn->close();

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($songs);
?>
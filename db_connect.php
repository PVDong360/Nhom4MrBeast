<?php
// Tệp: db_connect.php

$servername = "localhost"; // Thường là localhost
$username = "root";        // Tên đăng nhập CSDL mặc định của XAMPP
$password = "";            // Mật khẩu mặc định của XAMPP là rỗng
$dbname = "quanlynhac";    // Tên cơ sở dữ liệu bạn đã import

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập encoding utf8 để hiển thị tiếng Việt
$conn->set_charset("utf8mb4");
?>
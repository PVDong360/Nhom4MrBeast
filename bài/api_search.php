<?php
// Tệp: api_search.php

require 'db_connect.php'; // Kết nối CSDL

$songs = [];

// Chỉ tìm kiếm nếu có từ khóa
if (isset($_GET['query']) && !empty($_GET['query'])) {
    
    $query = $_GET['query'];
    
    // Thêm ký tự % để tìm kiếm LIKE (an toàn hơn)
    $search_term = "%" . $query . "%";

    // Dùng Prepared Statements để chống SQL Injection
    $stmt = $conn->prepare("SELECT * FROM bai_hat WHERE ten_bai_hat LIKE ? OR ca_si LIKE ? LIMIT 10");
    $stmt->bind_param("ss", $search_term, $search_term);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }
    }
    
    $stmt->close();
}

$conn->close();

// Trả về kết quả (dù là rỗng) dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($songs);
?>
<?php
require 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) exit;

$id = $_POST['id'] ?? null;
$ten = trim($_POST['ten_bai_hat'] ?? '');

if ($id && $ten !== '') {
    $sql = "UPDATE baihat 
            SET ten_bai_hat = ? 
            WHERE baihat_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $ten, $id, $_SESSION['user_id']);
    $stmt->execute();
}

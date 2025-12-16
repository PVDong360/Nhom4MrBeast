<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: firewall.php");
    exit();
}
if (!isset($_GET['id'])) {
    header("Location: EmpMan.php");
    exit();
}
$id = intval($_GET['id']);
// Xóa chỉ khi Role là 1 (nhân viên)
$stmt = $conn->prepare("DELETE FROM nguoi_dung WHERE user_id = ? AND Vai_tro = 1");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: EmpMan.php");
    exit();
} else {    
    echo "Lỗi khi xóa nhân viên.";
}
?>

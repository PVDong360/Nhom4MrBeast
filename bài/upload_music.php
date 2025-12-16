<?php
require 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = $_POST['ten_bai_hat'];
    $ca_si = $_POST['ca_si'] ?? null;
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['file_mp3']) && $_FILES['file_mp3']['error'] == 0) {
        $fileName = time() . "_" . basename($_FILES['file_mp3']['name']);
        $targetPath = "uploads/music/" . $fileName;

        if (move_uploaded_file($_FILES['file_mp3']['tmp_name'], $targetPath)) {
            $kich_thuoc = filesize($targetPath);

            $sql = "INSERT INTO bai_hat 
                    (ten_bai_hat, ca_si, file_mp3, user_id, kich_thuoc)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssii", $ten, $ca_si, $fileName, $user_id, $kich_thuoc);
            $stmt->execute();
        }
    }
}

header("Location: Liyourmusic.php");

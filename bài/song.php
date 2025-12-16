<?php
require 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$song = null;
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM bai_hat WHERE baihat_id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $song = $res->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $song ? htmlspecialchars($song['ten_bai_hat']) . ' — ' . htmlspecialchars($song['ca_si']) : 'Bài hát' ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <?php include 'templates/sidebar.php'; ?>

        <div class="main-view">
            <?php include 'templates/header.php'; ?>

            <main class="content" id="main-content">
                <section class="song-detail">
                    <?php if ($song): ?>
                        <!-- Hiển thị hình ảnh + tên bài / nghệ sĩ tương tự trang chủ -->
                        <div class="song-detail-card">
                            <div class="music-card" data-song-id="<?= $song['baihat_id'] ?>" style="width: 250px; margin: 0 auto;">
                                <img src="<?= htmlspecialchars($song['hinh_anh']) ?>" alt="">
                                <p class="card-title"><?= htmlspecialchars($song['ten_bai_hat']) ?></p>
                                <p class="card-artist"><?= htmlspecialchars($song['ca_si']) ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>Bài hát không tìm thấy.</p>
                    <?php endif; ?>
                </section>
            </main>
        </div>
    </div>

    <?php include 'templates/player.php'; ?>
    <script src="assets/script.js?v=<?php echo file_exists(__DIR__ . '/assets/script.js') ? filemtime(__DIR__ . '/assets/script.js') : time(); ?>" defer></script>
</body>
</html>
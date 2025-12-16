<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Music</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <?php include 'templates/sidebar.php';; ?>

        <div class="main-view">
            <?php include 'templates/header.php'; ?>
            <main class="content" id="main-content">
                <section class="library-nav">
                    <div class="tabs">
                    <a href="Lifavourite.php" class="nav-item"><span>Nhạc yêu thích</span></a>
                    <a href="Liplaylist.php" class="nav-item"><span>Danh sách phát</span></a>
                    <a href="Lihistory.php" class="nav-item active"><span>Lịch sử nghe</span></a>
                    <a href="Liyourmusic.php" class="nav-item"><span>Nhạc của bạn</span></a>
                    </div>
                </section>
        </main>
           <div id="history-container">
    <p style="color: gray;">Đang tải lịch sử...</p>
</div>
        </div>
    </div>

    <?php include 'templates/player.php'; ?>
    <script src="assets/script.js" defer></script>
</body>
</html>
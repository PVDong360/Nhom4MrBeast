<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư viện - Nhạc yêu thích</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style> 
        .library-nav .tabs {
            display: flex;
            align-items: center;
            gap: 36px;
            border-bottom: 1px solid #333; /* Thêm đường kẻ dưới cho đẹp */
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .library-nav .tabs .nav-item {
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 18px;
            color: #ddd;
            text-decoration: none;
            transition: 0.2s;
        }

        .library-nav .tabs .nav-item:hover {
            background: #303030;
            color: #fff;
        }

        .library-nav .tabs .nav-item.active {
            background: #404040;
            color: #fff;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <?php include 'templates/sidebar.php'; ?>

        <div class="main-view">
            <?php include 'templates/header.php'; ?>
            
            <main class="content" id="main-content">
    <section class="library-nav">
        <div class="tabs">
            <a href="Lifavourite.php" class="nav-item active"><span>Nhạc yêu thích</span></a>
            <a href="Liplaylist.php" class="nav-item"><span>Danh sách phát</span></a>
            <a href="Lihistory.php" class="nav-item"><span>Lịch sử nghe</span></a>
            <a href="Liyourmusic.php" class="nav-item"><span>Nhạc của bạn</span></a>
        </div>
    </section>

    <div id="liked-songs-container" style="margin-top: 20px;">
        <p style="color: gray;">Đang tải danh sách...</p>
    </div>
</main>
        </div>
    </div>

    <?php include 'templates/player.php'; ?>
    
    <script src="assets/script.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                if (typeof fetchLikedSongs === 'function') {
                    fetchLikedSongs();
                } else {
                    console.log("Đang chờ script.js...");
                }
            }, 100);
        });
    </script>
</body>
</html>
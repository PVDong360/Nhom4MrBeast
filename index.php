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

            <main class="content">
                <?php
                    $pop_songs = $conn->query("SELECT * FROM bai_hat WHERE the_loai = 'Pop' ORDER BY RAND() LIMIT 5");
                ?>
                <section class="music-shelf">
                    <div class="shelf-header">
                        <h2>Pop</h2>
                        <a href="#" class="see-all">Hiển thị tất cả</a>
                    </div>
                    <div class="shelf-grid">
                        <?php while($song = $pop_songs->fetch_assoc()): ?>
                            <div class="music-card" data-song-id="<?= $song['baihat_id'] ?>">
                                <img src="<?= htmlspecialchars($song['hinh_anh']) ?>" alt="">
                                <p class="card-title"><?= htmlspecialchars($song['ten_bai_hat']) ?></p>
                                <p class="card-artist"><?= htmlspecialchars($song['ca_si']) ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>

                <?php
                    $artists = $conn->query("SELECT DISTINCT ca_si FROM bai_hat ORDER BY RAND() LIMIT 5");
                 ?>
                <section class="music-shelf">
                    <div class="shelf-header">
                        <h2>Nghệ sĩ nổi bật</h2>
                    </div>
                    <div class="shelf-grid">
                         <?php while($artist = $artists->fetch_assoc()): ?>
                            <div class="artist-card">
                                <?php
                                    $first_song_img_query = $conn->query("SELECT hinh_anh FROM bai_hat WHERE ca_si = '" . $conn->real_escape_string($artist['ca_si']) . "' LIMIT 1");
                                    $img_row = $first_song_img_query->fetch_assoc();
                                    $artist_img = $img_row ? $img_row['hinh_anh'] : '/images/placeholder.png';
                                ?>
                                <img src="<?= htmlspecialchars($artist_img) ?>" alt="">
                                <p class="artist-name"><?= htmlspecialchars($artist['ca_si']) ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>

                <?php
                    $foryou_songs = $conn->query("SELECT * FROM bai_hat ORDER BY RAND() LIMIT 5");
                ?>
                <section class="music-shelf">
                    <div class="shelf-header">
                        <h2>Đĩa nhạc cho bạn</h2>
                        <a href="#" class="see-all">Hiển thị tất cả</a>
                    </div>
                    <div class="shelf-grid">
                        <?php while($song = $foryou_songs->fetch_assoc()): ?>
                            <div class="music-card" data-song-id="<?= $song['baihat_id'] ?>">
                                <img src="<?= htmlspecialchars($song['hinh_anh']) ?>" alt="">
                                <p class="card-title"><?= htmlspecialchars($song['ten_bai_hat']) ?></p>
                                <p class="card-artist"><?= htmlspecialchars($song['ca_si']) ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <?php include 'templates/player.php'; ?>
    <script src="assets/script.js" defer></script>
</body>
</html>
<?php
require 'db_connect.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

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

    <?php include 'templates/sidebar.php'; ?>

    <div class="main-view">
        <?php include 'templates/header.php'; ?>

        <!-- THÊM CLASS RIÊNG CHO TRANG -->
        <main class="content your-music-page" id="main-content">

            <!-- Tabs thư viện -->
            <section class="library-nav">
                <div class="tabs">
                    <a href="Lifavourite.php" class="nav-item"><span>Nhạc yêu thích</span></a>
                    <a href="Liplaylist.php" class="nav-item"><span>Danh sách phát</span></a>
                    <a href="Lihistory.php" class="nav-item"><span>Lịch sử nghe</span></a>
                    <a href="Liyourmusic.php" class="nav-item active"><span>Nhạc của bạn</span></a>
                </div>
            </section>

            <!-- UPLOAD NHẠC -->
            <section class="upload-music">
                <form action="upload_music.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="ten_bai_hat" placeholder="Tên bài hát" required>
                    <input type="text" name="ca_si" placeholder="Ca sĩ (tuỳ chọn)">
                    <input type="file" name="file_mp3" accept=".mp3" required>

                    <button type="submit" class="btn-upload">
                        <i class="fa fa-upload"></i> Chọn file
                    </button>
                </form>
            </section>

            <!-- DANH SÁCH NHẠC ĐÃ TẢI -->
            <section class="your-music-list">
                <?php
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM bai_hat WHERE user_id = ? ORDER BY baihat_id DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0):
                ?>
                    <p style="color:#aaa;">Bạn chưa tải bài hát nào.</p>
                <?php
                endif;

                while ($row = $result->fetch_assoc()):
                ?>
                    <div class="music-item" data-song-id="<?= $row['baihat_id'] ?>">
                        <span class="music-name">
                            <?= htmlspecialchars($row['ten_bai_hat']) ?>
                        </span>

                        <div class="music-actions">
                            <!-- NÚT NGHE -->
                            <button class="play-btn-item" title="Nghe nhạc">
                                <i class="fa fa-play"></i>
                            </button>

                            <!-- NÚT SỬA -->
                            <button class="edit-btn" title="Đổi tên">
                                <i class="fa fa-pen"></i>
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </section>

        </main>
    </div>
</div>

<?php include 'templates/player.php'; ?>
<script src="assets/script.js" defer></script>

</body>
<script>
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.closest('.music-item');
        const nameSpan = item.querySelector('.music-name');

        if (item.classList.contains('editing')) return;

        const oldName = nameSpan.innerText;
        item.classList.add('editing');

        const input = document.createElement('input');
        input.type = 'text';
        input.value = oldName;
        input.className = 'rename-input';

        nameSpan.replaceWith(input);
        input.focus();
        input.select();

        const cancelEdit = () => {
            input.replaceWith(nameSpan);
            item.classList.remove('editing');
        };

        const saveEdit = () => {
            const newName = input.value.trim();
            if (newName === '' || newName === oldName) {
                cancelEdit();
                return;
            }

            fetch('rename_music.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${item.dataset.id}&ten_bai_hat=${encodeURIComponent(newName)}`
            });

            nameSpan.innerText = newName;
            input.replaceWith(nameSpan);
            item.classList.remove('editing');
        };

        input.addEventListener('blur', saveEdit);

        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') saveEdit();
            if (e.key === 'Escape') cancelEdit();
        });
    });
});
</script>

<script>
document.querySelectorAll('.play-btn-item').forEach(btn => {
    btn.addEventListener('click', e => {
        e.stopPropagation();

        const item = btn.closest('.music-item');
        const songId = item.dataset.songId;

        const index = playlist.findIndex(
            song => song.baihat_id == songId
        );

        if (index !== -1) {
            songIndex = index;
            loadSong(playlist[songIndex]);
            playSong();

            // hiện player
            document.querySelector('.player-bar')
                .classList.add('show');
        } else {
            console.warn("Không tìm thấy bài trong playlist");
        }
    });
});
</script>



</html>

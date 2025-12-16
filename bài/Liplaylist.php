<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư viện - Danh sách phát</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style> 
        .library-nav .tabs { display: flex; align-items: center; gap: 36px; border-bottom: 1px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .library-nav .tabs .nav-item { padding: 8px 14px; border-radius: 10px; font-size: 18px; color: #ddd; text-decoration: none; transition: 0.2s; }
        .library-nav .tabs .nav-item:hover { background: #303030; color: #fff; }
        .library-nav .tabs .nav-item.active { background: #404040; color: #fff; font-weight: 500; }

        /* CSS Modal Chung */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center; }
        .modal-content { background-color: #282828; padding: 25px; border-radius: 12px; width: 400px; max-height: 80vh; overflow-y: auto; text-align: center; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.5); }
        .modal input { width: 100%; padding: 12px; margin: 20px 0; border-radius: 5px; border: 1px solid #444; background: #181818; color: white; box-sizing: border-box; }
        .modal-buttons { display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; }
        .btn-cancel { background: transparent; color: #ccc; border: none; cursor: pointer; padding: 8px 15px; }
        .btn-create { background: #1DB954; color: black; border: none; border-radius: 20px; padding: 8px 20px; font-weight: bold; cursor: pointer; }
        
        /* CSS cho danh sách bài hát trong Modal chọn bài */
        .song-select-item { display: flex; align-items: center; padding: 10px; border-bottom: 1px solid #333; cursor: pointer; transition: 0.2s; text-align: left; }
        .song-select-item:hover { background: #333; }
        .song-select-item img { width: 40px; height: 40px; border-radius: 4px; object-fit: cover; margin-right: 15px; }
        .song-select-info h4 { margin: 0; font-size: 14px; color: white; }
        .song-select-info p { margin: 0; font-size: 12px; color: #aaa; }
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
                        <a href="Lifavourite.php" class="nav-item"><span>Nhạc yêu thích</span></a>
                        <a href="Liplaylist.php" class="nav-item active"><span>Danh sách phát</span></a>
                        <a href="Lihistory.php" class="nav-item"><span>Lịch sử nghe</span></a>
                        <a href="Liyourmusic.php" class="nav-item"><span>Nhạc của bạn</span></a>
                    </div>
                </section>

                <div id="playlists-view">
                    <button id="open-create-modal" style="background: #1DB954; color: black; border: none; padding: 12px 24px; border-radius: 30px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <i class="fa-solid fa-plus"></i> Tạo danh sách phát mới
                    </button>
                    <div id="playlist-container">
                        <p style="color: gray;">Đang tải danh sách phát...</p>
                    </div>
                </div>

                <div id="playlist-detail-view" style="display: none;">
                    <button onclick="backToPlaylists()" style="background: transparent; border: none; color: #aaa; cursor: pointer; margin-bottom: 15px; font-size: 16px;">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại
                    </button>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h2 id="detail-playlist-name" style="color: white; font-size: 2rem;">Tên Playlist</h2>
                        <button id="add-song-btn" style="background: #333; color: white; border: 1px solid #aaa; padding: 8px 16px; border-radius: 20px; cursor: pointer;">
                            <i class="fa-solid fa-music"></i> Thêm bài hát
                        </button>
                    </div>

                    <div id="detail-songs-container">
                        </div>
                </div>

            </main>
        </div>
    </div>

    <div id="create-modal" class="modal">
        <div class="modal-content">
            <h3>Tạo Playlist Mới</h3>
            <input type="text" id="new-playlist-name" placeholder="Nhập tên playlist...">
            <div class="modal-buttons">
                <button class="btn-cancel" id="cancel-create">Hủy</button>
                <button class="btn-create" id="confirm-create">Tạo</button>
            </div>
        </div>
    </div>

    <div id="add-song-modal" class="modal">
        <div class="modal-content">
            <h3>Chọn bài hát để thêm</h3>
            <input type="text" id="search-song-input" placeholder="Tìm tên bài hát...">
            <div id="song-select-list" style="text-align: left; max-height: 300px; overflow-y: auto;">
                <p>Đang tải danh sách bài hát...</p>
            </div>
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="document.getElementById('add-song-modal').style.display='none'">Đóng</button>
            </div>
        </div>
    </div>

    <?php include 'templates/player.php'; ?>
    <script src="assets/script.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                if (typeof fetchPlaylists === 'function') fetchPlaylists();
                if (typeof setupCreatePlaylistUI === 'function') setupCreatePlaylistUI();
            }, 100);
        });
    </script>
</body>
</html>
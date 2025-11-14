<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tải Nhạc Lên</title>
    <link rel="stylesheet" href="assets/style.css"> 
    <style>
        /* CSS đơn giản cho form */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--color-background);
            color: var(--color-primary-text);
        }
        form {
            background: var(--color-surface);
            padding: 24px;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
        }
        form div {
            margin-bottom: 16px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        form input[type="text"],
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid var(--color-hover);
            background: var(--color-background);
            color: var(--color-primary-text);
        }
        form button {
            padding: 12px 20px;
            background: #1DB954; /* Màu xanh Spotify */
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
        }
    </style>
</head>
<body>

    <form action="handle_upload.php" method="POST" enctype="multipart/form-data">
        <h2>Tải Lên Bài Hát Mới</h2>
        
        <?php if (isset($_GET['message'])): ?>
            <p style="color: <?= (isset($_GET['success']) && $_GET['success'] == '1') ? '#1DB954' : '#FF0000'; ?>;">
                <?= htmlspecialchars($_GET['message']) ?>
            </p>
        <?php endif; ?>

        <div>
            <label for="ten_bai_hat">Tên bài hát:</label>
            <input type="text" id="ten_bai_hat" name="ten_bai_hat" required>
        </div>
        
        <div>
            <label for="ca_si">Tên ca sĩ:</label>
            <input type="text" id="ca_si" name="ca_si" required>
        </div>

        <div>
            <label for="file_mp3">Tệp nhạc (MP3):</label>
            <input type="file" id="file_mp3" name="file_mp3" accept=".mp3" required>
        </div>
        
        <div>
            <label for="hinh_anh">Ảnh bìa (JPG, PNG):</label>
            <input type="file" id="hinh_anh" name="hinh_anh" accept="image/*" required>
        </div>

        <button type="submit">Tải Lên</button>
    </form>

</body>
</html>
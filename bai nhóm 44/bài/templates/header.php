<?php
// Bắt đầu session ở đầu MỌI tệp
// (Bạn cũng nên thêm dòng này ở đầu index.php)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="main-header">
   
    <div class="search-container">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Tìm kiếm bài hát, nghệ sĩ..." id="search-input">
    </div>


    
    <div class="user-profile">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>Xin chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
            
           
            
            <a href="logout.php" style="margin-left: 10px; color: white;">Đăng xuất</a>
            
        <?php else: ?>
            <a href="login.php" style="padding: 10px 20px; background: #1DB954; border-radius: 20px; color: white; text-decoration: none;">Đăng Nhập</a>
        <?php endif; ?>
    </div>
</header>
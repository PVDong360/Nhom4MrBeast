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
     <?php
     // Hiển thị nút role dưới dạng button chữ nhật
     if (isset($_SESSION['role'])) {
         if ($_SESSION['role'] == 1) {
             echo '<a href="emp/nhanvien.php" class="role-btn">Nhân viên</a>';
         } elseif ($_SESSION['role'] == 2) {
             echo '<a href="ad/admin.php" class="role-btn">Admin</a>';
         }
     }
     ?>

    <style>
    /* Styles tạm tại chỗ; nếu có file CSS chung thì di chuyển vào đó */
    .role-btn{
        display:inline-block;
        padding:8px 14px;
        background:#1DB954;
        color:#fff;
        text-decoration:none;
        border-radius:6px;
        font-weight:600;
        margin-right:10px;
    }
    .user-profile .greeting { font-size:20px; vertical-align:middle; }
    </style>
 
         <?php if (isset($_SESSION['user_id'])): ?>
            <span class="greeting">Xin chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
            
           
            
            <a href="logout.php" style="margin-left: 10px; color: white;">Đăng xuất</a>
            
        <?php else: ?>
            <a href="login.php" style="padding: 10px 20px; background: #1DB954; border-radius: 20px; color: white; text-decoration: none;">Đăng Nhập</a>
        <?php endif; ?>
    </div>
</header>
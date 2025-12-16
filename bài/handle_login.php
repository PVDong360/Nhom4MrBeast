<?php
// LUÔN LUÔN bắt đầu session ở đầu tệp
session_start();

// Bắt đầu xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require 'db_connect.php'; // 1. KẾT NỐI CSDL

    // 2. LẤY DỮ LIỆU TỪ FORM (vẫn dùng 'username' và 'password' từ form)
    $username_from_form = $_POST['username'];
    $password_from_form = $_POST['password'];

    if (empty($username_from_form) || empty($password_from_form)) {
        $message = "Vui lòng nhập đầy đủ thông tin.";
        header("Location: login.php?success=0&message=" . urlencode($message));
        exit();
    }

    // 3. TÌM USER (Dùng cột 'ten_dang_nhap' của CSDL)
    // Lấy tất cả thông tin chúng ta cần
    $sql = "SELECT user_id, ten_dang_nhap, mat_khau, vai_tro, co_tinh_phi FROM nguoi_dung WHERE ten_dang_nhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username_from_form);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // 4. KIỂM TRA MẬT KHẨU (Dùng cột 'mat_khau' của CSDL)
        if (password_verify($password_from_form, $user['mat_khau'])) {
            // Mật khẩu ĐÚNG!

            // 5. LƯU VÀO "TRÍ NHỚ" (SESSION)
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['ten_dang_nhap']; // Lưu 'ten_dang_nhap'
            $_SESSION['role'] = $user['vai_tro'];         // Lưu vai trò (0 hoặc 1)
            $_SESSION['is_premium'] = $user['co_tinh_phi']; // Lưu trạng thái (0 hoặc 1)

            // Chuyển hướng về trang chủ
            header("Location: index.php");
            exit();

        } else {
            $message = "Sai tên đăng nhập hoặc mật khẩu.";
            header("Location: login.php?success=0&message=" . urlencode($message));
            exit();
        }
    } else {
        $message = "Sai tên đăng nhập hoặc mật khẩu.";
        header("Location: login.php?success=0&message=" . urlencode($message));
        exit();
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: index.php");
    exit();
}
?>
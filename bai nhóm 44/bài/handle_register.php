<?php
// Bắt đầu xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require 'db_connect.php'; // 1. KẾT NỐI CSDL

    // 2. LẤY DỮ LIỆU TỪ FORM (vẫn dùng 'username' và 'password' từ form)
    $username_from_form = $_POST['username'];
    $email_from_form = $_POST['email'];
    $password_from_form = $_POST['password'];

    // 3. KIỂM TRA DỮ LIỆU ĐẦU VÀO
    if (empty($username_from_form) || empty($email_from_form) || empty($password_from_form)) {
        $message = "Vui lòng nhập đầy đủ thông tin.";
        header("Location: register.php?success=0&message=" . urlencode($message));
        exit();
    }

    // 4. KIỂM TRA TỒN TẠI (Dùng cột 'ten_dang_nhap' của CSDL)
    $stmt = $conn->prepare("SELECT user_id FROM nguoi_dung WHERE ten_dang_nhap = ? OR email = ?");
    $stmt->bind_param("ss", $username_from_form, $email_from_form);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Tên đăng nhập hoặc Email đã tồn tại.";
        header("Location: register.php?success=0&message=" . urlencode($message));
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // 5. MÃ HÓA MẬT KHẨU
    $hashed_password = password_hash($password_from_form, PASSWORD_DEFAULT);

    // 6. THÊM VÀO CSDL (Dùng cột 'ten_dang_nhap' và 'mat_khau' của CSDL)
    // Cột 'vai_tro' và 'co_tinh_phi' sẽ tự nhận giá trị DEFAULT là 0
    $stmt = $conn->prepare("INSERT INTO nguoi_dung (ten_dang_nhap, email, mat_khau) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username_from_form, $email_from_form, $hashed_password);

    if ($stmt->execute()) {
        $message = "Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.";
        header("Location: login.php?success=1&message=" . urlencode($message));
        exit();
    } else {
        $message = "Đã xảy ra lỗi. Vui lòng thử lại.";
        header("Location: register.php?success=0&message=" . urlencode($message));
        exit();
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: index.php");
    exit();
}
?>
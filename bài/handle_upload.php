<?php
// Bắt đầu xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require 'db_connect.php'; // 1. KẾT NỐI CSDL

    // 2. THIẾT LẬP THƯ MỤC TẢI LÊN
    // Hãy tạo 2 thư mục này bằng tay trong project của bạn
    $target_dir_music = "uploads/music/"; 
    $target_dir_image = "uploads/images/";

    // Tạo đường dẫn đầy đủ cho file trên máy chủ
    $music_file_name = basename($_FILES["file_mp3"]["name"]);
    $image_file_name = basename($_FILES["hinh_anh"]["name"]);
    
    $music_target_file = $target_dir_music . $music_file_name;
    $image_target_file = $target_dir_image . $image_file_name;

    $uploadOk = 1; // Biến cờ

    // --- Bắt đầu kiểm tra file ---
    // (Đây là các kiểm tra cơ bản, có thể làm kỹ hơn)

    // Kiểm tra xem file đã tồn tại chưa
    if (file_exists($music_target_file) || file_exists($image_target_file)) {
        $message = "Lỗi: File nhạc hoặc ảnh đã tồn tại. Vui lòng đổi tên file.";
        $uploadOk = 0;
    }
    
    // --- Kết thúc kiểm tra file ---

    // Nếu $uploadOk = 0, có lỗi
    if ($uploadOk == 0) {
        // Chuyển hướng về trang upload với thông báo lỗi
        header("Location: upload.php?success=0&message=" . urlencode($message));
        exit();

    // Nếu mọi thứ ổn, bắt đầu tải file
    } else {
        // 3. DI CHUYỂN FILE TẠM SANG THƯ MỤC CHÍNH
        $move_music_ok = move_uploaded_file($_FILES["file_mp3"]["tmp_name"], $music_target_file);
        $move_image_ok = move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $image_target_file);

        if ($move_music_ok && $move_image_ok) {
            
            // 4. LẤY DỮ LIỆU TỪ FORM
            $ten_bai_hat = $_POST['ten_bai_hat'];
            $ca_si = $_POST['ca_si'];
            
            // Lấy đường dẫn LƯU VÀO CSDL (quan trọng: đây là đường dẫn web, không phải đường dẫn máy chủ)
            $music_db_path = $music_target_file; // VD: "uploads/music/tenbaihat.mp3"
            $image_db_path = $image_target_file; // VD: "uploads/images/tenanh.jpg"

            // 5. THÊM VÀO CSDL (Sử dụng Prepared Statements để chống SQL Injection)
            $stmt = $conn->prepare("INSERT INTO bai_hat (ten_bai_hat, ca_si, file_mp3, hinh_anh) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $ten_bai_hat, $ca_si, $music_db_path, $image_db_path);

            if ($stmt->execute()) {
                // Thành công!
                $message = "Tải lên và lưu bài hát thành công!";
                header("Location: upload.php?success=1&message=" . urlencode($message));
                exit();
            } else {
                $message = "Lỗi khi lưu vào CSDL: " . $stmt->error;
            }

            $stmt->close();

        } else {
            $message = "Lỗi: Đã xảy ra sự cố khi di chuyển file.";
        }
        
        $conn->close();

        // Nếu có lỗi ở bước lưu CSDL hoặc di chuyển file, báo lỗi
        header("Location: upload.php?success=0&message=" . urlencode($message));
        exit();
    }
} else {
    // Nếu ai đó gõ handle_upload.php trực tiếp, đá về trang chủ
    header("Location: index.php");
    exit();
}
?>
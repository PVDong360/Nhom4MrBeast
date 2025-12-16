-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2025 at 03:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlynhac`
--

-- --------------------------------------------------------

--
-- Table structure for table `bai_hat`
--

CREATE TABLE `bai_hat` (
  `baihat_id` int(11) NOT NULL,
  `ten_bai_hat` varchar(100) NOT NULL,
  `ca_si` varchar(100) DEFAULT NULL,
  `the_loai` varchar(50) DEFAULT NULL,
  `file_mp3` varchar(255) NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kich_thuoc` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bai_hat`
--

INSERT INTO `bai_hat` (`baihat_id`, `ten_bai_hat`, `ca_si`, `the_loai`, `file_mp3`, `hinh_anh`, `user_id`, `kich_thuoc`) VALUES
(1, 'NGÁO NGƠ', 'Anh trai say hi', 'Pop', 'uploads/music/NGÁO NGƠ - HIEUTHUHAI, Atus, Jsol, Erik ft. Orange - Anh Trai Say Hi.mp3', 'uploads/images/NGÁO NGƠ.jpg', 1, 0),
(2, 'AAA', 'Em xinh say hi', 'Pop', 'uploads/music/AAA - Liên Quân 2 - Em Xinh Say Hi [Performance].mp3', 'uploads/images/AAA.jpg', 1, 0),
(3, 'Anh Đã Quen Với Cô Đơn', 'Soobin Hoàng Sơn', 'Pop', 'uploads/music/Anh Đã Quen Với Cô Đơn - Soobin Hoàng Sơn - Official Music Video 4K.mp3', 'uploads/images/Anh Đã Quen Với Cô Đơn.jpg', 1, 0),
(4, 'ANH LÀ NGOẠI LÊ CỦA EM', 'PHƯƠNG LY', 'Pop', 'uploads/music/ANH LA NGOẠI LÊ CỦA EM - PHƯƠNG LY - OFFICIAL MV.mp3', 'uploads/images/ANH LA NGOAI LÊ CUA EM.jpg', 1, 0),
(5, 'BẠC PHẬN', 'ICM x JACK \r\n', 'Ballad', 'uploads/music/BẠC PHẬN - ICM x JACK - OFFICIAL MV.mp3', 'uploads/images/Bạc Phận.jpg', 1, 0),
(6, 'BAD LIAR', 'Em xinh say hi', 'Pop', 'uploads/music/BAD LIAR - Lâm Bảo Ngọc, Pháo, Phương Mỹ Chi, Saabirose, Liu Grace - Em Xinh Say Hi [Performance].mp3', 'uploads/images/BAD LIAR.jpg', 1, 0),
(7, 'Bánh Mì Không', 'ĐạtG', 'Ballad', 'uploads/music/Bánh Mì Không - ĐạtG x DuUyên -- OFFICIAL MV.mp3', 'uploads/images/Bánh Mì Không.jpg', 1, 0),
(8, 'Bùa Yêu', 'BÍCH PHƯƠNG', 'Pop', 'uploads/music/BÍCH PHƯƠNG - Bùa Yêu (Official M-V).mp3', 'uploads/images/Bùa Yêu.jpg', 1, 0),
(9, 'Đi Đu Đưa Đi', 'BÍCH PHƯƠNG', 'Pop', 'uploads/music/BÍCH PHƯƠNG - Đi Đu Đưa Đi (Official M-V).mp3', 'uploads/images/Đi Đu Đưa Đi.jpg', 1, 0),
(10, 'Nâng Chén Tiêu Sầu', 'BÍCH PHƯƠNG', 'Ballab', 'uploads/music/BÍCH PHƯƠNG - Nâng Chén Tiêu Sầu (Official M-V).mp3', 'uploads/images/Nâng Chén Tiêu Sầu.jpg', 1, 0),
(12, 'CẦM KỲ THI HOẠ', 'Em xinh say hi', 'Ballad', 'uploads/music/CẦM KỲ THI HOẠ -Bích Phương, Tiên Tiên, Lamoon, Phương Mỹ Chi, Bảo Anh -Em Xinh Say Hi [Performance].mp3', 'uploads/images/CẦM KỲ THI HOẠ.jpg', 1, 0),
(13, 'Chúng Ta Không Thuộc Về Nhau', 'Sơn Tùng M-TP', 'Pop', 'uploads/music/Chúng Ta Không Thuộc Về Nhau - Official Music Video - Sơn Tùng M-TP.mp3', 'uploads/images/Chúng Ta Không Thuộc Về Nhau.jpg', 1, 0),
(14, 'EM GÌ ƠI', 'ICM x JACK', 'Pop', 'uploads/music/EM GÌ ƠI - ICM x JACK - OFFICIAL MUSIC VIDEO.mp3', 'uploads/images/Em Gì Ơi.jpg', 1, 0),
(15, 'GÃ SĂN CÁ', 'Em xinh say hi', 'Pop', 'uploads/music/GÃ SĂN CÁ - MAIQUINN, Saabirose, Lâm Bảo Ngọc, Quỳnh Anh Shyn, Quang Hùng MasterD-EXSH [Performance].mp3', 'uploads/images/GÃ SĂN CÁ.jpg', 1, 0),
(16, 'HỀ', 'Em xinh say hi', 'Pop', 'uploads/music/HỀ - Phương Mỹ Chi, Phương Ly, Pháo, Chi Xê, WEAN - Em Xinh Say Hi [Performance].mp3', 'uploads/images/HỀ.jpg', 1, 0),
(17, 'Bo Xì Bo', 'Hoàng Thuỳ Linh', 'Ballad', 'uploads/music/Hoàng Thuỳ Linh - Bo Xì Bo (Vietnamese Concert Edition).mp3', 'uploads/images/Bo Xì Bo.jpg', 1, 0),
(18, 'Gieo Quẻ', 'Hoàng Thuỳ Linh', 'Pop', 'uploads/music/Hoàng Thuỳ Linh - Gieo Quẻ (Vietnamese Concert Edition).mp3', 'uploads/images/Gieo Quẻ.jpg', 1, 0),
(19, 'Hạ Phỏm', 'Hoàng Thuỳ Linh', 'Pop', 'uploads/music/Hoàng Thuỳ Linh - Hạ Phỏm (Vietnamese Concert Edition).mp3', 'uploads/images/Hạ Phỏm.jpg', 1, 0),
(20, 'Kẻ Cắp Gặp Bà Già', 'Hoàng Thuỳ Linh', 'Pop', 'uploads/music/Hoàng Thuỳ Linh - Kẻ Cắp Gặp Bà Già (Vietnamese Concert Edition).mp3', 'uploads/images/Kẻ Cắp Gặp Bà Già.jpg', 1, 0),
(21, 'See Tình ', 'Hoàng Thuỳ Linh', 'Ballad', 'uploads/music/Hoàng Thuỳ Linh - See Tình (Vietnamese Concert Edition).mp3', 'uploads/images/See Tình.jpg', 1, 0),
(22, 'Đom Đóm', 'Jack', 'R&B', 'uploads/music/Jack - Đom Đóm - Official Music Video.mp3', 'uploads/images/Đom đóm.jpg', 1, 0),
(23, 'HỒNG NHAN', 'ICM X JACK', 'Ballab', 'uploads/music/JACK - HỒNG NHAN [OFFICIAL MV] - G5R.mp3', 'uploads/images/Hồng Nhan.jpg', 1, 0),
(24, 'DƯỚI TÁN CÂY KHÔ HOA NỞ', 'JACK', 'Ballad', 'uploads/music/JACK - J97 - DƯỚI TÁN CÂY KHÔ HOA NỞ ( prod. Hino ) - OFFICIAL VISUALIZER - Track No.1.mp3', 'uploads/images/Dưới Tán Cây Khô Hoa Nở.jpg', 1, 0),
(25, 'THIÊN LÝ ƠI', 'JACK', 'Ballad', 'uploads/music/JACK - J97 - THIÊN LÝ ƠI - Official Music Video.mp3', 'uploads/images/Thiên Lý Ơi.jpg', 1, 0),
(26, 'Ghen', 'MIN', 'Ballad', 'uploads/music/KHẮC HƯNG x MIN x ERIK - Ghen - OFFICIAL MUSIC VIDEO.mp3', 'uploads/images/Ghen.jpg', 1, 0),
(27, 'KHÔNG ĐAU NỮA RỒI', 'Em xinh say hi', 'Pop', 'uploads/music/\'KHÔNG ĐAU NỮA RỒI\' - Pháp Kiều,52Hz, Orange, Mỹ Mỹ, Châu Bùi - Em Xinh Say Hi.mp3', 'uploads/images/KHÔNG ĐAU NỮA RỒI.jpg', 1, 0),
(28, 'KIM PHÚT KIM GIỜ', 'Anh trai say hi', 'Pop', 'uploads/music/KIM PHÚT KIM GIỜ - NEGAV, HURRYKNG, HIEUTHUHAI, Pháp Kiều, Isaac,Tiểu Vy - ATSH - YouTube.mp3', 'uploads/images/KIM PHÚT KIM GIỜ.jpg', 1, 0),
(29, 'LẠC TRÔI ', 'SƠN TÙNG M-TP', 'Pop', 'uploads/music/LẠC TRÔI - OFFICIAL MUSIC VIDEO - SƠN TÙNG M-TP.mp3', 'uploads/images/LẠC TRÔI.jpg', 1, 0),
(30, 'TRÊN TÌNH BẠN DƯỚI TÌNH YÊU', 'MIN', 'Ballad', 'uploads/music/MIN - TRÊN TÌNH BẠN DƯỚI TÌNH YÊU - OFFICIAL MUSIC VIDEO.mp3', 'uploads/images/TRÊN TÌNH BẠN DƯỚI TÌNH YÊU.jpg', 1, 0),
(31, 'Chăm Hoa', 'MONO', 'Ballad', 'uploads/music/MONO - \'Chăm Hoa\' (Official Music Video).mp3', 'uploads/images/Chăm Hoa.jpg', 4, 0),
(32, 'Đi Tìm Tình Yêu', 'MONO', '', 'uploads/music/MONO - \'Đi Tìm Tình Yêu\' (Official Music Video).mp3', 'uploads/images/Đi Tìm Tình Yêu.jpg', 1, 0),
(33, 'Em Xinh', 'MONO', '', 'uploads/music/MONO - Em Xinh (Official Music Video).mp3', 'uploads/images/Em Xinh.jpg', 1, 0),
(34, 'Waiting For You', 'MONO', '', 'uploads/music/MONO - Waiting For You (Official Music Video).mp3', 'uploads/images/Waiting For You.jpg', 1, 0),
(35, 'NGÁO NGƠ', 'Anh trai say hi', '', 'uploads/music/NGÁO NGƠ - HIEUTHUHAI, Atus, Jsol, Erik ft. Orange - Anh Trai Say Hi.mp3', 'uploads/images/NGÁO NGƠ.jpg', 1, 0),
(36, 'NƠI NÀY CÓ ANH', 'SƠN TÙNG M-TP', '', 'uploads/music/NƠI NÀY CÓ ANH - OFFICIAL MUSIC VIDEO - SƠN TÙNG M-TP.mp3', 'uploads/images/NƠI NÀY CÓ ANH.jpg', 1, 0),
(37, 'NOT MY FAULT', 'Em xinh say hi', '', 'uploads/music/NOT MY FAULT - Mỹ Mỹ, Liu Grace, MAIQUINN, LyHan - Em Xinh Say Hi [Performance].mp3', 'uploads/images/NOT MY FAULT.jpg', 1, 0),
(38, 'Phía Sau Một Cô Gái', 'SOOBIN', '', 'uploads/music/Phía Sau Một Cô Gái - Soobin Hoàng Sơn (Official Music Video 4K).mp3', 'uploads/images/Phía Sau Một Cô Gái.jpg', 1, 0),
(39, 'BÓNG PHÙ HOA', 'PHƯƠNG MỸ CHI', 'Bolero', 'uploads/music/PHƯƠNG MỸ CHI x DTAP - BÓNG PHÙ HOA - OFFICIAL VISUALIZER.mp3', 'uploads/images/Bóng phù hoa.jpg', 1, 0),
(40, 'CHIẾC LƯỢC NGÀ ', 'PHƯƠNG MỸ CHI', 'Bolero', 'uploads/music/PHƯƠNG MỸ CHI x DTAP - CHIẾC LƯỢC NGÀ ft. NSƯT KIM TỬ LONG - OFFICIAL VISUALIZER.mp3', 'uploads/images/Chiếc lược ngà.jpg', 1, 0),
(41, 'VŨ TRỤ CÓ ANH', 'PHƯƠNG MỸ CHI', 'Bolero', 'uploads/music/PHƯƠNG MỸ CHI x DTAP - VŨ TRỤ CÓ ANH ft. Pháo - Official Music Video.mp3', 'uploads/images/Vũ trụ cò bay.jpg', 1, 0),
(42, 'HÀO QUANG', 'Anh trai say hi', 'Pop', 'uploads/music/RHYDER, Dương Domic, Pháp Kiều - HÀO QUANG I OFFICIAL LYRICS VIDEO.mp3', 'uploads/images/HÀO QUANG.jpg', 1, 0),
(43, 'SO ĐẬM', 'Em xinh say hi', 'Pop', 'uploads/music/SO ĐẬM - Phương Ly, Vũ Thảo My, Muộii, Châu Bùi - Em Xinh Say Hi [Performance].mp3', 'uploads/images/SO ĐẬM.jpg', 1, 0),
(44, 'ĐỪNG LÀM TRÁI TIM ANH ĐAU', 'SƠN TÙNG M-TP', 'Pop', 'uploads/music/SƠN TÙNG M-TP - ĐỪNG LÀM TRÁI TIM ANH ĐAU - OFFICIAL MUSIC VIDEO.mp3', 'uploads/images/ĐỪNG LÀM TRÁI TIM ANH ĐAU.jpg', 1, 0),
(45, 'HÃY TRAO CHO ANH', 'Sơn Tùng M-TP', 'Pop', 'uploads/music/SƠN TÙNG M-TP - HÃY TRAO CHO ANH ft. Snoop Dogg - Official MV.mp3', 'uploads/images/HÃY TRAO CHO ANH.jpg', 1, 0),
(46, 'MUỘN RỒI MÀ SAO CÒN', 'Sơn Tùng M-TP', 'Pop', 'uploads/music/SƠN TÙNG M-TP - MUỘN RỒI MÀ SAO CÒN - OFFICIAL MUSIC VIDEO.mp3', 'uploads/images/MUỘN RỒI MÀ SAO CÒN.jpg', 1, 0),
(47, 'SÓNG GIÓ ', 'ICM x JACK', 'Pop', 'uploads/music/SÓNG GIÓ - ICM x JACK - OFFICIAL MUSIC VIDEO.mp3', 'uploads/images/Sóng Gió.jpg', 1, 0),
(48, 'giá như ', 'SOOBIN', 'Trữ tình', 'uploads/music/SOOBIN - giá như - \'BẬT NÓ LÊN\' Album (Official MV).mp3', 'uploads/images/giá như.jpg', 1, 0),
(49, 'THẰNG ĐIÊN', 'JUSTATEE x PHƯƠNG LY', 'Pop', 'uploads/music/THẰNG ĐIÊN - JUSTATEE x PHƯƠNG LY - OFFICIAL MV.mp3', 'uploads/images/THẰNG ĐIÊN.jpg', 3, 0),
(50, 'Thêm Bao Nhiêu Lâu ', 'Đạt G', '', 'uploads/music/Thêm Bao Nhiêu Lâu - Đạt G -- OFFICIAL MV.mp3', 'uploads/images/Thêm Bao Nhiêu Lâu.jpg', 3, 0),
(51, 'TÌNH ĐẦU QUÁ CHÉN', 'NEGAV x Quang Hùng MasterD x Erik x Pháp Kiều', 'Ballad', 'uploads/music/TÌNH ĐẦU QUÁ CHÉN - NEGAV x Quang Hùng MasterD x Erik x Pháp Kiều -say xỉn- mém quên SBD - ATSH - YouTube.mp3', 'uploads/images/TÌNH ĐẦU QUÁ CHÉN.jpg', 2, 0),
(52, 'WALK', 'NEGAV x HURRYKNG x HIEUTHUHAI x Pháp Kiều  x Isaac', 'Ballad', 'uploads/music/WALK - NEGAV x HURRYKNG x HIEUTHUHAI x Pháp Kiều  x Isaac - ANH TRAI SAY HI.mp3', 'uploads/images/WALK.jpg', 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bai_hat`
--
ALTER TABLE `bai_hat`
  ADD PRIMARY KEY (`baihat_id`),
  ADD KEY `fk_baihat_nguoidung` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bai_hat`
--
ALTER TABLE `bai_hat`
  MODIFY `baihat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bai_hat`
--
ALTER TABLE `bai_hat`
  ADD CONSTRAINT `fk_baihat_nguoidung` FOREIGN KEY (`user_id`) REFERENCES `nguoi_dung` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

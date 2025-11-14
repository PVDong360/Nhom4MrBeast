-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 03:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bai_hat`
--

INSERT INTO `bai_hat` (`baihat_id`, `ten_bai_hat`, `ca_si`, `the_loai`, `file_mp3`, `hinh_anh`, `user_id`) VALUES
(1, 'Nơi Này Có Anh', 'Sơn Tùng M-TP', 'Pop', 'uploads/music/NƠI NÀY CÓ ANH.mp3', 'uploads/images/ntca.jpg', 1),
(2, 'See Tình', 'Hoàng Thùy Linh', 'Pop', 'uploads/music/see_tinh.mp3', 'uploads/images/st.jpg', 1),
(3, 'Lạ Lùng', 'Vũ.', 'Indie', 'uploads/music/la_lung.mp3', 'uploads/images/ll.jpg', 1),
(4, 'Đi Về Nhà', 'Đen Vâu, JustaTee', 'Rap', 'uploads/music/di_ve_nha.mp3', 'uploads/images/dvn.jpg', 1),
(5, 'Tháng Tư Là Lời Nói Dối Của Em', 'Hà Anh Tuấn', 'Ballad', 'uploads/music/thang_tu.mp3', 'uploads/images/tt.jpg', 1),
(6, 'Đừng Hỏi Em', 'Mỹ Tâm', 'Ballad', 'uploads/music/dung_hoi_em.mp3', 'uploads/images/dhe.jpg', 1),
(7, 'Blinding Lights', 'The Weeknd', 'Synth-pop', 'uploads/music/blinding_lights.mp3', 'uploads/images/bl.jpg', 1),
(8, 'Shape of You', 'Ed Sheeran', 'Pop', 'uploads/music/shape_of_you.mp3', 'uploads/images/soy.jpg', 1),
(9, 'Believer', 'Imagine Dragons', 'Rock', 'uploads/music/believer.mp3', 'uploads/images/believer.jpg', 1),
(10, 'Someone Like You', 'Adele', 'Ballad', 'uploads/music/someone_like_you.mp3', 'uploads/images/sly.jpg', 1),
(11, 'Thanh Xuân', 'Da LAB', 'Pop', 'uploads/music/thanh_xuan.mp3', 'uploads/images/tx.jpg', 1),
(12, 'Bohemian Rhapsody', 'Queen', 'Rock', 'uploads/music/bohemian_rhapsody.mp3', 'uploads/images/br.jpg', 1),
(13, 'Em Gái Mưa', 'Hương Tràm', 'Pop', 'uploads/music/em_gai_mua.mp3', 'uploads/images/egm.jpg', 2),
(14, 'Hãy Trao Cho Anh', 'Sơn Tùng M-TP', 'Latin Pop', 'uploads/music/hay_trao_cho_anh.mp3', 'uploads/images/htca.jpg', 1),
(15, 'Bước Qua Nhau', 'Vũ.', 'Indie', 'uploads/music/buoc_qua_nhau.mp3', 'uploads/images/bqn.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_playlist`
--

CREATE TABLE `chi_tiet_playlist` (
  `chitiet_id` int(11) NOT NULL,
  `playlist_id` int(11) DEFAULT NULL,
  `baihat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chi_tiet_playlist`
--

INSERT INTO `chi_tiet_playlist` (`chitiet_id`, `playlist_id`, `baihat_id`) VALUES
(1, 1, 3),
(2, 1, 5),
(3, 1, 10),
(4, 1, 15),
(5, 2, 1),
(6, 2, 2),
(7, 2, 4),
(8, 2, 11),
(9, 2, 13),
(10, 2, 14),
(11, 3, 9),
(12, 3, 12),
(13, 4, 3),
(14, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `user_id` int(11) NOT NULL,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `co_tinh_phi` tinyint(1) DEFAULT 0,
  `vai_tro` int(11) NOT NULL COMMENT '0: User, 1: Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`user_id`, `ten_dang_nhap`, `mat_khau`, `email`, `ngay_tao`, `co_tinh_phi`, `vai_tro`) VALUES
(1, 'admin', 'password_placeholder', 'admin@musicapp.com', '2025-10-03 13:30:00', 1, 1),
(2, 'minhtran', 'password_placeholder', 'minh.tran@example.com', '2025-10-03 13:31:00', 1, 0),
(3, 'baole', 'password_placeholder', 'bao.le@example.com', '2025-10-03 13:32:00', 0, 0),
(4, 'hoaphung', 'password_placeholder', 'hoa.phung@example.com', '2025-10-03 13:33:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `playlist_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ten_playlist` varchar(100) NOT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`playlist_id`, `user_id`, `ten_playlist`, `ngay_tao`) VALUES
(1, 2, 'Nhạc Chill Buổi Tối', '2025-10-03 13:35:00'),
(2, 3, 'V-Pop Yêu Thích', '2025-10-03 13:36:00'),
(3, 4, 'Rock Bất Hủ', '2025-10-03 13:37:00'),
(4, 2, 'Tập Trung Học Bài', '2025-10-03 13:38:00');

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
-- Indexes for table `chi_tiet_playlist`
--
ALTER TABLE `chi_tiet_playlist`
  ADD PRIMARY KEY (`chitiet_id`),
  ADD KEY `playlist_id` (`playlist_id`),
  ADD KEY `baihat_id` (`baihat_id`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`playlist_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bai_hat`
--
ALTER TABLE `bai_hat`
  MODIFY `baihat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `chi_tiet_playlist`
--
ALTER TABLE `chi_tiet_playlist`
  MODIFY `chitiet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bai_hat`
--
ALTER TABLE `bai_hat`
  ADD CONSTRAINT `fk_baihat_nguoidung` FOREIGN KEY (`user_id`) REFERENCES `nguoi_dung` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `chi_tiet_playlist`
--
ALTER TABLE `chi_tiet_playlist`
  ADD CONSTRAINT `chi_tiet_playlist_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`playlist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chi_tiet_playlist_ibfk_2` FOREIGN KEY (`baihat_id`) REFERENCES `bai_hat` (`baihat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `nguoi_dung` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

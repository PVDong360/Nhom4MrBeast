-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2025 at 09:59 AM
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
(1, 'Nơi Này Có Anh', 'Sơn Tùng M-TP', 'Pop', '/music/videoplayback.mp3', '/images/ntca.jpg', 1),
(2, 'See Tình', 'Hoàng Thùy Linh', 'Pop', '/music/see_tinh.mp3', '/images/st.jpg', 1),
(3, 'Lạ Lùng', 'Vũ.', 'Indie', '/music/la_lung.mp3', '/images/ll.jpg', 1),
(4, 'Đi Về Nhà', 'Đen Vâu, JustaTee', 'Rap', '/music/di_ve_nha.mp3', '/images/dvn.jpg', 1),
(5, 'Tháng Tư Là Lời Nói Dối Của Em', 'Hà Anh Tuấn', 'Ballad', '/music/thang_tu.mp3', '/images/tt.jpg', 1),
(6, 'Đừng Hỏi Em', 'Mỹ Tâm', 'Ballad', '/music/dung_hoi_em.mp3', '/images/dhe.jpg', 1),
(7, 'Blinding Lights', 'The Weeknd', 'Synth-pop', '/music/blinding_lights.mp3', '/images/bl.jpg', 1),
(8, 'Shape of You', 'Ed Sheeran', 'Pop', '/music/shape_of_you.mp3', '/images/soy.jpg', 1),
(9, 'Believer', 'Imagine Dragons', 'Rock', '/music/believer.mp3', '/images/believer.jpg', 1),
(10, 'Someone Like You', 'Adele', 'Ballad', '/music/someone_like_you.mp3', '/images/sly.jpg', 1),
(11, 'Thanh Xuân', 'Da LAB', 'Pop', '/music/thanh_xuan.mp3', '/images/tx.jpg', 1),
(12, 'Bohemian Rhapsody', 'Queen', 'Rock', '/music/bohemian_rhapsody.mp3', '/images/br.jpg', 1),
(13, 'Đi Đu Đưa Đi', 'Bích Phương', 'Pop', '/music/di_du_dua_di.mp3', '/images/dddd.jpg', 1),
(14, 'Hãy Trao Cho Anh', 'Sơn Tùng M-TP', 'Latin Pop', '/music/hay_trao_cho_anh.mp3', '/images/htca.jpg', 1);

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
(3, 1, 6),
(4, 1, 10),
(5, 2, 2),
(6, 2, 7),
(7, 2, 9),
(8, 3, 1),
(9, 3, 2),
(10, 3, 4),
(11, 3, 11),
(12, 3, 13),
(13, 3, 14),
(14, 4, 3),
(15, 4, 5),
(16, 5, 9),
(17, 5, 12);

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
  `vai_tro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`user_id`, `ten_dang_nhap`, `mat_khau`, `email`, `ngay_tao`, `co_tinh_phi`, `vai_tro`) VALUES
(1, 'annguyen', 'password_hashed', 'an.nguyen@example.com', '2025-09-25 15:00:52', 1, 0),
(2, 'minhtran', 'password_hashed', 'minh.tran@example.com', '2025-09-25 15:00:52', 1, 0),
(3, 'baole', 'password_hashed', 'bao.le@example.com', '2025-09-25 15:00:52', 0, 0),
(4, 'hoaphung', 'password_hashed', 'hoa.phung@example.com', '2025-09-25 15:00:52', 0, 0),
(5, 'dungkhanh', 'password_hashed', 'dung.khanh@example.com', '2025-09-25 15:00:52', 1, 0);

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
(1, 1, 'Nhạc Chill Buổi Tối', '2025-09-25 15:12:23'),
(2, 1, 'Workout Hits', '2025-09-25 15:12:23'),
(3, 2, 'V-Pop Yêu Thích', '2025-09-25 15:12:23'),
(4, 3, 'Tập Trung Học Bài', '2025-09-25 15:12:23'),
(5, 4, 'Rock Bất Hủ', '2025-09-25 15:12:23');

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
  MODIFY `baihat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `chi_tiet_playlist`
--
ALTER TABLE `chi_tiet_playlist`
  MODIFY `chitiet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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

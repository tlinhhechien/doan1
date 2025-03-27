-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 02:15 PM
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
-- Database: `ban_ve_tau`
--

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` int(11) NOT NULL,
  `id_tau` int(11) NOT NULL,
  `so_sao` int(11) DEFAULT NULL CHECK (`so_sao` between 1 and 5),
  `binh_luan` text DEFAULT NULL,
  `ngay_danh_gia` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lich_su_giao_dich`
--

CREATE TABLE `lich_su_giao_dich` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` int(11) NOT NULL,
  `noi_dung` text NOT NULL,
  `thoi_gian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lich_trinh_bao_duong`
--

CREATE TABLE `lich_trinh_bao_duong` (
  `id` int(11) NOT NULL,
  `id_tau` int(11) NOT NULL,
  `ngay_bao_tri` date NOT NULL,
  `chi_tiet` text NOT NULL,
  `chi_phi` decimal(10,2) NOT NULL,
  `nguoi_phu_trach` varchar(255) NOT NULL,
  `trang_thai` enum('chưa thực hiện','đã hoàn thành') DEFAULT 'chưa thực hiện'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `vai_tro` enum('admin','khach_hang') DEFAULT 'khach_hang',
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tau`
--

CREATE TABLE `tau` (
  `id` int(11) NOT NULL,
  `ten_tau` varchar(255) NOT NULL,
  `so_toa` int(11) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `id` int(11) NOT NULL,
  `id_ve_tau` int(11) NOT NULL,
  `phuong_thuc` enum('momo','visa','chuyển khoản') NOT NULL,
  `trang_thai` enum('thành công','thất bại') DEFAULT 'thất bại',
  `ngay_thanh_toan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `toa_tau`
--

CREATE TABLE `toa_tau` (
  `id` int(11) NOT NULL,
  `id_tau` int(11) NOT NULL,
  `so_toa` int(11) NOT NULL,
  `loai_toa` enum('ghế mềm','ghế cứng','giường nằm') NOT NULL,
  `gia_ve` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tuyen_duong`
--

CREATE TABLE `tuyen_duong` (
  `id` int(11) NOT NULL,
  `diem_di` varchar(255) NOT NULL,
  `diem_den` varchar(255) NOT NULL,
  `thoi_gian_di` datetime NOT NULL,
  `thoi_gian_den` datetime NOT NULL,
  `id_tau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ve_tau`
--

CREATE TABLE `ve_tau` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` int(11) NOT NULL,
  `id_tuyen_duong` int(11) NOT NULL,
  `id_toa_tau` int(11) NOT NULL,
  `so_ghe` varchar(10) NOT NULL,
  `gia_ve` decimal(10,2) NOT NULL,
  `ngay_dat` datetime DEFAULT current_timestamp(),
  `trang_thai` enum('đã thanh toán','chưa thanh toán') DEFAULT 'chưa thanh toán'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoi_dung` (`id_nguoi_dung`),
  ADD KEY `id_tau` (`id_tau`);

--
-- Indexes for table `lich_su_giao_dich`
--
ALTER TABLE `lich_su_giao_dich`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoi_dung` (`id_nguoi_dung`);

--
-- Indexes for table `lich_trinh_bao_duong`
--
ALTER TABLE `lich_trinh_bao_duong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tau` (`id_tau`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tau`
--
ALTER TABLE `tau`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ve_tau` (`id_ve_tau`);

--
-- Indexes for table `toa_tau`
--
ALTER TABLE `toa_tau`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tau` (`id_tau`);

--
-- Indexes for table `tuyen_duong`
--
ALTER TABLE `tuyen_duong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tau` (`id_tau`);

--
-- Indexes for table `ve_tau`
--
ALTER TABLE `ve_tau`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoi_dung` (`id_nguoi_dung`),
  ADD KEY `id_tuyen_duong` (`id_tuyen_duong`),
  ADD KEY `id_toa_tau` (`id_toa_tau`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lich_su_giao_dich`
--
ALTER TABLE `lich_su_giao_dich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lich_trinh_bao_duong`
--
ALTER TABLE `lich_trinh_bao_duong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tau`
--
ALTER TABLE `tau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `toa_tau`
--
ALTER TABLE `toa_tau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tuyen_duong`
--
ALTER TABLE `tuyen_duong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ve_tau`
--
ALTER TABLE `ve_tau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`id_tau`) REFERENCES `tau` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lich_su_giao_dich`
--
ALTER TABLE `lich_su_giao_dich`
  ADD CONSTRAINT `lich_su_giao_dich_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lich_trinh_bao_duong`
--
ALTER TABLE `lich_trinh_bao_duong`
  ADD CONSTRAINT `lich_trinh_bao_duong_ibfk_1` FOREIGN KEY (`id_tau`) REFERENCES `tau` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`id_ve_tau`) REFERENCES `ve_tau` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `toa_tau`
--
ALTER TABLE `toa_tau`
  ADD CONSTRAINT `toa_tau_ibfk_1` FOREIGN KEY (`id_tau`) REFERENCES `tau` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tuyen_duong`
--
ALTER TABLE `tuyen_duong`
  ADD CONSTRAINT `tuyen_duong_ibfk_1` FOREIGN KEY (`id_tau`) REFERENCES `tau` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ve_tau`
--
ALTER TABLE `ve_tau`
  ADD CONSTRAINT `ve_tau_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ve_tau_ibfk_2` FOREIGN KEY (`id_tuyen_duong`) REFERENCES `tuyen_duong` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ve_tau_ibfk_3` FOREIGN KEY (`id_toa_tau`) REFERENCES `toa_tau` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

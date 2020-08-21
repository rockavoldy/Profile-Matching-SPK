-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2020 at 04:51 AM
-- Server version: 10.3.22-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akhmadid_spkbeasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_aspek`
--

CREATE TABLE `tb_aspek` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `persentase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_aspek`
--

INSERT INTO `tb_aspek` (`id`, `nama`, `persentase`) VALUES
(1, 'Prestasi akademik', 30),
(6, 'Data Keluarga', 20),
(7, 'Kondisi Ekonomi', 40),
(16, 'Tempat Tinggal', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_factor`
--

CREATE TABLE `tb_factor` (
  `id` int(11) NOT NULL,
  `id_aspek` int(11) NOT NULL,
  `jenis` enum('core','secondary') NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_factor`
--

INSERT INTO `tb_factor` (`id`, `id_aspek`, `jenis`, `deskripsi`, `nilai`) VALUES
(13, 7, 'core', 'Gaji orang tua', 9),
(17, 7, 'secondary', 'Bantuan pemerintah', 7),
(19, 7, 'secondary', 'Tanggungan utang', 8),
(24, 6, 'secondary', 'Jumlah saudara kandung', 5),
(25, 6, 'core', 'Jumlah Tanggungan', 7),
(27, 1, 'core', 'Nilai UN matematika', 6),
(28, 16, 'core', 'Luas tanah', 6),
(31, 16, 'core', 'Luas bangunan', 5),
(32, 16, 'secondary', 'Daya listrik', 5),
(35, 1, 'core', 'Nilai UN Bahasa Indonesia', 7),
(36, 1, 'secondary', 'Nilai UN Bahasa Inggris', 8),
(37, 1, 'secondary', 'Nilai UN Jurusan', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tb_gap_nilai_factor`
--

CREATE TABLE `tb_gap_nilai_factor` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_factor` int(11) NOT NULL,
  `gap` int(11) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_gap_nilai_factor`
--

INSERT INTO `tb_gap_nilai_factor` (`id`, `id_siswa`, `id_factor`, `gap`, `bobot`) VALUES
(1, 8, 13, -6, 3),
(2, 11, 13, -4, 1),
(3, 12, 13, -7, 3),
(4, 13, 13, -8, 3),
(5, 14, 13, 0, 3),
(6, 15, 13, -6, 3),
(7, 11, 17, -6, 3),
(8, 8, 17, -5, 3),
(9, 12, 17, 2, 4),
(10, 14, 17, -6, 3),
(11, 13, 17, -6, 3),
(12, 15, 17, -6, 3),
(13, 8, 19, -7, 3),
(14, 11, 19, -6, 3),
(15, 12, 19, -4, 1),
(16, 14, 19, 1, 3.5),
(17, 13, 19, -6, 3),
(18, 15, 19, -7, 3),
(19, 8, 24, -3, 1.5),
(20, 11, 24, -2, 2),
(21, 12, 24, -2, 2),
(22, 13, 24, -4, 1),
(23, 14, 24, -4, 1),
(24, 15, 24, -2, 2),
(25, 8, 25, -4, 1),
(26, 11, 25, -3, 1.5),
(27, 12, 25, -3, 1.5),
(28, 13, 25, -6, 3),
(29, 14, 25, -6, 3),
(30, 15, 25, -4, 1),
(31, 11, 27, -1, 2.5),
(32, 8, 27, 0, 3),
(33, 12, 27, -5, 3),
(34, 13, 27, 0, 3),
(35, 14, 27, 1, 3.5),
(36, 15, 27, 3, 4.5),
(37, 8, 28, 0, 3),
(38, 11, 28, 3, 4.5),
(39, 12, 28, 3, 4.5),
(40, 14, 28, -5, 3),
(41, 15, 28, -5, 3),
(42, 13, 28, -4, 1),
(43, 8, 31, 0, 3),
(44, 11, 31, 3, 4.5),
(45, 13, 31, -2, 2),
(46, 12, 31, 4, 5),
(47, 15, 31, -4, 1),
(48, 14, 31, -2, 2),
(49, 8, 32, 0, 3),
(50, 11, 32, 4, 5),
(51, 12, 32, 0, 3),
(52, 13, 32, -4, 1),
(53, 14, 32, 0, 3),
(54, 15, 32, 4, 5),
(55, 8, 35, -5, 3),
(56, 11, 35, 0, 3),
(57, 12, 35, -6, 3),
(58, 14, 35, -5, 3),
(59, 13, 35, -3, 1.5),
(60, 15, 35, -5, 3),
(61, 8, 36, -1, 2.5),
(62, 11, 36, -2, 2),
(63, 12, 36, 1, 3.5),
(64, 14, 36, -1, 2.5),
(65, 15, 36, -7, 3),
(66, 13, 36, -3, 1.5),
(67, 8, 37, 2, 4),
(68, 11, 37, -3, 1.5),
(69, 13, 37, -3, 1.5),
(70, 14, 37, -4, 1),
(71, 12, 37, 2, 4),
(72, 15, 37, -5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai_aspek`
--

CREATE TABLE `tb_nilai_aspek` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_aspek` int(11) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_nilai_aspek`
--

INSERT INTO `tb_nilai_aspek` (`id`, `id_siswa`, `id_aspek`, `nilai`) VALUES
(1, 8, 1, 6),
(2, 8, 6, 1),
(3, 8, 7, 4),
(4, 8, 16, 5),
(5, 11, 1, 5),
(6, 11, 6, 2),
(7, 11, 7, 3),
(8, 11, 16, 7),
(9, 12, 1, 7),
(10, 12, 6, 2),
(11, 12, 7, 4),
(12, 12, 16, 7),
(13, 13, 1, 4),
(14, 13, 6, 2),
(15, 13, 7, 4),
(16, 13, 16, 2),
(17, 14, 1, 5),
(18, 14, 6, 2),
(19, 14, 7, 4),
(20, 14, 16, 4),
(21, 15, 1, 7),
(22, 15, 6, 1),
(23, 15, 7, 4),
(24, 15, 16, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai_factor`
--

CREATE TABLE `tb_nilai_factor` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_factor` int(11) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_nilai_factor`
--

INSERT INTO `tb_nilai_factor` (`id`, `id_siswa`, `id_factor`, `nilai`) VALUES
(1, 8, 13, 3),
(2, 11, 13, 5),
(3, 12, 13, 2),
(4, 13, 13, 1),
(5, 14, 13, 9),
(6, 15, 13, 3),
(7, 11, 17, 1),
(8, 8, 17, 2),
(9, 12, 17, 9),
(10, 14, 17, 1),
(11, 13, 17, 1),
(12, 15, 17, 1),
(13, 8, 19, 1),
(14, 11, 19, 2),
(15, 12, 19, 4),
(16, 14, 19, 9),
(17, 13, 19, 2),
(18, 15, 19, 1),
(19, 8, 24, 2),
(20, 11, 24, 3),
(21, 12, 24, 3),
(22, 13, 24, 1),
(23, 14, 24, 1),
(24, 15, 24, 3),
(25, 8, 25, 3),
(26, 11, 25, 4),
(27, 12, 25, 4),
(28, 13, 25, 1),
(29, 14, 25, 1),
(30, 15, 25, 3),
(31, 11, 27, 5),
(32, 8, 27, 6),
(33, 12, 27, 1),
(34, 13, 27, 6),
(35, 14, 27, 7),
(36, 15, 27, 9),
(37, 8, 28, 6),
(38, 11, 28, 9),
(39, 12, 28, 9),
(40, 14, 28, 1),
(41, 15, 28, 1),
(42, 13, 28, 2),
(43, 8, 31, 5),
(44, 11, 31, 8),
(45, 13, 31, 3),
(46, 12, 31, 9),
(47, 15, 31, 1),
(48, 14, 31, 3),
(49, 8, 32, 5),
(50, 11, 32, 9),
(51, 12, 32, 5),
(52, 13, 32, 1),
(53, 14, 32, 5),
(54, 15, 32, 9),
(55, 8, 35, 2),
(56, 11, 35, 7),
(57, 12, 35, 1),
(58, 14, 35, 2),
(59, 13, 35, 4),
(60, 15, 35, 2),
(61, 8, 36, 7),
(62, 11, 36, 6),
(63, 12, 36, 9),
(64, 14, 36, 7),
(65, 15, 36, 1),
(66, 13, 36, 5),
(67, 8, 37, 8),
(68, 11, 37, 3),
(69, 13, 37, 3),
(70, 14, 37, 2),
(71, 12, 37, 8),
(72, 15, 37, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_raw_factor`
--

CREATE TABLE `tb_raw_factor` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_factor` int(11) NOT NULL,
  `raw_data` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_raw_factor`
--

INSERT INTO `tb_raw_factor` (`id`, `id_siswa`, `id_factor`, `raw_data`) VALUES
(44, 11, 27, 75),
(45, 8, 27, 80),
(46, 12, 27, 50),
(50, 13, 27, 80),
(53, 14, 27, 90),
(54, 15, 27, 100),
(55, 8, 36, 90),
(56, 8, 35, 75),
(57, 8, 37, 100),
(58, 11, 35, 90),
(59, 11, 36, 85),
(60, 11, 37, 80),
(61, 12, 35, 70),
(62, 12, 36, 100),
(63, 13, 37, 80),
(64, 14, 35, 75),
(65, 14, 36, 90),
(66, 15, 36, 60),
(67, 13, 35, 80),
(68, 8, 24, 3),
(69, 8, 25, 4),
(71, 11, 25, 5),
(73, 11, 24, 4),
(74, 12, 24, 4),
(76, 12, 25, 5),
(78, 13, 24, 2),
(79, 13, 25, 2),
(80, 14, 37, 75),
(81, 12, 37, 100),
(82, 15, 37, 70),
(83, 13, 36, 80),
(84, 15, 35, 75),
(85, 14, 25, 2),
(86, 14, 24, 2),
(87, 15, 24, 4),
(88, 15, 25, 4),
(89, 8, 13, 3000000),
(90, 8, 19, 0),
(91, 11, 17, 0),
(92, 8, 17, 1700000),
(93, 12, 17, 10000000),
(94, 11, 19, 600000),
(95, 12, 19, 2000000),
(96, 11, 13, 5000000),
(97, 12, 13, 2000000),
(98, 13, 13, 500000),
(99, 14, 17, 0),
(100, 14, 19, 5000000),
(101, 13, 17, 0),
(102, 14, 13, 10000000),
(103, 13, 19, 1000000),
(104, 15, 17, 200000),
(105, 15, 19, 0),
(106, 15, 13, 3000000),
(107, 8, 31, 72),
(108, 8, 28, 84),
(109, 8, 32, 900),
(110, 11, 28, 100),
(111, 11, 31, 96),
(112, 11, 32, 1400),
(113, 12, 28, 100),
(114, 13, 31, 56),
(115, 12, 32, 900),
(116, 12, 31, 100),
(117, 13, 32, 450),
(118, 15, 31, 42),
(119, 14, 28, 56),
(120, 15, 28, 56),
(121, 14, 32, 900),
(122, 14, 31, 56),
(123, 13, 28, 64),
(124, 15, 32, 1400);

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id` int(11) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `asal_sekolah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id`, `nisn`, `nama`, `asal_sekolah`) VALUES
(8, '1607672', 'Fitri', 'SMKN 1 Tasikmalaya'),
(11, '1604125', 'Dijah', 'SMAN 4 Bandung'),
(12, '1606238', 'Faisal', 'SMAN 3 Bandung'),
(13, '1606444', 'Hilda', 'SMKN 3 Bandung'),
(14, '1601731', 'Rasyid', 'SMAN 5 Wakanda'),
(15, '1607488', 'Akhmad', 'SMKN 2 Garut');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_aspek`
--
ALTER TABLE `tb_aspek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_factor`
--
ALTER TABLE `tb_factor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_factor_ibfk_1` (`id_aspek`);

--
-- Indexes for table `tb_gap_nilai_factor`
--
ALTER TABLE `tb_gap_nilai_factor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_factor` (`id_factor`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tb_nilai_aspek`
--
ALTER TABLE `tb_nilai_aspek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_nilai_aspek_ibfk_1` (`id_aspek`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tb_nilai_factor`
--
ALTER TABLE `tb_nilai_factor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_factor` (`id_factor`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tb_raw_factor`
--
ALTER TABLE `tb_raw_factor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_factor` (`id_factor`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nisn` (`nisn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_aspek`
--
ALTER TABLE `tb_aspek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_factor`
--
ALTER TABLE `tb_factor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tb_gap_nilai_factor`
--
ALTER TABLE `tb_gap_nilai_factor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tb_nilai_aspek`
--
ALTER TABLE `tb_nilai_aspek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_nilai_factor`
--
ALTER TABLE `tb_nilai_factor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tb_raw_factor`
--
ALTER TABLE `tb_raw_factor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_factor`
--
ALTER TABLE `tb_factor`
  ADD CONSTRAINT `tb_factor_ibfk_1` FOREIGN KEY (`id_aspek`) REFERENCES `tb_aspek` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_gap_nilai_factor`
--
ALTER TABLE `tb_gap_nilai_factor`
  ADD CONSTRAINT `tb_gap_nilai_factor_ibfk_1` FOREIGN KEY (`id_factor`) REFERENCES `tb_factor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_gap_nilai_factor_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_nilai_aspek`
--
ALTER TABLE `tb_nilai_aspek`
  ADD CONSTRAINT `tb_nilai_aspek_ibfk_1` FOREIGN KEY (`id_aspek`) REFERENCES `tb_aspek` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_nilai_aspek_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_nilai_factor`
--
ALTER TABLE `tb_nilai_factor`
  ADD CONSTRAINT `tb_nilai_factor_ibfk_1` FOREIGN KEY (`id_factor`) REFERENCES `tb_factor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_nilai_factor_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_raw_factor`
--
ALTER TABLE `tb_raw_factor`
  ADD CONSTRAINT `tb_raw_factor_ibfk_1` FOREIGN KEY (`id_factor`) REFERENCES `tb_factor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_raw_factor_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 04:15 PM
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
-- Database: `sewa_ambulance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `detail_tugas`
--

CREATE TABLE `detail_tugas` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `km_awal` int(11) DEFAULT NULL,
  `km_akhir` int(11) DEFAULT NULL,
  `penggunaan_oksigen` varchar(50) DEFAULT NULL,
  `catatan_petugas` text DEFAULT NULL,
  `waktu_selesai` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manager_akun`
--

CREATE TABLE `manager_akun` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_manager` varchar(100) DEFAULT NULL,
  `foto_profil` varchar(100) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager_akun`
--

INSERT INTO `manager_akun` (`id`, `username`, `password`, `nama_manager`, `foto_profil`) VALUES
(1, 'manager1', 'manager123', 'Ahmad Faiz Ramadhan', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama_pasien` varchar(100) DEFAULT NULL,
  `alamat_jemput` text DEFAULT NULL,
  `tujuan` text DEFAULT NULL,
  `status_pesanan` enum('waiting','proses','selesai') DEFAULT 'waiting',
  `harga` int(11) DEFAULT 0,
  `unit_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama_pasien`, `alamat_jemput`, `tujuan`, `status_pesanan`, `harga`, `unit_id`) VALUES
(68, 'sewa1', 'awertyjk', 'adsfghjkl;', 'selesai', 750000, 2),
(69, 'sewa1', 'asdfgh', 'asdfghj', 'selesai', 750000, 2),
(70, 'sewa1', 'asdrftg', 'adsfgh', 'selesai', 250000, 1),
(71, 'sewa1', 'ASFTY', 'SDFGHJK', 'selesai', 250000, 1),
(72, 'sewa1', 'asdfgh', 'asdfdghjk', 'selesai', 250000, 1),
(73, 'sewa1', 'qwertyu', 'sefdrgtygh', 'selesai', 250000, 1),
(74, 'sewa1', 'qwerty', 'wertyui', 'selesai', 750000, 2),
(75, 'sewa1', 'ertyui', 'wsedrtyui', 'selesai', 250000, 1),
(76, 'sewa1', 'qwerftghj', 'adesfdgfhjk', 'selesai', 250000, 1),
(77, 'sewa1', 'waesdrfgtfyg', 'awsedrtyu', 'selesai', 250000, 1),
(78, 'sewa1', 'aszdfgh', 'szdfghjh', 'selesai', 750000, 2),
(79, 'sewa1', 'aerdtfy', 'asdfsrgtu', 'selesai', 250000, 1),
(80, 'sewa1', 'waesfd', 'asdfg', 'selesai', 250000, 1),
(81, 'sewa1', 'dfghj', 'ertyu', 'selesai', 250000, 1),
(82, 'sewa1', 'sdfghj', 'ertyui', 'selesai', 250000, 1),
(83, 'sewa1', 'sdf', 'sdfg', 'selesai', 250000, 1),
(84, 'sewa1', 'asdf', 'asdf', 'selesai', 250000, 1),
(85, 'sewa1', 'QAWDESD', 'AWSDFD', 'selesai', 250000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `petugas_akun`
--

CREATE TABLE `petugas_akun` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_petugas` varchar(100) DEFAULT NULL,
  `id_unit` int(11) DEFAULT NULL,
  `status_tugas` enum('standby','on-duty') DEFAULT 'standby'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas_akun`
--

INSERT INTO `petugas_akun` (`id`, `username`, `password`, `nama_petugas`, `id_unit`, `status_tugas`) VALUES
(1, 'petugas1', 'petugas123', 'Budi Santoso', NULL, 'standby');

-- --------------------------------------------------------

--
-- Table structure for table `unit_ambulance`
--

CREATE TABLE `unit_ambulance` (
  `id` int(11) NOT NULL,
  `nama_unit` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `status` enum('tersedia','dipakai') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_ambulance`
--

INSERT INTO `unit_ambulance` (`id`, `nama_unit`, `keterangan`, `harga`, `status`) VALUES
(1, 'Ekonomi', 'Ambulance standar tanpa alat medis khusus', 250000, 'tersedia'),
(2, 'VIP', 'Ambulance dengan fasilitas lengkap & pendamping medis', 750000, 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(4, 'sewa1', 'sewa1', 'user'),
(5, 'pasien3', 'pasien3', 'user'),
(6, 'manager1', 'password123', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_tugas`
--
ALTER TABLE `detail_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `manager_akun`
--
ALTER TABLE `manager_akun`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas_akun`
--
ALTER TABLE `petugas_akun`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `unit_ambulance`
--
ALTER TABLE `unit_ambulance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_tugas`
--
ALTER TABLE `detail_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manager_akun`
--
ALTER TABLE `manager_akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `petugas_akun`
--
ALTER TABLE `petugas_akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `unit_ambulance`
--
ALTER TABLE `unit_ambulance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_tugas`
--
ALTER TABLE `detail_tugas`
  ADD CONSTRAINT `detail_tugas_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2026 at 08:57 AM
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
-- Database: `db_pegawai`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cari_pegawai` (IN `keyword` VARCHAR(100))   BEGIN
SELECT p.id,p.nip,p.nama,d.nama AS departemen,p.jabatan,p.status
FROM pegawai p
JOIN departemen d ON p.id_departemen = d.id
WHERE p.nama LIKE CONCAT('%',keyword,'%')
OR p.nip LIKE CONCAT('%',keyword,'%')
OR p.jabatan LIKE CONCAT('%',keyword,'%')
ORDER BY p.nama ASC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `kode`, `nama`, `created_at`) VALUES
(1, 'IT', 'Teknologi Informasi', '2026-05-17 14:50:48'),
(2, 'HRD', 'Human Resource Development', '2026-05-17 14:50:48'),
(3, 'FIN', 'Keuangan', '2026-05-17 14:50:48'),
(4, 'MKT', 'Marketing', '2026-05-17 14:50:48'),
(5, 'OPS', 'Operasional', '2026-05-17 14:50:48');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `aksi` varchar(10) DEFAULT NULL,
  `tabel` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `waktu` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `aksi`, `tabel`, `keterangan`, `waktu`) VALUES
(1, 'DELETE', 'pegawai', 'pegawaiAsu(NIP:2023003)dihapus', '2026-05-23 08:48:36');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_departemen` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `gaji` decimal(12,2) NOT NULL DEFAULT 0.00,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tgl_masuk` date NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama`, `id_departemen`, `jabatan`, `gaji`, `no_hp`, `email`, `tgl_masuk`, `status`, `created_at`) VALUES
(1, '2020001', 'Andi Saputra', 1, 'Software Engineer', 8500000.00, '081234567899', 'andi@mail.com', '2020-03-01', 'aktif', '2026-05-17 15:03:35'),
(2, '2020002', 'Budi Santoso', 2, 'HR Manager', 9000000.00, '081234567891', 'budi@mail.com', '2020-05-15', 'aktif', '2026-05-17 15:03:35'),
(3, '2021001', 'Citra Dewi', 3, 'Finance Staff', 6500000.00, '081234567892', 'citra@mail.com', '2021-01-10', 'aktif', '2026-05-17 15:03:35'),
(4, '2021002', 'Dian Pratama', 4, 'Marketing Staff', 6000000.00, '081234567893', 'dian@mail.com', '2021-06-01', 'aktif', '2026-05-17 15:03:35'),
(5, '2022001', 'Eka Rahayu', 1, 'Web Developer', 7500000.00, '081234567894', 'eka@mail.com', '2022-02-14', 'aktif', '2026-05-17 15:03:35'),
(6, '2022002', 'Fajar Nugroho', 5, 'Supervisor', 8000000.00, '081234567895', 'fajar@mail.com', '2022-07-01', 'aktif', '2026-05-17 15:03:35'),
(7, '2023001', 'Gita lestrari', 2, 'Recruiter', 5500000.00, '081234567896', 'gita@mail.com', '2023-01-03', 'aktif', '2026-05-17 15:03:35'),
(8, '2023002', 'Hendra Wijaya', 3, 'Accounting', 7000000.00, '081234567897', 'hendra@mail.com', '2023-04-17', 'nonaktif', '2026-05-17 15:03:35'),
(9, '2024001', 'Uus', 3, 'Staf Finansial Kantor', 5000000.00, '08789839421', 'jayajaya@gmail.com', '2026-05-18', 'aktif', '2026-05-18 09:51:06'),
(11, '2024003', 'Murfi', 1, 'Staff IT', 5600000.00, '081234567897', 'murfi@example.com', '2026-03-18', 'aktif', '2026-05-25 09:12:07');

--
-- Triggers `pegawai`
--
DELIMITER $$
CREATE TRIGGER `tr_hapus_pegawai` AFTER DELETE ON `pegawai` FOR EACH ROW BEGIN
INSERT INTO log_aktivitas(aksi,tabel,keterangan)
VALUES('DELETE','pegawai',
CONCAT('pegawai',OLD.nama, '(NIP:',OLD.nip,')dihapus'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_update_status` AFTER UPDATE ON `pegawai` FOR EACH ROW BEGIN
IF OLD.status != NEW.status THEN
INSERT INTO log_aktivitas(aksi,tabel,keterangan)
VALUES('UPDATE','pegawai',
CONCAT('Status',NEW.nama,'diubah:',OLD.status,'->',NEW.status));
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pegawai`
-- (See below for the actual view)
--
CREATE TABLE `v_pegawai` (
`id` int(11)
,`nip` varchar(20)
,`nama` varchar(100)
,`departemen` varchar(100)
,`kode_dept` varchar(10)
,`jabatan` varchar(100)
,`gaji` decimal(12,2)
,`no_hp` varchar(15)
,`email` varchar(100)
,`tgl_masuk` date
,`status` enum('aktif','nonaktif')
,`lama_kerja` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_statistik_dept`
-- (See below for the actual view)
--
CREATE TABLE `v_statistik_dept` (
`id` int(11)
,`kode` varchar(10)
,`nama` varchar(100)
,`total_pegawai` bigint(21)
,`total_gaji` decimal(34,2)
,`rata_gaji` decimal(11,0)
,`gaji_tertinggi` decimal(12,2)
,`gaji_terendah` decimal(12,2)
);

-- --------------------------------------------------------

--
-- Structure for view `v_pegawai`
--
DROP TABLE IF EXISTS `v_pegawai`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pegawai`  AS SELECT `p`.`id` AS `id`, `p`.`nip` AS `nip`, `p`.`nama` AS `nama`, `d`.`nama` AS `departemen`, `d`.`kode` AS `kode_dept`, `p`.`jabatan` AS `jabatan`, `p`.`gaji` AS `gaji`, `p`.`no_hp` AS `no_hp`, `p`.`email` AS `email`, `p`.`tgl_masuk` AS `tgl_masuk`, `p`.`status` AS `status`, timestampdiff(YEAR,`p`.`tgl_masuk`,curdate()) AS `lama_kerja` FROM (`pegawai` `p` join `departemen` `d` on(`p`.`id_departemen` = `d`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_statistik_dept`
--
DROP TABLE IF EXISTS `v_statistik_dept`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_statistik_dept`  AS SELECT `d`.`id` AS `id`, `d`.`kode` AS `kode`, `d`.`nama` AS `nama`, count(`p`.`id`) AS `total_pegawai`, coalesce(sum(`p`.`gaji`),0) AS `total_gaji`, coalesce(round(avg(`p`.`gaji`),0),0) AS `rata_gaji`, coalesce(max(`p`.`gaji`),0) AS `gaji_tertinggi`, coalesce(min(`p`.`gaji`),0) AS `gaji_terendah` FROM (`departemen` `d` left join `pegawai` `p` on(`d`.`id` = `p`.`id_departemen` and `p`.`status` = 'aktif')) GROUP BY `d`.`id`, `d`.`kode`, `d`.`nama` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_departemen` (`id_departemen`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_departemen`) REFERENCES `departemen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

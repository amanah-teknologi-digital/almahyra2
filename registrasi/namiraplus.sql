-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2022 at 03:10 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `namiraplus`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_user`
--

CREATE TABLE `data_user` (
  `id` int(100) NOT NULL,
  `id_role` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT '-',
  `photo` varchar(100) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(100) DEFAULT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_user`
--

INSERT INTO `data_user` (`id`, `id_role`, `name`, `email`, `password`, `phone`, `photo`, `purpose`, `status`, `date_created`, `date_updated`, `created_by`, `is_active`) VALUES
(1, 2, 'admin', 'admin', 'admin', '08100200400', NULL, 'mendaftarkan anak edit', 1, '2022-05-22 15:05:31', '2022-05-22 15:05:47', NULL, 1),
(2, 3, 'tes', 'tes1@mail.com', 'tes1@mail.com', '08912192', NULL, 'fjofijef', 0, '2022-05-22 21:05:46', '2022-05-23 03:31:46', NULL, 1),
(3, 0, '', NULL, '', '-', NULL, NULL, 0, '2022-05-22 21:05:44', '2022-05-23 03:35:44', NULL, 1),
(4, 0, '', NULL, '', '-', NULL, NULL, 0, '2022-05-22 21:05:51', '2022-05-23 03:35:51', NULL, 1),
(5, 0, '', NULL, '', '-', NULL, NULL, 0, '2022-05-22 21:05:18', '2022-05-23 03:36:18', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_imunisasi`
--

CREATE TABLE `m_imunisasi` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `created_by` int(100) DEFAULT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_imunisasi`
--

INSERT INTO `m_imunisasi` (`id`, `name`, `date_created`, `date_updated`, `created_by`, `is_active`) VALUES
(1, 'Hepatitis B', '2022-05-23 04:05:48', '0000-00-00 00:00:00', NULL, 1),
(2, 'Polio Tetes 2', '2022-05-23 04:05:02', '0000-00-00 00:00:00', NULL, 1),
(3, 'Polio Tetes 4', '2022-05-23 04:05:09', '0000-00-00 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_penyakit`
--

CREATE TABLE `m_penyakit` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `created_by` int(100) DEFAULT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_penyakit`
--

INSERT INTO `m_penyakit` (`id`, `name`, `date_created`, `date_updated`, `created_by`, `is_active`) VALUES
(1, 'Jantung Bawaan', '2022-05-23 04:05:29', '0000-00-00 00:00:00', NULL, 1),
(2, 'Epilepsi', '2022-05-23 04:05:36', '0000-00-00 00:00:00', NULL, 1),
(3, 'Kulit', '2022-05-23 04:05:45', '0000-00-00 00:00:00', NULL, 1),
(4, 'Asma', '2022-05-23 04:05:56', '0000-00-00 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_role`
--

CREATE TABLE `m_role` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `created_by` int(100) DEFAULT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_role`
--

INSERT INTO `m_role` (`id`, `name`, `date_created`, `date_updated`, `created_by`, `is_active`) VALUES
(1, 'Administrator', '2022-05-22 15:05:19', '0000-00-00 00:00:00', NULL, 1),
(2, 'Owner', '2022-05-22 15:05:31', '0000-00-00 00:00:00', NULL, 1),
(3, 'Pengasuh', '2022-05-22 15:05:38', '0000-00-00 00:00:00', NULL, 1),
(4, 'Orang Tua', '2022-05-22 15:05:46', '0000-00-00 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_data_anak`
--

CREATE TABLE `registrasi_data_anak` (
  `id` int(100) NOT NULL,
  `id_orangtua` int(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nick` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT '-',
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT 'L',
  `golongan_darah` varchar(2) DEFAULT 'O',
  `anak_ke` varchar(100) DEFAULT NULL,
  `jumlah_saudara` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(100) DEFAULT NULL,
  `is_done` int(1) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registrasi_data_anak`
--

INSERT INTO `registrasi_data_anak` (`id`, `id_orangtua`, `nama`, `nick`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `golongan_darah`, `anak_ke`, `jumlah_saudara`, `date_created`, `date_updated`, `created_by`, `is_done`, `is_active`) VALUES
(1, 1, 'c100', 'bb100', 'sd11', '2022-05-23', 'P', 'O', '10', '200', '2022-05-22 18:05:44', '2022-05-22 18:05:26', NULL, 0, 0),
(2, 1, 'cc', 'cc', 'dfg', '2022-05-09', 'P', 'B', '1', '2', '2022-05-22 18:05:44', '2022-05-23 00:29:44', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_data_berkas`
--

CREATE TABLE `registrasi_data_berkas` (
  `id` int(100) NOT NULL,
  `id_anak` int(100) NOT NULL,
  `upload_foto_anak` varchar(100) NOT NULL,
  `upload_surat_pernyataan` varchar(100) DEFAULT NULL,
  `upload_akta` varchar(100) DEFAULT '-',
  `upload_kk` varchar(100) DEFAULT '-',
  `upload_ktp_ayah` varchar(100) DEFAULT '-',
  `upload_ktp_ibu` varchar(100) DEFAULT '-',
  `upload_kartu_sehat` varchar(100) DEFAULT '-',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(100) DEFAULT NULL,
  `is_done` int(1) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registrasi_data_berkas`
--

INSERT INTO `registrasi_data_berkas` (`id`, `id_anak`, `upload_foto_anak`, `upload_surat_pernyataan`, `upload_akta`, `upload_kk`, `upload_ktp_ayah`, `upload_ktp_ibu`, `upload_kartu_sehat`, `date_created`, `date_updated`, `created_by`, `is_done`, `is_active`) VALUES
(3, 2, '', '230522025403.html', '-', '-', '230522025637.html', '-', '2305220256371.html', '2022-05-23 14:05:03', '2022-05-23 14:05:37', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_data_orangtua`
--

CREATE TABLE `registrasi_data_orangtua` (
  `id` int(100) NOT NULL,
  `id_anak` int(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `hubungan` varchar(100) NOT NULL,
  `status` varchar(100) DEFAULT '-',
  `riwayat` varchar(100) DEFAULT '-',
  `pekerjaan` varchar(100) DEFAULT '-',
  `perusahaan` varchar(100) DEFAULT '-',
  `alamat_kantor` varchar(100) DEFAULT '-',
  `jam_kerja` varchar(100) DEFAULT '-',
  `telp_kantor` varchar(100) DEFAULT '-',
  `pendapatan` varchar(100) DEFAULT '-',
  `pendidikan` varchar(100) DEFAULT '-',
  `alamat_rumah` varchar(100) DEFAULT '-',
  `telp_rumah` varchar(100) DEFAULT '-',
  `hubungan_orang_tua` varchar(100) DEFAULT '-',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(100) DEFAULT NULL,
  `is_active` int(1) NOT NULL,
  `is_done` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registrasi_data_orangtua`
--

INSERT INTO `registrasi_data_orangtua` (`id`, `id_anak`, `nama`, `hubungan`, `status`, `riwayat`, `pekerjaan`, `perusahaan`, `alamat_kantor`, `jam_kerja`, `telp_kantor`, `pendapatan`, `pendidikan`, `alamat_rumah`, `telp_rumah`, `hubungan_orang_tua`, `date_created`, `date_updated`, `created_by`, `is_active`, `is_done`) VALUES
(1, 2, 'ayah', 'A', 'Bukan Kandung', 'Mati', 'ayahp', 'ayahnp', 'ayahap', 'ayahjk', 'ayahtp', '1', 'S2', 'ayahar', 'ayahhp', '-', '2022-05-22 20:05:26', '2022-05-23 02:31:26', NULL, 0, 0),
(2, 2, 'wali', 'W', 'Wali', 'Mati', 'walip', 'waliper', 'waliap', 'walijk', 'walitp', '1', 'SMP', 'wali ar', 'walihp', '', '2022-05-22 20:05:26', '2022-05-23 02:31:26', NULL, 0, 0),
(3, 2, 'ibu', 'I', 'Kandung', 'Hidup', 'ibup', 'ibupr', 'ibuap', 'ibujk', 'ibtp', '1', 'S3', 'ibuAr', 'ibhp', '-', '2022-05-22 20:05:26', '2022-05-23 02:31:26', NULL, 0, 0),
(4, 2, 'ayah', 'A', 'Kandung', 'Hidup', 'ayahp', 'ayahnp', 'ayahap', 'ayahjk', 'ayahtp', '1', 'S2', 'ayahar', 'ayahhp', '-', '2022-05-22 20:05:51', '2022-05-23 02:58:51', NULL, 0, 0),
(5, 2, 'wali', 'W', 'Wali', '-', 'walip', 'waliper', 'waliap', 'walijk', 'walitp', '1', 'SMP', 'wali ar', 'walihp', 'acnc', '2022-05-22 20:05:51', '2022-05-23 02:58:51', NULL, 0, 0),
(6, 2, 'ibu', 'I', 'Kandung', 'Hidup', 'ibup', 'ibupr', 'ibuap', 'ibujk', 'ibtp', '1', 'S3', 'ibuAr', 'ibhp', '-', '2022-05-22 20:05:51', '2022-05-23 02:58:51', NULL, 0, 0),
(7, 2, 'ayah', 'A', 'Kandung', 'Hidup', 'ayahp', 'ayahnp', 'ayahap', 'ayahjk', 'ayahtp', '1', 'S2', 'ayahar', 'ayahhp', '-', '2022-05-22 21:05:33', '2022-05-23 03:00:33', NULL, 0, 0),
(8, 2, 'wali', 'W', 'Wali', 'Mati', 'walip', 'waliper', 'waliap', 'walijk', 'walitp', '1', 'SMP', 'wali ar', 'walihp', 'acnc', '2022-05-22 21:05:33', '2022-05-23 03:00:33', NULL, 0, 0),
(9, 2, 'ibu', 'I', 'Bukan Kandung', 'Mati', 'ibup', 'ibupr', 'ibuap', 'ibujk', 'ibtp', '1', 'S3', 'ibuAr', 'ibhp', '-', '2022-05-22 21:05:33', '2022-05-23 03:00:33', NULL, 0, 0),
(10, 2, 'ayah', 'A', 'Kandung', 'Hidup', 'ayahp', 'ayahnp', 'ayahap', 'ayahjk', 'ayahtp', '1', 'S2', 'ayahar', 'ayahhp', '-', '2022-05-22 21:05:51', '2022-05-23 03:01:51', NULL, 1, 0),
(11, 2, 'wali', 'W', 'Wali', 'Mati', 'walip', 'waliper', 'waliap', 'walijk', 'walitp', '2', 'SMP', 'wali ar', 'walihp', 'acnc', '2022-05-22 21:05:51', '2022-05-23 03:01:51', NULL, 1, 0),
(12, 2, 'ibu', 'I', 'Bukan Kandung', 'Mati', 'ibup', 'ibupr', 'ibuap', 'ibujk', 'ibtp', '1', 'S3', 'ibuAr', 'ibhp', '-', '2022-05-22 21:05:51', '2022-05-23 03:01:51', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_data_rekam_medik`
--

CREATE TABLE `registrasi_data_rekam_medik` (
  `id` int(100) NOT NULL,
  `id_anak` int(100) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `alamat_dokter` varchar(100) DEFAULT NULL,
  `tb_lahir` int(100) NOT NULL,
  `bb_lahir` varchar(100) DEFAULT '-',
  `metode_lahir` varchar(100) DEFAULT '-',
  `goldar` varchar(100) DEFAULT '-',
  `penyakit_khusus` varchar(100) DEFAULT '-',
  `alergi_makanan` text DEFAULT '-',
  `alergi_obat` text DEFAULT '-',
  `alergi_lainnya` text DEFAULT '-',
  `informasi_penting` text DEFAULT '-',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(100) DEFAULT NULL,
  `is_active` int(1) NOT NULL,
  `is_done` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registrasi_data_rekam_medik`
--

INSERT INTO `registrasi_data_rekam_medik` (`id`, `id_anak`, `nama_dokter`, `alamat_dokter`, `tb_lahir`, `bb_lahir`, `metode_lahir`, `goldar`, `penyakit_khusus`, `alergi_makanan`, `alergi_obat`, `alergi_lainnya`, `informasi_penting`, `date_created`, `date_updated`, `created_by`, `is_active`, `is_done`) VALUES
(1, 2, 'nd', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 05:05:57', '2022-05-23 11:05:57', NULL, 0, 0),
(2, 2, 'nde', 'ade', 1000, '2000', 'Caesar', 'O', 'demam;fluss;e', 'susu;protein;mangan;e', 'obat1;obat2;obat3;e', 'lain1;lain2;lain3;e;', 'informasipenting;e', '2022-05-23 05:05:12', '2022-05-23 11:27:12', NULL, 0, 0),
(3, 2, 'ndr', 'ade', 1200, '700', 'Caesar', 'B', 'demam;fluss;e', 'susu;protein;mangan;e', 'obat1;obat2;obat3;e', 'lain1;lain2;lain3;e', 'informasipenting;e', '2022-05-23 05:05:17', '2022-05-23 11:28:17', NULL, 0, 0),
(4, 2, 'ndx', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 05:05:25', '2022-05-23 11:29:25', NULL, 0, 0),
(5, 2, 'ndx', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 05:05:29', '2022-05-23 11:30:29', NULL, 0, 0),
(6, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 05:05:05', '2022-05-23 11:31:05', NULL, 0, 0),
(7, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:35', '2022-05-23 12:31:35', NULL, 0, 0),
(8, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:10', '2022-05-23 12:32:10', NULL, 0, 0),
(9, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:19', '2022-05-23 12:32:19', NULL, 0, 0),
(10, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:26', '2022-05-23 12:35:26', NULL, 0, 0),
(11, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:23', '2022-05-23 12:36:23', NULL, 0, 0),
(12, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:45', '2022-05-23 12:36:45', NULL, 0, 0),
(13, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:47', '2022-05-23 12:37:47', NULL, 0, 0),
(14, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:20', '2022-05-23 12:40:20', NULL, 0, 0),
(15, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:41', '2022-05-23 12:40:41', NULL, 0, 0),
(16, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:41', '2022-05-23 12:41:41', NULL, 0, 0),
(17, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:30', '2022-05-23 12:55:30', NULL, 0, 0),
(18, 2, 'ndc', 'ad', 120, '70', 'Normal', 'AB', 'demam;fluss', 'susu;protein;mangan', 'obat1;obat2;obat3', 'lain1;lain2;lain3;', 'informasipenting', '2022-05-23 06:05:19', '2022-05-23 12:57:19', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_data_rekam_medik_imunisasi`
--

CREATE TABLE `registrasi_data_rekam_medik_imunisasi` (
  `id` int(100) NOT NULL,
  `id_rekam_medik` int(100) NOT NULL,
  `id_imunisasi` int(100) DEFAULT NULL,
  `tanggal_imunisasi` date DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(100) DEFAULT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registrasi_data_rekam_medik_imunisasi`
--

INSERT INTO `registrasi_data_rekam_medik_imunisasi` (`id`, `id_rekam_medik`, `id_imunisasi`, `tanggal_imunisasi`, `date_created`, `date_updated`, `created_by`, `is_active`) VALUES
(1, 13, 2, NULL, '2022-05-23 06:05:47', '2022-05-23 12:37:47', NULL, 1),
(2, 13, 3, NULL, '2022-05-23 06:05:47', '2022-05-23 12:37:47', NULL, 1),
(3, 14, 2, NULL, '2022-05-23 06:05:20', '2022-05-23 12:40:20', NULL, 1),
(4, 14, 3, NULL, '2022-05-23 06:05:20', '2022-05-23 12:40:20', NULL, 1),
(5, 15, 2, NULL, '2022-05-23 06:05:41', '2022-05-23 12:40:41', NULL, 1),
(6, 15, 3, NULL, '2022-05-23 06:05:41', '2022-05-23 12:40:41', NULL, 1),
(7, 16, 2, NULL, '2022-05-23 06:05:41', '2022-05-23 12:41:41', NULL, 1),
(8, 16, 3, NULL, '2022-05-23 06:05:41', '2022-05-23 12:41:41', NULL, 1),
(9, 17, 1, NULL, '2022-05-23 06:05:30', '2022-05-23 12:55:30', NULL, 1),
(10, 17, 2, NULL, '2022-05-23 06:05:30', '2022-05-23 12:55:30', NULL, 1),
(11, 18, 1, NULL, '2022-05-23 06:05:19', '2022-05-23 12:57:19', NULL, 1),
(12, 18, 2, NULL, '2022-05-23 06:05:19', '2022-05-23 12:57:19', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_data_rekam_medik_penyakit`
--

CREATE TABLE `registrasi_data_rekam_medik_penyakit` (
  `id` int(100) NOT NULL,
  `id_rekam_medik` int(100) NOT NULL,
  `id_penyakit` int(100) NOT NULL,
  `keterangan` text DEFAULT '-',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(100) DEFAULT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registrasi_data_rekam_medik_penyakit`
--

INSERT INTO `registrasi_data_rekam_medik_penyakit` (`id`, `id_rekam_medik`, `id_penyakit`, `keterangan`, `date_created`, `date_updated`, `created_by`, `is_active`) VALUES
(1, 16, 2, 'epi', '2022-05-23 06:05:41', '2022-05-23 12:41:41', NULL, 1),
(2, 16, 3, 'kulit', '2022-05-23 06:05:41', '2022-05-23 12:41:41', NULL, 1),
(3, 17, 2, 'ep', '2022-05-23 06:05:30', '2022-05-23 12:55:30', NULL, 1),
(4, 17, 3, 'ku', '2022-05-23 06:05:30', '2022-05-23 12:55:30', NULL, 1),
(5, 18, 2, 'ep', '2022-05-23 06:05:19', '2022-05-23 12:57:19', NULL, 1),
(6, 18, 4, 'cwre', '2022-05-23 06:05:19', '2022-05-23 12:57:19', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_imunisasi`
--
ALTER TABLE `m_imunisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_penyakit`
--
ALTER TABLE `m_penyakit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_role`
--
ALTER TABLE `m_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi_data_anak`
--
ALTER TABLE `registrasi_data_anak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi_data_berkas`
--
ALTER TABLE `registrasi_data_berkas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi_data_orangtua`
--
ALTER TABLE `registrasi_data_orangtua`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi_data_rekam_medik`
--
ALTER TABLE `registrasi_data_rekam_medik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi_data_rekam_medik_imunisasi`
--
ALTER TABLE `registrasi_data_rekam_medik_imunisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi_data_rekam_medik_penyakit`
--
ALTER TABLE `registrasi_data_rekam_medik_penyakit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_imunisasi`
--
ALTER TABLE `m_imunisasi`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_penyakit`
--
ALTER TABLE `m_penyakit`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_role`
--
ALTER TABLE `m_role`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registrasi_data_anak`
--
ALTER TABLE `registrasi_data_anak`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registrasi_data_berkas`
--
ALTER TABLE `registrasi_data_berkas`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registrasi_data_orangtua`
--
ALTER TABLE `registrasi_data_orangtua`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registrasi_data_rekam_medik`
--
ALTER TABLE `registrasi_data_rekam_medik`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `registrasi_data_rekam_medik_imunisasi`
--
ALTER TABLE `registrasi_data_rekam_medik_imunisasi`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registrasi_data_rekam_medik_penyakit`
--
ALTER TABLE `registrasi_data_rekam_medik_penyakit`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

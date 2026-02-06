-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2026 at 03:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int NOT NULL,
  `nomor_induk` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jadwal_harian_id` bigint UNSIGNED DEFAULT NULL,
  `absen_at` timestamp NULL DEFAULT NULL,
  `kategori` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=jam_masuk, 2=istirahat_mulai, 3=istirahat_selesai, 4=pulang',
  `idmesin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `nomor_induk`, `jadwal_harian_id`, `absen_at`, `kategori`, `idmesin`, `updated_at`) VALUES
(1, '1', 1, '2026-01-22 19:28:05', '1', '1', '2026-01-22 19:28:05'),
(2, '1', 1, '2026-01-22 19:28:05', '4', '1', '2026-01-22 19:28:05'),
(3, '1', 1, '2026-01-22 19:28:05', '2', '1', '2026-01-22 19:28:05'),
(4, '1', 1, '2026-01-22 19:28:05', '3', '1', '2026-01-22 19:28:05'),
(5, '1', 1, '2026-01-22 19:28:05', '', '1', '2026-01-22 19:28:05'),
(151, '12329252', 1, '2026-01-22 19:28:05', '1', '1', '2026-01-22 19:28:05'),
(152, '12329252', 1, '2026-01-22 19:28:05', '1', '1', '2026-01-22 19:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `absensi_jadwal_harian`
--

CREATE TABLE `absensi_jadwal_harian` (
  `absensi_id` bigint UNSIGNED NOT NULL,
  `jadwal_harian_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi_jadwal_harian`
--

INSERT INTO `absensi_jadwal_harian` (`absensi_id`, `jadwal_harian_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(151, 1),
(152, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cabang_gedung`
--

CREATE TABLE `cabang_gedung` (
  `id` int UNSIGNED NOT NULL,
  `lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zona_waktu` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cabang_gedung`
--

INSERT INTO `cabang_gedung` (`id`, `lokasi`, `zona_waktu`, `aktif`) VALUES
(1, 'Cirebon', '1', '1'),
(2, 'Jakarta', '1', '1'),
(3, 'Ciamis', '1', '1'),
(5, 'Sholat Dhuhur', '1', '1'),
(6, 'Sumsel', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id` int NOT NULL,
  `nomor_induk` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id`, `nomor_induk`, `tanggal`) VALUES
(1, '1', '2024-11-18'),
(2, '1234', '2024-11-19'),
(3, '23456', '2024-11-19'),
(5, '23456', '2026-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `denda_master`
--

CREATE TABLE `denda_master` (
  `id` int UNSIGNED NOT NULL,
  `prioritas` int NOT NULL,
  `jenis` varchar(100) DEFAULT NULL,
  `per_menit` int DEFAULT NULL,
  `rupiah_pertama` int DEFAULT NULL,
  `rupiah_selanjutnya` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `denda_master`
--

INSERT INTO `denda_master` (`id`, `prioritas`, `jenis`, `per_menit`, `rupiah_pertama`, `rupiah_selanjutnya`) VALUES
(1, 1, 'Terlambat', 5, 1000, 500),
(2, 5, 'Tidak Hadir', 0, 50000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` int UNSIGNED NOT NULL,
  `hak` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `hak`) VALUES
(0, 'nusabot'),
(1, 'Full'),
(2, 'General');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_status`
--

CREATE TABLE `jabatan_status` (
  `id` bigint UNSIGNED NOT NULL,
  `jabatan_status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hak_akses` int UNSIGNED DEFAULT NULL,
  `aktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan_status`
--

INSERT INTO `jabatan_status` (`id`, `jabatan_status`, `hak_akses`, `aktif`) VALUES
(1, 'main', 0, '1'),
(2, 'Direktur', 1, '1'),
(3, 'HRD', 1, '1'),
(5, 'Office Boy', 2, '1'),
(7, 'Manger', 2, '1'),
(8, 'CEO', 1, '1'),
(9, 'CTO', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_harian`
--

CREATE TABLE `jadwal_harian` (
  `id` bigint UNSIGNED NOT NULL,
  `cabang_gedung_id` int UNSIGNED NOT NULL,
  `hari` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `libur` tinyint(1) NOT NULL DEFAULT '0',
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `istirahat1_mulai` time DEFAULT NULL,
  `istirahat1_selesai` time DEFAULT NULL,
  `istirahat2_mulai` time DEFAULT NULL,
  `istirahat2_selesai` time DEFAULT NULL,
  `keterangan` enum('libur','berangkat') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'berangkat',
  `absensi_id` bigint UNSIGNED NOT NULL,
  `jadwal_harian_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_harian`
--

INSERT INTO `jadwal_harian` (`id`, `cabang_gedung_id`, `hari`, `libur`, `jam_masuk`, `jam_pulang`, `istirahat1_mulai`, `istirahat1_selesai`, `istirahat2_mulai`, `istirahat2_selesai`, `keterangan`, `absensi_id`, `jadwal_harian_id`, `created_at`, `updated_at`) VALUES
(6, 1, 'Senin', 0, '08:00:00', '16:00:00', NULL, NULL, NULL, '08:33:00', 'berangkat', 0, 0, NULL, NULL),
(7, 1, 'Selasa', 0, '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(8, 1, 'Rabu', 0, '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(9, 1, 'Kamis', 0, '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(10, 1, 'Jumat', 0, '08:00:00', '16:00:00', NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(11, 2, 'Senin', 0, '02:00:00', '10:00:00', '06:00:00', '07:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(12, 2, 'Selasa', 0, '02:00:00', '10:00:00', '06:00:00', '07:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(13, 2, 'Rabu', 0, '02:00:00', '10:00:00', '06:00:00', '07:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(14, 2, 'Kamis', 0, '02:00:00', '10:00:00', '06:00:00', '07:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(15, 2, 'Jumat', 0, '02:00:00', '10:00:00', '06:00:00', '07:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(16, 3, 'Senin', 0, '01:00:00', '09:00:00', '05:00:00', '06:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(17, 3, 'Selasa', 0, '01:00:00', '09:00:00', '05:00:00', '06:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(18, 3, 'Rabu', 0, '01:00:00', '09:00:00', '05:00:00', '06:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(19, 3, 'Kamis', 0, '01:00:00', '09:00:00', '05:00:00', '06:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(20, 3, 'Jumat', 0, '01:00:00', '09:00:00', '05:00:00', '06:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(21, 5, 'Senin', 0, '05:00:00', '05:45:00', '17:00:00', '17:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(22, 5, 'Selasa', 0, '05:00:00', '05:45:00', '17:00:00', '17:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(23, 5, 'Rabu', 0, '05:00:00', '05:45:00', '17:00:00', '17:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(24, 5, 'Kamis', 0, '05:00:00', '05:45:00', '17:00:00', '17:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(25, 5, 'Jumat', 0, '05:00:00', '05:45:00', '17:00:00', '17:00:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(26, 6, 'Senin', 0, '00:30:00', '09:30:00', '05:00:00', '05:30:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(27, 6, 'Selasa', 0, '00:30:00', '09:30:00', '05:00:00', '05:30:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(28, 6, 'Rabu', 0, '00:30:00', '09:30:00', '05:00:00', '05:30:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(29, 6, 'Kamis', 0, '00:30:00', '09:30:00', '05:00:00', '05:30:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(30, 6, 'Jumat', 0, '00:30:00', '09:30:00', '05:00:00', '05:30:00', NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(31, 1, 'Sabtu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(32, 1, 'Minggu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(33, 2, 'Sabtu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(34, 2, 'Minggu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(35, 3, 'Sabtu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(36, 3, 'Minggu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(37, 5, 'Sabtu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(38, 5, 'Minggu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(39, 6, 'Sabtu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL),
(40, 6, 'Minggu', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'berangkat', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `libur_khusus`
--

CREATE TABLE `libur_khusus` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `libur_khusus`
--

INSERT INTO `libur_khusus` (`id`, `tanggal`, `keterangan`) VALUES
(1, '2024-11-21', 'Bos sedaang istirahat dirumha'),
(3, '2026-01-21', 'lari'),
(4, '2026-01-19', 'jalan');

-- --------------------------------------------------------

--
-- Table structure for table `mesin`
--

CREATE TABLE `mesin` (
  `id_mesin` int NOT NULL,
  `id_cabang_gedung` int UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idmesin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mesin`
--

INSERT INTO `mesin` (`id_mesin`, `id_cabang_gedung`, `keterangan`, `idmesin`) VALUES
(1, 1, 'Kesambi', '1');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '0001_01_01_000000_create_users_table', 1),
(5, '0001_01_01_000001_create_cache_table', 1),
(6, '0001_01_01_000002_create_jobs_table', 1),
(23, '2026_01_09_012259_create_jadwal_harian_table', 2),
(24, '2026_01_09_012619_migrate_jadwal_from_cabang_gedung', 2),
(25, '2026_01_12_020438_change_password_type_in_pengguna_table', 2),
(28, '2026_01_12_013913_alter_password_column_in_pengguna_table', 3),
(29, '2026_01_12_073747_add_fk_to_cuti_table', 3),
(30, '2026_01_22_065130_drop_old_columns_from_cabang_gedung', 4),
(32, '2026_01_22_073644_add_libur_column_to_jadwal_harian_table', 5),
(33, '2026_01_23_021411_change_jadwal_harian_id_to_nullable', 6),
(37, '2026_01_21_034021_update_pengguna_table_relations', 7),
(39, '2026_01_26_090000_standardize_fk_and_types', 8),
(40, '2026_01_26_101500_add_fk_absensi_jadwal_harian', 8),
(41, '2026_01_26_110000_create_absensi_jadwal_pivot', 9),
(42, '2026_01_23_022400_add_updated_at_column_to_absensi_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `nomor_induk` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_status` bigint UNSIGNED NOT NULL,
  `cabang_gedung` int UNSIGNED NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`nomor_induk`, `nama`, `tag`, `jabatan_status`, `cabang_gedung`, `password`, `aktif`) VALUES
('0', 'Nusabot.id', '', 1, 0, '$2y$12$eYEDlKEONVYoR91znHEw1etT2.SlEqng5hpIkZBIBu1EWsZJ/eCLi', '1'),
('0111111', 'Tegar 123', '11223344', 2, 3, '9549d400a68633435918290085f06293', '1'),
('0987654', 'putri', '0987654', 8, 2, '$2y$12$evEqBcOF3eHmzmRStOnX1O9Cmvei7BcTPNU18EeiEo4TmKYgFsLF.', '1'),
('1', 'pratama fahriel sanjaya', '73cba8aa', 2, 1, 'c4ca4238a0b923820dcc509a6f75849b', '1'),
('12228418', 'Muhammad Bintoro', '79603bd5', 2, 1, '2a372a408d5d7f2ddc30142b9fdc2563', '1'),
('123', 'hasta', '3755fe', 3, 1, '827ccb0eea8a706c4c34a16891f84e7b', '1'),
('12329252', 'Nuril Jannatii', 'accf695', 3, 1, '7a7a52fcbfa494a96604d4b2ddba79ec', '1'),
('1234', 'Fauzan Azhiman', 'e3dbfbb6', 5, 1, '81dc9bdb52d04dc20036dbd8313ed055', '1'),
('234556', 'riza', '234556', 7, 1, '$2y$12$Kf1NIljvltbfWTG6pZtGjO2kHJa1Encu7fGYjCS6r/lUndMTIK6aq', '1'),
('23456', 'Boya Rizky Agung', '98756fg', 7, 2, 'adcaec3805aa912c0d0b14a81bedb6ff', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bp73q0VEhmjo0T9ZDx2Sr9XtzHE66Db7MMCHjEMF', 0, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZGRzeU5tWU1VeldKVzZrYm4yVlFDa2RIbW9tbEhEcHZDMmt6ZDdjdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hYnNlbnNpIjtzOjU6InJvdXRlIjtzOjEzOiJhYnNlbnNpLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MToiMCI7fQ==', 1768271441);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_absensi_mesin` (`idmesin`),
  ADD KEY `absensi_nomor_induk_foreign` (`nomor_induk`),
  ADD KEY `absensi_jadwal_harian_id_index` (`jadwal_harian_id`);

--
-- Indexes for table `absensi_jadwal_harian`
--
ALTER TABLE `absensi_jadwal_harian`
  ADD PRIMARY KEY (`absensi_id`,`jadwal_harian_id`);

--
-- Indexes for table `cabang_gedung`
--
ALTER TABLE `cabang_gedung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_nomor_induk_foreign` (`nomor_induk`);

--
-- Indexes for table `denda_master`
--
ALTER TABLE `denda_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prioritas` (`prioritas`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan_status`
--
ALTER TABLE `jabatan_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jabatan_status_hak_akses_foreign` (`hak_akses`);

--
-- Indexes for table `jadwal_harian`
--
ALTER TABLE `jadwal_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_harian_cabang_gedung_id_foreign` (`cabang_gedung_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `libur_khusus`
--
ALTER TABLE `libur_khusus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id_mesin`),
  ADD UNIQUE KEY `mesin_idmesin_unique` (`idmesin`),
  ADD UNIQUE KEY `idmesin` (`idmesin`),
  ADD KEY `mesin_id_cabang_gedung_foreign` (`id_cabang_gedung`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`nomor_induk`),
  ADD KEY `pengguna_cabang_gedung_foreign` (`cabang_gedung`),
  ADD KEY `pengguna_jabatan_status_foreign` (`jabatan_status`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `denda_master`
--
ALTER TABLE `denda_master`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_harian`
--
ALTER TABLE `jadwal_harian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `libur_khusus`
--
ALTER TABLE `libur_khusus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id_mesin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_nomor_induk_foreign` FOREIGN KEY (`nomor_induk`) REFERENCES `pengguna` (`nomor_induk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_absensi_mesin` FOREIGN KEY (`idmesin`) REFERENCES `mesin` (`idmesin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jabatan_status`
--
ALTER TABLE `jabatan_status`
  ADD CONSTRAINT `jabatan_status_hak_akses_foreign` FOREIGN KEY (`hak_akses`) REFERENCES `hak_akses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

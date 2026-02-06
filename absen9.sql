-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250114.98b0d33571
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 02 Feb 2026 pada 04.20
-- Versi server: 8.0.30
-- Versi PHP: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absen9`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int NOT NULL,
  `nomor_induk` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `absen` datetime DEFAULT NULL,
  `absen_maks` datetime DEFAULT NULL,
  `kategori` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=jam_masuk, 2=istirahat_mulai, 3=istirahat_selesai, 4=pulang',
  `idmesin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `nomor_induk`, `absen`, `absen_maks`, `kategori`, `idmesin`) VALUES
(1, '1', '2026-01-23 02:28:05', '2026-01-23 08:00:00', '1', '4cebd61f8e57'),
(2, '1', '2026-01-23 02:28:05', '2026-01-23 17:00:00', '4', '4cebd61f8e57'),
(3, '1', '2026-01-23 02:28:05', '2026-01-23 12:00:00', '2', '4cebd61f8e57'),
(4, '1', '2026-01-23 02:28:05', '2026-01-23 13:00:00', '3', '4cebd61f8e57'),
(5, '1', '2026-01-23 02:28:05', '2026-01-23 08:00:00', '', '4cebd61f8e57'),
(151, '12329252', '2026-01-23 02:28:05', '2026-01-23 08:00:00', '1', '4cebd61f8e57'),
(152, '12329252', '2026-01-23 02:28:05', '2026-01-23 08:00:00', '1', '4cebd61f8e57'),
(154, '1', '2026-01-31 06:34:22', '2026-01-31 08:00:00', '1', '4cebd61f8e57'),
(213, '12329252', '2026-02-02 03:40:02', NULL, '1', '4cebd61f8e57'),
(214, '12329252', '2026-02-02 03:43:53', NULL, '1', '4cebd61f8e57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_backup_yyyymmdd`
--

CREATE TABLE `absensi_backup_yyyymmdd` (
  `id` int NOT NULL DEFAULT '0',
  `nomor_induk` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jadwal_harian_id` bigint UNSIGNED DEFAULT NULL,
  `absen_at` timestamp NULL DEFAULT NULL,
  `kategori` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=jam_masuk, 2=istirahat_mulai, 3=istirahat_selesai, 4=pulang',
  `idmesin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `absensi_backup_yyyymmdd`
--

INSERT INTO `absensi_backup_yyyymmdd` (`id`, `nomor_induk`, `jadwal_harian_id`, `absen_at`, `kategori`, `idmesin`, `updated_at`) VALUES
(1, '1', 1, '2026-01-22 19:28:05', '1', '1', '2026-01-22 19:28:05'),
(2, '1', 1, '2026-01-22 19:28:05', '4', '1', '2026-01-22 19:28:05'),
(3, '1', 1, '2026-01-22 19:28:05', '2', '1', '2026-01-22 19:28:05'),
(4, '1', 1, '2026-01-22 19:28:05', '3', '1', '2026-01-22 19:28:05'),
(5, '1', 1, '2026-01-22 19:28:05', '', '1', '2026-01-22 19:28:05'),
(151, '12329252', 1, '2026-01-22 19:28:05', '1', '1', '2026-01-22 19:28:05'),
(152, '12329252', 1, '2026-01-22 19:28:05', '1', '1', '2026-01-22 19:28:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cabang_gedung`
--

CREATE TABLE `cabang_gedung` (
  `id` int UNSIGNED NOT NULL,
  `lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `istirahat_mulai` time NOT NULL,
  `istirahat_selesai` time NOT NULL,
  `hari_libur` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zona_waktu` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cabang_gedung`
--

INSERT INTO `cabang_gedung` (`id`, `lokasi`, `jam_masuk`, `jam_pulang`, `istirahat_mulai`, `istirahat_selesai`, `hari_libur`, `zona_waktu`, `aktif`) VALUES
(1, 'Cirebon', '07:30:00', '16:30:00', '11:30:00', '12:30:00', '0,6', '1', '1'),
(2, 'Jakarta', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '', '1', '1'),
(3, 'Ciamis', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '0,6', '1', '1'),
(5, 'Sholat Dhuhur', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '', '1', '1'),
(6, 'Sumsel', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '', '1', '1'),
(7, 'smkn 2 jamet', '07:30:00', '15:30:00', '12:30:00', '13:00:00', '0,6', '1', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id` int NOT NULL,
  `nomor_induk` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cuti`
--

INSERT INTO `cuti` (`id`, `nomor_induk`, `tanggal`) VALUES
(1, '1', '2024-11-18'),
(2, '1234', '2024-11-19'),
(3, '23456', '2024-11-19'),
(5, '23456', '2026-01-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `denda_master`
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
-- Dumping data untuk tabel `denda_master`
--

INSERT INTO `denda_master` (`id`, `prioritas`, `jenis`, `per_menit`, `rupiah_pertama`, `rupiah_selanjutnya`) VALUES
(1, 1, 'Terlambat', 5, 1000, 500),
(2, 5, 'Tidak Hadir', 0, 50000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` int UNSIGNED NOT NULL,
  `hak` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `hak`) VALUES
(0, 'nusabot'),
(1, 'nusabot'),
(2, 'full'),
(3, 'general');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan_status`
--

CREATE TABLE `jabatan_status` (
  `id` int UNSIGNED NOT NULL,
  `jabatan_status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hak_akses` int UNSIGNED NOT NULL,
  `aktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jabatan_status`
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
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `libur_khusus`
--

CREATE TABLE `libur_khusus` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `libur_khusus`
--

INSERT INTO `libur_khusus` (`id`, `tanggal`, `keterangan`) VALUES
(1, '2024-11-21', 'Bos sedaang istirahat dirumha'),
(3, '2026-01-21', 'lari'),
(4, '2026-01-19', 'jalan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mesin`
--

CREATE TABLE `mesin` (
  `id_mesin` int NOT NULL,
  `id_cabang_gedung` int UNSIGNED NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idmesin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mesin`
--

INSERT INTO `mesin` (`id_mesin`, `id_cabang_gedung`, `keterangan`, `idmesin`) VALUES
(1, 1, 'Kesambi', '4cebd61f8e57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
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
(42, '2026_01_23_022400_add_updated_at_column_to_absensi_table', 10),
(43, '2026_01_28_023731_update_pengguna_table_relations', 11),
(44, '2026_01_29_add_general_hak_akses', 11),
(45, '2026_01_29_fix_hak_akses_values', 11),
(46, '2026_01_29_update_hak_akses_values', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `nomor_induk` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_status` int UNSIGNED NOT NULL,
  `cabang_gedung` int UNSIGNED NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`nomor_induk`, `nama`, `tag`, `jabatan_status`, `cabang_gedung`, `password`, `aktif`) VALUES
('0', 'Nusabot.id', '', 1, 0, '$2y$12$eYEDlKEONVYoR91znHEw1etT2.SlEqng5hpIkZBIBu1EWsZJ/eCLi', '1'),
('0111111', 'Tegar 123', '11223344', 2, 3, '9549d400a68633435918290085f06293', '1'),
('0987654', 'putri', '0987654', 8, 2, '$2y$12$evEqBcOF3eHmzmRStOnX1O9Cmvei7BcTPNU18EeiEo4TmKYgFsLF.', '1'),
('1', 'pratama fahriel sanjaya', '73cba8aa', 2, 1, 'c4ca4238a0b923820dcc509a6f75849b', '1'),
('12228418', 'Muhammad Bintoro', '79603bd5', 2, 1, '2a372a408d5d7f2ddc30142b9fdc2563', '1'),
('123', 'hasta', '3755fe', 3, 1, '827ccb0eea8a706c4c34a16891f84e7b', '1'),
('12329252', 'Nuril Jannatii', 'accf6905', 3, 1, '7a7a52fcbfa494a96604d4b2ddba79ec', '1'),
('1234', 'Fauzan Azhiman', 'e3dbfbb6', 5, 1, '81dc9bdb52d04dc20036dbd8313ed055', '1'),
('234556', 'riza', '234556', 7, 1, '$2y$12$Kf1NIljvltbfWTG6pZtGjO2kHJa1Encu7fGYjCS6r/lUndMTIK6aq', '1'),
('23456', 'Boya Rizky Agung', '98756fg', 7, 2, 'adcaec3805aa912c0d0b14a81bedb6ff', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0uU6tmn8HUiqvoLobgyfHi7Ya6vk9HECRHxs5ZaV', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1FHcDMwM0xwZzFubzJvMDBoRDF6RDAwTERUNmdoV3BBTXk0OTdFbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTA6Imh0dHA6Ly8xOTIuMTY4LjEuMTEzL0Fic2VuX09ubGluZS9wdWJsaWMvYWJzZW5zaS1tYWNoaW5lP2lkbWVzaW49MSZrYXRlZ29yaT0xJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002695),
('5QVBMpKUbh6cYj72kfWGsVhf3aeoUN6Bkx59jw9v', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRm5FNGx4eElJQUh1TXFTNktHRVlnQUhYNlJ2eEdJeTNqUlZnZWNFSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002533),
('78fdW12k5TEt0aknLoiPl18noC1q742Qq3JiiHEs', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkZzOEdSVGpmTllhN3NVVXVhZnZaaFdLRWl6TTI4N09kd2lRS0JDWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002531),
('a6HJmlofxHygSYPKqVEzkZdpOlnIQAKFSdGSrrVH', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkJMUlNhbG1rdlpRZEpIQzMwZUNWVGl4RWk3WFdSVXY4Q1MzRnE5biI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002445),
('bT5e9nCdM3HjnG7kpYEWyqJjyZWKlH4cPC9nRS10', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoienBmMWM1elgyMXNsYzlmREh3S2RKTnhBSXVnZEVKM3JTeGx3ZmlVbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003602),
('bVAC2v9fG1Gf8kt7pXxQl7EgVpmXozIdg0jJzC7E', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaG5MbGFJMkFCSnV4REhyVlcyMHFMNmlkVmRlVEpGMDY3NHBPTlNaVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTA6Imh0dHA6Ly8xOTIuMTY4LjEuMTEzL0Fic2VuX09ubGluZS9wdWJsaWMvYWJzZW5zaS1tYWNoaW5lP2lkbWVzaW49MSZrYXRlZ29yaT0yJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002780),
('CGEqYLPZ8VU20Pj92QLNAquAlsMxdCCWTAQipblA', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUWQ1SldJcTVqOVhyM2R2Yk1QZGRyakVUOFRMVkRzMDJ2cWxGUGJ3OCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003558),
('eOZUwk4cAB8mYHw3tHXzPAD456SE3PtWTpTmZ1fu', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWI5Z2tOOFltamlweGdoR3lnb0hGQzB0dzJac3d3eGZGWHJSWmVodyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003833),
('Ga2ZMlcX9oMp8pQL5Qy1yTc48Asi9Ts15uSVG7ho', NULL, '192.168.1.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUHVmRkVPTVNrZkR5aTRVNWxFSGQ1Q2JUWnB2TjZWQ29VS0ZRbDVCdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003543),
('GMrhtoOPo8986RzUJP06ibaL7Zv3NaCBmjIWn6N1', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWt5MjN1UXR2aldoU0tyQnZHdk9rZERHSW5yVnlFQW9jM1JTMmlGZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003827),
('HUknpyMYM0QoPbU8GzDWWEruuSsULpLS2NyjQGAX', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkN1bHVQdHFubUdXQjJ0WkhIMUlYRWpORDF4UXlYczJwaUxTemFtaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002467),
('iyRs2CmbPN0BVuF85cNA7Ep679eHzK8GhhWK2OVe', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaE5ONDhvSkJmVkxRTTBLeEFVRUEzYlA5ZDJESmtLckdPcXo2QXQ5eCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002608),
('lX9dWFy1PWM1MVQNj9h4mtiD4oqj4NgnsLVSk3xU', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidmpIbzl3ZFIzZ3hzMUtrT1JDck9XbVduN2FsV1hkWHJPVDlueFdSWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTA6Imh0dHA6Ly8xOTIuMTY4LjEuMTEzL0Fic2VuX09ubGluZS9wdWJsaWMvYWJzZW5zaS1tYWNoaW5lP2lkbWVzaW49MSZrYXRlZ29yaT0xJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002702),
('mq3v5W8m8CCHBxPDtqMJmOdRId8TOgROWj2bRFZI', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNVhCWEJBVWhJbVFwUGF4WDRSZzhBTTJLREhOelFRcGxYSEpNY1B2UCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTA6Imh0dHA6Ly8xOTIuMTY4LjEuMTEzL0Fic2VuX09ubGluZS9wdWJsaWMvYWJzZW5zaS1tYWNoaW5lP2lkbWVzaW49MSZrYXRlZ29yaT0yJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002722),
('nx4Xw68147JFQJw0sdqoJpSXUvyJwTZq5MmDJTf9', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkl1VUZSUVZOdFBXTFBBalBTQ1JuMU1VNTBTc0hvY2d3elpmSWdJayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003825),
('obBVnRCiUz4JSnGRo6J2pO6iAnjZBqHPtS2UmZgq', 0, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWjVZa20wRzA5MEk0NVFuQTdrZUlwbTVIQ1MxVU16QVJ5ekc0S242WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZXNpbi8xL2VkaXQiO3M6NToicm91dGUiO3M6MTA6Im1lc2luLmVkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czoxOiIwIjt9', 1770003313),
('p8nWZYwvMrGPGbmsSAaxmdAlw6llx9Ya7TpKBls4', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWDBSSzlZWG4wZUc5ejI2N3FNVzNucWlWOHA4UFFRWWZzZk92d3RveiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002445),
('PCKovTYyXZLdihViOHiV0K6NlZQds1kQohRS9v9H', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnYwb2JwVWI5c0p6dEJzMHJybnZyemh0WHNSUEt4d1Z4VFpiamQ3byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003832),
('qM4DYcsoJm6MD3ydqUg8Xx6IWMl96aiPaNus2xZj', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTBScW5RV3lGamFIQ3dxWmZFUW16Y2JncmVZTHo4YU5abUFVWmIwRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003826),
('QPMsXVfwxEdAgkXwtxsoqePX8oo546DEzwtrEAaC', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNVh6NFNsT0JnUlZTUUpjRlZ0d2g4OE8xV3hTMTRSTkJuaGN1b3RoaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002465),
('skYPjxkPGRzJcX297lYf93ryOXJYb56WshRm77AA', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVNXdWpIU2FWT1puY1YxdG9SYkJxUTlXM0VPYUdZSThiSUx0Z3RzZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002457),
('sztfHSB5yRkA65uidPrbm9g6HL6DRbGwKP4ptr1u', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2lpcnZ3eVY3UHhBT3Zsc0gxSDRIaVYyMWhyQlczQnBMS1lrS2hlUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTA6Imh0dHA6Ly8xOTIuMTY4LjEuMTEzL0Fic2VuX09ubGluZS9wdWJsaWMvYWJzZW5zaS1tYWNoaW5lP2lkbWVzaW49MSZrYXRlZ29yaT0xJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002692),
('ufShwIgKmlQhUwGtLL3MluZaQfxMGAx3RxPPafj7', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMG5lOXk3R3FpWmFTSGtLS09DRTRvakt0UnBqbXI5c202cjJuVlhvRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0xJnRhZz1iZWY0NmQwNiI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770003840),
('vCDMmKKalsWoGpfUJDbBrKPhVxcfuyp6Ibgqb0dI', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibEREUmhqRXY3ZnJ0bjZPVmYzQWk5eGN0bXpsajlqdDh1a1ZZSEVpcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002616),
('Wod8HLep9du9xIKSwZqbUOAnGpR36AitYdqDMjAQ', NULL, '192.168.1.197', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlhIWU9MUFVNM0x3cFIzSWx1aDVlVmk4VW9aWUpBVTV5RElMbkRTVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTAxOiJodHRwOi8vMTkyLjE2OC4xLjExMy9BYnNlbl9PbmxpbmUvcHVibGljL2Fic2Vuc2ktbWFjaGluZT9pZG1lc2luPTRjZWJkNjFmOGU1NyZrYXRlZ29yaT0yJnRhZz1hY2NmNjkwNSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770002501);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_absensi_mesin` (`idmesin`),
  ADD KEY `absensi_nomor_induk_foreign` (`nomor_induk`);

--
-- Indeks untuk tabel `cabang_gedung`
--
ALTER TABLE `cabang_gedung`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_nomor_induk_foreign` (`nomor_induk`);

--
-- Indeks untuk tabel `denda_master`
--
ALTER TABLE `denda_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prioritas` (`prioritas`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan_status`
--
ALTER TABLE `jabatan_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jabatan_status_hak_akses_foreign` (`hak_akses`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `libur_khusus`
--
ALTER TABLE `libur_khusus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id_mesin`),
  ADD UNIQUE KEY `mesin_idmesin_unique` (`idmesin`),
  ADD UNIQUE KEY `idmesin` (`idmesin`),
  ADD KEY `mesin_id_cabang_gedung_foreign` (`id_cabang_gedung`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`nomor_induk`),
  ADD KEY `pengguna_cabang_gedung_foreign` (`cabang_gedung`),
  ADD KEY `pengguna_jabatan_status_foreign` (`jabatan_status`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT untuk tabel `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `denda_master`
--
ALTER TABLE `denda_master`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `libur_khusus`
--
ALTER TABLE `libur_khusus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id_mesin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_nomor_induk_foreign` FOREIGN KEY (`nomor_induk`) REFERENCES `pengguna` (`nomor_induk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_absensi_mesin` FOREIGN KEY (`idmesin`) REFERENCES `mesin` (`idmesin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_nomor_induk_foreign` FOREIGN KEY (`nomor_induk`) REFERENCES `pengguna` (`nomor_induk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jabatan_status`
--
ALTER TABLE `jabatan_status`
  ADD CONSTRAINT `jabatan_status_hak_akses_foreign` FOREIGN KEY (`hak_akses`) REFERENCES `hak_akses` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mesin`
--
ALTER TABLE `mesin`
  ADD CONSTRAINT `mesin_id_cabang_gedung_foreign` FOREIGN KEY (`id_cabang_gedung`) REFERENCES `cabang_gedung` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_cabang_gedung_foreign` FOREIGN KEY (`cabang_gedung`) REFERENCES `cabang_gedung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengguna_jabatan_status_foreign` FOREIGN KEY (`jabatan_status`) REFERENCES `jabatan_status` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

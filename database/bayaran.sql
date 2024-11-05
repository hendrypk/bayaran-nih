-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 05 Nov 2024 pada 16.47
-- Versi server: 10.5.25-MariaDB-cll-lve
-- Versi PHP: 8.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sips4226_dev-bayaran`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"group_name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:52:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"view overtime\";s:1:\"c\";s:8:\"overtime\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:15:\"create overtime\";s:1:\"c\";s:8:\"overtime\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:15:\"update overtime\";s:1:\"c\";s:8:\"overtime\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"create employee\";s:1:\"c\";s:8:\"employee\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:15:\"update employee\";s:1:\"c\";s:8:\"employee\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:15:\"delete employee\";s:1:\"c\";s:8:\"employee\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:13:\"view employee\";s:1:\"c\";s:8:\"employee\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:15:\"create presence\";s:1:\"c\";s:8:\"presence\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"update presence\";s:1:\"c\";s:8:\"presence\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"delete presence\";s:1:\"c\";s:8:\"presence\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:13:\"view presence\";s:1:\"c\";s:8:\"presence\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:21:\"view presence summary\";s:1:\"c\";s:16:\"presence summary\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"presence export\";s:1:\"c\";s:15:\"presence export\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:23:\"export presence summary\";s:1:\"c\";s:16:\"presence summary\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:10:\"create kpi\";s:1:\"c\";s:3:\"kpi\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:10:\"update kpi\";s:1:\"c\";s:3:\"kpi\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:10:\"delete kpi\";s:1:\"c\";s:3:\"kpi\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:8:\"view kpi\";s:1:\"c\";s:3:\"kpi\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:9:\"create pa\";s:1:\"c\";s:9:\"appraisal\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:9:\"update pa\";s:1:\"c\";s:9:\"appraisal\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:9:\"delete pa\";s:1:\"c\";s:9:\"appraisal\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:7:\"view pa\";s:1:\"c\";s:9:\"appraisal\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:7:\"view pm\";s:1:\"c\";s:19:\"performance options\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:10:\"export-kpi\";s:1:\"c\";s:14:\"employee grade\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:9:\"export-pa\";s:1:\"c\";s:14:\"employee grade\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:18:\"export-final-grade\";s:1:\"c\";s:14:\"employee grade\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:9:\"create pm\";s:1:\"c\";s:19:\"performance options\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:9:\"update pm\";s:1:\"c\";s:19:\"performance options\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:9:\"delete pm\";s:1:\"c\";s:19:\"performance options\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:19:\"view employee grade\";s:1:\"c\";s:14:\"employee grade\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:12:\"create sales\";s:1:\"c\";s:5:\"sales\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"update sales\";s:1:\"c\";s:5:\"sales\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"delete sales\";s:1:\"c\";s:5:\"sales\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:10:\"view sales\";s:1:\"c\";s:5:\"sales\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:14:\"create options\";s:1:\"c\";s:7:\"options\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"update options\";s:1:\"c\";s:7:\"options\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"delete options\";s:1:\"c\";s:7:\"options\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:12:\"view options\";s:1:\"c\";s:7:\"options\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:19:\"create work pattern\";s:1:\"c\";s:12:\"work pattern\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:19:\"update work pattern\";s:1:\"c\";s:12:\"work pattern\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:5:{s:1:\"a\";i:41;s:1:\"b\";s:19:\"delete work pattern\";s:1:\"c\";s:12:\"work pattern\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:5:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"view work pattern\";s:1:\"c\";s:12:\"work pattern\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:5:{s:1:\"a\";i:43;s:1:\"b\";s:15:\"delete overtime\";s:1:\"c\";s:8:\"overtime\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:11:\"create user\";s:1:\"c\";s:4:\"user\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:11:\"update user\";s:1:\"c\";s:4:\"user\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:11:\"delete user\";s:1:\"c\";s:4:\"user\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:9:\"view user\";s:1:\"c\";s:4:\"user\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:11:\"create role\";s:1:\"c\";s:4:\"role\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:11:\"update role\";s:1:\"c\";s:4:\"role\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:5:{s:1:\"a\";i:50;s:1:\"b\";s:11:\"delete role\";s:1:\"c\";s:4:\"role\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:5:{s:1:\"a\";i:51;s:1:\"b\";s:9:\"view role\";s:1:\"c\";s:4:\"role\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:5:{s:1:\"a\";i:52;s:1:\"b\";s:15:\"overtime export\";s:1:\"c\";s:15:\"presence export\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"administrator\";s:1:\"d\";s:3:\"web\";}}}', 1730885456);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `domicile` varchar(255) NOT NULL,
  `place_birth` varchar(255) NOT NULL,
  `date_birth` date DEFAULT NULL,
  `blood_type` varchar(50) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `religion` varchar(15) NOT NULL,
  `marriage` varchar(25) NOT NULL,
  `education` varchar(25) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `bank_number` varchar(255) NOT NULL,
  `position_id` int(11) NOT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `joining_date` date NOT NULL,
  `calendar_id` int(11) DEFAULT NULL,
  `work_day_id` int(11) DEFAULT NULL,
  `employee_status` varchar(255) NOT NULL,
  `sales_status` int(11) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `kpi_id` int(11) DEFAULT NULL,
  `bobot_kpi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_office_location`
--

CREATE TABLE `employee_office_location` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `office_location_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_status`
--

CREATE TABLE `employee_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_work_day`
--

CREATE TABLE `employee_work_day` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `work_day_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `grade_kpis`
--

CREATE TABLE `grade_kpis` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `indicator_id` int(11) NOT NULL,
  `achievement` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `grade_pas`
--

CREATE TABLE `grade_pas` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `appraisal_id` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_titles`
--

CREATE TABLE `job_titles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `section` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'AppModelsUser', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `office_locations`
--

CREATE TABLE `office_locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `radius` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `overtimes`
--

CREATE TABLE `overtimes` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_at` time NOT NULL,
  `end_at` time DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `performance_appraisals`
--

CREATE TABLE `performance_appraisals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `performance_kpis`
--

CREATE TABLE `performance_kpis` (
  `id` int(11) NOT NULL,
  `kpi_id` int(11) NOT NULL,
  `aspect` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `bobot` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `performance_kpi_name`
--

CREATE TABLE `performance_kpi_name` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view overtime', 'overtime', 'web', '2024-11-04 07:32:53', '2024-11-04 07:32:53'),
(2, 'create overtime', 'overtime', 'web', '2024-11-04 07:32:53', '2024-11-04 07:32:53'),
(3, 'update overtime', 'overtime', 'web', '2024-11-04 08:11:52', '2024-11-04 08:11:52'),
(4, 'create employee', 'employee', 'web', '2024-11-04 08:52:37', '2024-11-04 08:52:37'),
(5, 'update employee', 'employee', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(6, 'delete employee', 'employee', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(7, 'view employee', 'employee', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(8, 'create presence', 'presence', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(9, 'update presence', 'presence', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(10, 'delete presence', 'presence', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(11, 'view presence', 'presence', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(12, 'view presence summary', 'presence summary', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(13, 'presence export', 'presence export', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(14, 'export presence summary', 'presence summary', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(15, 'create kpi', 'kpi', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(16, 'update kpi', 'kpi', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(17, 'delete kpi', 'kpi', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(18, 'view kpi', 'kpi', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(19, 'create pa', 'appraisal', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(20, 'update pa', 'appraisal', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(21, 'delete pa', 'appraisal', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(22, 'view pa', 'appraisal', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(23, 'view pm', 'performance options', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(24, 'export-kpi', 'employee grade', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(25, 'export-pa', 'employee grade', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(26, 'export-final-grade', 'employee grade', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(27, 'create pm', 'performance options', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(28, 'update pm', 'performance options', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(29, 'delete pm', 'performance options', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(30, 'view employee grade', 'employee grade', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(31, 'create sales', 'sales', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(32, 'update sales', 'sales', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(33, 'delete sales', 'sales', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(34, 'view sales', 'sales', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(35, 'create options', 'options', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(36, 'update options', 'options', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(37, 'delete options', 'options', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(38, 'view options', 'options', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(39, 'create work pattern', 'work pattern', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(40, 'update work pattern', 'work pattern', 'web', '2024-11-04 08:52:38', '2024-11-04 08:52:38'),
(41, 'delete work pattern', 'work pattern', 'web', '2024-11-04 08:52:39', '2024-11-04 08:52:39'),
(42, 'view work pattern', 'work pattern', 'web', '2024-11-04 08:52:39', '2024-11-04 08:52:39'),
(43, 'delete overtime', 'overtime', 'web', NULL, NULL),
(44, 'create user', 'user', 'web', '2024-11-05 07:12:37', '2024-11-05 07:12:37'),
(45, 'update user', 'user', 'web', '2024-11-05 07:12:37', '2024-11-05 07:12:37'),
(46, 'delete user', 'user', 'web', '2024-11-05 07:12:37', '2024-11-05 07:12:37'),
(47, 'view user', 'user', 'web', '2024-11-05 07:12:37', '2024-11-05 07:12:37'),
(48, 'create role', 'role', 'web', '2024-11-05 07:12:37', '2024-11-05 07:12:37'),
(49, 'update role', 'role', 'web', '2024-11-05 07:12:37', '2024-11-05 07:12:37'),
(50, 'delete role', 'role', 'web', '2024-11-05 07:12:38', '2024-11-05 07:12:38'),
(51, 'view role', 'role', 'web', '2024-11-05 07:12:38', '2024-11-05 07:12:38'),
(52, 'overtime export', 'presence export', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `presences`
--

CREATE TABLE `presences` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `eid` varchar(255) NOT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `work_day_id` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `check_in` time NOT NULL,
  `late_arrival` int(11) NOT NULL DEFAULT 0,
  `late_check_in` int(11) NOT NULL DEFAULT 0,
  `check_out` time DEFAULT NULL,
  `check_out_early` int(11) DEFAULT NULL,
  `note_in` varchar(255) DEFAULT NULL,
  `note_out` varchar(255) DEFAULT NULL,
  `photo_in` varchar(255) DEFAULT NULL,
  `photo_out` varchar(255) DEFAULT NULL,
  `location_in` varchar(255) DEFAULT NULL,
  `location_out` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'web', '2024-11-05 08:48:27', '2024-11-05 08:48:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_persons`
--

CREATE TABLE `sales_persons` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`, `remember_token`) VALUES
(1, 'administrator', 'administrator', 'admin@bayaran.id', '$2y$12$EVZxmXfMQRqjyY/viNSZ2O417EnMmZkWbYEiE/K1PZAqVpFTUX4cK', '2024-11-05 08:51:37', '2024-11-05 08:51:37', '2024-11-05 08:51:37', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `work_calendar`
--

CREATE TABLE `work_calendar` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `jan` int(11) NOT NULL,
  `feb` int(11) NOT NULL,
  `mar` int(11) NOT NULL,
  `apr` int(11) NOT NULL,
  `may` int(11) NOT NULL,
  `jun` int(11) NOT NULL,
  `jul` int(11) NOT NULL,
  `aug` int(11) NOT NULL,
  `sep` int(11) NOT NULL,
  `oct` int(11) NOT NULL,
  `nov` int(11) NOT NULL,
  `dec` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `work_days`
--

CREATE TABLE `work_days` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  `day_off` int(11) NOT NULL,
  `tolerance` int(11) DEFAULT NULL,
  `arrival` time DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `break` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted)at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `work_schedules`
--

CREATE TABLE `work_schedules` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `arrival` time NOT NULL,
  `start_at` time NOT NULL,
  `end_at` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

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
-- Indeks untuk tabel `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department` (`name`);

--
-- Indeks untuk tabel `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `division` (`name`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eid` (`eid`);

--
-- Indeks untuk tabel `employee_office_location`
--
ALTER TABLE `employee_office_location`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_status`
--
ALTER TABLE `employee_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_status` (`name`);

--
-- Indeks untuk tabel `employee_work_day`
--
ALTER TABLE `employee_work_day`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `work_day_id` (`work_day_id`);

--
-- Indeks untuk tabel `grade_kpis`
--
ALTER TABLE `grade_kpis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `grade_pas`
--
ALTER TABLE `grade_pas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `job_titles`
--
ALTER TABLE `job_titles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_title` (`name`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `office_locations`
--
ALTER TABLE `office_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `performance_appraisals`
--
ALTER TABLE `performance_appraisals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appraisal` (`name`);

--
-- Indeks untuk tabel `performance_kpis`
--
ALTER TABLE `performance_kpis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`aspect`);

--
-- Indeks untuk tabel `performance_kpi_name`
--
ALTER TABLE `performance_kpi_name`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `position` (`name`);

--
-- Indeks untuk tabel `presences`
--
ALTER TABLE `presences`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sales_persons`
--
ALTER TABLE `sales_persons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eid` (`employee_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `work_days`
--
ALTER TABLE `work_days`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_office_location`
--
ALTER TABLE `employee_office_location`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_status`
--
ALTER TABLE `employee_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `employee_work_day`
--
ALTER TABLE `employee_work_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `grade_kpis`
--
ALTER TABLE `grade_kpis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `grade_pas`
--
ALTER TABLE `grade_pas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `job_titles`
--
ALTER TABLE `job_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `office_locations`
--
ALTER TABLE `office_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `performance_appraisals`
--
ALTER TABLE `performance_appraisals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `performance_kpis`
--
ALTER TABLE `performance_kpis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `performance_kpi_name`
--
ALTER TABLE `performance_kpi_name`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `presences`
--
ALTER TABLE `presences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `work_days`
--
ALTER TABLE `work_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

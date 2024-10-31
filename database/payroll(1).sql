-- phpMyAdmin SQL Dump
-- version 5.2.1-4.fc40
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2024 at 06:30 AM
-- Server version: 8.4.2
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sales', '2024-09-22 06:26:02', '2024-09-22 06:26:02', '2024-09-22 06:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Hospitality', '2024-09-22 06:25:57', '2024-09-22 06:25:57', '2024-09-22 06:25:57');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `eid` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `position_id` int NOT NULL,
  `job_title_id` int DEFAULT NULL,
  `division_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `joining_date` date NOT NULL,
  `calendar_id` int DEFAULT NULL,
  `work_day_id` int DEFAULT NULL,
  `employee_status` varchar(255) NOT NULL,
  `sales_status` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `eid`, `email`, `username`, `password`, `name`, `city`, `position_id`, `job_title_id`, `division_id`, `department_id`, `joining_date`, `calendar_id`, `work_day_id`, `employee_status`, `sales_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(63, 1063, '', '1063', '1063', 'Frey', 'Sleman', 1, 1, 1, 1, '2024-09-24', NULL, NULL, 'Contract', 1, '2024-09-24 08:25:27', '2024-09-26 09:08:27', '2024-09-24 08:25:27'),
(64, 2064, 'hendryputra934@gmail.com', '1064', '$2y$12$QG/5XQ4e8VgMlAOyklQaP.7/kGjNHlOwZkUIDKVou23FUcumQi5Ae', 'Hendry', 'Slemann', 1, 2, 1, 1, '2024-09-24', NULL, NULL, 'Contract', 1, '2024-09-24 08:27:34', '2024-09-26 09:10:58', '2024-09-24 08:27:34'),
(65, 2065, '', '2065', '8888', 'Srrri', 'Sleman', 2, 2, 1, 1, '2024-09-26', 9, NULL, 'Contract', 0, '2024-09-26 09:26:00', '2024-09-26 09:26:00', '2024-09-26 09:26:00'),
(66, 2066, '', '2066', '$2y$12$nin7nQjKAmQ2qmDJPCxiv.splTs2cKC12Ro7DyIArDm1gl.5mIiQa', 'Cek User', 'cek', 2, 2, 1, 1, '2024-09-12', 9, NULL, 'Contract', 0, '2024-09-26 09:34:09', '2024-09-26 09:34:09', '2024-09-26 09:34:09'),
(67, 2067, '', '2067', '$2y$12$sDwZE4GwPOt4gYDfSGJdqO/J1FSi.R9L2.qYz8FtDlqw.dgYO6G9y', 'Lagi Lagi', 'Sleman', 2, 2, 1, 1, '2024-09-12', 9, NULL, 'Contract', 1, '2024-09-26 09:44:18', '2024-09-26 09:44:18', '2024-09-26 09:44:18'),
(68, 1068, '', '1068', '$2y$12$lHKAEHqQrv0s.hmZO0.RgOx547e7F4E6fxyOV0yw2RyZWegx1cSse', 'Hendry PK', 'Secang', 1, 1, NULL, NULL, '2024-10-04', NULL, NULL, 'Contract', 1, '2024-09-27 02:38:16', '2024-09-28 14:24:27', '2024-09-27 02:38:16');

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

CREATE TABLE `employee_status` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_status`
--

INSERT INTO `employee_status` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Contract', '2024-09-22 06:26:10', '2024-09-22 06:26:10', '2024-09-22 06:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `employee_work_day`
--

CREATE TABLE `employee_work_day` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `work_day_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_work_day`
--

INSERT INTO `employee_work_day` (`id`, `employee_id`, `work_day_id`, `created_at`, `updated_at`) VALUES
(49, 64, 16, '2024-09-24 08:51:16', '2024-09-24 08:51:16'),
(50, 63, 9, '2024-09-24 08:53:42', '2024-09-24 08:53:42'),
(51, 63, 16, '2024-09-24 08:53:42', '2024-09-24 08:53:42'),
(52, 64, 23, '2024-09-25 03:41:29', '2024-09-25 03:41:29'),
(53, 65, 9, '2024-09-26 09:26:00', '2024-09-26 09:26:00'),
(54, 65, 16, '2024-09-26 09:26:00', '2024-09-26 09:26:00'),
(55, 65, 23, '2024-09-26 09:26:00', '2024-09-26 09:26:00'),
(56, 66, 9, '2024-09-26 09:34:09', '2024-09-26 09:34:09'),
(57, 67, 23, '2024-09-26 09:44:18', '2024-09-26 09:44:18'),
(63, 68, 44, '2024-09-29 16:00:32', '2024-09-29 16:00:32'),
(64, 68, 9, '2024-10-02 02:44:05', '2024-10-02 02:44:05'),
(65, 68, 16, '2024-10-02 02:44:05', '2024-10-02 02:44:05'),
(66, 68, 23, '2024-10-02 02:44:05', '2024-10-02 02:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `grade_kpis`
--

CREATE TABLE `grade_kpis` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `indicator_id` int NOT NULL,
  `achievement` int NOT NULL,
  `grade` int NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_kpis`
--

INSERT INTO `grade_kpis` (`id`, `employee_id`, `indicator_id`, `achievement`, `grade`, `month`, `year`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 63, 286, 23, 18, 'September', 2024, '2024-09-26 03:52:21', '2024-09-26 04:01:59', '2024-09-26 03:52:21'),
(10, 63, 287, 20, 4, 'September', 2024, '2024-09-26 03:52:21', '2024-09-26 04:01:59', '2024-09-26 03:52:21'),
(11, 63, 288, 1, 5, 'September', 2024, '2024-09-26 03:52:21', '2024-09-26 04:01:59', '2024-09-26 03:52:21'),
(12, 63, 289, 50, 15, 'September', 2024, '2024-09-26 03:52:21', '2024-09-26 04:01:59', '2024-09-26 03:52:21'),
(13, 63, 290, 45, 10, 'September', 2024, '2024-09-26 03:52:21', '2024-09-26 04:01:59', '2024-09-26 03:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `grade_pas`
--

CREATE TABLE `grade_pas` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `appraisal_id` int NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int NOT NULL,
  `grade` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_titles`
--

CREATE TABLE `job_titles` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `section` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_titles`
--

INSERT INTO `job_titles` (`id`, `name`, `section`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'C-Level', 1, '2024-09-22 06:25:49', '2024-09-22 06:25:49', '2024-09-22 06:25:49'),
(2, 'Manager', 2, '2024-09-26 09:10:45', '2024-09-26 09:10:45', '2024-09-26 09:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_09_27_100807_create_password_resets_table', 1),
(2, '2024_10_02_095850_presence_calculating', 2);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overtimes`
--

CREATE TABLE `overtimes` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `date` date NOT NULL,
  `start_at` time NOT NULL,
  `end_at` time NOT NULL,
  `TOTAL` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08'),
('hendryputra934@gmail.com', 'x48qutvGlB3PbuWPaCjNtCnXIJxhu05lvITho7E50d5PfJupszZa8QF6NEEv', '2024-09-27 04:41:08');

-- --------------------------------------------------------

--
-- Table structure for table `performance_appraisals`
--

CREATE TABLE `performance_appraisals` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performance_kpis`
--

CREATE TABLE `performance_kpis` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `position_id` int NOT NULL,
  `target` int NOT NULL,
  `bobot` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `performance_kpis`
--

INSERT INTO `performance_kpis` (`id`, `name`, `position_id`, `target`, `bobot`, `created_at`, `updated_at`, `deleted_at`) VALUES
(155, '1', 2, 1, 1, '2024-09-23 08:56:03', '2024-09-23 08:56:03', '2024-09-23 08:56:03'),
(156, '3', 2, 3, 3, '2024-09-23 08:56:03', '2024-09-23 08:56:03', '2024-09-23 08:56:03'),
(157, '2', 2, 2, 2, '2024-09-23 08:56:18', '2024-09-23 08:56:18', '2024-09-23 08:56:18'),
(158, '4', 2, 4, 4, '2024-09-23 08:56:18', '2024-09-23 08:56:18', '2024-09-23 08:56:18'),
(159, '3', 2, 3, 3, '2024-09-23 08:56:18', '2024-09-23 08:56:18', '2024-09-23 08:56:18'),
(286, 'Kehadiran', 1, 26, 20, '2024-09-24 07:12:55', '2024-09-24 07:12:55', '2024-09-24 07:12:55'),
(287, 'Output Sukes (pcs)', 1, 95, 20, '2024-09-24 07:12:55', '2024-09-24 07:12:55', '2024-09-24 07:12:55'),
(288, 'Kaizen', 1, 2, 10, '2024-09-24 07:12:55', '2024-09-24 07:12:55', '2024-09-24 07:12:55'),
(289, 'Administrasi Spv', 1, 100, 30, '2024-09-24 07:12:55', '2024-09-24 07:12:55', '2024-09-24 07:12:55'),
(290, 'Ketepatan Deadline', 1, 91, 20, '2024-09-24 07:12:55', '2024-09-24 07:12:55', '2024-09-24 07:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Chief Business Officer', '2024-09-22 06:24:37', '2024-09-22 06:24:37', '2024-09-22 06:24:37'),
(2, 'GM', '2024-09-23 02:40:57', '2024-09-23 02:40:57', '2024-09-23 02:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `presences`
--

CREATE TABLE `presences` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `employee_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `check_in` time NOT NULL,
  `late_arrival` int NOT NULL DEFAULT '0',
  `late_check_in` int NOT NULL DEFAULT '0',
  `check_out` time DEFAULT NULL,
  `check_out_early` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `presences`
--

INSERT INTO `presences` (`id`, `employee_id`, `employee_name`, `date`, `check_in`, `late_arrival`, `late_check_in`, `check_out`, `check_out_early`, `created_at`, `updated_at`, `deleted_at`) VALUES
(34, 68, NULL, '2024-10-02', '10:56:47', 1, 176, NULL, 0, '2024-10-02 03:56:47', '2024-10-02 03:56:47', '2024-10-02 03:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` int NOT NULL,
  `employee_id` int NOT NULL,
  `qty` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `month`, `year`, `employee_id`, `qty`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'January', 2024, 63, 549, '2024-09-26 06:35:15', '2024-09-26 06:35:15', NULL),
(3, 'January', 2024, 64, 150, '2024-09-26 06:35:15', '2024-09-26 06:35:15', NULL),
(4, 'February', 2024, 63, 1000, '2024-09-26 07:33:24', '2024-09-26 07:33:24', NULL),
(5, 'March', 2024, 64, 890, '2024-09-26 07:33:40', '2024-09-26 07:33:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_persons`
--

CREATE TABLE `sales_persons` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RkBAopZiCWEhiBEUQmnOM5B6dZDCkPLxxzurmWFK', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoianNCTGUxT3Y2UklEY2F6MWVKM0tCS2lKN0NrcTduelN2RTBHcGs5QSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcmVzZW5jZSI7fX0=', 1727171549);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'hendry@gmail.com', '$2y$12$2HUpodXm.CubK6pRB5SXaONqLLWZrzz2HVorX.O2/V/DvmaZ9qCuK', '2024-09-25 09:27:40', '2024-09-25 09:27:40', '2024-09-25 09:27:40'),
(2, 'hendry', 'hen@gmail.com', '$2y$12$QZfUhP3fjgQpTv9TrTEAZeBGjcFYwQ7vEU/kDFCHRPk.sGgdvVbEC', '2024-09-25 10:02:18', '2024-09-25 10:02:18', '2024-09-25 10:02:18'),
(3, 'cek', 'cek@gmail.com', '$2y$12$MHL0D.X35dqOKR9DYZEvG.wBtkj9gmq1SutiPgWpoIeKQUajBWiru', '2024-09-25 10:03:00', '2024-09-25 10:03:00', '2024-09-25 10:03:00'),
(4, 'hen', 'henf@gmail.com', '$2y$12$lla/8rvBgRdRQLVoI1.Gbuj8FGwc058MMs1COBnJaAkHioRQEZq1a', '2024-09-25 10:03:40', '2024-09-25 10:03:40', '2024-09-25 10:03:40'),
(5, '333', '3@gmail.com', '$2y$12$nyO88dRnvKN4uX/olURkFOasQn6vR1aId2XBpIjmEvoPu.0ewv3te', '2024-09-25 10:04:08', '2024-09-25 10:04:08', '2024-09-25 10:04:08'),
(6, '555', '5@gmail.com', '$2y$12$9QhTtbXmF.TOgtCfxToEeenkA7Uv9HYM1dODBfcffYKCqicoJaxNO', '2024-09-25 12:14:31', '2024-09-25 12:14:31', '2024-09-25 12:14:31'),
(7, '66666666', '6@gmail.com', '$2y$12$H7ynb9vxTgAENh2NgHxHTuf.bLc/AU01cgC0v9X7NEwbkseEGKpW6', '2024-09-25 12:16:27', '2024-09-25 12:16:27', '2024-09-25 12:16:27'),
(8, 'hendry@gmail.com', 'hendry@gmail.cpm', '$2y$12$oAnWlc7gDcV0wqUHci6BXe8SQ64VjBJMbCYucSLgNGFTPbOTwqwdK', '2024-09-25 14:51:08', '2024-09-25 14:51:08', '2024-09-25 14:51:08'),
(9, 'adminn', 'adminn@gmail.com', '$2y$12$ktPQLTS4/iXu4nVPIT7XL.qNJ.LZo2RM1iDhIdBAFjYZzgx5vbPye', '2024-09-27 02:22:26', '2024-09-27 02:22:26', '2024-09-27 02:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `work_calendar`
--

CREATE TABLE `work_calendar` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `jan` int NOT NULL,
  `feb` int NOT NULL,
  `mar` int NOT NULL,
  `apr` int NOT NULL,
  `may` int NOT NULL,
  `jun` int NOT NULL,
  `jul` int NOT NULL,
  `aug` int NOT NULL,
  `sep` int NOT NULL,
  `oct` int NOT NULL,
  `nov` int NOT NULL,
  `dec` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_days`
--

CREATE TABLE `work_days` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  `day_off` int NOT NULL,
  `tolerance` int DEFAULT NULL,
  `arrival` time DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `break` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted)at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_days`
--

INSERT INTO `work_days` (`id`, `name`, `day`, `day_off`, `tolerance`, `arrival`, `check_in`, `check_out`, `break`, `created_at`, `updated_at`, `deleted)at`) VALUES
(9, 'Manager', 'monday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 1, '2024-09-23 09:32:02', '2024-09-29 15:38:01', NULL),
(10, 'Manager', 'tuesday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-23 09:32:02', '2024-09-29 15:07:44', NULL),
(11, 'Manager', 'wednesday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-23 09:32:02', '2024-09-29 15:07:44', NULL),
(12, 'Manager', 'thursday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-23 09:32:02', '2024-09-29 15:07:44', NULL),
(13, 'Manager', 'friday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-23 09:32:02', '2024-09-29 15:07:44', NULL),
(14, 'Manager', 'saturday', 0, 0, '07:45:00', '08:00:00', '12:30:00', 0, '2024-09-23 09:32:02', '2024-09-29 15:07:44', NULL),
(15, 'Manager', 'sunday', 1, 0, NULL, NULL, NULL, 0, '2024-09-23 09:32:02', '2024-09-23 12:28:38', NULL),
(16, 'Bordir Pagi', 'monday', 1, 0, NULL, NULL, NULL, 0, '2024-09-24 07:37:53', '2024-09-25 03:39:40', NULL),
(17, 'Bordir Pagi', 'tuesday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-24 07:37:53', '2024-09-25 03:39:40', NULL),
(18, 'Bordir Pagi', 'wednesday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-24 07:37:53', '2024-09-25 03:39:40', NULL),
(19, 'Bordir Pagi', 'thursday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-24 07:37:53', '2024-09-25 03:39:40', NULL),
(20, 'Bordir Pagi', 'friday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-24 07:37:53', '2024-09-25 03:39:40', NULL),
(21, 'Bordir Pagi', 'saturday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-24 07:37:53', '2024-09-25 03:39:40', NULL),
(22, 'Bordir Pagi', 'sunday', 0, 0, '07:45:00', '08:00:00', '16:30:00', 0, '2024-09-24 07:37:53', '2024-09-25 03:39:40', NULL),
(23, 'Bordir Malam', 'monday', 1, 0, NULL, NULL, NULL, 0, '2024-09-25 03:41:11', '2024-09-25 03:41:11', NULL),
(24, 'Bordir Malam', 'tuesday', 0, 0, '15:45:00', '16:00:00', '23:59:00', 0, '2024-09-25 03:41:11', '2024-09-25 03:41:11', NULL),
(25, 'Bordir Malam', 'wednesday', 0, 0, '15:45:00', '16:00:00', '23:59:00', 0, '2024-09-25 03:41:11', '2024-09-25 03:41:11', NULL),
(26, 'Bordir Malam', 'thursday', 0, 0, '15:45:00', '16:00:00', '23:59:00', 0, '2024-09-25 03:41:11', '2024-09-25 03:41:11', NULL),
(27, 'Bordir Malam', 'friday', 0, 0, '15:45:00', '16:00:00', '23:59:00', 0, '2024-09-25 03:41:11', '2024-09-25 03:41:11', NULL),
(28, 'Bordir Malam', 'saturday', 0, 0, '15:45:00', '16:00:00', '23:59:00', 0, '2024-09-25 03:41:11', '2024-09-25 03:41:11', NULL),
(29, 'Bordir Malam', 'sunday', 0, 0, '15:45:00', '16:00:00', '23:59:00', 0, '2024-09-25 03:41:11', '2024-09-25 03:41:11', NULL),
(30, 'CS', 'monday', 0, 0, NULL, NULL, NULL, 0, '2024-09-29 15:12:02', '2024-09-29 15:12:02', NULL),
(31, 'CS', 'tuesday', 0, 0, NULL, NULL, NULL, 0, '2024-09-29 15:12:02', '2024-09-29 15:12:02', NULL),
(32, 'CS', 'wednesday', 0, 0, NULL, NULL, NULL, 0, '2024-09-29 15:12:02', '2024-09-29 15:12:02', NULL),
(33, 'CS', 'thursday', 0, 0, NULL, NULL, '12:18:00', 0, '2024-09-29 15:12:02', '2024-09-29 15:18:58', NULL),
(34, 'CS', 'friday', 1, 0, NULL, NULL, NULL, 0, '2024-09-29 15:12:02', '2024-09-29 15:13:54', NULL),
(35, 'CS', 'saturday', 1, 0, NULL, NULL, NULL, 0, '2024-09-29 15:12:02', '2024-09-29 15:12:02', NULL),
(36, 'CS', 'sunday', 1, 0, NULL, NULL, NULL, 0, '2024-09-29 15:12:02', '2024-09-29 15:12:02', NULL),
(37, 'gjhkf', 'monday', 0, 0, NULL, NULL, NULL, 0, '2024-09-29 15:33:33', '2024-09-29 15:35:17', NULL),
(38, 'gjhkf', 'tuesday', 0, 0, NULL, NULL, NULL, 0, '2024-09-29 15:33:33', '2024-09-29 15:35:26', NULL),
(39, 'gjhkf', 'wednesday', 0, 0, NULL, NULL, NULL, 0, '2024-09-29 15:33:33', '2024-09-29 15:35:26', NULL),
(40, 'gjhkf', 'thursday', 1, 0, NULL, NULL, NULL, 0, '2024-09-29 15:33:33', '2024-09-29 15:35:26', NULL),
(41, 'gjhkf', 'friday', 1, 0, NULL, NULL, NULL, 0, '2024-09-29 15:33:33', '2024-09-29 15:35:26', NULL),
(42, 'gjhkf', 'saturday', 1, 0, NULL, NULL, NULL, 0, '2024-09-29 15:33:33', '2024-09-29 15:35:26', NULL),
(43, 'gjhkf', 'sunday', 0, 0, NULL, NULL, NULL, 0, '2024-09-29 15:33:33', '2024-09-29 15:35:26', NULL),
(44, 'minggu', 'monday', 1, NULL, NULL, NULL, NULL, 0, '2024-09-29 16:00:21', '2024-09-29 16:00:21', NULL),
(45, 'minggu', 'tuesday', 1, NULL, NULL, NULL, NULL, 0, '2024-09-29 16:00:21', '2024-09-29 16:00:21', NULL),
(46, 'minggu', 'wednesday', 1, NULL, NULL, NULL, NULL, 0, '2024-09-29 16:00:21', '2024-09-29 16:00:21', NULL),
(47, 'minggu', 'thursday', 1, NULL, NULL, NULL, NULL, 0, '2024-09-29 16:00:21', '2024-09-29 16:00:21', NULL),
(48, 'minggu', 'friday', 1, NULL, NULL, NULL, NULL, 0, '2024-09-29 16:00:21', '2024-09-29 16:00:21', NULL),
(49, 'minggu', 'saturday', 1, NULL, NULL, NULL, NULL, 0, '2024-09-29 16:00:21', '2024-09-29 16:00:21', NULL),
(50, 'minggu', 'sunday', 0, NULL, '22:00:00', '23:00:00', '23:30:00', 0, '2024-09-29 16:00:21', '2024-09-29 16:00:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_schedules`
--

CREATE TABLE `work_schedules` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `arrival` time NOT NULL,
  `start_at` time NOT NULL,
  `end_at` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department` (`name`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `division` (`name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eid` (`eid`);

--
-- Indexes for table `employee_status`
--
ALTER TABLE `employee_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_status` (`name`);

--
-- Indexes for table `employee_work_day`
--
ALTER TABLE `employee_work_day`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `work_day_id` (`work_day_id`);

--
-- Indexes for table `grade_kpis`
--
ALTER TABLE `grade_kpis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_pas`
--
ALTER TABLE `grade_pas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_titles`
--
ALTER TABLE `job_titles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_title` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `performance_appraisals`
--
ALTER TABLE `performance_appraisals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appraisal` (`name`);

--
-- Indexes for table `performance_kpis`
--
ALTER TABLE `performance_kpis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `position` (`name`);

--
-- Indexes for table `presences`
--
ALTER TABLE `presences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_persons`
--
ALTER TABLE `sales_persons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eid` (`employee_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `work_calendar`
--
ALTER TABLE `work_calendar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `calendar` (`name`);

--
-- Indexes for table `work_days`
--
ALTER TABLE `work_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_schedules`
--
ALTER TABLE `work_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schedule` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `employee_status`
--
ALTER TABLE `employee_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_work_day`
--
ALTER TABLE `employee_work_day`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `grade_kpis`
--
ALTER TABLE `grade_kpis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `grade_pas`
--
ALTER TABLE `grade_pas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_titles`
--
ALTER TABLE `job_titles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance_appraisals`
--
ALTER TABLE `performance_appraisals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance_kpis`
--
ALTER TABLE `performance_kpis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `presences`
--
ALTER TABLE `presences`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales_persons`
--
ALTER TABLE `sales_persons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `work_calendar`
--
ALTER TABLE `work_calendar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_days`
--
ALTER TABLE `work_days`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `work_schedules`
--
ALTER TABLE `work_schedules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_work_day`
--
ALTER TABLE `employee_work_day`
  ADD CONSTRAINT `employee_work_day_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_work_day_ibfk_2` FOREIGN KEY (`work_day_id`) REFERENCES `work_days` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

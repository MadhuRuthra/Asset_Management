-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2024 at 11:45 AM
-- Server version: 8.0.36-0ubuntu0.20.04.1
-- PHP Version: 8.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asset_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset_managers`
--

CREATE TABLE `asset_managers` (
  `asset_manager_id` bigint UNSIGNED NOT NULL,
  `asset_master_id` int NOT NULL,
  `user_id` int NOT NULL,
  `asset_serial_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_to` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_entry_date` timestamp NULL DEFAULT NULL,
  `assigned_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_managers`
--

INSERT INTO `asset_managers` (`asset_manager_id`, `asset_master_id`, `user_id`, `asset_serial_no`, `asset_details`, `assigned_to`, `assigned_status`, `remarks`, `assigned_entry_date`, `assigned_modified_date`) VALUES
(1, 2, 1, 'YJUSB1', '[\"storage\",\"model_name\",\"ford\",\"macaddress\",\"ram\"]', 'rajesh', 'Y', NULL, '2024-05-21 13:25:13', '2024-05-21 13:25:13'),
(17, 1, 1, 'YJLP2', '[\"ram\",\"macaddress\",\"rom\"]', 'rajesh', 'Y', NULL, '2024-05-29 18:23:46', '2024-05-29 18:23:46');

-- --------------------------------------------------------

--
-- Table structure for table `asset_masters`
--

CREATE TABLE `asset_masters` (
  `asset_master_id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `asset_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_serial_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_brand` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_model_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` timestamp NOT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_entry_date` timestamp NULL DEFAULT NULL,
  `asset_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_masters`
--

INSERT INTO `asset_masters` (`asset_master_id`, `user_id`, `asset_name`, `asset_serial_name`, `asset_type`, `asset_brand`, `asset_model_name`, `asset_status`, `purchase_date`, `remarks`, `asset_entry_date`, `asset_modified_date`) VALUES
(1, 1, 'hp_laptop', 'YJLP', 'laptop_hp', 'hp', 'hp_i5_gen_7', 'Y', '2024-05-21 10:42:00', NULL, '2024-05-21 10:43:03', '2024-05-21 10:43:03'),
(2, 1, 'usb', 'YJUSB', 'usb', 'hp', 'hp_pendrive', 'Y', '2024-05-21 10:42:00', NULL, '2024-05-21 10:59:44', '2024-05-21 10:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `asset_properties`
--

CREATE TABLE `asset_properties` (
  `asset_properties_id` bigint UNSIGNED NOT NULL,
  `asset_master_id` int NOT NULL,
  `user_id` int NOT NULL,
  `feature_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature_input` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feature_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature_entry_date` timestamp NULL DEFAULT NULL,
  `feature_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_properties`
--

INSERT INTO `asset_properties` (`asset_properties_id`, `asset_master_id`, `user_id`, `feature_name`, `feature_input`, `feature_status`, `feature_entry_date`, `feature_modified_date`) VALUES
(1, 1, 1, 'serial_no', 'yeejai-lap-1', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30'),
(2, 1, 1, 'ram', '8gb', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30'),
(3, 1, 1, 'rom', '200gb', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30'),
(4, 1, 1, 'processor', 'intel i5', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30'),
(5, 1, 1, 'mac_address', '18:60:24:4f:af:b7', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30'),
(6, 1, 1, 'storage', '400gb', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30'),
(7, 1, 1, 'os', 'windows', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30'),
(8, 1, 1, 'quantity', '1', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30'),
(10, 1, 1, 'size', '12inch', 'Y', '2024-05-30 11:11:30', '2024-05-30 11:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_11_09_064224_create_user_profiles_table', 1),
(6, '2021_11_11_110731_create_permission_tables', 1),
(7, '2021_11_16_114009_create_media_table', 1),
(8, '2024_05_18_112130_asset_masters', 2),
(9, '2024_05_18_112205_asset_properties', 2),
(10, '2024_05_18_112223_asset_managers', 2),
(11, '2024_05_18_112230_user_log', 2),
(12, '2024_05_18_112258_user_master', 2),
(13, '2024_05_22_112719_owners_masters', 3),
(14, '2024_05_29_114222_create_sessions_table', 4),
(15, '2024_05_31_093703_system_credentials', 4),
(16, '2024_05_31_123705_os_masters', 5),
(17, '2024_05_31_123717_version_masters', 5);

-- --------------------------------------------------------

--
-- Table structure for table `os_masters`
--

CREATE TABLE `os_masters` (
  `os_master_id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `os_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os_entry_date` timestamp NULL DEFAULT NULL,
  `os_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `os_masters`
--

INSERT INTO `os_masters` (`os_master_id`, `user_id`, `os_name`, `os_status`, `os_entry_date`, `os_modified_date`) VALUES
(1, 1, 'windows', 'Y', '2024-05-31 13:14:30', '2024-05-31 13:14:30'),
(2, 1, 'linux', 'Y', '2024-05-31 13:14:30', '2024-05-31 13:14:30'),
(3, 1, 'mac', 'Y', '2024-05-31 13:15:27', '2024-05-31 13:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `owners_masters`
--

CREATE TABLE `owners_masters` (
  `owner_master_id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `owner_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_entry_date` timestamp NULL DEFAULT NULL,
  `owner_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owners_masters`
--

INSERT INTO `owners_masters` (`owner_master_id`, `user_id`, `owner_name`, `owner_id`, `owner_role`, `owner_status`, `owner_entry_date`, `owner_modified_date`) VALUES
(1, 1, 'Rajesh', '123', 'system admin', 'Y', '2024-05-22 18:52:35', '2024-05-22 18:52:35'),
(2, 1, 'Asar', '234', 'system admin', 'Y', '2024-05-22 18:52:35', '2024-05-22 18:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `system_credentials`
--

CREATE TABLE `system_credentials` (
  `credential_id` bigint UNSIGNED NOT NULL,
  `os_master_id` int NOT NULL,
  `version_master_id` int NOT NULL,
  `user_id` int NOT NULL,
  `serial_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `root_password` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mysql_user_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mongodb_user_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credential_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credential_entry_date` timestamp NULL DEFAULT NULL,
  `credential_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_credentials`
--

INSERT INTO `system_credentials` (`credential_id`, `os_master_id`, `version_master_id`, `user_id`, `serial_number`, `user_name`, `password`, `root_password`, `mysql_user_password`, `mongodb_user_password`, `credential_status`, `credential_entry_date`, `credential_modified_date`) VALUES
(1, 1, 1, 1, 'YJLP2', 'yeejai', 'yeejai@123', NULL, '{\"Mysql User Name\":\"Admin\",\"Mysql Password\":\"Admin@123\"}', '{\"Mysql User Name\":\"Admin\",\"Mysql Password\":\"Admin@123\"}', 'Y', '2024-06-01 11:34:33', '2024-06-01 11:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `phone_number`, `email_verified_at`, `user_type`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Asar', 'Asarudheen', 'Ahamad', 'admin123@gmail.com', '6380747454', NULL, 'Admin', '$2y$10$bGSzLS/8Nz5c5VJHzOEUq.IjU8U3MRcbFG5Hk5ydAkwmGIo93mvGu', 'pending', NULL, '2024-05-17 14:46:25', '2024-06-03 14:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `user_log_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_date` date NOT NULL,
  `login_time` timestamp NOT NULL,
  `logout_time` timestamp NULL DEFAULT NULL,
  `user_log_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'I',
  `user_log_entry_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`user_log_id`, `user_id`, `ip_address`, `login_date`, `login_time`, `logout_time`, `user_log_status`, `user_log_entry_date`, `created_at`, `updated_at`) VALUES
(1, 1, '::1', '2024-05-29', '2024-05-29 13:03:26', '2024-05-29 13:05:58', 'O', '2024-05-29 13:03:26', NULL, NULL),
(2, 1, '::1', '2024-05-29', '2024-05-29 13:06:53', '2024-05-29 13:10:17', 'O', '2024-05-29 13:06:53', NULL, NULL),
(3, 1, '::1', '2024-05-29', '2024-05-29 13:10:17', '2024-05-29 13:31:06', 'O', '2024-05-29 13:10:17', NULL, NULL),
(4, 1, '::1', '2024-05-29', '2024-05-29 13:31:16', '2024-05-29 13:32:43', 'O', '2024-05-29 13:31:16', NULL, NULL),
(5, 1, '::1', '2024-05-29', '2024-05-29 13:32:52', '2024-05-29 13:34:17', 'O', '2024-05-29 13:32:52', NULL, NULL),
(6, 1, '::1', '2024-05-29', '2024-05-29 13:34:25', '2024-05-29 14:49:44', 'O', '2024-05-29 13:34:25', NULL, NULL),
(7, 1, '::1', '2024-05-29', '2024-05-29 14:49:53', '2024-05-29 15:25:22', 'O', '2024-05-29 14:49:53', NULL, NULL),
(8, 1, '::1', '2024-05-29', '2024-05-29 15:25:31', '2024-05-30 09:32:09', 'O', '2024-05-29 15:25:31', NULL, NULL),
(9, 1, '::1', '2024-05-30', '2024-05-30 09:32:09', '2024-05-30 17:09:33', 'O', '2024-05-30 09:32:09', NULL, NULL),
(10, 1, '::1', '2024-05-30', '2024-05-30 17:09:33', '2024-05-31 09:31:38', 'O', '2024-05-30 17:09:33', NULL, NULL),
(11, 1, '::1', '2024-05-31', '2024-05-31 09:31:37', '2024-06-01 10:13:54', 'O', '2024-05-31 09:31:37', NULL, NULL),
(12, 1, '::1', '2024-06-01', '2024-06-01 10:13:54', '2024-06-03 09:47:55', 'O', '2024-06-01 10:13:54', NULL, NULL),
(13, 1, '::1', '2024-06-03', '2024-06-03 09:47:55', '2024-06-03 14:29:24', 'O', '2024-06-03 09:47:55', NULL, NULL),
(14, 1, '::1', '2024-06-03', '2024-06-03 14:33:20', NULL, 'I', '2024-06-03 14:33:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_masters`
--

CREATE TABLE `user_masters` (
  `user_master_id` int UNSIGNED NOT NULL,
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_details` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_master_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_entry_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_addr_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_addr_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin_code` bigint DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkdin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `version_masters`
--

CREATE TABLE `version_masters` (
  `version_master_id` bigint UNSIGNED NOT NULL,
  `os_master_id` int NOT NULL,
  `user_id` int NOT NULL,
  `version_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version_status` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version_entry_date` timestamp NULL DEFAULT NULL,
  `version_modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `version_masters`
--

INSERT INTO `version_masters` (`version_master_id`, `os_master_id`, `user_id`, `version_type`, `version_name`, `version_status`, `version_entry_date`, `version_modified_date`) VALUES
(1, 1, 1, 'Windows', '9', 'Y', '2024-05-31 15:00:33', '2024-05-31 15:00:33'),
(2, 1, 1, 'Windows', '10', 'Y', '2024-05-31 15:01:48', '2024-05-31 15:01:48'),
(3, 1, 1, 'Windows', '11', 'Y', '2024-05-31 15:01:54', '2024-05-31 15:01:54'),
(4, 1, 1, 'Windows', '11 pro', 'Y', '2024-05-31 15:02:00', '2024-05-31 15:02:00'),
(5, 2, 1, 'ubuntu', '22.09', 'Y', '2024-05-31 15:02:17', '2024-05-31 15:02:17'),
(6, 2, 1, 'centos', '9', 'Y', '2024-05-31 15:02:29', '2024-05-31 15:02:29'),
(7, 2, 1, 'kali', '10', 'Y', '2024-05-31 15:02:40', '2024-05-31 15:02:40'),
(8, 2, 1, 'debian', '10', 'Y', '2024-05-31 15:02:57', '2024-05-31 15:02:57'),
(9, 3, 1, 'Mac', '5', 'Y', '2024-05-31 15:03:08', '2024-05-31 15:03:08'),
(10, 3, 1, 'Mac', '6', 'Y', '2024-05-31 15:03:13', '2024-05-31 15:03:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset_managers`
--
ALTER TABLE `asset_managers`
  ADD PRIMARY KEY (`asset_manager_id`);

--
-- Indexes for table `asset_masters`
--
ALTER TABLE `asset_masters`
  ADD PRIMARY KEY (`asset_master_id`);

--
-- Indexes for table `asset_properties`
--
ALTER TABLE `asset_properties`
  ADD PRIMARY KEY (`asset_properties_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `os_masters`
--
ALTER TABLE `os_masters`
  ADD PRIMARY KEY (`os_master_id`);

--
-- Indexes for table `owners_masters`
--
ALTER TABLE `owners_masters`
  ADD PRIMARY KEY (`owner_master_id`);

--
-- Indexes for table `system_credentials`
--
ALTER TABLE `system_credentials`
  ADD PRIMARY KEY (`credential_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`user_log_id`),
  ADD KEY `user_log_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_masters`
--
ALTER TABLE `user_masters`
  ADD PRIMARY KEY (`user_master_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `version_masters`
--
ALTER TABLE `version_masters`
  ADD PRIMARY KEY (`version_master_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset_managers`
--
ALTER TABLE `asset_managers`
  MODIFY `asset_manager_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `asset_masters`
--
ALTER TABLE `asset_masters`
  MODIFY `asset_master_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `asset_properties`
--
ALTER TABLE `asset_properties`
  MODIFY `asset_properties_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `os_masters`
--
ALTER TABLE `os_masters`
  MODIFY `os_master_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `owners_masters`
--
ALTER TABLE `owners_masters`
  MODIFY `owner_master_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_credentials`
--
ALTER TABLE `system_credentials`
  MODIFY `credential_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `user_log_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_masters`
--
ALTER TABLE `user_masters`
  MODIFY `user_master_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `version_masters`
--
ALTER TABLE `version_masters`
  MODIFY `version_master_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

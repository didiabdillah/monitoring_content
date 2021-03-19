-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2021 at 04:57 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring_contents`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Phantom', '2021-03-16 04:14:48', '2021-03-16 04:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `content_user_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_date` date NOT NULL,
  `content_is_present` tinyint(1) NOT NULL,
  `content_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_type` enum('file','link') COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_status` enum('accepted','rejected','process') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_files`
--

CREATE TABLE `content_files` (
  `content_file_id` bigint(20) UNSIGNED NOT NULL,
  `content_file_content_id` bigint(20) UNSIGNED NOT NULL,
  `content_file_original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_file_hash_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_file_base_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_file_extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_histories`
--

CREATE TABLE `content_histories` (
  `content_history_id` bigint(20) UNSIGNED NOT NULL,
  `content_history_content_id` bigint(20) UNSIGNED NOT NULL,
  `content_history_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_history_status` enum('accepted','rejected','process') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_links`
--

CREATE TABLE `content_links` (
  `content_link_id` bigint(20) UNSIGNED NOT NULL,
  `content_link_content_id` bigint(20) UNSIGNED NOT NULL,
  `content_link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_tokens`
--

CREATE TABLE `forgot_tokens` (
  `forgot_token_id` bigint(20) UNSIGNED NOT NULL,
  `forgot_token_user_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forgot_token_user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forgot_token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forgot_token_due_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `holiday_id` bigint(20) UNSIGNED NOT NULL,
  `holiday_event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_01_05_071906_create_users_table', 1),
(2, '2021_01_05_084240_create_settings_table', 1),
(3, '2021_01_05_084651_create_notifications_table', 1),
(4, '2021_01_15_143218_create_forgot_tokens_table', 1),
(5, '2021_02_18_105752_create_telegram_data_sources_table', 1),
(6, '2021_02_23_090202_create_contents_table', 1),
(7, '2021_02_23_144850_create_content_files_table', 1),
(8, '2021_02_23_145012_create_content_links_table', 1),
(9, '2021_02_25_162901_create_holidays_table', 1),
(10, '2021_02_26_051134_create_content_histories_table', 1),
(11, '2021_03_04_100919_create_missed_uploads_table', 1),
(12, '2021_03_09_144636_create_categories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `missed_uploads`
--

CREATE TABLE `missed_uploads` (
  `missed_upload_id` bigint(20) UNSIGNED NOT NULL,
  `missed_upload_user_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `missed_upload_date` date NOT NULL,
  `missed_upload_total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `missed_uploads`
--

INSERT INTO `missed_uploads` (`missed_upload_id`, `missed_upload_user_id`, `missed_upload_date`, `missed_upload_total`, `created_at`, `updated_at`) VALUES
(1, 'fb17afbd5b314b7284c54844c3597570', '2021-03-16', 1, '2021-03-16 05:02:19', '2021-03-19 03:50:57');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `notification_user_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_status` tinyint(1) NOT NULL,
  `notification_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` bigint(20) UNSIGNED NOT NULL,
  `setting_api_whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting_api_telegram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting_smtp_host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting_smtp_port` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting_smtp_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting_smtp_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting_favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_api_whatsapp`, `setting_api_telegram`, `setting_smtp_host`, `setting_smtp_port`, `setting_smtp_user`, `setting_smtp_password`, `setting_logo`, `setting_favicon`, `created_at`, `updated_at`) VALUES
(1, 'a6fbe3c5-7479-46f0-960c-4ded3438dc0d', '550569ba-0792-4d8d-bd6c-9fd6be9c98d8', 'miller.com', '465', 'wheathcote@hotmail.com', '{+uAe<>NJ4$Kc', 'default-logo.png', 'default-favicon.ico', '2021-03-16 03:24:28', '2021-03-16 03:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `telegram_data_sources`
--

CREATE TABLE `telegram_data_sources` (
  `data_id` bigint(20) UNSIGNED NOT NULL,
  `chat_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_type` enum('group','private') COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_mute` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_daily_target` int(10) UNSIGNED NOT NULL,
  `user_phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` enum('admin','operator') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_daily_target`, `user_phone`, `user_role`, `user_image`, `created_at`, `updated_at`) VALUES
('a5c860decf204ea686aedbb6dbeb6ab1', 'Didi', 'abdillah1965didiokey@gmail.com', '$2y$10$nWLF9Affscg8fqtLfT5ruOJHPXy9OIexcQ7UkvX1zDQub1JtpL.w6', 0, '087727598653', 'admin', 'default.jpg', '2021-03-16 03:24:37', '2021-03-16 03:24:37'),
('fb17afbd5b314b7284c54844c3597570', 'Igoy', 'igoy@email.com', '$2y$10$QbOQLGXJRdAiIYaSbEiHOOpgzhfZiN1VI9MfqstuajXC2ApqxUIOe', 2, '081564678102', 'operator', 'default.jpg', '2021-03-16 03:59:00', '2021-03-16 03:59:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `contents_content_user_id_foreign` (`content_user_id`);

--
-- Indexes for table `content_files`
--
ALTER TABLE `content_files`
  ADD PRIMARY KEY (`content_file_id`),
  ADD KEY `content_files_content_file_content_id_foreign` (`content_file_content_id`);

--
-- Indexes for table `content_histories`
--
ALTER TABLE `content_histories`
  ADD PRIMARY KEY (`content_history_id`),
  ADD KEY `content_histories_content_history_content_id_foreign` (`content_history_content_id`);

--
-- Indexes for table `content_links`
--
ALTER TABLE `content_links`
  ADD PRIMARY KEY (`content_link_id`),
  ADD KEY `content_links_content_link_content_id_foreign` (`content_link_content_id`);

--
-- Indexes for table `forgot_tokens`
--
ALTER TABLE `forgot_tokens`
  ADD PRIMARY KEY (`forgot_token_id`),
  ADD KEY `forgot_tokens_forgot_token_user_id_foreign` (`forgot_token_user_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `missed_uploads`
--
ALTER TABLE `missed_uploads`
  ADD PRIMARY KEY (`missed_upload_id`),
  ADD KEY `missed_uploads_missed_upload_user_id_foreign` (`missed_upload_user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notifications_notification_user_id_foreign` (`notification_user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `telegram_data_sources`
--
ALTER TABLE `telegram_data_sources`
  ADD PRIMARY KEY (`data_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_user_email_unique` (`user_email`),
  ADD UNIQUE KEY `users_user_phone_unique` (`user_phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `content_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `content_files`
--
ALTER TABLE `content_files`
  MODIFY `content_file_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `content_histories`
--
ALTER TABLE `content_histories`
  MODIFY `content_history_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_links`
--
ALTER TABLE `content_links`
  MODIFY `content_link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forgot_tokens`
--
ALTER TABLE `forgot_tokens`
  MODIFY `forgot_token_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `holiday_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `missed_uploads`
--
ALTER TABLE `missed_uploads`
  MODIFY `missed_upload_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `telegram_data_sources`
--
ALTER TABLE `telegram_data_sources`
  MODIFY `data_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `contents_content_user_id_foreign` FOREIGN KEY (`content_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `content_files`
--
ALTER TABLE `content_files`
  ADD CONSTRAINT `content_files_content_file_content_id_foreign` FOREIGN KEY (`content_file_content_id`) REFERENCES `contents` (`content_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `content_histories`
--
ALTER TABLE `content_histories`
  ADD CONSTRAINT `content_histories_content_history_content_id_foreign` FOREIGN KEY (`content_history_content_id`) REFERENCES `contents` (`content_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `content_links`
--
ALTER TABLE `content_links`
  ADD CONSTRAINT `content_links_content_link_content_id_foreign` FOREIGN KEY (`content_link_content_id`) REFERENCES `contents` (`content_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forgot_tokens`
--
ALTER TABLE `forgot_tokens`
  ADD CONSTRAINT `forgot_tokens_forgot_token_user_id_foreign` FOREIGN KEY (`forgot_token_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `missed_uploads`
--
ALTER TABLE `missed_uploads`
  ADD CONSTRAINT `missed_uploads_missed_upload_user_id_foreign` FOREIGN KEY (`missed_upload_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_notification_user_id_foreign` FOREIGN KEY (`notification_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

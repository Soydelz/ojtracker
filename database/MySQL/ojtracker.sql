-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 04:09 AM
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
-- Database: `ojtracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `accomplishments`
--

CREATE TABLE `accomplishments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `task_description` text NOT NULL,
  `tools_used` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accomplishments`
--

INSERT INTO `accomplishments` (`id`, `user_id`, `date`, `task_description`, `tools_used`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-12-15', 'Day 1:\r\n\r\nOn our first day, we attended the flag-raising ceremony, which ended around 9:00 AM. At 9:30 AM, we returned to the function hall to attend another activity. After that, we were assisted and brought to the office of Ma’am Sittie (Regional Director). She asked about our skills, and both Cadigal and I were sent to the security office. However, only Cadigal was selected, so I returned to the TOD office and waited for further instructions.\r\n\r\nAround 10:00 AM, we were called back to the function hall where Sir Jeniel Wabe oriented us about our tasks. We were assigned to the TWG (Technical Working Group). After the orientation, we had our lunch break. In the afternoon, the orientation continued, and we were asked to help prepare materials for the upcoming event at N-Hotel Kauswagan. We cut and prepared name tags and pliers for the event.', NULL, '2026-01-14 07:49:28', '2026-01-14 07:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `dtr_logs`
--

CREATE TABLE `dtr_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `break_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
  `total_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `face_photo` varchar(255) DEFAULT NULL,
  `face_confidence` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dtr_logs`
--

INSERT INTO `dtr_logs` (`id`, `user_id`, `date`, `time_in`, `time_out`, `break_hours`, `total_hours`, `status`, `notes`, `face_photo`, `face_confidence`, `created_at`, `updated_at`) VALUES
(16, 2, '2025-12-15', '07:21:00', '17:01:00', 1.00, 8.67, 'completed', 'Day 1', NULL, NULL, '2026-01-13 07:05:40', '2026-01-13 07:05:40'),
(17, 2, '2025-12-16', '07:14:00', '21:00:00', 1.00, 12.77, 'completed', 'Day 2', NULL, NULL, '2026-01-13 07:06:31', '2026-01-13 07:06:31'),
(18, 2, '2025-12-17', '07:00:00', '17:00:00', 1.00, 9.00, 'completed', 'Day 3', NULL, NULL, '2026-01-13 07:07:41', '2026-01-13 07:07:41'),
(19, 2, '2025-12-18', '07:00:00', '17:00:00', 1.00, 9.00, 'completed', 'Day 4', NULL, NULL, '2026-01-13 07:08:29', '2026-01-13 07:08:29'),
(20, 2, '2025-12-22', '06:52:00', '17:00:00', 1.00, 9.13, 'completed', 'Day 5', NULL, NULL, '2026-01-13 07:09:33', '2026-01-13 07:09:33'),
(21, 2, '2025-12-23', '07:05:00', '17:00:00', 1.00, 8.92, 'completed', 'Day 6', NULL, NULL, '2026-01-13 07:10:20', '2026-01-13 07:10:20'),
(22, 2, '2025-12-26', '07:06:00', '17:00:00', 1.00, 8.90, 'completed', 'Day 7', NULL, NULL, '2026-01-13 07:10:56', '2026-01-13 07:10:56'),
(23, 2, '2026-01-05', '06:53:00', '17:00:00', 1.00, 9.12, 'completed', 'Day 8', NULL, NULL, '2026-01-13 07:11:50', '2026-01-13 07:11:50'),
(24, 2, '2026-01-06', '06:57:00', '17:00:00', 1.00, 9.05, 'completed', 'Day 9', NULL, NULL, '2026-01-13 07:12:18', '2026-01-13 07:12:18'),
(25, 2, '2026-01-07', '06:56:00', '17:03:00', 1.00, 9.12, 'completed', 'Day 10', NULL, NULL, '2026-01-13 07:12:50', '2026-01-13 07:12:50'),
(26, 2, '2026-01-08', '07:21:00', '17:07:00', 1.00, 8.77, 'completed', 'Day 11', NULL, NULL, '2026-01-13 07:13:40', '2026-01-13 07:13:40'),
(27, 2, '2026-01-12', '06:44:00', '17:00:00', 1.00, 9.27, 'completed', 'Day 12', NULL, NULL, '2026-01-13 23:52:03', '2026-01-13 23:52:03'),
(28, 2, '2026-01-13', '06:42:00', '17:00:00', 1.00, 9.30, 'completed', 'Day 13', NULL, NULL, '2026-01-13 23:52:36', '2026-01-13 23:52:36'),
(29, 2, '2026-01-14', '06:50:00', '17:00:10', 1.00, 9.17, 'completed', 'Day 14', NULL, NULL, '2026-01-14 00:56:54', '2026-01-14 09:00:10'),
(30, 3, '2026-01-14', '15:43:41', '15:43:57', 1.00, -1.00, 'completed', NULL, NULL, NULL, '2026-01-14 07:43:41', '2026-01-14 07:43:58'),
(33, 2, '2026-01-15', '06:50:00', '17:00:00', 1.00, 9.17, 'completed', 'Day 15', NULL, NULL, '2026-02-02 02:21:15', '2026-02-02 02:21:15'),
(34, 2, '2026-01-16', '06:52:00', '17:00:00', 1.00, 9.13, 'completed', 'Day 16', NULL, NULL, '2026-02-02 02:21:48', '2026-02-02 02:21:48'),
(35, 2, '2026-01-19', '06:43:00', '14:35:00', 1.00, 6.87, 'completed', 'Day 17', NULL, NULL, '2026-02-02 02:22:32', '2026-02-02 02:22:32'),
(36, 2, '2026-01-20', '06:38:00', '17:00:00', 1.00, 9.37, 'completed', 'Day 18', NULL, NULL, '2026-02-02 02:23:02', '2026-02-02 02:23:02'),
(37, 2, '2026-01-21', '06:49:00', '17:00:00', 1.00, 9.18, 'completed', 'Day 19', NULL, NULL, '2026-02-02 02:23:33', '2026-02-02 02:23:33'),
(38, 2, '2026-01-22', '06:52:00', '17:00:00', 1.00, 9.13, 'completed', 'Day 20', NULL, NULL, '2026-02-02 02:24:16', '2026-02-02 02:24:16'),
(39, 2, '2026-01-23', '06:53:00', '17:00:00', 1.00, 9.12, 'completed', 'Day 21', NULL, NULL, '2026-02-02 02:33:45', '2026-02-02 02:33:45'),
(40, 2, '2026-01-26', '06:42:00', '17:00:00', 1.00, 9.30, 'completed', 'Day 22', NULL, NULL, '2026-02-02 02:36:18', '2026-02-02 02:36:18'),
(41, 2, '2026-01-27', '06:49:00', '17:00:00', 1.00, 9.18, 'completed', 'Day 23', NULL, NULL, '2026-02-02 02:37:22', '2026-02-02 02:37:22'),
(42, 2, '2026-01-29', '06:50:00', '17:00:00', 1.00, 9.17, 'completed', 'Day 24', NULL, NULL, '2026-02-02 02:38:10', '2026-02-02 02:38:10'),
(43, 2, '2026-01-30', '06:41:00', '17:00:00', 1.00, 9.32, 'completed', 'Day 25', NULL, NULL, '2026-02-02 02:38:52', '2026-02-02 02:38:52'),
(44, 2, '2026-02-02', '06:57:00', '17:00:00', 1.00, 9.05, 'completed', 'Day 26', NULL, NULL, '2026-02-02 08:35:01', '2026-02-02 08:35:01'),
(45, 2, '2026-02-03', '06:44:00', '17:00:00', 1.00, 9.27, 'completed', 'Day 27', NULL, NULL, '2026-02-03 07:07:01', '2026-02-03 07:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_13_052539_create_dtr_logs_table', 2),
(6, '2026_01_13_144800_add_break_hours_to_dtr_logs_table', 3),
(7, '2026_01_14_090238_create_accomplishments_table', 4),
(8, '2026_01_14_151048_add_required_hours_and_school_to_users_table', 5),
(9, '2026_01_15_101649_add_profile_and_cover_photos_to_users_table', 6),
(10, '2026_01_15_104926_create_notifications_table', 7),
(11, '2026_01_23_112124_add_face_recognition_fields_to_users_and_dtr_logs', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `icon`, `link`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, 'system', '👋 Welcome to OJTracker!', 'Welcome Soydelz Dela Peña! Start tracking your OJT hours by logging your Time In/Out on the Dashboard.', '👋', 'http://localhost/OJTracker/dashboard', 0, '2026-01-15 02:58:45', '2026-01-15 02:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `required_hours` int(11) NOT NULL DEFAULT 590,
  `school` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `face_descriptor` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `required_hours`, `school`, `password`, `profile_picture`, `cover_photo`, `face_descriptor`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Soydelz Dela Peña', 'soydelz', 'syydlzz@gmail.com', '2026-01-15 02:07:35', 590, 'Southern de Oro Philippines College', '$2y$12$Y/01dCZyUKkX/G1k2N1bquBiRH/VDduFgzBRB8riRo7fOM6781GMG', 'profiles/gzeEJDrfeXcaVTf8uua8lnlYK3n3JDOGhk7Ev0pP.png', 'covers/nKjO96gs861fjyZHWwSFzQeaFJojuU2NGyEPe1hB.jpg', '[-0.11869791150093079,0.08882013708353043,0.013567078858613968,-0.051184628158807755,-0.020233575254678726,-0.1355513632297516,0.007822971791028976,-0.10563994944095612,0.18828198313713074,-0.04262511432170868,0.3096872568130493,-0.02393028698861599,-0.22859050333499908,-0.1220579743385315,0.007471358869224787,0.15839050710201263,-0.18194295465946198,-0.0920574963092804,-0.07451578229665756,-0.0832047164440155,0.035980336368083954,-0.04087897017598152,0.05085699260234833,0.07954239845275879,-0.12225200235843658,-0.2916375994682312,-0.11682067811489105,-0.15003690123558044,0.10103175789117813,-0.03204227611422539,0.003909663762897253,0.02442016638815403,-0.17750899493694305,-0.1142834722995758,0.08204630762338638,-0.0013453764840960503,-0.021372631192207336,0.009295140393078327,0.28692367672920227,-0.01115435641258955,-0.18967100977897644,-0.09877996891736984,0.027465298771858215,0.23863889276981354,0.14157529175281525,0.015624512918293476,0.07830963283777237,-0.06880112737417221,0.08300197869539261,-0.1704147458076477,0.0386069118976593,0.1290862113237381,0.16323593258857727,0.04335780069231987,0.03802700713276863,-0.1438356637954712,-0.007187645882368088,0.2093777060508728,-0.23003025352954865,0.08124849200248718,0.05800239369273186,-0.1720789670944214,-0.09165238589048386,-0.021173954010009766,0.2630639374256134,0.08495576679706573,-0.15623067319393158,-0.1404765248298645,0.24148908257484436,-0.12540580332279205,-0.004500964190810919,0.11867322027683258,-0.10659757256507874,-0.19694750010967255,-0.31173762679100037,0.023559562861919403,0.4351414740085602,0.11340051144361496,-0.17395645380020142,0.04096387326717377,-0.09149104356765747,-0.038334138691425323,0.0534469336271286,0.12613029778003693,-0.0813545510172844,0.05376181751489639,-0.04887456074357033,-0.013320193625986576,0.14739985764026642,-0.02418740838766098,-0.022944575175642967,0.18052399158477783,-0.043885089457035065,0.10026999562978745,0.012960916385054588,-0.02037244662642479,-0.06490066647529602,-0.07466067373752594,-0.08022225648164749,-0.009453549981117249,-0.03723949193954468,-0.06382206082344055,0.03367238864302635,0.06403125822544098,-0.13603784143924713,0.09648586064577103,0.018215667456388474,-0.029264291748404503,-0.09185121208429337,0.042520832270383835,-0.005372227169573307,-0.0837816670536995,0.12092889845371246,-0.2561272382736206,0.22808659076690674,0.18086573481559753,0.029013508930802345,0.14964881539344788,0.029125751927495003,0.03443580120801926,0.010661046020686626,-0.04970588907599449,-0.13796013593673706,-0.02606086991727352,0.06105803698301315,-0.09009206295013428,0.13391824066638947,-0.035157594829797745]', 'cBPpyf5VUJtKBWcDaFCfBryjns412oZ6KXXUFkUZhVNfuyhqUh2uKu8oOKm9', '2026-01-12 19:11:49', '2026-01-23 05:53:24'),
(3, 'Carl Gallardo', 'carlgallardo', 'carlwynegallardo@gmail.com', NULL, 500, 'St. Rita\'s College of Balingasag', '$2y$12$kNfijnuCuqdQfFtBtqLUw.X1eLeP0xKiwiqCZIfmB7sebh/1wNe6S', NULL, NULL, NULL, 'HnyWwNreGsWEBsw5p5c5teTxkSeVbKExHnQiBCazgdKo4scGoYpIBShejsr6', '2026-01-14 07:42:56', '2026-01-14 07:42:56'),
(4, 'Barrozo, Virgilio Jr. Lampad', 'virggg05', 'virgbarrozo15@gmail.com', NULL, 590, 'Southern de Oro Philipines College', '$2y$12$fz0mSYM.ZbEa3IMcAFxBdeJ2qT0D7iVl8dLQNy78Scs72HOgf4fQq', NULL, NULL, NULL, NULL, '2026-01-14 08:02:55', '2026-01-14 08:02:55'),
(5, 'C Jay L. Macuse', 'makyuz', 'cjlo.macuse.coc@phinmaed.com', NULL, 486, 'PHINMA COC', '$2y$12$nECDJ9A6SgfuY3HZPXsu6OjxXXoooExbDFYkVrJtdtincoYU6C2BW', NULL, NULL, NULL, '3GbE0mvHUQcCZCm1ccd62hxGwgAOdF0tmhsedlTjKXyFpG6d1jNueDUqwWEU', '2026-01-14 08:07:06', '2026-01-14 08:07:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accomplishments`
--
ALTER TABLE `accomplishments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accomplishments_user_id_date_index` (`user_id`,`date`);

--
-- Indexes for table `dtr_logs`
--
ALTER TABLE `dtr_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dtr_logs_user_id_date_unique` (`user_id`,`date`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accomplishments`
--
ALTER TABLE `accomplishments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dtr_logs`
--
ALTER TABLE `dtr_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accomplishments`
--
ALTER TABLE `accomplishments`
  ADD CONSTRAINT `accomplishments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dtr_logs`
--
ALTER TABLE `dtr_logs`
  ADD CONSTRAINT `dtr_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

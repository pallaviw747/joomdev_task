-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2025 at 05:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `joomdev_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email_id` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `last_login` datetime DEFAULT NULL,
  `last_password_change` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active, 0=Inactive',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email_id`, `phone`, `password`, `role`, `last_login`, `last_password_change`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'admin', NULL, NULL, 1, '2025-02-05 11:06:12', '2025-02-05 13:11:08'),
(2, 'test', 'user', 'abc@gmail.com', '9890876756', '$2y$10$tWNZJow/OeLwyb2f52DPu.8IftAg18h8Q6GDpSyBcNKgYfOEjCkra', 'user', NULL, NULL, 1, '0000-00-00 00:00:00', '2025-02-05 13:02:38'),
(3, 'test', 'user2', 'test.user2@gmail.com', '9089786789', '$2y$10$nUXyco3GbVpb9Wrpv8SxDOl2LqxC.JUz5q49sHH3aj8gCpb7/NrRi', 'user', NULL, NULL, 1, '2025-02-05 14:25:43', '2025-02-05 13:25:43'),
(4, 'test', 'user3', 'testuser3@gmail.com', '5678786789', '$2y$10$t89BsKY7RXe8znwftuIRl.wxB14kVWs/ykq8wporHxfWzt2FCnQKq', 'user', '2025-02-06 06:57:56', '2025-02-06 06:57:56', 1, '2025-02-05 14:50:43', '2025-02-11 04:09:01'),
(5, 'test', 'user4', 'testuser4@gmail.com', '8978908978', '$2y$10$issSTA0sx1OJ739Ht/UiQu8mCnsKIdd2W9C.2ePP2U7pZ0/z3f.De', 'user', '2025-02-06 09:23:49', '2025-02-06 09:23:49', 1, '2025-02-06 09:23:26', '2025-02-06 08:23:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_tasks`
--

CREATE TABLE `user_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `start_time` timestamp NULL DEFAULT NULL,
  `stop_time` timestamp NULL DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tasks`
--

INSERT INTO `user_tasks` (`id`, `user_id`, `start_time`, `stop_time`, `notes`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, '2025-02-04 09:00:00', '2025-02-05 14:03:00', 'task 1 completed', 'task 1 completed with no issues', 1, '2025-02-06 08:59:56', '2025-02-06 07:59:56'),
(2, 4, '2025-02-05 03:30:00', '2025-02-05 15:02:00', 'task 2', 'task 2 completed', 1, '2025-02-06 08:59:56', '2025-02-06 07:59:56'),
(3, 4, '2025-02-05 03:00:00', '2025-02-06 07:59:00', 'task 3', 'task 3 completed', 1, '2025-02-06 08:59:56', '2025-02-06 07:59:56'),
(4, 5, '2025-02-04 05:30:00', '2025-02-06 08:24:00', 'all task completed', 'completed', 1, '2025-02-06 09:25:22', '2025-02-06 08:25:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_tasks`
--
ALTER TABLE `user_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

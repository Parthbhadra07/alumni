-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 02:36 PM
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
-- Database: `user_auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `approved_registrations`
--

CREATE TABLE `approved_registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `stream` varchar(255) NOT NULL,
  `year` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `current_work` varchar(255) DEFAULT NULL,
  `photo` varchar(500) NOT NULL,
  `approval_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approved_registrations`
--

INSERT INTO `approved_registrations` (`id`, `user_id`, `username`, `email`, `stream`, `year`, `gender`, `current_work`, `photo`, `approval_date`) VALUES
(22, 10, 'parth', 'bhadraparth1@gmail.com', 'bca', '2004-09-16', 'male', 'ghgg', 'uploads/Screenshot 2024-02-03 195507.png', '2025-03-16 15:17:32'),
(26, 12, 'siddhi', 'psiddhi@gmail.com', 'Mca', '2040-05-15', 'male', 'rkdesai', 'uploads/wp5709607-hacker-desktop-4k-wallpapers.jpg', '2025-03-17 04:40:05');

-- --------------------------------------------------------

--
-- Table structure for table `unapproved_submissions`
--

CREATE TABLE `unapproved_submissions` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `stream` varchar(50) NOT NULL,
  `year` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `current_work` varchar(100) DEFAULT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `rejection_reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(10, 'parth', '$2y$10$67gilTYmvff3UMB9p4d0duIwFTeDG9t7J6DkTNWx1Bd5egI5LuMIe'),
(11, 'aman', '$2y$10$cT.0wVCjRXZExaur04bUr.NN8bimtHd4A3IV/uYNhlGrkeNc9cBUC'),
(12, 'siddhi', '$2y$10$x5XWEuVsONs1NaUBK6Rda.utNZPWz5ubYzZYRPWCr6RuVz2PsxRYW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approved_registrations`
--
ALTER TABLE `approved_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `unapproved_submissions`
--
ALTER TABLE `unapproved_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approved_registrations`
--
ALTER TABLE `approved_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `unapproved_submissions`
--
ALTER TABLE `unapproved_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approved_registrations`
--
ALTER TABLE `approved_registrations`
  ADD CONSTRAINT `approved_registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `unapproved_submissions`
--
ALTER TABLE `unapproved_submissions`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

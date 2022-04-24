-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 22, 2022 at 03:45 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arbitrary_team_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `type` enum('In-Person','Virtual') COLLATE utf8mb4_bin NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `organization` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `presenter` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `user_id`, `name`, `type`, `start_time`, `end_time`, `organization`, `presenter`, `description`) VALUES
(1, 6, 'Preparation for class A', 'In-Person', '2022-04-06', '2022-04-09', 'Jackson College', 'Michael', 'This is a necessary course.'),
(2, 6, 'Preparation for class B', 'Virtual', '2022-04-06', '2022-04-09', '', 'Michael', 'This is a necessary course.'),
(13, 6, 'Preparation for class C', 'In-Person', '2022-04-06', '2022-04-09', 'Jackson College', 'Michael', 'This is a necessary course.'),
(14, 6, 'Preparation for class D', 'Virtual', '2022-04-06', '2022-04-09', '', 'Michael', 'This is a necessary course.'),
(15, 6, 'Yuzhen Zhang', 'Virtual', '2022-04-19', '2022-04-26', '123', '999', 'abc'),
(26, 6, 'Yuzhen Zhang', 'In-Person', '2022-04-09', '2022-04-16', '', '', ''),
(27, 16, 'Yuzhen', 'Virtual', '2022-04-09', '2022-04-06', '', '', ''),
(28, 16, '6qw5', 'Virtual', '2022-04-09', '2022-04-06', '', '', ''),
(29, 16, '6qw5', 'Virtual', '2022-04-09', '2022-04-06', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` enum('Full-Time','Adjunct','Uncertain') COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password_hash`, `status`, `email`) VALUES
(5, 'Tyr999', '$2y$10$Dn4ovsR0lQNl6G25Wjj6XeJa5plNlrBrLMxgN86ZAHIoqUlCrYaUS', NULL, ''),
(6, '999abc', '$2y$10$WSg.KeEpZVDZJucntE7gO.9HPWwPumGUuPSRvMBG5xGWqy.tl6wVm', NULL, ''),
(15, 'abc', '$2y$10$XZCMlwYOleEDoLLgxce51e9wOxY9vN/HH4ziWPYqQgp4Yh.HxlBt.', NULL, ''),
(16, 'Tyr123', '$2y$10$6ckvf702ZB1c9XJRljJhAeIQFtM9Yv3i.vQFhIEnPP2giksWON2Zi', NULL, 'zxcv1050135042@126.com'),
(17, 'josh', '$2y$10$PBL59SURFaxsLu6rYKfmxul8un3mSnVmMVDSvB8Xns7koxrTMlb/6', NULL, 'riddlejoshua98@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activity_id_uindex` (`id`),
  ADD KEY `activity_fk_user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_uindex` (`id`),
  ADD UNIQUE KEY `user_name_uindex` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `activity_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

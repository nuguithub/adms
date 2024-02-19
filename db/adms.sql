-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2024 at 08:01 AM
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
-- Database: `adms`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `alumni_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_number` varchar(9) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `civil_status` enum('Single','Married','Divorced','Widowed','Other') NOT NULL,
  `birthday` date NOT NULL,
  `address_` text NOT NULL,
  `contact_no` varchar(13) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `approved` varchar(8) DEFAULT NULL,
  `archive` varchar(10) DEFAULT NULL,
  `archive_expiry` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`alumni_id`, `user_id`, `student_number`, `img`, `fname`, `mname`, `lname`, `gender`, `civil_status`, `birthday`, `address_`, `contact_no`, `email`, `approved`, `archive`, `archive_expiry`) VALUES
(3, NULL, '202011111', NULL, 'Alexander', 'Llamas', 'Samo', 'Male', 'Married', '2001-02-06', 'General Trias, Cavite', NULL, NULL, NULL, NULL, NULL),
(4, NULL, '202011112', NULL, 'Juan', 'Yano', 'Dela Cruz', 'Male', 'Single', '2005-02-27', 'General Trias, Cavite', NULL, NULL, NULL, NULL, NULL),
(5, NULL, '202011113', NULL, 'Mario', 'Dimagiba', 'Santos', 'Male', 'Single', '2003-05-01', 'Silang, Cavite', NULL, NULL, NULL, NULL, NULL),
(6, 13, '202011114', NULL, 'Kyla', 'Santos', 'Reyes', 'Female', 'Single', '2003-12-12', 'Nasugbu, Batangas', NULL, 'kylareyes@example.com', NULL, NULL, NULL),
(7, 15, '202013211', NULL, 'Andrei', 'Ybanez', 'Mercado', 'Male', 'Single', '2003-05-26', 'General Trias, Cavite', NULL, 'andrei.dead@sample.test', NULL, NULL, NULL),
(8, NULL, '202119099', NULL, 'Biya', 'Very', 'Sungit', 'Female', 'Single', '2002-12-12', 'Laguna', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`alumni_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `alumni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `accounts` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `emails` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 03:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
  `coll_dept` varchar(10) DEFAULT NULL,
  `coll_course` varchar(10) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  `approved` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`alumni_id`, `user_id`, `student_number`, `img`, `fname`, `mname`, `lname`, `gender`, `civil_status`, `birthday`, `address_`, `contact_no`, `email`, `coll_dept`, `coll_course`, `batch`, `approved`) VALUES
(1, 4, '202014190', NULL, 'Alfred', 'Javier', 'Nuguit', 'Male', 'Single', '2001-08-27', 'Imus, Cavite', NULL, 'alfnuguitxx@gmail.com', 'CEIT', 'BSIT', 2022, 'approved'),
(2, NULL, '202014293', NULL, 'Smile', 'G', 'Barcelona', 'Female', 'Divorced', '2003-02-05', 'Dasmarinas, Cavite', NULL, NULL, 'CEIT', 'BSIT', 2024, NULL),
(3, NULL, '202014556', NULL, 'Jan Rayven', NULL, 'Velasco', 'Male', 'Single', '2002-09-08', 'Dasmarinas, Cavite', NULL, NULL, 'CEIT', 'BSIT', 2024, NULL),
(4, NULL, '202011455', NULL, 'Kent David', NULL, 'Higyawan', 'Male', 'Single', '2002-03-14', 'Dasmarinas, Cavite', NULL, NULL, 'CEIT', 'BSIT', 2024, NULL),
(5, NULL, '202011111', NULL, 'Alexander', 'Llamas', 'Samo', 'Male', 'Married', '2001-02-06', 'General Trias, Cavite', NULL, NULL, 'CEIT', 'BSIT', 2024, NULL),
(6, NULL, '202011112', NULL, 'Juan', 'Yano', 'Dela Cruz', 'Male', 'Single', '2002-02-27', 'General Trias, Cavite', NULL, NULL, 'CEIT', 'BSIT', 2024, NULL),
(7, NULL, '202011113', NULL, 'Mario', 'Dimagiba', 'Santos', 'Male', 'Single', '2003-05-01', 'Silang, Cavite', NULL, NULL, 'CEIT', 'BSIT', 2024, NULL),
(8, NULL, '202011114', NULL, 'Kyla', 'Santos', 'Reyes', 'Female', 'Single', '2003-12-12', 'Nasugbu, Batangas', NULL, NULL, 'CEIT', 'BSIT', 2024, NULL),
(9, 8, '202011421', NULL, 'Josef', NULL, 'Dreamer', 'Male', 'Single', '2002-07-09', '', NULL, 'jowsefx1@jowsef.com', 'CEIT', 'BSCS', 2024, NULL),
(15, 5, '202312313', NULL, 'Jake', NULL, 'Ersando', 'Male', 'Single', '2023-12-08', '', NULL, NULL, 'CEIT', 'BSIT', 2023, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `venue` text NOT NULL,
  `organizer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `img`, `title`, `content`, `event_date`, `event_time`, `venue`, `organizer`) VALUES
(1, 'Green.png', 'Announcement1', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias libero eum voluptatibus unde placeat sit inventore minima eius corrupti nisi. At nulla iste incidunt tempore quisquam sapiente dolorem corporis aliquid!', '2023-12-30', '09:20:00', 'TBA', 'Ron'),
(2, 'Stray SS.png', 'Announcement2', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias libero eum voluptatibus unde placeat sit inventore minima eius corrupti nisi. At nulla iste incidunt tempore quisquam sapiente dolorem corporis aliquid!', '2023-12-07', '14:30:00', 'CvSU', 'Kent'),
(3, 'BG.jpg', 'Announcement3', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias libero eum voluptatibus unde placeat sit inventore minima eius corrupti nisi. At nulla iste incidunt tempore quisquam sapiente dolorem corporis aliquid!', '2023-03-07', '13:00:00', 'Grand Stand', 'Rayven');

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `career_id` int(11) NOT NULL,
  `career_name` varchar(100) NOT NULL,
  `department` varchar(10) NOT NULL,
  `course` varchar(10) NOT NULL,
  `related` varchar(3) NOT NULL DEFAULT 'YES'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `careers`
--

INSERT INTO `careers` (`career_id`, `career_name`, `department`, `course`, `related`) VALUES
(1, 'Junior Web Developer', 'CEIT', 'BSIT', 'YES'),
(2, 'Senior Web Developer', 'CEIT', 'BSIT', 'YES'),
(3, 'Network Engineer', 'CEIT', 'BSIT', 'YES'),
(4, 'Software Developer', 'CEIT', 'BSCS', 'YES'),
(5, 'Call Center Agent', 'CEIT', 'BSIT', 'NOT');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_code` varchar(100) NOT NULL,
  `course_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `department_id`, `course_code`, `course_name`) VALUES
(1, 1, 'BSIT', 'Bachelors of Science in Information Technology'),
(2, 2, 'BSN', 'Bachelor of Science in Nursing'),
(3, 1, 'BSCS', 'Bachelors of Science in Computer Science');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `dept_code` varchar(10) DEFAULT NULL,
  `dept_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `dept_code`, `dept_name`) VALUES
(1, 'CEIT', 'College of Engineering and Information Technology'),
(2, 'CON', 'College of Nursing');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `author_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `img`, `title`, `content`, `created_at`, `author_name`) VALUES
(1, 'BoneThugz.jpg', 'Sample1', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias libero eum voluptatibus unde placeat sit inventore minima eius corrupti nisi. At nulla iste incidunt tempore quisquam sapiente dolorem corporis aliquid!', '2023-09-30 13:20:42', 'Ron'),
(2, 'Custom-BG.png', 'Sample2', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias libero eum voluptatibus unde placeat sit inventore minima eius corrupti nisi. At nulla iste incidunt tempore quisquam sapiente dolorem corporis aliquid!', '2023-11-05 04:57:00', 'Kent'),
(3, 'Coffee-Wallpaper.jpg', 'Sample3', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias libero eum voluptatibus unde placeat sit inventore minima eius corrupti nisi. At nulla iste incidunt tempore quisquam sapiente dolorem corporis aliquid!', '2023-11-06 02:43:51', 'Rayven'),
(4, 'BG.jpg', 'Sample4', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias libero eum voluptatibus unde placeat sit inventore minima eius corrupti nisi. At nulla iste incidunt tempore quisquam sapiente dolorem corporis aliquid!', '2023-11-06 02:44:06', 'Alfred');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `passwordx` varchar(100) NOT NULL,
  `role_` enum('alumni','alumni_admin','college_coordinator','super_admin') NOT NULL DEFAULT 'alumni',
  `college` varchar(10) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `passwordx`, `role_`, `college`, `token`, `token_expiry`) VALUES
(1, 'superadmin', NULL, '$2y$10$S6zIPxlxr3yoqFhDMFsf4.5lxEGXZ2n1wEd6FtizwB7XmcPtPV2T.', 'super_admin', NULL, NULL, NULL),
(2, 'admin', NULL, '$2y$10$Zk6PW4Ssf5osKdiZ8r4w4uTF0Z0nZkhlpS8hobbqJnaGE.iHGBsSq', 'alumni_admin', NULL, NULL, NULL),
(3, 'coordinator', NULL, '$2y$10$BcBXZvnbltfjvIgNNJAbNOxJqeSdB.4h.Cs4KtGV4hD.FNUqQ.5Nm', 'college_coordinator', 'CEIT', NULL, NULL),
(4, 'alfred', 'alfnuguitxx@gmail.com', '$2y$10$dYzcTPnBWTlZVrnmQcVDoui6Nmqm52juCRHyNUPJ0lVA.IdZWrti.', 'alumni', NULL, NULL, NULL),
(5, 'jake11', NULL, '$2y$10$bl047/3zW5Fw5WQLazyY5edDUFvOsJisLgFxB8NWa3MfSbRqo9LRm', 'alumni', NULL, NULL, NULL),
(6, 'condinator', NULL, '$2y$10$mnSWanpaDuLxv0OQcjBh0ewKKjHV548WVWTyaNNtzkAxGiw2qhfpO', 'college_coordinator', 'CON', NULL, NULL),
(8, 'jowsefx1', 'jowsefx1@jowsef.com', '$2y$10$gZ0PK3eAe04ev03.cLQq7uaeqseyu2jCZDrvCSo2e41ZjcAAac67K', 'alumni', NULL, NULL, NULL),
(9, 'ceitnator', NULL, '$2y$10$QyxHnCbQJjeZLSZuelI22uKpAQcou9uX8MPEyYw9XntxO2V8PstkO', 'college_coordinator', 'CEIT', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `date` datetime NOT NULL,
  `ip` varchar(255) NOT NULL,
  `user_visit` int(11) NOT NULL,
  `alumni_visit` int(11) NOT NULL,
  `coordinator_visit` int(11) NOT NULL,
  `admin_visit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`date`, `ip`, `user_visit`, `alumni_visit`, `coordinator_visit`, `admin_visit`) VALUES
('2023-10-24 00:00:00', '::1', 27, 0, 1, 0),
('2023-10-25 00:00:00', '::1', 1, 0, 0, 0),
('2023-10-29 00:00:00', '::1', 1, 0, 2, 0),
('2023-10-30 00:00:00', '::1', 1, 0, 0, 0),
('2023-10-31 00:00:00', '::1', 2, 3, 4, 0),
('2023-11-04 00:00:00', '::1', 1, 1, 1, 0),
('2023-11-05 00:00:00', '::1', 2, 1, 1, 1),
('2023-11-06 00:00:00', '::1', 6, 4, 7, 4),
('2023-11-13 00:00:00', '::1', 1, 0, 0, 0),
('2023-11-19 00:00:00', '::1', 3, 2, 8, 0),
('2023-11-26 00:00:00', '::1', 1, 1, 3, 0),
('2023-11-27 00:00:00', '::1', 2, 1, 4, 3),
('2023-11-29 00:00:00', '::1', 2, 1, 2, 0),
('2023-12-04 00:00:00', '::1', 1, 0, 9, 4),
('2023-12-05 00:00:00', '::1', 1, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `workhistory`
--

CREATE TABLE `workhistory` (
  `work_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `workStart` varchar(255) NOT NULL,
  `workEnd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workhistory`
--

INSERT INTO `workhistory` (`work_id`, `user_id`, `company`, `position`, `workStart`, `workEnd`) VALUES
(1, 4, 'IBM', 'Junior Web Developer', '2023-01', 'Present');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`alumni_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `coll_dept_id` (`coll_dept`),
  ADD KEY `fk_coll_course` (`coll_course`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`career_id`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`),
  ADD UNIQUE KEY `dept_code_2` (`dept_code`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token_hash` (`token`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `coll_dept` (`college`);

--
-- Indexes for table `workhistory`
--
ALTER TABLE `workhistory`
  ADD PRIMARY KEY (`work_id`),
  ADD UNIQUE KEY `work_id` (`work_id`,`user_id`),
  ADD KEY `alumWork` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `alumni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `workhistory`
--
ALTER TABLE `workhistory`
  MODIFY `work_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `accounts` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `course_1` FOREIGN KEY (`coll_course`) REFERENCES `courses` (`course_code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dept_1` FOREIGN KEY (`coll_dept`) REFERENCES `departments` (`dept_code`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`dept_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `coll_dept` FOREIGN KEY (`college`) REFERENCES `departments` (`dept_code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `emails` FOREIGN KEY (`email`) REFERENCES `alumni` (`email`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `workhistory`
--
ALTER TABLE `workhistory`
  ADD CONSTRAINT `alumWork` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

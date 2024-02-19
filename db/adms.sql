-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2024 at 09:59 AM
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
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `alumni_id` int(11) NOT NULL,
  `achievement` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(6, 13, '202011114', NULL, 'Kyla', 'Santos', 'Reyes', 'Female', 'Single', '2003-12-12', 'Nasugbu, Batangas', NULL, 'alfnuguitxx@gmail.com', 'approved', NULL, NULL),
(7, 15, '202013211', NULL, 'Andrei', 'Ybanez', 'Mercado', 'Male', 'Single', '2003-05-26', 'General Trias, Cavite', NULL, 'andrei.dead@sample.test', NULL, NULL, NULL),
(8, NULL, '202119099', NULL, 'Biya', 'Very', 'Sungit', 'Female', 'Single', '2002-12-12', 'Laguna', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `alumni_program`
--

CREATE TABLE `alumni_program` (
  `alumni_program_id` int(11) NOT NULL,
  `alumni_id` int(11) NOT NULL,
  `coll_dept` varchar(10) NOT NULL,
  `coll_course` varchar(10) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni_program`
--

INSERT INTO `alumni_program` (`alumni_program_id`, `alumni_id`, `coll_dept`, `coll_course`, `batch`) VALUES
(3, 3, 'CEIT', 'BSIT', 2024),
(4, 4, 'CEIT', 'BSIT', 2024),
(5, 5, 'CEIT', 'BSIT', 2024),
(6, 6, 'CEIT', 'BSIT', 2024),
(7, 7, 'CEIT', 'BSIT', 2023),
(8, 8, 'CEIT', 'BSIT', 2024);

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
(1, 'Web Developer', 'CEIT', 'BSIT', 'YES'),
(2, 'IT Technician', 'CEIT', 'BSIT', 'YES'),
(19, 'Testx', 'CEIT', 'BSCS', 'YES'),
(21, 'Professor I', 'CEIT', 'BSCS', 'NOT'),
(22, 'Barista', 'CEIT', 'BSIT', 'NOT');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_code` varchar(10) NOT NULL,
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
-- Table structure for table `mailer`
--

CREATE TABLE `mailer` (
  `id` int(11) NOT NULL,
  `emailx` varchar(255) NOT NULL,
  `passx` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mailer`
--

INSERT INTO `mailer` (`id`, `emailx`, `passx`) VALUES
(1, '$2y$10$objXAWJ7aGQ2b7u7axREhOq3nbjXYPSYx4O.bobKGyU0u1TyIlwXq', '$2y$10$DDqiQivV8SoQxtlb6o1FaO67LOmx/HFu3IVj7Ia9mTkL.oOMpaCoq');

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
(4, 'BG.jpg', 'Sample4', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias libero eum voluptatibus unde placeat sit inventore minima eius corrupti nisi. At nulla iste incidunt tempore quisquam sapiente dolorem corporis aliquid.', '2023-11-06 02:44:00', 'Alfred');

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
(2, 'admin', NULL, '$2y$10$FsrRygvXsQpnKj57DY2lH.OcdwWAEg3oNF64gJjYeAKTr6iTE4dye', 'alumni_admin', NULL, NULL, NULL),
(3, 'ceitcoor', NULL, '$2y$10$BcBXZvnbltfjvIgNNJAbNOxJqeSdB.4h.Cs4KtGV4hD.FNUqQ.5Nm', 'college_coordinator', 'CEIT', NULL, NULL),
(13, 'kyla.kyla', 'alfnuguitxx@gmail.com', '$2y$10$s/GJL1HQQTKGfelRtYh/5Ou8sHEgi8apJNGJMEykTDu0Z7ArncslK', 'alumni', NULL, '$2y$10$WPGOE5IP9KlFH7iniy.L0.YOSa2Jxz9O9HewX8xto960T5Pddbgi.', '2024-02-19 09:08:48'),
(14, 'rudolf', 'rudolf.reindeer@sample.email', '$2y$10$B8Kov8gPwg2RPZ9mZeK/vuJMFr3WigVq0dF0Mf5J.gzYvW.H6PuS6', 'alumni', NULL, NULL, NULL),
(15, 'andrei', 'andrei.dead@sample.test', '$2y$10$E4M1fLnlBhsHt4F96nHWW.jZzuHRHR62av8ilhlacIYUoHlNJ1TSm', 'alumni', NULL, NULL, NULL);

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
('2023-12-05 00:00:00', '::1', 1, 4, 0, 0),
('2023-12-07 00:00:00', '::1', 2, 2, 0, 0),
('2023-12-08 00:00:00', '::1', 4, 5, 1, 0),
('2023-12-10 00:00:00', '::1', 3, 1, 5, 6),
('2023-12-11 00:00:00', '::1', 1, 2, 1, 0),
('2023-12-18 00:00:00', '::1', 2, 1, 2, 2),
('2023-12-27 00:00:00', '::1', 3, 3, 7, 1),
('2023-12-30 00:00:00', '::1', 1, 1, 0, 2),
('2024-01-02 00:00:00', '::1', 2, 1, 1, 0),
('2024-01-03 00:00:00', '::1', 2, 1, 1, 0),
('2024-01-07 00:00:00', '::1', 2, 2, 4, 3),
('2024-01-08 00:00:00', '::1', 1, 0, 0, 1),
('2024-01-09 00:00:00', '::1', 3, 2, 7, 1),
('2024-01-10 00:00:00', '::1', 2, 1, 3, 2),
('2024-01-13 00:00:00', '::1', 1, 0, 0, 0),
('2024-01-17 00:00:00', '::1', 5, 0, 2, 2),
('2024-02-12 00:00:00', '::1', 1, 1, 3, 0),
('2024-02-13 00:00:00', '::1', 2, 3, 3, 0),
('2024-02-14 00:00:00', '::1', 3, 5, 10, 3),
('2024-02-15 00:00:00', '::1', 2, 3, 4, 3),
('2024-02-16 00:00:00', '::1', 2, 1, 3, 0),
('2024-02-18 00:00:00', '::1', 2, 0, 4, 1),
('2024-02-19 00:00:00', '::1', 3, 0, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `workhistory`
--

CREATE TABLE `workhistory` (
  `work_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company` varchar(255) NOT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `work_location` enum('Foreign','Local') DEFAULT 'Local',
  `position` varchar(255) NOT NULL,
  `empStat` varchar(50) NOT NULL,
  `workStart` varchar(255) NOT NULL,
  `workEnd` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workhistory`
--

INSERT INTO `workhistory` (`work_id`, `user_id`, `company`, `company_address`, `work_location`, `position`, `empStat`, `workStart`, `workEnd`, `date_added`) VALUES
(13, 14, 'Big Brew', 'Indang, Cavite', 'Local', 'Barista', 'Temporary', '2024-01', 'Present', '2024-02-15 13:15:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumniiii` (`alumni_id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`alumni_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `alumni_program`
--
ALTER TABLE `alumni_program`
  ADD PRIMARY KEY (`alumni_program_id`),
  ADD KEY `alumni_id` (`alumni_id`),
  ADD KEY `course_1` (`coll_course`),
  ADD KEY `dept_1` (`coll_dept`);

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
-- Indexes for table `mailer`
--
ALTER TABLE `mailer`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `alumWork` (`user_id`),
  ADD KEY `workHistory` (`position`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `alumni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `alumni_program`
--
ALTER TABLE `alumni_program`
  MODIFY `alumni_program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mailer`
--
ALTER TABLE `mailer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `workhistory`
--
ALTER TABLE `workhistory`
  MODIFY `work_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `alumniiii` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`alumni_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `accounts` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `emails` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `alumni_program`
--
ALTER TABLE `alumni_program`
  ADD CONSTRAINT `alumni_program_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`alumni_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_1` FOREIGN KEY (`coll_course`) REFERENCES `courses` (`course_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`dept_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `coll_dept` FOREIGN KEY (`college`) REFERENCES `departments` (`dept_code`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `workhistory`
--
ALTER TABLE `workhistory`
  ADD CONSTRAINT `alumWork` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

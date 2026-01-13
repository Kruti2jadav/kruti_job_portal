-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2026 at 05:42 PM
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
-- Database: `naukri_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `recruiter_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `recruiter_id`, `title`, `skills`, `description`, `created_at`) VALUES
(1, 1, 'Php developer', 'php , Html, css, bootstrap, javascript', 'Experience 1 year', '2026-01-13 11:07:18'),
(2, 1, 'python developer', 'Html, css, bootstrap, javascript, laravel python', 'No Experience', '2026-01-13 16:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stage` enum('Applied','Shortlisted','Technical Checked','HR Checked','Selected') NOT NULL DEFAULT 'Applied',
  `resume_score` float DEFAULT NULL,
  `github_score` float DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `git_lang` varchar(255) DEFAULT NULL,
  `tech_score` float DEFAULT NULL,
  `tech_comment` varchar(255) DEFAULT NULL,
  `hr_score` float DEFAULT NULL,
  `hr_comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `candidate_id`, `resume`, `skills`, `applied_at`, `stage`, `resume_score`, `github_score`, `score`, `git_lang`, `tech_score`, `tech_comment`, `hr_score`, `hr_comment`) VALUES
(1, 1, 2, '1768315191_Kruti_tech_resume.pdf', 'php , Html, css, bootstrap, javascript', '2026-01-13 15:00:51', 'Selected', 85.7143, 21, 53, 'JavaScript,SCSS,HTML,CSS,PHP,Blade', 55, 'good one', 90, 'good one'),
(2, 2, 3, '1768321109_Aniket Resume.pdf', 'Html, css, bootstrap, javascript, python', '2026-01-13 16:19:24', 'HR Checked', 71.4286, 100, 86, 'JavaScript,CSS,HTML,PHP,Hack,SCSS,Less', 80, 'good', 86, 'good'),
(3, 1, 3, '1768321109_Aniket Resume.pdf', 'Html, css, bootstrap, javascript, python', '2026-01-13 16:20:14', 'Applied', 71.4286, 0, 36, 'JavaScript,CSS,HTML,PHP,HTML,CSS,PHP,Hack,HTML,HTML,JavaScript,CSS,SCSS,Less,JavaScript,HTML,CSS,PHP,Hack,CSS', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('candidate','recruiter','hrreviewer','techreviewer') DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `resume` varchar(555) DEFAULT NULL,
  `gitprofile` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `skills`, `resume`, `gitprofile`, `created_at`) VALUES
(1, 'Kruti', 'kruti@gmail.com', '$2y$12$LYaFzMLp3Pi.VJjsEq7qoOW39dD2WLUk7.aP3Te9rEIhA8Nz0T9rq', 'recruiter', '', '', NULL, '2026-01-13 10:04:08'),
(2, 'pooja', 'pooja@gmail.com', '$2y$12$L4tUg62MH7bZmMMjo08PQOKqMoemKxrJgf75DYE2wzzVMDBrTNf2S', 'candidate', 'php , Html, css, bootstrap, javascript', '1768315191_Kruti_tech_resume.pdf', 'https://github.com/Kruti2jadav', '2026-01-13 11:27:54'),
(3, 'Arpana', 'apu@gmail.com', '$2y$12$nx1AIsNpYtMYtg5JuHZQ5OSFrxxZiXsMcX2Vx8AvqQQR78U8UBR16', 'candidate', 'Html, css, bootstrap, javascript, python', '1768321109_Aniket Resume.pdf', 'https://github.com/ANIKET1074', '2026-01-13 12:27:54'),
(4, 'Pankaj', 'pankaj@gmail.com', '$2y$12$8GkdRIC2nVrmwFmoC9s9WeONy4rwF0bMyvHUb6jAlKBcROwZgF5eS', 'recruiter', NULL, NULL, NULL, '2026-01-13 13:05:26'),
(5, 'Jankhana', 'jankhana@gmail.com', '$2y$12$x9BU8LarQeLuEHFtMNevUOBYX3Eo5og17abNKNR6EDb9AeS62lbR2', 'candidate', NULL, NULL, NULL, '2026-01-13 13:06:31'),
(6, 'mann', 'man@gmail.com', '$2y$12$CTovPh8UdfaVciDdVQJ/0O2HVxEMQPvCeyLALCgx4J6oweNfgtub2', 'techreviewer', NULL, NULL, NULL, '2026-01-13 13:13:54'),
(7, 'anil', 'anil@gmail.com', '$2y$12$kqRkaxTd1I/egE3jBUaO4eHhEN1TxIV2GmEBen45.i2nv.3CP4ID.', 'hrreviewer', NULL, NULL, NULL, '2026-01-13 15:00:21'),
(8, 'Manisha', 'manisha@gmail.com', '$2y$12$Ohz97voqoU16WHNvmIM8Ruze4HISYisC2cgnCsSnLDSmBs66w7dD2', 'hrreviewer', NULL, NULL, NULL, '2026-01-13 15:10:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id_idx` (`job_id`),
  ADD KEY `candidate_id_idx` (`candidate_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_candidate_fk` FOREIGN KEY (`candidate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_job_fk` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

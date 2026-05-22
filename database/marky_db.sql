-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 04:21 PM
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
-- Database: `marky_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `year` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('work','education','certification') DEFAULT 'work',
  `month` varchar(50) DEFAULT '',
  `image` varchar(255) DEFAULT '',
  `keywords` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `year`, `title`, `company`, `description`, `type`, `month`, `image`, `keywords`) VALUES
(1, '2026', 'Bachelor of Science in Information Systems', 'Davao del Norte State College', '', 'education', '', '', ''),
(2, '2022-2024', 'Technical-Vocational-Livelihood (Cookery)', 'Panabo City National High School', '', 'education', '', '', ''),
(3, '2018-2022', 'Junior High School', 'Panabo City National High School', '', 'education', '', '', ''),
(4, '2013-2018', 'Elementary', 'Panabo Central Elementary School - SPED Center', '', 'education', '', '', ''),
(5, '2016', 'Work Immersion Student', 'Maria Clara Resort & Restaurant', 'Assisted in kitchen operations, including food preparation and maintain cleanliness to ensure a safe and efficient working environment.\n\nSupported pool area management by monitoring guest needs, ensuring safety guidelines were followed, and keeping the area organized.', 'work', '', '', ''),
(9, '2024', 'On-the-Job Training Completion Certificate', 'Maria Clara Restaurant and Resort', 'Successfully completed 80 hours of On-the-Job Training at Maria Clara Restaurant and Resort. Gained hands-on experience in workplace operations, customer service, teamwork, and professional communication in a real-world hospitality environment.', 'certification', 'March', 'assets/images/uploads/6a103972a07d8.jpg', 'OJT, Hospitality, Customer Service, Teamwork, Communication, Professional Experience');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES
(1, 'Jang Ha-ri', 'jellypenajhanrex@gmail.com', 'ascsadcsa', 'dasdsadsa', 1, '2026-05-22 13:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `page_views`
--

CREATE TABLE `page_views` (
  `id` int(11) NOT NULL,
  `view_date` date DEFAULT NULL,
  `views` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_views`
--

INSERT INTO `page_views` (`id`, `view_date`, `views`) VALUES
(1, '2026-05-22', 844);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `tech_stack` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT '',
  `project_date` varchar(100) DEFAULT '',
  `gallery_images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT '',
  `image` varchar(255) DEFAULT '',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `icon`, `image`, `description`) VALUES
(1, 'Web Development', 'fas fa-code', '6a10409615ef2.png', 'Building responsive and dynamic websites using modern web technologies.'),
(2, 'UI/UX Design', 'fab fa-figma', '6a104067c5d5f.png', 'Designing intuitive and aesthetically pleasing user interfaces.'),
(3, 'System Analysis', 'fas fa-chart-line', '6a103d10271d8.png', 'Analyzing business requirements and designing effective technical solutions.');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_title` varchar(255) DEFAULT 'Mark Dale D. Cabansag',
  `hero_title` varchar(255) DEFAULT 'INFORMATION SYSTEMS STUDENT',
  `hero_name` varchar(255) DEFAULT 'MARK DALE D. CABANSAG',
  `objective` text DEFAULT NULL,
  `email` varchar(255) DEFAULT 'markcabansag108@gmail.com',
  `phone` varchar(50) DEFAULT '0993-740-0980',
  `location` varchar(255) DEFAULT 'Purok 2b, Sto Nino, Carmen, Davao del Norte',
  `linkedin` varchar(255) DEFAULT 'https://www.linkedin.com/in/mark-dale-cabansag-010105409/',
  `github` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_title`, `hero_title`, `hero_name`, `objective`, `email`, `phone`, `location`, `linkedin`, `github`) VALUES
(1, 'MarkDale', 'INFORMATION SYSTEMS STUDENT', 'MARK DALE D. CABANSAG', 'Motivated and hardworking student seeking an opportunity to gain experience, improve skills, and contribute positively in a professional work environment. Willing to learn and adapt to new challenges.', 'markcabansag108@gmail.com', '09937500980', 'Purok 2b, Sto Nino, Carmen, Davao del Norte', 'https://www.linkedin.com/in/mark-dale-cabansag-010105409/', '');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `percentage` int(11) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `percentage`, `icon`, `image`) VALUES
(1, 'HTML', 87, 'fab fa-html5 text-danger', ''),
(2, 'CSS', 85, 'fab fa-css3-alt text-primary', ''),
(3, 'JavaScript', 70, 'fab fa-js text-warning', ''),
(4, 'PHP', 75, 'fab fa-php text-info', ''),
(5, 'Bootstrap 5', 85, 'fab fa-bootstrap text-purple', ''),
(6, 'Figma (UI/UX)', 80, 'fab fa-figma text-danger', ''),
(7, 'System Analyst (Docs)', 85, 'fas fa-file-signature text-info', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$FinlX0y5Qj7hQuD96.p97OpGuC8o9SqhBMR8FVkmQ8rLTARHYpLr.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_views`
--
ALTER TABLE `page_views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `view_date` (`view_date`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `page_views`
--
ALTER TABLE `page_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

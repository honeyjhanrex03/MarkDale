-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 05:38 PM
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
(1, '2024 - Present', 'Bachelor of Science in Information Systems (BSIS)', 'Davao del Norte State College', '', 'education', '', '', ''),
(2, '2022-2024', 'Technical-Vocational-Livelihood (Cookery)', 'Panabo City National High School', '', 'education', '', '', ''),
(3, '2018-2022', 'Panabo City National High School', '', '', 'education', '', '', ''),
(4, '2013-2018', 'Panabo Central Elementary School - SPED Center', '', '', 'education', '', '', ''),
(5, '2024', 'Work Immersion Student', 'Maria Clara Resort & Restaurant', 'Assisted in kitchen operations, including food preparation and maintain cleanliness to ensure a safe and efficient working environment.\r\n\r\nSupported pool area management by monitoring guest needs, ensuring safety guidelines were followed, and keeping the area organized.', 'work', '', '', ''),
(9, '2024', 'On-the-Job Training Completion Certificate', 'Maria Clara Restaurant and Resort', 'Successfully completed 80 hours of On-the-Job Training at Maria Clara Restaurant and Resort. Gained hands-on experience in workplace operations, customer service, teamwork, and professional communication in a real-world hospitality environment.', 'certification', 'March', 'assets/images/uploads/6a106af2af890.jpg', 'OJT, Hospitality, Customer Service, Teamwork, Communication, Professional Experience');

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
(1, '2026-05-22', 925);

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

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `image`, `link`, `tech_stack`, `client`, `project_date`, `gallery_images`) VALUES
(13, 'PCNHS E-Learning Management System UI/UX Prototype', 'Designed a complete UI/UX prototype for the PCNHS E-Learning Management System using Figma. The prototype includes responsive mobile and desktop interfaces for students and administrators, featuring dashboards, assignment management, subject tracking, scheduling, announcements, chatbot assistance, and administrative monitoring tools. The design focuses on creating a clean, user-friendly, and modern academic experience with organized workflows, intuitive navigation, and visually consistent interfaces tailored for educational environments. The project demonstrates skills in user interface design, user experience planning, dashboard structuring, responsive layouts, and educational system workflow visualization.', 'assets/images/uploads/6a107761b3558_main.png', '', 'Figma, UI/UX Design, Wireframing, Prototyping, Responsive Design, Dashboard Design', 'Academic / School Prototype Project', '06 January. 2023', 'assets/images/uploads/6a1073de5f7db_gallery_0.png,assets/images/uploads/6a1073de5f91a_gallery_1.png,assets/images/uploads/6a1073de5fa69_gallery_2.png,assets/images/uploads/6a1073de5fb98_gallery_3.png,assets/images/uploads/6a1073de5fd11_gallery_4.png,assets/images/uploads/6a1073de5fe4e_gallery_5.png,assets/images/uploads/6a1073de5ff74_gallery_6.png,assets/images/uploads/6a1073de60090_gallery_7.png,assets/images/uploads/6a1073de601d7_gallery_8.png,assets/images/uploads/6a1073de602fb_gallery_9.png,assets/images/uploads/6a1073de60425_gallery_10.png,assets/images/uploads/6a1073de60548_gallery_11.png,assets/images/uploads/6a1073de6068e_gallery_12.png,assets/images/uploads/6a1073de607b6_gallery_13.png,assets/images/uploads/6a1073de608e9_gallery_14.png,assets/images/uploads/6a1073de60a39_gallery_15.png,assets/images/uploads/6a1073de60b6c_gallery_16.png,assets/images/uploads/6a1073de60ca5_gallery_17.png,assets/images/uploads/6a1073de60dfa_gallery_18.png,assets/images/uploads/6a10763fd88a7_gallery_0.png,assets/images/uploads/6a10763fd89f0_gallery_1.png,assets/images/uploads/6a10763fd8ace_gallery_2.png,assets/images/uploads/6a10763fd8bd8_gallery_3.png,assets/images/uploads/6a10763fd8ce3_gallery_4.png,assets/images/uploads/6a10763fd8dd7_gallery_5.png,assets/images/uploads/6a10763fd8ebb_gallery_6.png,assets/images/uploads/6a10763fd8fa7_gallery_7.png,assets/images/uploads/6a10763fd907e_gallery_8.png,assets/images/uploads/6a10763fd916f_gallery_9.png,assets/images/uploads/6a10763fd923e_gallery_10.png,assets/images/uploads/6a10763fdd979_gallery_11.png,assets/images/uploads/6a10763fddb2b_gallery_12.png,assets/images/uploads/6a10763fddc98_gallery_13.png,assets/images/uploads/6a10763fe0e4a_gallery_14.png,assets/images/uploads/6a10763fe0fb2_gallery_15.png,assets/images/uploads/6a10763fe119a_gallery_16.png,assets/images/uploads/6a10763fe12e9_gallery_17.png,assets/images/uploads/6a10763fe1417_gallery_18.png,assets/images/uploads/6a107761b369e_gallery_0.png,assets/images/uploads/6a107761b385d_gallery_1.png,assets/images/uploads/6a107761b39b6_gallery_2.png,assets/images/uploads/6a107761b3ae7_gallery_3.png,assets/images/uploads/6a107761b3c25_gallery_4.png,assets/images/uploads/6a107761b3d4e_gallery_5.png,assets/images/uploads/6a107761b3e77_gallery_6.png,assets/images/uploads/6a107761b3f9b_gallery_7.png,assets/images/uploads/6a107761b40dd_gallery_8.png,assets/images/uploads/6a107761b42d7_gallery_9.png,assets/images/uploads/6a107761b450e_gallery_10.png,assets/images/uploads/6a107761b4692_gallery_11.png,assets/images/uploads/6a107761b4803_gallery_12.png,assets/images/uploads/6a107761b4994_gallery_13.png,assets/images/uploads/6a107761b4b29_gallery_14.png,assets/images/uploads/6a107761b4c97_gallery_15.png,assets/images/uploads/6a107761b4dd4_gallery_16.png,assets/images/uploads/6a107761b4f81_gallery_17.png,assets/images/uploads/6a107761b5120_gallery_18.png');

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
(1, 'Web Development', 'fas fa-code', '6a106b21deff3.png', 'Building responsive and dynamic websites using modern web technologies.'),
(2, 'UI/UX Design', 'fab fa-figma', '6a106b17a338d.png', 'Designing intuitive and aesthetically pleasing user interfaces.'),
(3, 'System Analysis', 'fas fa-chart-line', '6a106b1053c52.png', 'Analyzing business requirements and designing effective technical solutions.');

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
(1, 'HTML', 87, 'fab fa-html5 text-danger', 'assets/images/uploads/6a10708a895a0_skill.png'),
(2, 'CSS', 85, 'fab fa-css3-alt text-primary', 'assets/images/uploads/6a1070ae8c7fc_skill.png'),
(3, 'JavaScript', 70, 'fab fa-js text-warning', 'assets/images/uploads/6a1071580e221_skill.webp'),
(4, 'PHP', 75, 'fab fa-php text-info', 'assets/images/uploads/6a107184d82d6_skill.webp'),
(5, 'Bootstrap 5', 85, 'fab fa-bootstrap text-purple', 'assets/images/uploads/6a1070c0870a9_skill.png'),
(6, 'Figma (UI/UX)', 80, 'fab fa-figma text-danger', 'assets/images/uploads/6a107119103f3_skill.png'),
(7, 'System Analyst (Docs)', 85, 'fas fa-file-signature text-info', 'assets/images/uploads/6a1070fa5f932_skill.png');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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

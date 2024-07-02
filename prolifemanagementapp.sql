-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 05:30 PM
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
-- Database: `projectlifecyclemanagmentapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `fk_parent_id` int(11) NOT NULL DEFAULT 0,
  `fk_feed_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companys`
--

CREATE TABLE `companys` (
  `id` int(11) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `companyCUI` varchar(255) NOT NULL,
  `companyAddress` varchar(255) NOT NULL,
  `companyType` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companys`
--

INSERT INTO `companys` (`id`, `companyName`, `companyCUI`, `companyAddress`, `companyType`, `date`) VALUES
(13, 'Taki Companyes', 'RO5693453C', 'Str. Brazilor', 'Taki Company', '2024-05-28'),
(14, 'Admin Company', 'RO5693453C', 'Bulevardul Trandafirilor', 'S.R.L.', '2024-06-27');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL,
  `fk_feed_id` int(11) NOT NULL,
  `fk_comment_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `fk_project_id`, `fk_feed_id`, `fk_comment_id`, `name`, `type`, `date`, `path`) VALUES
(12, 82, 37, 0, 'elfbar-fs18000-peachice-1696257007.webp', 'image/png', '2024-06-28', 'uploads/feed/images'),
(17, 82, 0, 0, 'cerere_Takacs_Norbert.pdf-24605266', 'application/pdf', '2024-06-29', 'uploads/documents/documents'),
(18, 82, 0, 0, 'cerere_Takacs_Norbert.pdf-72160306', 'application/pdf', '2024-06-29', 'uploads/documents/documents');

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id` int(11) NOT NULL,
  `fk_parent_id` int(11) NOT NULL,
  `parent_number` int(11) NOT NULL DEFAULT 0,
  `fk_user_id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL,
  `fk_company_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `show` tinyint(1) NOT NULL DEFAULT 1,
  `likes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `id` int(11) NOT NULL,
  `fk_company_id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_role` varchar(255) NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invitations`
--

INSERT INTO `invitations` (`id`, `fk_company_id`, `fk_project_id`, `name`, `email`, `phone`, `token`, `created_at`, `expires_at`, `user_role`, `used`) VALUES
(63, 14, -1, 'szekely@gmail.com', 'szekely@gmail.com', '0749345949', 'c6066c840d58c59ecfecac48123124f4ca441ca6cdb83f7e2ded5d4458db7dff', '2024-06-30 18:11:09', '2024-06-30 18:11:09', 'employee', 0);

-- --------------------------------------------------------

--
-- Table structure for table `map_comment_user_likes`
--

CREATE TABLE `map_comment_user_likes` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `map_feed_user_likes`
--

CREATE TABLE `map_feed_user_likes` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_feed_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `map_users_projects`
--

CREATE TABLE `map_users_projects` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `map_users_projects`
--

INSERT INTO `map_users_projects` (`id`, `fk_user_id`, `fk_project_id`) VALUES
(173, 27, 83),
(174, 56, 83),
(186, 27, 82),
(187, 56, 82),
(188, 59, 82);

-- --------------------------------------------------------

--
-- Table structure for table `map_users_tasks`
--

CREATE TABLE `map_users_tasks` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `map_users_tasks`
--

INSERT INTO `map_users_tasks` (`id`, `fk_user_id`, `fk_task_id`) VALUES
(84, 27, 37),
(87, 56, 36),
(88, 27, 36),
(93, 27, 41);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fk_status_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `priority` varchar(255) NOT NULL DEFAULT 'low',
  `date` date NOT NULL DEFAULT current_timestamp(),
  `start_date` datetime DEFAULT current_timestamp(),
  `end_date` datetime DEFAULT current_timestamp(),
  `fk_teamlead_id` int(11) NOT NULL,
  `fk_company_id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `slug` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `fk_status_id`, `description`, `priority`, `date`, `start_date`, `end_date`, `fk_teamlead_id`, `fk_company_id`, `color`, `slug`) VALUES
(82, 'Website Redesign', 5, 'The project involves a complete redesign of the company website, including a new user interface and improved backend functionality.', 'high', '2024-06-14', '2024-07-01 09:00:00', '2024-07-19 05:00:00', 27, 14, '#88ae45', 'next-problem'),
(83, 'Project 2 for test', 1, '', 'medium', '2024-06-22', '2024-06-19 00:00:00', '2024-07-15 11:00:00', 27, 14, '#5cc17b', 'project-2-for-test');

-- --------------------------------------------------------

--
-- Table structure for table `projects_comments`
--

CREATE TABLE `projects_comments` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects_files`
--

CREATE TABLE `projects_files` (
  `id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects_status`
--

CREATE TABLE `projects_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects_status`
--

INSERT INTO `projects_status` (`id`, `name`, `color`, `priority`, `active`) VALUES
(1, 'Ready', '#60e67b', 1, 1),
(2, 'Started', '#3abad9', 5, 1),
(3, 'Approval', '#ffe32e', 2, 0),
(4, 'Completed', '#428f51', 999, 1),
(5, 'InProgress', '#bcde12', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `fk_category_id` int(11) NOT NULL,
  `fk_company_id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL,
  `createdBy_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `fk_category_id`, `fk_company_id`, `fk_project_id`, `createdBy_id`, `priority`, `date`) VALUES
(33, 'Task project 222', 'Description', 4, 14, 83, 27, 1, '2024-06-22'),
(36, 'Task old project ', '', 2, 14, 82, 27, 2, '2024-06-22'),
(37, 'Task old project ss', 'ADS', 5, 14, 83, 27, 2, '2024-06-22'),
(39, 'My task(Employee)', '(Employee)', 1, 14, 82, 56, 2, '2024-06-22'),
(41, 'done task', 'test', 3, 14, 82, 27, 4, '2024-06-29'),
(42, 'Project 2', '', 1, 14, 82, 27, 5, '2024-06-29'),
(43, 'Nem kiosztott feladat', '', 1, 14, 82, 27, 6, '2024-06-30'),
(44, 'Nem kiosztott feladat a Project2 ben', '', 4, 14, 83, 27, 7, '2024-06-30'),
(45, 'Client task for Company team', 'test client task', 1, 14, 82, 59, 8, '2024-06-30'),
(47, '', 'Oppa', 1, 14, 82, 59, 9, '2024-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `task_categories`
--

CREATE TABLE `task_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `fk_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_categories`
--

INSERT INTO `task_categories` (`id`, `name`, `priority`, `active`, `fk_project_id`) VALUES
(1, 'To Do', 1, 1, 82),
(2, 'In Progress', 2, 1, 82),
(3, 'Done', 3, 1, 82),
(4, 'To Do', 1, 1, 83),
(5, 'In Progress', 2, 1, 83),
(8, 'Done', 3, 1, 83);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `companyCUI` varchar(255) NOT NULL,
  `companyAddress` varchar(255) NOT NULL,
  `companyType` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `role` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `fk_company_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `online`, `username`, `email`, `phone`, `facebook`, `instagram`, `youtube`, `password`, `name`, `birthday`, `companyName`, `companyCUI`, `companyAddress`, `companyType`, `date`, `role`, `occupation`, `fk_company_id`, `image`, `avatar`) VALUES
(27, 1, 'Admin User', 'admin@gmail.com', '0711111222', '', '', '', '$2y$10$FQBpa9aMn4DndjmjsP9l5.EdmhmEeVjRnNRA56BQo5E64Y6x3L8Dy', 'Takacs Norbert', '2024-05-29', 'Admin Company', 'RO5693453C', 'Bulevardul Trandafirilor', 'S.R.L.', '2024-06-27', 'admin', 'developer', 14, '', 'user-9.jpg'),
(56, 0, 'Employee User', 'employee@gmail.com', '0749345949', '', '', '', '$2y$10$FQBpa9aMn4DndjmjsP9l5.EdmhmEeVjRnNRA56BQo5E64Y6x3L8Dy', 'Nagy Emerencia', '2024-05-29', 'Admin Company', 'RO5693453C', 'Bulevardul Trandafirilor', 'S.R.L.', '2024-06-01', 'employee', 'web dev', 14, '', 'user-3.jpg'),
(59, 0, 'Client User', 'client@gmail.com', '0749345949', '', '', '', '$2y$10$FQBpa9aMn4DndjmjsP9l5.EdmhmEeVjRnNRA56BQo5E64Y6x3L8Dy', 'Kiss Janos', '2024-05-29', '', '', '', '', '2024-06-29', 'client', 'client', 14, '', 'user-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `white_boards`
--

CREATE TABLE `white_boards` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_board_code` varchar(255) NOT NULL,
  `board_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `white_boards`
--

INSERT INTO `white_boards` (`id`, `fk_user_id`, `fk_board_code`, `board_name`) VALUES
(22, 56, '1cbb0dba-4de6-47af-a985-e7853ae7dd84', 'Employee test whiteboard'),
(23, 27, '81ff82d2-4108-4140-a37c-6abf785a53ab', 'Admin board');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companys`
--
ALTER TABLE `companys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_id` (`fk_company_id`),
  ADD KEY `fk_project_id` (`fk_project_id`);

--
-- Indexes for table `map_comment_user_likes`
--
ALTER TABLE `map_comment_user_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_feed_user_likes`
--
ALTER TABLE `map_feed_user_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_users_projects`
--
ALTER TABLE `map_users_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_users_tasks`
--
ALTER TABLE `map_users_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects_comments`
--
ALTER TABLE `projects_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_project_id` (`fk_project_id`);

--
-- Indexes for table `projects_files`
--
ALTER TABLE `projects_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_project_id` (`fk_project_id`);

--
-- Indexes for table `projects_status`
--
ALTER TABLE `projects_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_categories`
--
ALTER TABLE `task_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `white_boards`
--
ALTER TABLE `white_boards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `companys`
--
ALTER TABLE `companys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `map_comment_user_likes`
--
ALTER TABLE `map_comment_user_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `map_feed_user_likes`
--
ALTER TABLE `map_feed_user_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `map_users_projects`
--
ALTER TABLE `map_users_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `map_users_tasks`
--
ALTER TABLE `map_users_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `projects_comments`
--
ALTER TABLE `projects_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects_files`
--
ALTER TABLE `projects_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects_status`
--
ALTER TABLE `projects_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `task_categories`
--
ALTER TABLE `task_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `white_boards`
--
ALTER TABLE `white_boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invitations`
--
ALTER TABLE `invitations`
  ADD CONSTRAINT `fk_company_id` FOREIGN KEY (`fk_company_id`) REFERENCES `companys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invitations_ibfk_1` FOREIGN KEY (`fk_company_id`) REFERENCES `companys` (`id`);

--
-- Constraints for table `projects_comments`
--
ALTER TABLE `projects_comments`
  ADD CONSTRAINT `projects_comments_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_comments_ibfk_2` FOREIGN KEY (`fk_project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects_files`
--
ALTER TABLE `projects_files`
  ADD CONSTRAINT `projects_files_ibfk_1` FOREIGN KEY (`fk_project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

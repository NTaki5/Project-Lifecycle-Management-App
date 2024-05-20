-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 08:06 PM
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
(13, 'Taki Company', 'RO5693453C', 'Str. Bula', 'Taki Company', '2024-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `Birthday` date NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `companyCUI` varchar(255) NOT NULL,
  `companyAddress` varchar(255) NOT NULL,
  `companyType` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `role` varchar(255) NOT NULL,
  `fk_company_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `firstname`, `lastname`, `Birthday`, `companyName`, `companyCUI`, `companyAddress`, `companyType`, `date`, `role`, `fk_company_id`, `image`, `avatar`) VALUES
(14, 'admin123', 'takacsn525@gmail.com', '$2y$10$9TCVev0jDava2po3UJFC1ujs6ct7pYDIQ03FIDYVTx7VtKZcoAAk.', 'Takacs', 'Norbert', '2024-05-04', 'Taki Company', 'RO5693453C', 'Str. Bula', 'Taki Company', '2024-05-20', 'admin', 13, '', 'user-3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companys`
--
ALTER TABLE `companys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companys`
--
ALTER TABLE `companys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

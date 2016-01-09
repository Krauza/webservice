-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 172.17.0.1
-- Generation Time: Jan 09, 2016 at 04:45 PM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fiche_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `fiche_fiche`
--

CREATE TABLE `fiche_fiche` (
  `id` int(3) NOT NULL,
  `group_id` int(3) NOT NULL,
  `word` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `explain_word` text COLLATE utf8_polish_ci NOT NULL,
  `level` int(1) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `fiche_fiche`
--

INSERT INTO `fiche_fiche` (`id`, `group_id`, `word`, `explain_word`, `level`, `archived`) VALUES
(1, 6, 'dd', '44', 0, 0),
(2, 6, 'dd', '44', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fiche_group`
--

CREATE TABLE `fiche_group` (
  `id` int(5) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` varchar(120) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `fiche_group`
--

INSERT INTO `fiche_group` (`id`, `owner_id`, `name`) VALUES
(6, 1, 'group :) hh');

-- --------------------------------------------------------

--
-- Table structure for table `fiche_user`
--

CREATE TABLE `fiche_user` (
  `id` int(5) NOT NULL,
  `name` varchar(120) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `fiche_user`
--

INSERT INTO `fiche_user` (`id`, `name`, `email`, `password`) VALUES
(1, 'ddddddddd', 'test@test.test', '$2y$10$fI4rzAlQCZBssahVCt/Um.RBhuITPTS102APCeG42GqAojQ2kpLta'),
(2, 'Mateusz', 'test2@test.test', '$2y$10$Z3w.LNX.IwknYomAPTza1ObCEgjxCzk6FyycfUmPuEtYxFn7oPwEK'),
(3, 'mt', 'test3@test.test', '$2y$10$KIpw3J0t3AEttbabQGo3I.bA0NuCAvtzxlVlShuo7gf5rXfqANxkS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fiche_fiche`
--
ALTER TABLE `fiche_fiche`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fiche_group`
--
ALTER TABLE `fiche_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fiche_user`
--
ALTER TABLE `fiche_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fiche_fiche`
--
ALTER TABLE `fiche_fiche`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fiche_group`
--
ALTER TABLE `fiche_group`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fiche_user`
--
ALTER TABLE `fiche_user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
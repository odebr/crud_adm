-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 17, 2020 at 01:38 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.6

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `btrulead_leads`
--

-- --------------------------------------------------------

--
-- Table structure for table `giving_settings`
--

CREATE TABLE `giving_settings` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `fund_type` varchar(255) NOT NULL
) ENGINE=MyISAM;

--
-- Dumping data for table `giving_settings`
--

--
-- AUTO_INCREMENT for table `giving_settings`
--
ALTER TABLE `giving_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
-- Table structure for table `fund_form`
--

CREATE TABLE `fund_form` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `contact_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `fund_type` varchar(255) NOT NULL,
  `receive_date` varchar(255) NOT NULL,
  `receive_date_format` datetime NOT NULL,
  `payment_source` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `check_no` varchar(255) NOT NULL,
  `check_date` varchar(255) NOT NULL,
  `last_four` varchar(255) NOT NULL,
  `card_type` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=MyISAM;

--
-- Dumping data for table `fund_form`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fund_form`
--
ALTER TABLE `fund_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fund_form`
--
ALTER TABLE `fund_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

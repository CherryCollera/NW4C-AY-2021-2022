-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2021 at 04:48 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brand_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `justin`
--

CREATE TABLE `justin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `size_small` int(11) DEFAULT NULL,
  `price_small` int(11) DEFAULT NULL,
  `size_medium` int(11) DEFAULT NULL,
  `price_medium` int(11) DEFAULT NULL,
  `size_large` int(11) DEFAULT NULL,
  `price_large` int(11) DEFAULT NULL,
  `size_xlarge` int(11) DEFAULT NULL,
  `price_xlarge` int(11) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `prod_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `justin`
--

INSERT INTO `justin` (`id`, `name`, `image`, `size_small`, `price_small`, `size_medium`, `price_medium`, `size_large`, `price_large`, `size_xlarge`, `price_xlarge`, `owner_name`, `prod_desc`) VALUES
(1, 'qweqe', 'halfwaysample2.jpg', 12, 120, 12, 12, 12, 12, 12, 12, 'zxc@gmail.com', 'qweasdzxcczxzasd'),
(2, 'asd', 'nullifysample.jpg', 1, 111, 2, 112, 3, 113, 4, 211, 'zxc@gmail.com', 'asdzxcqwe');

-- --------------------------------------------------------

--
-- Table structure for table `qwe`
--

CREATE TABLE `qwe` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `size_small` int(11) DEFAULT NULL,
  `price_small` int(11) DEFAULT NULL,
  `size_medium` int(11) DEFAULT NULL,
  `price_medium` int(11) DEFAULT NULL,
  `size_large` int(11) DEFAULT NULL,
  `price_large` int(11) DEFAULT NULL,
  `size_xlarge` int(11) DEFAULT NULL,
  `price_xlarge` int(11) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `prod_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `qwe`
--

INSERT INTO `qwe` (`id`, `name`, `image`, `size_small`, `price_small`, `size_medium`, `price_medium`, `size_large`, `price_large`, `size_xlarge`, `price_xlarge`, `owner_name`, `prod_desc`) VALUES
(1, 'asdasd', 'nullifysample.jpg', 12, 111, 12, 112, 12, 113, 12, 114, 'zxc@gmail.com', 'asdzxcdqw');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `justin`
--
ALTER TABLE `justin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qwe`
--
ALTER TABLE `qwe`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `justin`
--
ALTER TABLE `justin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `qwe`
--
ALTER TABLE `qwe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

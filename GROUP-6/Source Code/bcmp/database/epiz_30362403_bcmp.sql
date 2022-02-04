-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql300.byetcluster.com
-- Generation Time: Dec 20, 2021 at 10:34 AM
-- Server version: 5.7.35-38
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_30362403_bcmp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `brand_names`
--

CREATE TABLE `brand_names` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_logo` varchar(255) NOT NULL,
  `seller_name` varchar(255) NOT NULL,
  `seller_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brand_names`
--

INSERT INTO `brand_names` (`brand_id`, `brand_name`, `brand_logo`, `seller_name`, `seller_id`) VALUES
(5, 'Nullify', 'http://res.cloudinary.com/bcmp-uploader/image/upload/v1636943937/Nullify.jpg', 'Mark', '2'),
(6, 'Penshoppe', 'http://res.cloudinary.com/bcmp-uploader/image/upload/v1639232244/Penshoppe.jpg', 'Mark', '4');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `upd_date` varchar(255) DEFAULT NULL,
  `buy_date` varchar(255) NOT NULL,
  `accept_date` varchar(255) NOT NULL,
  `ship_date` varchar(255) NOT NULL,
  `packed_date` varchar(255) NOT NULL,
  `cancel_date` varchar(255) NOT NULL,
  `recieve_date` varchar(255) NOT NULL,
  `prod_size` varchar(255) NOT NULL,
  `prod_quantity` int(11) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `deliver_loc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`order_id`, `seller_id`, `product_id`, `user_id`, `status`, `upd_date`, `buy_date`, `accept_date`, `ship_date`, `packed_date`, `cancel_date`, `recieve_date`, `prod_size`, `prod_quantity`, `prod_price`, `deliver_loc`) VALUES
(6, 2, 3, 4, 'Order', '2021-12-13 05:52:26 AM', '2021-12-13 05:52:26 AM', '', '', '', '', '', 'Medium', 1, 132, 'San Jose'),
(7, 4, 5, 5, 'Cancel', '2021-12-13 02:53:40 PM', '2021-12-13 02:51:26 PM', '', '', '', '2021-12-13 02:53:40 PM- User Cancelled', '', 'Medium', 2, 264, 'san jose'),
(8, 4, 5, 5, 'Recieved', '2021-12-13 03:10:48 PM', '2021-12-13 02:51:39 PM', '2021-12-13 02:57:25 PM', '2021-12-13 03:06:45 PM', '2021-12-13 03:03:30 PM', '', '2021-12-13 03:10:48 PM', 'Large', 2, 426, 'san jose'),
(9, 4, 5, 5, 'Recieved', '2021-12-13 03:10:53 PM', '2021-12-13 02:52:02 PM', '2021-12-13 02:57:19 PM', '2021-12-13 03:05:03 PM', '2021-12-13 03:03:45 PM', '', '2021-12-13 03:10:53 PM', 'Small', 2, 246, 'san jose'),
(10, 4, 5, 5, 'Recieved', '2021-12-13 03:10:57 PM', '2021-12-13 02:54:03 PM', '2021-12-13 02:54:52 PM', '2021-12-13 03:04:58 PM', '2021-12-13 03:03:49 PM', '', '2021-12-13 03:10:57 PM', 'Small', 1, 123, 'san jose'),
(11, 4, 5, 4, 'Recieved', '2021-12-13 03:27:35 PM', '2021-12-13 03:24:47 PM', '2021-12-13 03:26:57 PM', '2021-12-13 03:27:09 PM', '2021-12-13 03:27:04 PM', '', '2021-12-13 03:27:35 PM', 'Medium', 1, 132, 'San Jose');

-- --------------------------------------------------------

--
-- Table structure for table `product_cart`
--

CREATE TABLE `product_cart` (
  `cartID` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_cart`
--

INSERT INTO `product_cart` (`cartID`, `product_id`, `user_id`, `timestamp`) VALUES
(3, 3, 4, '2021-12-13 05:52:04 AM'),
(4, 5, 5, '2021-12-13 02:50:35 PM');

-- --------------------------------------------------------

--
-- Table structure for table `product_desc`
--

CREATE TABLE `product_desc` (
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_img` varchar(255) NOT NULL,
  `prod_color` varchar(255) NOT NULL,
  `prod_gend` varchar(255) NOT NULL,
  `prod_type` varchar(255) NOT NULL,
  `prod_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_desc`
--

INSERT INTO `product_desc` (`product_id`, `brand_id`, `brand_name`, `prod_name`, `prod_img`, `prod_color`, `prod_gend`, `prod_type`, `prod_desc`) VALUES
(3, 5, 'Nullify', 'Nullify Shirt', 'http://res.cloudinary.com/bcmp-uploader/image/upload/v1639205572/Nullify%20Shirt.jpg', '#ffffff', 'Unisex', 'Tops', ' White Shirt'),
(5, 6, 'Penshoppe', 'Product_x', 'http://res.cloudinary.com/bcmp-uploader/image/upload/v1639377928/Product_x.jpg', '#000000', 'Unisex', 'Tops', ' damit'),
(6, 6, 'Penshoppe', 'Product_y', 'http://res.cloudinary.com/bcmp-uploader/image/upload/v1639377965/Product_y.jpg', '#000000', 'Unisex', 'Hoodie', 'Black Hoodie'),
(7, 6, 'Penshoppe', 'product', 'http://res.cloudinary.com/bcmp-uploader/image/upload/v1639378058/product.jpg', '#000000', 'Male', 'Caps', ' White Shirt');

-- --------------------------------------------------------

--
-- Table structure for table `product_rate`
--

CREATE TABLE `product_rate` (
  `rate_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rater_id` int(11) NOT NULL,
  `rater_name` varchar(255) NOT NULL,
  `rate_value` int(11) NOT NULL,
  `rate_desc` varchar(255) NOT NULL,
  `rate_time` varchar(255) NOT NULL,
  `rateImg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_rate`
--

INSERT INTO `product_rate` (`rate_id`, `product_id`, `order_id`, `rater_id`, `rater_name`, `rate_value`, `rate_desc`, `rate_time`, `rateImg`) VALUES
(2, 5, 8, 5, 'Justin', 5, 'maganda', '2021-12-13 03:11:49 PM', ' http://res.cloudinary.com/bcmp-uploader/image/upload/v1639379509/whiteshort.jpg.jpg'),
(3, 5, 9, 5, 'Justin', 1, 'panget', '2021-12-13 03:12:44 PM', ' '),
(4, 5, 10, 5, 'Justin', 3, 'medyo panget', '2021-12-13 03:13:25 PM', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `product_value`
--

CREATE TABLE `product_value` (
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `small` int(10) NOT NULL,
  `medium` int(10) NOT NULL,
  `large` int(10) NOT NULL,
  `x_large` int(10) NOT NULL,
  `s_price` int(11) NOT NULL,
  `m_price` int(11) NOT NULL,
  `l_price` int(11) NOT NULL,
  `xl_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_value`
--

INSERT INTO `product_value` (`product_id`, `brand_id`, `brand_name`, `prod_name`, `small`, `medium`, `large`, `x_large`, `s_price`, `m_price`, `l_price`, `xl_price`) VALUES
(3, 5, 'Nullify', 'Nullify Shirt', 15, 11, 12, 12, 123, 132, 213, 231),
(5, 6, 'Penshoppe', 'Product_x', 9, 11, 10, 1, 123, 132, 213, 321),
(6, 6, 'Penshoppe', 'Product_y', 12, 12, 12, 12, 123, 132, 213, 231),
(7, 6, 'Penshoppe', 'product', 12, 12, 12, 12, 123, 132, 213, 231);

-- --------------------------------------------------------

--
-- Table structure for table `requestaccounts`
--

CREATE TABLE `requestaccounts` (
  `id` int(11) NOT NULL,
  `brandname` varchar(255) NOT NULL,
  `ownername` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cnumber` varchar(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `permit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cnumber` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`id`, `brand_name`, `owner_name`, `password`, `email`, `cnumber`) VALUES
(2, 'Nullify', 'Mark', '76d80224611fc919a5d54f0ff9fba446', 'dyasten2@gmail.com', '09167548216'),
(3, 'Regatta', 'Mark', '76d80224611fc919a5d54f0ff9fba446', 'dyasten2@gmail.com', '09167548216'),
(4, 'b', 'Mark', 'ea82410c7a9991816b5eeeebe195e20a', 'jas7iin@gmail.com', '09167548216');

-- --------------------------------------------------------

--
-- Table structure for table `seller_report`
--

CREATE TABLE `seller_report` (
  `report_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `report_desc` varchar(255) NOT NULL,
  `report_time` varchar(255) NOT NULL,
  `report_file` varchar(255) NOT NULL,
  `isValid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller_report`
--

INSERT INTO `seller_report` (`report_id`, `reporter_id`, `seller_id`, `report_title`, `report_desc`, `report_time`, `report_file`, `isValid`) VALUES
(2, 5, 4, 'Spam', 'makulit', '2021-12-13', 'http://res.cloudinary.com/bcmp-uploader/image/upload/v1639379509/whiteshort.jpg.jpg', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`, `contact_number`) VALUES
(4, 'Justin', 'dyasten2@gmail.com', '76d80224611fc919a5d54f0ff9fba446', 'San Jose', '09167548216'),
(5, 'Justin', 'jas7iin@gmail.com', '53dd9c6005f3cdfc5a69c5c07388016d', 'san jose', '09070525515');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand_names`
--
ALTER TABLE `brand_names`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product_cart`
--
ALTER TABLE `product_cart`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `product_desc`
--
ALTER TABLE `product_desc`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_rate`
--
ALTER TABLE `product_rate`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `product_value`
--
ALTER TABLE `product_value`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `requestaccounts`
--
ALTER TABLE `requestaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_report`
--
ALTER TABLE `seller_report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand_names`
--
ALTER TABLE `brand_names`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_cart`
--
ALTER TABLE `product_cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_desc`
--
ALTER TABLE `product_desc`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_rate`
--
ALTER TABLE `product_rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_value`
--
ALTER TABLE `product_value`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `requestaccounts`
--
ALTER TABLE `requestaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller_report`
--
ALTER TABLE `seller_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

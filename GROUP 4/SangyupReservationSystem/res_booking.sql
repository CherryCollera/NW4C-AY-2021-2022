-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2021 at 05:58 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `res_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_chair`
--

CREATE TABLE `booking_chair` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(200) DEFAULT NULL,
  `chair_id` int(11) DEFAULT NULL,
  `chair_no` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_chair`
--

INSERT INTO `booking_chair` (`id`, `booking_id`, `chair_id`, `chair_no`) VALUES
(1, '5ccbd8f5609b3', 38, 'TBL-4-1'),
(2, '5ccbd8f5609b3', 39, 'TBL-4-2'),
(3, '607f6cfb76336', 37, 'TBL-3-4'),
(4, '6087f11425f85', 64, 'TBL-1-6'),
(5, '608923125f5eb', 60, 'TBL-1-2'),
(6, '608923125f5eb', 62, 'TBL-1-4'),
(7, '608923125f5eb', 64, 'TBL-1-6'),
(8, '609239b04fbe6', 61, 'TBL-1-3'),
(9, '609239b04fbe6', 62, 'TBL-1-4'),
(10, '609239b04fbe6', 63, 'TBL-1-5'),
(11, '609239b04fbe6', 64, 'TBL-1-6'),
(12, '60923ad9abc49', 61, 'TBL-1-3'),
(13, '60923ad9abc49', 63, 'TBL-1-5'),
(14, '60923ad9abc49', 64, 'TBL-1-6'),
(15, '609790bc61ad5', 59, 'TBL-1-1'),
(16, '609790bc61ad5', 61, 'TBL-1-3'),
(17, '609790bc61ad5', 63, 'TBL-1-5'),
(18, '6098ef011f850', 60, 'TBL-1-2'),
(19, '6098ef011f850', 62, 'TBL-1-4'),
(20, '6098ef011f850', 64, 'TBL-1-6'),
(21, '6098f075e21e7', 60, 'TBL-1-2'),
(22, '6098f075e21e7', 62, 'TBL-1-4'),
(23, '6098f075e21e7', 64, 'TBL-1-6'),
(24, '6098f08c3e6cf', 60, 'TBL-1-2'),
(25, '6098f08c3e6cf', 62, 'TBL-1-4'),
(26, '6098f08c3e6cf', 64, 'TBL-1-6'),
(27, '609b2e6ad48bd', 61, 'TBL-1-3'),
(28, '609b2e6ad48bd', 63, 'TBL-1-5'),
(29, '609b2e6ad48bd', 64, 'TBL-1-6'),
(30, '609b2f3bc5a36', 60, 'TBL-1-2'),
(31, '609b2f3bc5a36', 62, 'TBL-1-4'),
(32, '609b2f3bc5a36', 64, 'TBL-1-6'),
(33, '609b2ff2ed2e3', 60, 'TBL-1-2'),
(34, '609b2ff2ed2e3', 62, 'TBL-1-4'),
(35, '609b2ff2ed2e3', 64, 'TBL-1-6'),
(36, '609b3043897a4', 62, 'TBL-1-4'),
(37, '609b3043897a4', 63, 'TBL-1-5'),
(38, '609b3043897a4', 64, 'TBL-1-6'),
(39, '609b31a19991b', 59, 'TBL-1-1'),
(40, '609b31a19991b', 60, 'TBL-1-2'),
(41, '609b31a19991b', 61, 'TBL-1-3'),
(42, '609b320248ebe', 59, 'TBL-1-1'),
(43, '609b320248ebe', 60, 'TBL-1-2'),
(44, '609b320248ebe', 61, 'TBL-1-3'),
(45, '609b32ac21cab', 59, 'TBL-1-1'),
(46, '609b32ac21cab', 60, 'TBL-1-2'),
(47, '609b32ac21cab', 61, 'TBL-1-3'),
(48, '609b3361e826c', 59, 'TBL-1-1'),
(49, '609b3361e826c', 60, 'TBL-1-2'),
(50, '609b3361e826c', 61, 'TBL-1-3'),
(51, '609b33dd787ec', 59, 'TBL-1-1'),
(52, '609b33dd787ec', 60, 'TBL-1-2'),
(53, '609b33dd787ec', 61, 'TBL-1-3'),
(54, '609b3452c27a6', 59, 'TBL-1-1'),
(55, '609b3452c27a6', 60, 'TBL-1-2'),
(56, '609b3452c27a6', 61, 'TBL-1-3'),
(57, '609b34a2c6104', 59, 'TBL-1-1'),
(58, '609b34a2c6104', 60, 'TBL-1-2'),
(59, '609b34a2c6104', 61, 'TBL-1-3'),
(60, '609b3858159ed', 61, 'TBL-1-3'),
(61, '609b3858159ed', 62, 'TBL-1-4'),
(62, '609b3858159ed', 64, 'TBL-1-6'),
(63, '609b38f3ea18b', 61, 'TBL-1-3'),
(64, '609b38f3ea18b', 62, 'TBL-1-4'),
(65, '609b38f3ea18b', 64, 'TBL-1-6'),
(66, '609b3da210129', 61, 'TBL-1-3'),
(67, '609b3da210129', 63, 'TBL-1-5'),
(68, '609b3da210129', 64, 'TBL-1-6'),
(69, '609b4372de686', 61, 'TBL-1-3'),
(70, '609b4372de686', 63, 'TBL-1-5'),
(71, '609b4372de686', 64, 'TBL-1-6'),
(72, '609cff34470a1', 59, 'TBL-1-1'),
(73, '609cff34470a1', 60, 'TBL-1-2'),
(74, '609cff34470a1', 61, 'TBL-1-3'),
(75, '609cff88003b5', 59, 'TBL-1-1'),
(76, '609cff88003b5', 61, 'TBL-1-3'),
(77, '609cff88003b5', 63, 'TBL-1-5'),
(78, '609d09a50bf5a', 59, 'TBL-1-1'),
(79, '609d09a50bf5a', 60, 'TBL-1-2'),
(80, '609d09a50bf5a', 62, 'TBL-1-4'),
(81, '609d0a673a60f', 60, 'TBL-1-2'),
(82, '609d0a673a60f', 62, 'TBL-1-4'),
(83, '609d0a673a60f', 64, 'TBL-1-6'),
(84, '609d0c7f237c6', 59, 'TBL-1-1'),
(85, '609d0c7f237c6', 60, 'TBL-1-2'),
(86, '609d0c7f237c6', 61, 'TBL-1-3'),
(87, '609d317412cef', 60, 'TBL-1-2'),
(88, '609d317412cef', 62, 'TBL-1-4'),
(89, '609d317412cef', 64, 'TBL-1-6'),
(90, '609da89c5b2a8', 59, 'TBL-1-1'),
(91, '609da89c5b2a8', 61, 'TBL-1-3'),
(92, '609da89c5b2a8', 63, 'TBL-1-5'),
(93, '609dae1d2ee17', 60, 'TBL-1-2'),
(94, '609dae1d2ee17', 62, 'TBL-1-4'),
(95, '609dae1d2ee17', 64, 'TBL-1-6'),
(96, '609dae61bc670', 60, 'TBL-1-2'),
(97, '609dae61bc670', 62, 'TBL-1-4'),
(98, '609dae61bc670', 64, 'TBL-1-6'),
(99, '609dcf78a45f1', 61, 'TBL-1-3'),
(100, '609e27aa7cc67', 60, 'TBL-1-2'),
(101, '609e27aa7cc67', 62, 'TBL-1-4'),
(102, '609e27aa7cc67', 64, 'TBL-1-6'),
(103, '609e27aaf1a2f', 60, 'TBL-1-2'),
(104, '609e27aaf1a2f', 62, 'TBL-1-4'),
(105, '609e27aaf1a2f', 64, 'TBL-1-6'),
(106, '609e2814397c7', 60, 'TBL-1-2'),
(107, '609e2814397c7', 63, 'TBL-1-5'),
(108, '609e28147aae2', 60, 'TBL-1-2'),
(109, '609e28147aae2', 63, 'TBL-1-5'),
(110, '609e2912d3dfb', 60, 'TBL-1-2'),
(111, '609e2912d3dfb', 62, 'TBL-1-4'),
(112, '609e2912d3dfb', 64, 'TBL-1-6'),
(113, '609e2ec6ade3a', 60, 'TBL-1-2'),
(114, '609e31d6c41b5', 60, 'TBL-1-2'),
(115, '609e31d6c41b5', 62, 'TBL-1-4'),
(116, '609e31d6c41b5', 64, 'TBL-1-6'),
(117, '609e336d2c00d', 60, 'TBL-1-2'),
(118, '609e336d2c00d', 62, 'TBL-1-4'),
(119, '609e336d2c00d', 64, 'TBL-1-6'),
(120, '609e33dc7f46a', 60, 'TBL-1-2'),
(121, '609e33dc7f46a', 62, 'TBL-1-4'),
(122, '609e33dc7f46a', 64, 'TBL-1-6'),
(123, '60a198e16ffe1', 60, 'TBL-1-2'),
(124, '60a198e16ffe1', 62, 'TBL-1-4'),
(125, '60a198e16ffe1', 64, 'TBL-1-6'),
(126, '60a19f4e2adbb', 60, 'TBL-1-2'),
(127, '60a19f4e2adbb', 62, 'TBL-1-4'),
(128, '60a19f4e2adbb', 64, 'TBL-1-6'),
(129, '60a1a26aa6841', 59, 'TBL-1-1'),
(130, '60a1a26aa6841', 61, 'TBL-1-3'),
(131, '60a1a26aa6841', 63, 'TBL-1-5'),
(132, '60a1a26aa6841', 65, 'TBL-2-1'),
(133, '60a1a26aa6841', 66, 'TBL-2-2'),
(134, '60a1a26aa6841', 67, 'TBL-2-3'),
(135, '60a1a26aa6841', 68, 'TBL-2-4'),
(136, '60a1a26aa6841', 69, 'TBL-2-5'),
(137, '60a1a26aa6841', 70, 'TBL-2-6'),
(138, '60a1a6372faeb', 59, 'TBL-1-1'),
(139, '60a1a6372faeb', 60, 'TBL-1-2'),
(140, '60a1a6372faeb', 61, 'TBL-1-3'),
(141, '60a1a6372faeb', 62, 'TBL-1-4'),
(142, '60a1a6372faeb', 63, 'TBL-1-5'),
(143, '60a1a6372faeb', 64, 'TBL-1-6'),
(144, '60a1a6372faeb', 65, 'TBL-2-1'),
(145, '60a1a6372faeb', 66, 'TBL-2-2'),
(146, '60a1a6372faeb', 67, 'TBL-2-3'),
(147, '60a1a6372faeb', 68, 'TBL-2-4'),
(148, '60a1a6372faeb', 69, 'TBL-2-5'),
(149, '60a1a6372faeb', 70, 'TBL-2-6'),
(150, '60a1c151c5ee3', 60, 'TBL-1-2'),
(151, '60a1c151c5ee3', 61, 'TBL-1-3'),
(152, '60a1c151c5ee3', 62, 'TBL-1-4'),
(153, '60a1c151c5ee3', 63, 'TBL-1-5'),
(154, '60a2e1b62b9fc', 59, 'TBL-1-1'),
(155, '60a2e1b62b9fc', 60, 'TBL-1-2'),
(156, '60a2e1b62b9fc', 61, 'TBL-1-3'),
(157, '60a2e1b62b9fc', 62, 'TBL-1-4'),
(158, '60a2e1b62b9fc', 63, 'TBL-1-5'),
(159, '60a2e1b62b9fc', 64, 'TBL-1-6'),
(160, '60a2e236216ee', 59, 'TBL-1-1'),
(161, '60a2e236216ee', 60, 'TBL-1-2'),
(162, '60a2e236216ee', 61, 'TBL-1-3'),
(163, '60a2e236216ee', 62, 'TBL-1-4'),
(164, '60a2e236216ee', 63, 'TBL-1-5'),
(165, '60a2e236216ee', 64, 'TBL-1-6'),
(166, '60a2e2c10cce8', 59, 'TBL-1-1'),
(167, '60a2e2c10cce8', 61, 'TBL-1-3'),
(168, '60a2e2c10cce8', 62, 'TBL-1-4'),
(169, '60a2e2c10cce8', 63, 'TBL-1-5'),
(170, '60a2e2c10cce8', 64, 'TBL-1-6'),
(171, '60a2e31e0c742', 59, 'TBL-1-1'),
(172, '60a2e31e0c742', 61, 'TBL-1-3'),
(173, '60a2e31e0c742', 62, 'TBL-1-4'),
(174, '60a2e31e0c742', 63, 'TBL-1-5'),
(175, '60a2e31e0c742', 64, 'TBL-1-6'),
(176, '60a2e3edc6beb', 60, 'TBL-1-2'),
(177, '60a2e3edc6beb', 62, 'TBL-1-4'),
(178, '60a2e3edc6beb', 64, 'TBL-1-6'),
(179, '60a2e461738b5', 60, 'TBL-1-2'),
(180, '60a2e461738b5', 62, 'TBL-1-4'),
(181, '60a2e461738b5', 64, 'TBL-1-6'),
(182, '60a2e473084f8', 60, 'TBL-1-2'),
(183, '60a2e473084f8', 62, 'TBL-1-4'),
(184, '60a2e473084f8', 64, 'TBL-1-6'),
(185, '60a2e6f685f9e', 60, 'TBL-1-2'),
(186, '60a2e6f685f9e', 62, 'TBL-1-4'),
(187, '60a2e6f685f9e', 64, 'TBL-1-6'),
(188, '60a2e6f6d4736', 60, 'TBL-1-2'),
(189, '60a2e6f6d4736', 62, 'TBL-1-4'),
(190, '60a2e6f6d4736', 64, 'TBL-1-6'),
(191, '60a2e74e8431e', 59, 'TBL-1-1'),
(192, '60a2e74e8431e', 60, 'TBL-1-2'),
(193, '60a2e74e8431e', 61, 'TBL-1-3'),
(194, '60a2e74e8431e', 62, 'TBL-1-4'),
(195, '60a2e74e8431e', 63, 'TBL-1-5'),
(196, '60a2e74e8431e', 64, 'TBL-1-6'),
(197, '60a2e827c58bc', 59, 'TBL-1-1'),
(198, '60a2e827c58bc', 60, 'TBL-1-2'),
(199, '60a2e827c58bc', 61, 'TBL-1-3'),
(200, '60a2e827c58bc', 62, 'TBL-1-4'),
(201, '60a2e827c58bc', 63, 'TBL-1-5'),
(202, '60a2e827c58bc', 64, 'TBL-1-6'),
(203, '60a2e89166c0b', 60, 'TBL-1-2'),
(204, '60a2e89166c0b', 62, 'TBL-1-4'),
(205, '60a2e89166c0b', 64, 'TBL-1-6'),
(206, '60a2e8c798eb8', 59, 'TBL-1-1'),
(207, '60a2e8c798eb8', 60, 'TBL-1-2'),
(208, '60a2e8c798eb8', 61, 'TBL-1-3'),
(209, '60a2e8c798eb8', 62, 'TBL-1-4'),
(210, '60a2e8c798eb8', 63, 'TBL-1-5'),
(211, '60a2e8c798eb8', 64, 'TBL-1-6'),
(212, '60a2e95b6205e', 59, 'TBL-1-1'),
(213, '60a2e95b6205e', 60, 'TBL-1-2'),
(214, '60a2e95b6205e', 61, 'TBL-1-3'),
(215, '60a2e9b34f0f7', 59, 'TBL-1-1'),
(216, '60a2e9b34f0f7', 60, 'TBL-1-2'),
(217, '60a2e9b34f0f7', 61, 'TBL-1-3'),
(218, '60a2e9f33c3ac', 59, 'TBL-1-1'),
(219, '60a2e9f33c3ac', 60, 'TBL-1-2'),
(220, '60a2e9f33c3ac', 61, 'TBL-1-3'),
(221, '60a2ea138b970', 59, 'TBL-1-1'),
(222, '60a2ea138b970', 60, 'TBL-1-2'),
(223, '60a2ea138b970', 61, 'TBL-1-3'),
(224, '60a2ea8829328', 59, 'TBL-1-1'),
(225, '60a2ea8829328', 60, 'TBL-1-2'),
(226, '60a2ea8829328', 61, 'TBL-1-3'),
(227, '60a2ea9f6e80c', 59, 'TBL-1-1'),
(228, '60a2ea9f6e80c', 60, 'TBL-1-2'),
(229, '60a2ea9f6e80c', 61, 'TBL-1-3'),
(230, '60a2eabf4a896', 59, 'TBL-1-1'),
(231, '60a2eabf4a896', 60, 'TBL-1-2'),
(232, '60a2eabf4a896', 61, 'TBL-1-3'),
(233, '60a2eacbcdc5f', 59, 'TBL-1-1'),
(234, '60a2eacbcdc5f', 60, 'TBL-1-2'),
(235, '60a2eacbcdc5f', 61, 'TBL-1-3'),
(236, '60a2eb1d61cf9', 59, 'TBL-1-1'),
(237, '60a2eb1d61cf9', 60, 'TBL-1-2'),
(238, '60a2eb1d61cf9', 61, 'TBL-1-3'),
(239, '60a2eb31e1b28', 59, 'TBL-1-1'),
(240, '60a2eb31e1b28', 60, 'TBL-1-2'),
(241, '60a2eb31e1b28', 61, 'TBL-1-3'),
(242, '60a2ec0f99662', 65, 'TBL-2-1'),
(243, '60a2ec0f99662', 66, 'TBL-2-2'),
(244, '60a2ec0f99662', 67, 'TBL-2-3'),
(245, '60a2ec0f99662', 68, 'TBL-2-4'),
(246, '60a2ec0f99662', 69, 'TBL-2-5'),
(247, '60a2ec0f99662', 70, 'TBL-2-6'),
(248, '60a2ed3072155', 62, 'TBL-1-4'),
(249, '60a2ed3072155', 63, 'TBL-1-5'),
(250, '60a2ed3072155', 64, 'TBL-1-6'),
(251, '60a2eded9f8a4', 59, 'TBL-1-1'),
(252, '60a2eded9f8a4', 60, 'TBL-1-2'),
(253, '60a2eded9f8a4', 61, 'TBL-1-3'),
(254, '60a2eded9f8a4', 62, 'TBL-1-4'),
(255, '60a2eded9f8a4', 63, 'TBL-1-5'),
(256, '60a2eded9f8a4', 64, 'TBL-1-6'),
(257, '60a2ee0f9593d', 59, 'TBL-1-1'),
(258, '60a2ee0f9593d', 60, 'TBL-1-2'),
(259, '60a2ee0f9593d', 61, 'TBL-1-3'),
(260, '60a2ee0f9593d', 62, 'TBL-1-4'),
(261, '60a2ee0f9593d', 63, 'TBL-1-5'),
(262, '60a2ee0f9593d', 64, 'TBL-1-6'),
(263, '60a2ee2e63c0b', 59, 'TBL-1-1'),
(264, '60a2ee2e63c0b', 60, 'TBL-1-2'),
(265, '60a2ee2e63c0b', 61, 'TBL-1-3'),
(266, '60a2ee2e63c0b', 62, 'TBL-1-4'),
(267, '60a2ee2e63c0b', 63, 'TBL-1-5'),
(268, '60a2ee2e63c0b', 64, 'TBL-1-6'),
(269, '60a2ee911169f', 59, 'TBL-1-1'),
(270, '60a2ee911169f', 60, 'TBL-1-2'),
(271, '60a2ee911169f', 61, 'TBL-1-3'),
(272, '60a2ee911169f', 62, 'TBL-1-4'),
(273, '60a2ee911169f', 63, 'TBL-1-5'),
(274, '60a2ee911169f', 64, 'TBL-1-6'),
(275, '60a2eed588d34', 59, 'TBL-1-1'),
(276, '60a2eed588d34', 60, 'TBL-1-2'),
(277, '60a2eed588d34', 61, 'TBL-1-3'),
(278, '60a2eed588d34', 62, 'TBL-1-4'),
(279, '60a2eed588d34', 63, 'TBL-1-5'),
(280, '60a2eed588d34', 64, 'TBL-1-6'),
(281, '60a2f19ceb3a2', 65, 'TBL-2-1'),
(282, '60a2f19ceb3a2', 66, 'TBL-2-2'),
(283, '60a2f19ceb3a2', 67, 'TBL-2-3'),
(284, '60a2f19ceb3a2', 68, 'TBL-2-4'),
(285, '60a2f19ceb3a2', 69, 'TBL-2-5'),
(286, '60a2f19ceb3a2', 70, 'TBL-2-6'),
(287, '60a2fa560db64', 59, 'TBL-1-1'),
(288, '60a2fa560db64', 60, 'TBL-1-2'),
(289, '60a2fa560db64', 61, 'TBL-1-3'),
(290, '60a2fb7238a4e', 59, 'TBL-1-1'),
(291, '60a2fb7238a4e', 60, 'TBL-1-2'),
(292, '60a2fb7238a4e', 61, 'TBL-1-3'),
(293, '60a2fcea4f5c8', 59, 'TBL-1-1'),
(294, '60a2fcea4f5c8', 60, 'TBL-1-2'),
(295, '60a2fcea4f5c8', 61, 'TBL-1-3'),
(296, '60a2fcea4f5c8', 62, 'TBL-1-4'),
(297, '60a2fcea4f5c8', 63, 'TBL-1-5'),
(298, '60a2fcea4f5c8', 64, 'TBL-1-6'),
(299, '60a301a186fcd', 59, 'TBL-1-1'),
(300, '60a301a186fcd', 60, 'TBL-1-2'),
(301, '60a301a186fcd', 61, 'TBL-1-3'),
(302, '60a302902f055', 59, 'TBL-1-1'),
(303, '60a302902f055', 60, 'TBL-1-2'),
(304, '60a302902f055', 61, 'TBL-1-3'),
(305, '60a31feca53ea', 59, 'TBL-1-1'),
(306, '60a31feca53ea', 60, 'TBL-1-2'),
(307, '60a31feca53ea', 61, 'TBL-1-3'),
(308, '60a321a3d6cfd', 65, 'TBL-2-1'),
(309, '60a321a3d6cfd', 66, 'TBL-2-2'),
(310, '60a321a3d6cfd', 67, 'TBL-2-3'),
(311, '60a321a3d6cfd', 68, 'TBL-2-4'),
(312, '60a321a3d6cfd', 69, 'TBL-2-5'),
(313, '60a321a3d6cfd', 70, 'TBL-2-6'),
(314, '60a321d763ba8', 65, 'TBL-2-1'),
(315, '60a321d763ba8', 66, 'TBL-2-2'),
(316, '60a321d763ba8', 67, 'TBL-2-3'),
(317, '60a321d763ba8', 68, 'TBL-2-4'),
(318, '60a321d763ba8', 69, 'TBL-2-5'),
(319, '60a321d763ba8', 70, 'TBL-2-6'),
(320, '60a322bef12f7', 59, 'TBL-1-1'),
(321, '60a322bef12f7', 60, 'TBL-1-2'),
(322, '60a322bef12f7', 61, 'TBL-1-3'),
(323, '60a322bef12f7', 62, 'TBL-1-4'),
(324, '60a322bef12f7', 63, 'TBL-1-5'),
(325, '60a322bef12f7', 64, 'TBL-1-6'),
(326, '60a47c45db828', 117, 'TBL-1-1'),
(327, '60a47c45db828', 118, 'TBL-1-2'),
(328, '60a47c45db828', 119, 'TBL-1-3'),
(329, '60a47c45db828', 120, 'TBL-1-4'),
(330, '60a49e18d18fc', 117, 'TBL-1-1'),
(331, '60a49e18d18fc', 118, 'TBL-1-2'),
(332, '60a49e18d18fc', 119, 'TBL-1-3'),
(333, '60a49e18d18fc', 120, 'TBL-1-4'),
(334, '60a49e18d18fc', 121, 'TBL-2-1'),
(335, '60a49e18d18fc', 122, 'TBL-2-2'),
(336, '60a49e18d18fc', 123, 'TBL-2-3'),
(337, '60a49e18d18fc', 124, 'TBL-2-4'),
(338, '60a5dfa83565b', 59, 'TBL-1-1'),
(339, '60a5dfa83565b', 60, 'TBL-1-2'),
(340, '60a5dfa83565b', 61, 'TBL-1-3'),
(341, '60a5dfa83565b', 62, 'TBL-1-4'),
(342, '60a5dfa83565b', 63, 'TBL-1-5'),
(343, '60a5dfa83565b', 64, 'TBL-1-6'),
(344, '60a5dfa83565b', 65, 'TBL-2-1'),
(345, '60a5dfa83565b', 66, 'TBL-2-2'),
(346, '60a5dfa83565b', 67, 'TBL-2-3'),
(347, '60a5dfa83565b', 68, 'TBL-2-4'),
(348, '60a5dfa83565b', 69, 'TBL-2-5'),
(349, '60a5dfa83565b', 70, 'TBL-2-6'),
(350, '60a602652e84e', 75, 'TBL-3-1'),
(351, '60a602652e84e', 76, 'TBL-3-2'),
(352, '60a602652e84e', 77, 'TBL-3-3'),
(353, '60a602652e84e', 78, 'TBL-3-4'),
(354, '60a602652e84e', 79, 'TBL-3-5'),
(355, '60a602652e84e', 80, 'TBL-3-6'),
(356, '60a602d17acc7', 117, 'TBL-1-1'),
(357, '60a602d17acc7', 118, 'TBL-1-2'),
(358, '60a602d17acc7', 119, 'TBL-1-3'),
(359, '60a602d17acc7', 120, 'TBL-1-4'),
(360, '60a61586ca9d1', 137, 'TBL-1-1'),
(361, '60a61586ca9d1', 139, 'TBL-1-3'),
(362, '60a61586ca9d1', 141, 'TBL-1-5'),
(363, '60a616eb22637', 143, 'TBL-2-1'),
(364, '60a616eb22637', 144, 'TBL-2-2'),
(365, '60a616eb22637', 145, 'TBL-2-3'),
(366, '60a616eb22637', 146, 'TBL-2-4');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(200) DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `c_id` int(11) DEFAULT NULL,
  `make_date` date DEFAULT NULL,
  `make_time` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` varchar(30) DEFAULT NULL,
  `address` varchar(108) NOT NULL,
  `type` int(11) NOT NULL,
  `bill` float DEFAULT NULL,
  `transactionid` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0- reject, 1-confirmed',
  `reject` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `res_id`, `c_id`, `make_date`, `make_time`, `name`, `phone`, `booking_date`, `booking_time`, `address`, `type`, `bill`, `transactionid`, `status`, `reject`) VALUES
(106, '60a3265925bd6', 14, 27, '2021-05-18', '08:28:41am', 'Kirk Manansala', '09323213123', '2021-05-20', '12:15pm', '', 0, 1894, '', 0, 0),
(107, '60a3267522ff0', 14, 27, '2021-05-18', '08:29:09am', 'Kirk Manansala', '09323213123', '2021-05-20', '12:15pm', '88 Mangrove St Balut1, Pilar', 1, 1894, '', 1, 0),
(108, '60a47c45db828', 29, 30, '2021-05-19', '08:47:33am', 'Syrome Kristiane Samson', '09301226391', '2021-05-25', '10:00am', '', 0, 692, '', 0, 0),
(109, '60a49e18d18fc', 29, 31, '2021-05-19', '11:11:52am', 'Kiah Diwa', '0912387689', '2021-05-21', '11:30am', '', 0, 790, '', 0, 0),
(110, '60a49f5e9c9dc', 29, 31, '2021-05-19', '11:17:18am', 'Kiah Diwa', '0912387689', '2021-05-20', '4:15pm', '#98 Balut 1', 1, 1851, '', 1, 0),
(111, '60a5dfa83565b', 14, 27, '2021-05-20', '10:03:52am', 'Kirk Steven Manansala', '09301226407', '2021-05-27', '10:00am', '', 0, 22368, '', 1, 0),
(112, '60a602652e84e', 14, 27, '2021-05-20', '12:32:05pm', 'Kirk Steven Manansala', '09301226407', '2021-05-27', '10:00am', '', 0, 1844, '', 0, 0),
(113, '60a602d17acc7', 29, 27, '2021-05-20', '12:33:53pm', 'Kirk Steven Manansala', '09301226407', '2021-05-21', '10:45am', '', 0, 592, '', 0, 0),
(114, '60a61586ca9d1', 32, 27, '2021-05-20', '01:53:42pm', 'kirk steven bernabe Manansala', '09301226407', '2021-05-21', '10:00am', '', 0, 370, '', 0, 0),
(115, '60a616eb22637', 32, 27, '2021-05-20', '01:59:39pm', 'kirk steven bernabe Manansala', '09301226407', '2021-05-21', '10:00am', '', 0, 39250, '', 0, 0),
(116, '60a6182ad9090', 14, 27, '2021-05-20', '02:04:58pm', 'kirk steven bernabe Manansala', '09301226407', '2021-05-21', '10:00am', '88 Mangrove St. Balut 1, Pilar', 1, 690, '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `booking_menus`
--

CREATE TABLE `booking_menus` (
  `id` int(11) NOT NULL,
  `booking_id` varchar(200) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_menus`
--

INSERT INTO `booking_menus` (`id`, `booking_id`, `item_id`, `qty`) VALUES
(1, '5ccbd8f5609b3', 4, 2),
(2, '5ccbd8f5609b3', 5, 2),
(3, '607f6cfb76336', 4, 1),
(4, '607f6cfb76336', 5, 2),
(5, '607f6cfb76336', 6, 4),
(6, '6087f11425f85', 10, 6),
(7, '608923125f5eb', 10, 4),
(8, '609239b04fbe6', 10, 1),
(9, '60923ad9abc49', 10, 1),
(10, '609790bc61ad5', 10, 1),
(11, '6098ef011f850', 10, 1),
(12, '6098f075e21e7', 10, 1),
(13, '6098f08c3e6cf', 10, 1),
(14, '609b2e6ad48bd', 10, 1),
(15, '609b2f3bc5a36', 10, 1),
(16, '609b2ff2ed2e3', 10, 1),
(17, '609b3043897a4', 10, 1),
(18, '609b31a19991b', 10, 1),
(19, '609b320248ebe', 10, 1),
(20, '609b32ac21cab', 10, 1),
(21, '609b3361e826c', 10, 1),
(22, '609b33dd787ec', 10, 1),
(23, '609b3452c27a6', 10, 1),
(24, '609b34a2c6104', 10, 1),
(25, '609b3858159ed', 10, 1),
(26, '609b38f3ea18b', 10, 1),
(27, '609b3da210129', 10, 1),
(28, '609b4372de686', 10, 1),
(29, '609cff34470a1', 10, 1),
(30, '609cff88003b5', 10, 1),
(31, '609d09a50bf5a', 10, 1),
(32, '609d09a50bf5a', 13, 0),
(33, '609d0a673a60f', 10, 1),
(34, '609d0a673a60f', 13, 0),
(35, '609d0c7f237c6', 10, 1),
(36, '609d0c7f237c6', 14, 2),
(37, '609d0c7f237c6', 15, 1),
(38, '609d317412cef', 10, 1),
(39, '609d317412cef', 14, 1),
(40, '609d317412cef', 15, 1),
(41, '609da89c5b2a8', 10, 1),
(42, '609dae1d2ee17', 16, 1),
(43, '609dae61bc670', 16, 1),
(44, '609dcf78a45f1', 16, 1),
(45, '609e27aa7cc67', 16, 1),
(46, '609e27aaf1a2f', 16, 1),
(47, '609e2814397c7', 16, 1),
(48, '609e28147aae2', 16, 1),
(49, '609e2912d3dfb', 16, 1),
(50, '609e2ec6ade3a', 16, 1),
(51, '609e31d6c41b5', 16, 1),
(52, '609e31d6c41b5', 14, 2),
(53, '609e31d6c41b5', 15, 2),
(54, '609e336d2c00d', 16, 1),
(55, '609e33dc7f46a', 16, 1),
(56, '609e33dc7f46a', 14, 1),
(57, '609e33dc7f46a', 15, 1),
(58, '60a198e16ffe1', 16, 1),
(59, '60a198e16ffe1', 18, 1),
(60, '60a19f4e2adbb', 16, 1),
(61, '60a1a26aa6841', 16, 6),
(62, '60a1a26aa6841', 18, 1),
(63, '60a1a6372faeb', 16, 12),
(64, '60a1a6372faeb', 18, 12),
(65, '60a1c151c5ee3', 16, 1),
(66, '60a1c151c5ee3', 18, 1),
(67, '60a22149dd8c4', 16, 1),
(68, '60a2e1b62b9fc', 16, 1),
(69, '60a2e1b62b9fc', 18, 1),
(70, '60a2e236216ee', 16, 1),
(71, '60a2e236216ee', 18, 1),
(72, '60a2e2c10cce8', 16, 1),
(73, '60a2e2c10cce8', 18, 2),
(74, '60a2e31e0c742', 16, 1),
(75, '60a2e31e0c742', 18, 2),
(76, '60a2e3edc6beb', 16, 3),
(77, '60a2e461738b5', 16, 3),
(78, '60a2e473084f8', 16, 3),
(79, '60a2e6f685f9e', 16, 1),
(80, '60a2e6f6d4736', 16, 1),
(81, '60a2e74e8431e', 16, 6),
(82, '60a2e827c58bc', 16, 6),
(83, '60a2e89166c0b', 16, 1),
(84, '60a2e8c798eb8', 16, 6),
(85, '60a2e95b6205e', 16, 1),
(86, '60a2e9b34f0f7', 16, 1),
(87, '60a2e9f33c3ac', 16, 1),
(88, '60a2ea138b970', 16, 1),
(89, '60a2ea8829328', 16, 1),
(90, '60a2ea9f6e80c', 16, 1),
(91, '60a2eabf4a896', 16, 1),
(92, '60a2eacbcdc5f', 16, 1),
(93, '60a2eb1d61cf9', 16, 1),
(94, '60a2eb31e1b28', 16, 1),
(95, '60a2ec0f99662', 16, 1),
(96, '60a2ec0f99662', 18, 1),
(97, '60a2ed3072155', 16, 3),
(98, '60a2eded9f8a4', 16, 1),
(99, '60a2eded9f8a4', 18, 1),
(100, '60a2ee0f9593d', 16, 1),
(101, '60a2ee0f9593d', 18, 1),
(102, '60a2ee2e63c0b', 16, 1),
(103, '60a2ee2e63c0b', 18, 1),
(104, '60a2ee911169f', 16, 1),
(105, '60a2ee911169f', 18, 1),
(106, '60a2eed588d34', 16, 1),
(107, '60a2eed588d34', 18, 1),
(108, '60a2f19ceb3a2', 16, 1),
(109, '60a2f19ceb3a2', 18, 1),
(110, '60a2fa560db64', 16, 1),
(111, '60a2fa560db64', 18, 3),
(112, '60a2fb7238a4e', 16, 1),
(113, '60a2fb7238a4e', 18, 2),
(114, '60a2fcea4f5c8', 16, 1),
(115, '60a2fcea4f5c8', 18, 1),
(116, '60a301a186fcd', 16, 3),
(117, '60a301c06c489', 16, 1),
(118, '60a301c06c489', 18, 2),
(119, '60a301c9646dc', 16, 1),
(120, '60a301c9646dc', 18, 2),
(121, '60a302902f055', 16, 1),
(122, '60a3034c0fb90', 16, 1),
(123, '60a3034c0fb90', 18, 2),
(124, '60a31feca53ea', 19, 1),
(125, '60a31feca53ea', 21, 1),
(126, '60a31feca53ea', 26, 1),
(127, '60a31feca53ea', 23, 1),
(128, '60a31feca53ea', 24, 1),
(129, '60a31feca53ea', 25, 1),
(130, '60a31feca53ea', 20, 2),
(131, '60a31feca53ea', 22, 2),
(132, '60a321a3d6cfd', 19, 1),
(133, '60a321a3d6cfd', 21, 1),
(134, '60a321a3d6cfd', 26, 1),
(135, '60a321a3d6cfd', 23, 1),
(136, '60a321a3d6cfd', 24, 1),
(137, '60a321a3d6cfd', 25, 1),
(138, '60a321a3d6cfd', 20, 1),
(139, '60a321a3d6cfd', 22, 1),
(140, '60a321d763ba8', 19, 1),
(141, '60a321d763ba8', 21, 1),
(142, '60a321d763ba8', 26, 1),
(143, '60a321d763ba8', 23, 1),
(144, '60a321d763ba8', 24, 1),
(145, '60a321d763ba8', 25, 1),
(146, '60a321d763ba8', 20, 1),
(147, '60a321d763ba8', 22, 1),
(148, '60a322bef12f7', 19, 1),
(149, '60a322bef12f7', 21, 1),
(150, '60a322bef12f7', 26, 1),
(151, '60a322bef12f7', 23, 1),
(152, '60a322bef12f7', 24, 1),
(153, '60a322bef12f7', 25, 1),
(154, '60a322bef12f7', 20, 1),
(155, '60a322bef12f7', 22, 1),
(156, '60a3265925bd6', 19, 1),
(157, '60a3265925bd6', 21, 1),
(158, '60a3265925bd6', 26, 1),
(159, '60a3265925bd6', 23, 1),
(160, '60a3265925bd6', 24, 1),
(161, '60a3265925bd6', 25, 1),
(162, '60a3265925bd6', 20, 1),
(163, '60a3265925bd6', 22, 1),
(164, '60a3267522ff0', 19, 1),
(165, '60a3267522ff0', 21, 1),
(166, '60a3267522ff0', 26, 1),
(167, '60a3267522ff0', 23, 1),
(168, '60a3267522ff0', 24, 1),
(169, '60a3267522ff0', 25, 1),
(170, '60a3267522ff0', 20, 1),
(171, '60a3267522ff0', 22, 1),
(172, '60a47c45db828', 27, 1),
(173, '60a47c45db828', 28, 1),
(174, '60a47c45db828', 29, 1),
(175, '60a47c45db828', 31, 1),
(176, '60a47c45db828', 30, 4),
(177, '60a49e18d18fc', 27, 1),
(178, '60a49e18d18fc', 28, 1),
(179, '60a49e18d18fc', 29, 1),
(180, '60a49e18d18fc', 31, 2),
(181, '60a49e18d18fc', 30, 4),
(182, '60a49f5e9c9dc', 27, 3),
(183, '60a49f5e9c9dc', 28, 3),
(184, '60a49f5e9c9dc', 29, 3),
(185, '60a49f5e9c9dc', 31, 3),
(186, '60a49f5e9c9dc', 30, 3),
(187, '60a5dfa83565b', 19, 12),
(188, '60a5dfa83565b', 21, 12),
(189, '60a5dfa83565b', 26, 12),
(190, '60a5dfa83565b', 23, 12),
(191, '60a5dfa83565b', 24, 12),
(192, '60a5dfa83565b', 25, 12),
(193, '60a5dfa83565b', 20, 12),
(194, '60a5dfa83565b', 22, 12),
(195, '60a602652e84e', 19, 1),
(196, '60a602652e84e', 21, 1),
(197, '60a602652e84e', 26, 1),
(198, '60a602652e84e', 23, 1),
(199, '60a602652e84e', 24, 1),
(200, '60a602652e84e', 25, 1),
(201, '60a602652e84e', 20, 1),
(202, '60a602652e84e', 22, 1),
(203, '60a602d17acc7', 27, 1),
(204, '60a602d17acc7', 28, 1),
(205, '60a602d17acc7', 29, 1),
(206, '60a602d17acc7', 31, 1),
(207, '60a61586ca9d1', 32, 1),
(208, '60a616eb22637', 32, 100),
(209, '60a616eb22637', 33, 30),
(210, '60a6182ad9090', 19, 1),
(211, '60a6182ad9090', 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `location_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_name`) VALUES
(1, 'Balanga'),
(2, 'Pilar'),
(3, 'Abucay'),
(9, 'Morong'),
(10, 'Bagac'),
(11, 'Mariveles'),
(12, 'Orani'),
(13, 'Hermosa'),
(14, 'Orion'),
(15, 'Samal'),
(16, 'Dinalupihan'),
(18, 'Limay');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `id` int(11) NOT NULL,
  `res_id` int(11) DEFAULT NULL,
  `item_name` varchar(200) DEFAULT NULL,
  `madeby` varchar(300) DEFAULT NULL,
  `stocks` int(11) NOT NULL,
  `measurement` int(2) NOT NULL,
  `food_type` varchar(100) NOT NULL,
  `price` float DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`id`, `res_id`, `item_name`, `madeby`, `stocks`, `measurement`, `food_type`, `price`, `image`) VALUES
(19, 14, 'Samgyeopsal Set', 'Samgyeop (170grams) rice, soup, kimchi', 100, 1, 'Fast Food', 300, 'RBsamgyeop.jpg'),
(20, 14, 'Coke', 'in can 12 oz', 100, 3, 'Drink', 50, 'OIP.jpg'),
(21, 14, 'Samgyeopsal Beef', 'Beef Samgyeopsal 1kg', 100, 1, 'Fast Food', 390, 'beef.jpg'),
(22, 14, 'Soju', '1 bottle', 100, 3, 'Drink', 250, 'soju.jpg'),
(23, 14, 'Kimchi', '100 grams', 9000, 2, 'Add On', 50, 'kimchi.jpg'),
(24, 14, 'Ssamjang Sauce', 'Green', 100, 4, 'Add On', 15, 'samjang green.jpg'),
(25, 14, 'Extra Meat', '100 grams', 10000, 2, 'Add On', 90, 'RBsamgyeop.jpg'),
(26, 14, 'Samgyeopsal Meat', 'Pork Samgyeopsal 1kg', 100, 1, 'Fast Food', 699, 'RBsamgyeop.jpg'),
(27, 29, 'Lava Pork', 'Pork', 100, 1, 'Fast Food', 128, 'lava pork.jpg'),
(28, 29, 'Gyeopsam Wings', '6 pcs Spicy Wings', 90, 1, 'Fast Food', 208, 'wings.jpg'),
(29, 29, 'Korean Chicken Fillet', 'w/ coleslaw salad', 100, 4, 'Fast Food', 158, 'korean chicken filler.jpg'),
(31, 29, 'Banana Split', 'Ice Cream', 100, 4, 'Add On', 98, 'Banana_split_1.jpg'),
(32, 32, 'Plain Beef', 'Beef', 90, 1, 'Fast Food', 370, 'plainbeef350.jpg'),
(33, 32, 'Plain Pork', 'Pork', 20, 1, 'Fast Food', 75, 'plainpork250.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_chair`
--

CREATE TABLE `restaurant_chair` (
  `id` int(11) NOT NULL,
  `tbl_id` int(11) DEFAULT NULL,
  `chair_no` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_chair`
--

INSERT INTO `restaurant_chair` (`id`, `tbl_id`, `chair_no`) VALUES
(24, 3, 'TBL-1-1'),
(25, 3, 'TBL-1-2'),
(26, 3, 'TBL-1-3'),
(27, 3, 'TBL-1-4'),
(28, 3, 'TBL-1-5'),
(29, 3, 'TBL-1-6'),
(30, 4, 'TBL-2-1'),
(31, 4, 'TBL-2-2'),
(32, 4, 'TBL-2-3'),
(33, 4, 'TBL-2-4'),
(34, 5, 'TBL-3-1'),
(35, 5, 'TBL-3-2'),
(36, 5, 'TBL-3-3'),
(37, 5, 'TBL-3-4'),
(38, 6, 'TBL-4-1'),
(39, 6, 'TBL-4-2'),
(40, 6, 'TBL-4-3'),
(41, 7, 'TBL-1-1'),
(42, 7, 'TBL-1-2'),
(43, 7, 'TBL-1-3'),
(44, 7, 'TBL-1-4'),
(45, 7, 'TBL-1-5'),
(46, 8, 'TBL-2-1'),
(47, 8, 'TBL-2-2'),
(48, 8, 'TBL-2-3'),
(49, 9, 'TBL-3-1'),
(50, 9, 'TBL-3-2'),
(51, 9, 'TBL-3-3'),
(52, 9, 'TBL-3-4'),
(53, 10, 'TBL-4-1'),
(54, 10, 'TBL-4-2'),
(55, 11, 'TBL-1-1'),
(56, 11, 'TBL-1-2'),
(57, 11, 'TBL-1-3'),
(58, 11, 'TBL-1-4'),
(59, 12, 'TBL-1-1'),
(60, 12, 'TBL-1-2'),
(61, 12, 'TBL-1-3'),
(62, 12, 'TBL-1-4'),
(63, 12, 'TBL-1-5'),
(64, 12, 'TBL-1-6'),
(65, 13, 'TBL-2-1'),
(66, 13, 'TBL-2-2'),
(67, 13, 'TBL-2-3'),
(68, 13, 'TBL-2-4'),
(69, 13, 'TBL-2-5'),
(70, 13, 'TBL-2-6'),
(75, 14, 'TBL-3-1'),
(76, 14, 'TBL-3-2'),
(77, 14, 'TBL-3-3'),
(78, 14, 'TBL-3-4'),
(79, 14, 'TBL-3-5'),
(80, 14, 'TBL-3-6'),
(81, 15, 'TBL-4-1'),
(82, 15, 'TBL-4-2'),
(83, 15, 'TBL-4-3'),
(84, 15, 'TBL-4-4'),
(85, 15, 'TBL-4-5'),
(86, 15, 'TBL-4-6'),
(87, 17, 'TBL-6-1'),
(88, 17, 'TBL-6-2'),
(89, 17, 'TBL-6-3'),
(90, 17, 'TBL-6-4'),
(91, 17, 'TBL-6-5'),
(92, 17, 'TBL-6-6'),
(93, 16, 'TBL-5-1'),
(94, 16, 'TBL-5-2'),
(95, 16, 'TBL-5-3'),
(96, 16, 'TBL-5-4'),
(97, 16, 'TBL-5-5'),
(98, 16, 'TBL-5-6'),
(99, 18, 'TBL-7-1'),
(100, 18, 'TBL-7-2'),
(101, 18, 'TBL-7-3'),
(102, 18, 'TBL-7-4'),
(103, 18, 'TBL-7-5'),
(104, 18, 'TBL-7-6'),
(105, 19, 'TBL-8-1'),
(106, 19, 'TBL-8-2'),
(107, 19, 'TBL-8-3'),
(108, 19, 'TBL-8-4'),
(109, 20, 'TBL-9-1'),
(110, 20, 'TBL-9-2'),
(111, 20, 'TBL-9-3'),
(112, 20, 'TBL-9-4'),
(113, 21, 'TBL-10-1'),
(114, 21, 'TBL-10-2'),
(115, 21, 'TBL-10-3'),
(116, 21, 'TBL-10-4'),
(117, 22, 'TBL-1-1'),
(118, 22, 'TBL-1-2'),
(119, 22, 'TBL-1-3'),
(120, 22, 'TBL-1-4'),
(121, 23, 'TBL-2-1'),
(122, 23, 'TBL-2-2'),
(123, 23, 'TBL-2-3'),
(124, 23, 'TBL-2-4'),
(125, 24, 'TBL-3-1'),
(126, 24, 'TBL-3-2'),
(127, 24, 'TBL-3-3'),
(128, 24, 'TBL-3-4'),
(129, 25, 'TBL-4-1'),
(130, 25, 'TBL-4-2'),
(131, 25, 'TBL-4-3'),
(132, 25, 'TBL-4-4'),
(133, 26, 'TBL-12-1'),
(134, 26, 'TBL-12-2'),
(135, 26, 'TBL-12-3'),
(136, 26, 'TBL-12-4'),
(137, 27, 'TBL-1-1'),
(138, 27, 'TBL-1-2'),
(139, 27, 'TBL-1-3'),
(140, 27, 'TBL-1-4'),
(141, 27, 'TBL-1-5'),
(142, 27, 'TBL-1-6'),
(143, 28, 'TBL-2-1'),
(144, 28, 'TBL-2-2'),
(145, 28, 'TBL-2-3'),
(146, 28, 'TBL-2-4');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_info`
--

CREATE TABLE `restaurant_info` (
  `id` int(11) NOT NULL,
  `restaurent_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `location` int(11) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `approve_status` int(11) NOT NULL DEFAULT 0 COMMENT '0-not approve,1-approve ',
  `role` int(20) DEFAULT NULL COMMENT '1 = restaurant, 2 = customer '
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_info`
--

INSERT INTO `restaurant_info` (`id`, `restaurent_name`, `email`, `phone`, `address`, `location`, `logo`, `password`, `approve_status`, `role`) VALUES
(1, 'Administrator', 'admin@gmail.com', '', '', 0, 'logo.png', 'admin123', 1, 3),
(14, 'Romantic Baboy', 'RB@gmail.com', '09123456789', 'San Jose, Balanga, Bataan', 1, 'RB.jpg', 'RBbataan', 1, 1),
(27, 'Kirk Steven Manansala', 'kirkbernabe@gmail.com', '', '', 0, 'prof.jpg', 'kirky', 1, 2),
(28, 'Mr. Kimchi', 'kimchi@gmail.com', '09987654321', 'San Jose, Balanga, Bataan', 1, 'mr-kimchi-78788034.jpg', 'kimchi', 1, 1),
(29, 'Gyeopsam', 'gyeopsam@gmail.com', '09301213456', 'Pilar Arcade, Panilao', 2, '164799151_109589111224106_6673525527470000071_n.png', 'gyeopsam', 1, 1),
(30, 'Syrome Kristiane Samson', 'syrome@gmail.com', '09301226391', '88 Mangrove St. Balut 1', 2, 'dp.jpg', 'syrome', 1, 2),
(31, 'Kiah Diwa', 'kd@gmail.com', '0912387689', '#98 Balut 1', 2, 'dp.jpg', 'kiahdiwa', 1, 2),
(32, 'Super Boink', 'SB@gmail.com', '09123456789', 'Ibayo, Balanga', 1, 'sb logo.jpg', 'SBbataan', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_tables`
--

CREATE TABLE `restaurant_tables` (
  `id` int(11) NOT NULL,
  `res_id` int(11) DEFAULT NULL,
  `table_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_tables`
--

INSERT INTO `restaurant_tables` (`id`, `res_id`, `table_name`) VALUES
(3, 4, 'TBL-1'),
(4, 4, 'TBL-2'),
(5, 4, 'TBL-3'),
(6, 4, 'TBL-4'),
(7, 5, 'TBL-1'),
(8, 5, 'TBL-2'),
(9, 5, 'TBL-3'),
(10, 5, 'TBL-4'),
(11, 7, 'TBL-1'),
(12, 14, 'TBL-1'),
(13, 14, 'TBL-2'),
(14, 14, 'TBL-3'),
(15, 14, 'TBL-4'),
(16, 14, 'TBL-5'),
(17, 14, 'TBL-6'),
(18, 14, 'TBL-7'),
(19, 14, 'TBL-8'),
(20, 14, 'TBL-9'),
(21, 14, 'TBL-10'),
(22, 29, 'TBL-1'),
(23, 29, 'TBL-2'),
(24, 29, 'TBL-3'),
(25, 29, 'TBL-4'),
(26, 14, 'TBL-12'),
(27, 32, 'TBL-1'),
(28, 32, 'TBL-2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `poll` int(1) NOT NULL,
  `feedback` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`id`, `res_id`, `name`, `poll`, `feedback`) VALUES
(6, 14, 'Kirk Steven Manansala', 5, ''),
(7, 14, 'Kirk Steven Manansala', 4, 'Great'),
(8, 14, 'Kirk Manansala', 5, 'Fast Delivery\r\n'),
(9, 29, 'Syrome Kristiane Samson', 4, 'Great Service'),
(10, 29, 'Kiah Diwa', 4, ''),
(11, 29, 'Kiah Diwa', 4, ''),
(12, 14, 'Kirk Steven Manansala', 4, 'Reliable'),
(13, 14, 'Kirk Steven Manansala', 5, 'Great Service add more menu '),
(14, 29, 'Kirk Steven Manansala', 5, 'Add more menu \r\n'),
(15, 32, 'kirk steven bernabe Manansala', 5, 'Add more menu'),
(16, 32, 'kirk steven bernabe Manansala', 4, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_chair`
--
ALTER TABLE `booking_chair`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_menus`
--
ALTER TABLE `booking_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_chair`
--
ALTER TABLE `restaurant_chair`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_info`
--
ALTER TABLE `restaurant_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_chair`
--
ALTER TABLE `booking_chair`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=367;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `booking_menus`
--
ALTER TABLE `booking_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `restaurant_chair`
--
ALTER TABLE `restaurant_chair`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `restaurant_info`
--
ALTER TABLE `restaurant_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

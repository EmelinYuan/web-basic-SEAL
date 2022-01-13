-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2022 at 03:00 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cheatstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `cheatlist`
--

CREATE TABLE `cheatlist` (
  `id_cheat` int(11) NOT NULL,
  `cheat_name` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cheatlist`
--

INSERT INTO `cheatlist` (`id_cheat`, `cheat_name`) VALUES
(5, 'Cheat ML'),
(7, 'asdasdf'),
(8, 'sdsdsd'),
(9, 'daadad'),
(10, 'daad'),
(11, 'daadad'),
(12, 'daadad'),
(13, 'adad'),
(14, 'dadad'),
(15, 'dadadad'),
(16, 'adadad'),
(17, 'dadadad'),
(18, 'dsdsd'),
(19, 'sdsd');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id_order` int(11) NOT NULL,
  `id_user` varchar(155) NOT NULL,
  `id_pricelist` varchar(155) NOT NULL,
  `qty` int(100) NOT NULL,
  `status` varchar(155) NOT NULL,
  `date_created` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pricelist`
--

CREATE TABLE `pricelist` (
  `id_pricelist` int(11) NOT NULL,
  `name_pricelist` varchar(155) NOT NULL,
  `price` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(155) NOT NULL,
  `username` varchar(155) NOT NULL,
  `name` varchar(155) NOT NULL,
  `password` varchar(155) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `name`, `password`, `role`) VALUES
(1, 'irpannawawi.ixd@gmail.com', 'user', 'Irpan Nawawi', '123', 'user'),
(2, 'irpannawawi@gmail.com', 'user1', 'Irpan Nawawi', '123', 'user'),
(3, 'irpannawawi.@gmail.com', 'admin', 'Irpan Nawawi', '123', 'user'),
(4, 'admin@admin.com', 'admin', 'Admin', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cheatlist`
--
ALTER TABLE `cheatlist`
  ADD PRIMARY KEY (`id_cheat`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `pricelist`
--
ALTER TABLE `pricelist`
  ADD PRIMARY KEY (`id_pricelist`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cheatlist`
--
ALTER TABLE `cheatlist`
  MODIFY `id_cheat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pricelist`
--
ALTER TABLE `pricelist`
  MODIFY `id_pricelist` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

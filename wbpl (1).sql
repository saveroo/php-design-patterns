-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2016 at 05:15 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wbpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `details_transaction`
--

CREATE TABLE IF NOT EXISTS `details_transaction` (
  `detail_id` int(11) NOT NULL,
  `ckName` varchar(33) NOT NULL,
  `Qty` int(11) NOT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `cake_id` int(11) NOT NULL,
  `tr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`cake_id` int(11) NOT NULL,
  `ckName` varchar(50) NOT NULL,
  `ckPrice` int(20) NOT NULL,
  `ckStock` int(3) NOT NULL,
  `ckImage` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`cake_id`, `ckName`, `ckPrice`, `ckStock`, `ckImage`) VALUES
(9, 'Reaa', 99999, 12, 'assets/6.jpg'),
(10, 'Raspberry', 8900, 16, 'assets/6.jpg'),
(11, 'tokek', 232323, 2, 'assets/7.jpg'),
(12, 'Roll Cake', 159000, 72, 'assets/6.jpg'),
(13, 'Lovecholate', 620000, 55, 'assets/7.jpg'),
(14, 'Strawberry Cake', 427999, 11, 'assets/3.jpg'),
(15, 'Minion Cake', 150000, 3, 'assets/2.jpg'),
(16, 'arear', 5555, 55, 'assets/1.JPG'),
(17, 'Cake Good', 150000, 6, 'assets/1.JPG'),
(18, 'sadadad', 232323, 2, 'assets/1.JPG'),
(19, 'Bagong', 515251, 55, 'assets/8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
`rv_id` int(11) NOT NULL,
  `rv_username` varchar(25) NOT NULL,
  `rv_products` varchar(25) NOT NULL,
  `rv_comment` text NOT NULL,
  `rv_status` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
`tr_id` int(11) NOT NULL,
  `tr_username` varchar(20) NOT NULL,
  `tr_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tr_ckImage` varchar(55) NOT NULL,
  `tr_ckName` varchar(55) NOT NULL,
  `tr_qty` int(35) NOT NULL,
  `tr_subtotal` int(35) NOT NULL,
  `tr_total` int(35) NOT NULL,
  `tr_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `usertype` varchar(6) NOT NULL DEFAULT 'Member',
  `phone` tinytext NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `usertype`, `phone`, `gender`, `email`, `address`) VALUES
(1, 'savero', '46f94c8de14fb36680850768ff1b7f2a', 'Member', '81341', 'Male', 'surga@gmail.com', 'jalan walet'),
(2, 'saveroo', '46f94c8de14fb36680850768ff1b7f2a', 'Admin', '0', 'Male', 'test', 'Blablabla Street');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `details_transaction`
--
ALTER TABLE `details_transaction`
 ADD PRIMARY KEY (`detail_id`,`cake_id`,`tr_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`cake_id`), ADD KEY `cake_id` (`cake_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
 ADD PRIMARY KEY (`rv_id`), ADD KEY `rv_id` (`rv_id`), ADD KEY `rv_id_2` (`rv_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
 ADD PRIMARY KEY (`tr_id`), ADD KEY `tr_id` (`tr_id`), ADD KEY `tr_id_2` (`tr_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `cake_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
MODIFY `rv_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

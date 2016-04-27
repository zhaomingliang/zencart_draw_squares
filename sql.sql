-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-04-27 13:48:21
-- 服务器版本： 5.5.47
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daxiong`
--

-- --------------------------------------------------------

--
-- 表的结构 `zen_prizew`
--

CREATE TABLE `zen_prizew` (
  `id` int(11) NOT NULL,
  `prize` varchar(255) DEFAULT NULL,
  `v` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `prompt` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `message` varchar(300) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `zen_prizew`
--

INSERT INTO `zen_prizew` (`id`, `prize`, `v`, `time`, `prompt`, `type`, `message`, `condition`) VALUES
(1, '10', '0', '2016-04-27 09:44:39', NULL, 'coupon', '\r\nCongratulations to you in $10 coupons, please go to my record for lottery coupons', '100'),
(2, '200', '0', '2016-04-27 09:44:39', NULL, 'coupon', 'Congratulations to you in $200 coupons, please go to my record for lottery coupons', '500'),
(3, '0', '0', '2016-04-27 09:44:39', NULL, NULL, 'Thank you for participating', NULL),
(4, 'iphone 6s', '0', '2016-04-26 09:44:39', NULL, NULL, 'Congratulations on the iphone 6s, we will contact you with the awarding process', NULL),
(5, '5', '82', '2016-04-27 09:44:39', NULL, 'coupon', 'Congratulations to you in $5 coupons, please go to my record for lottery coupons', '0'),
(6, '10', '0', '2016-04-27 09:44:39', NULL, NULL, 'Congratulations to you in $10 coupons, please go to my record for lottery coupons', '100'),
(7, '50', '0', '2016-04-27 09:44:39', NULL, NULL, 'Congratulations to you in $50 coupons, please go to my record for lottery coupons', '200'),
(8, 'iwatch', '0', '2016-04-27 09:44:39', NULL, NULL, 'Congratulations on the Iwatch, we will contact you with the awarding process', NULL),
(9, '10', '42', '2016-04-27 09:44:39', NULL, 'coupon', 'Congratulations to you in $5 coupons, please go to my record for lottery coupons', '100'),
(10, '0', '0', '2016-04-25 09:44:39', NULL, NULL, 'Thank you for participating', ''),
(11, '10', '10', '2016-04-26 09:44:39', NULL, 'coupon', 'Congratulations to you in $10 coupons, please go to my record for lottery coupons', '100'),
(12, '5', '7', '2016-04-25 09:44:39', NULL, 'coupon', 'Congratulations to you in $5 coupons, please go to my record for lottery coupons', '0');

-- --------------------------------------------------------

--
-- 表的结构 `zen_prizew_log`
--

CREATE TABLE `zen_prizew_log` (
  `id` int(11) NOT NULL,
  `drawtime` varchar(255) DEFAULT NULL,
  `prizew_id` int(11) DEFAULT NULL,
  `releasestatus` varchar(255) DEFAULT NULL,
  `customerid` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `log` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `zen_prizew_log`
--

INSERT INTO `zen_prizew_log` (`id`, `drawtime`, `prizew_id`, `releasestatus`, `customerid`, `ip`, `log`) VALUES
(51, '2016-04-27 11:38:43', 9, NULL, 1, NULL, 'Your coupon is:(rpiQWu), Please purchase the time to copy the use of'),
(52, '2016-04-27 11:46:01', 5, NULL, 1, NULL, 'Your coupon is:(IXoJsf), Please purchase the time to copy the use of'),
(45, '2016-04-27 10:33:56', 5, NULL, 1, NULL, NULL),
(47, '2016-04-27 11:30:03', 9, NULL, 1, NULL, ''),
(48, '2016-04-27 11:30:05', 9, NULL, 1, NULL, ''),
(49, '2016-04-27 11:31:07', 5, NULL, 1, NULL, ''),
(50, '2016-04-27 11:31:42', 5, NULL, 1, NULL, 'Your coupon is:(tSQjQr), Please purchase the time to copy the use of'),
(53, '2016-04-27 11:46:02', 5, NULL, 1, NULL, 'Your coupon is:(rvQw5B), Please purchase the time to copy the use of'),
(54, '2016-04-27 11:46:03', 5, NULL, 1, NULL, 'Your coupon is:(LtDc29), Please purchase the time to copy the use of'),
(46, '2016-04-27 11:30:01', 9, NULL, 1, NULL, ''),
(55, '2016-04-27 11:46:03', 5, NULL, 1, NULL, 'Your coupon is:(zoWcgB), Please purchase the time to copy the use of'),
(56, '2016-04-27 11:46:34', 12, NULL, 1, NULL, 'Your coupon is:(WMtGuh), Please purchase the time to copy the use of'),
(57, '2016-04-27 11:47:52', 5, NULL, 1, NULL, 'Your coupon is:(C6MRW6), Please purchase the time to copy the use of');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zen_prizew`
--
ALTER TABLE `zen_prizew`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zen_prizew_log`
--
ALTER TABLE `zen_prizew_log`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `zen_prizew`
--
ALTER TABLE `zen_prizew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `zen_prizew_log`
--
ALTER TABLE `zen_prizew_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2017 at 07:58 AM
-- Server version: 5.5.57-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `dictionary`
--

CREATE TABLE IF NOT EXISTS `dictionary` (
`id` int(11) NOT NULL,
  `ename` varchar(30) CHARACTER SET utf8 NOT NULL,
  `aname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `translator` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ver` int(11) NOT NULL,
  `example` text NOT NULL,
  `comment` text NOT NULL,
  `up` int(11) NOT NULL,
  `down` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=cp1256;

--
-- Dumping data for table `dictionary`
--

INSERT INTO `dictionary` (`id`, `ename`, `aname`, `translator`, `ver`, `example`, `comment`, `up`, `down`) VALUES
(2, 'Targeting', 'استهداف', 'محمد الفحماوي', 1, '', '', 2, 0),
(5, 'Scheduling', 'جدولة', 'رعد دودخ', 0, '', '', 0, 0),
(6, 'CPC', 'تكلفة النقرة على الموقع', 'محمد فحماوي', 0, '', '', 0, 1),
(7, 'Search Network', 'شبكة البحث', 'ذيب غنما', 0, '', '', 0, 0),
(8, 'Subscribers', 'المشتركين', 'انس فارس', 1, '', '', 1, 1),
(9, 'Average Response Time', 'متوسّط زمن الاستجابة', 'رعد دودخ', 1, '', '', 0, 0),
(10, 'Verified', 'موثّق', 'رعد دودخ', 1, '', '', 0, 0),
(11, 'Views', 'مشاهدات', 'رعد دودخ', 1, '', '', 0, 1),
(12, 'Ecommerce', 'تجارة الكترونية', 'ذيب غنما', 0, '', '', 0, 0),
(13, 'Repost', 'إعادة نشر', 'رعد دودخ', 1, '', '', 0, 0),
(14, 'Pinned Post', 'المنشور المثبت', 'رعد دودخ', 1, '', '', 1, 0),
(15, 'Sponsored Ad', 'إعلان مموّل', 'رعد دودخ', 0, '', '', 0, 0),
(16, 'Frequency', 'التكرار', 'ذيب غنما', 0, '', '', 0, 0),
(17, 'Notifications ', 'الإشعارات', 'رعد دودخ', 1, '', '', 1, 0),
(18, 'Forum', 'منتدى', 'Sparkie', 0, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `realname` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `realname`, `password`, `email`) VALUES
(3, 'admin', 'Administrator', '7a0e15fcd5fb7a32a84282e828b571b7', 'admin@qamos.net');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
`voteid` int(11) NOT NULL,
  `wordid` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=cp1256;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`voteid`, `wordid`, `ip`) VALUES
(1, 8, '156.213.102.140'),
(2, 8, '41.42.98.153'),
(3, 14, '151.255.39.56'),
(4, 2, '41.42.83.150'),
(5, 11, '93.169.226.160'),
(6, 2, '213.244.118.243'),
(7, 17, '188.52.148.254'),
(8, 6, '176.44.199.211');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dictionary`
--
ALTER TABLE `dictionary`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
 ADD PRIMARY KEY (`voteid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dictionary`
--
ALTER TABLE `dictionary`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
MODIFY `voteid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

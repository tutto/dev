-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2014 at 07:23 PM
-- Server version: 5.6.11-log
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `parent`, `name`, `level`) VALUES
(1, NULL, 'guest', 0),
(2, 1, 'member', 10),
(3, 2, 'client', 20),
(4, 2, 'worker', 30),
(5, 4, 'advisor', 40),
(6, 5, 'administrator', 90);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `roles` (`id`);

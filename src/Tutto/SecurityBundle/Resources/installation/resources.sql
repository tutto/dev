-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2014 at 07:27 PM
-- Server version: 5.6.11-log
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `version` varchar(255) NOT NULL DEFAULT '1.0.0',
  `allowRecursion` tinyint(1) NOT NULL DEFAULT '1',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_2` (`parent`,`type`,`name`,`version`),
  UNIQUE KEY `parent_3` (`parent`,`type`,`name`,`version`),
  KEY `parent` (`parent`,`role`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `parent`, `role`, `type`, `name`, `title`, `keywords`, `description`, `version`, `allowRecursion`, `isActive`) VALUES
(1, NULL, 1, 'controller', 'Impuls\\Bundle\\AccountBundle\\Controller\\AuthController', '@AccountBundle::AuthController', NULL, NULL, '1.0.0', 1, 1),
(2, 1, 1, 'action', 'loginAction', 'Log in', NULL, NULL, '1.0.0', 1, 1),
(3, 1, 1, 'action', 'logoutAction', 'Log out', NULL, NULL, '1.0.0', 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_2` FOREIGN KEY (`role`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `resources` (`id`);

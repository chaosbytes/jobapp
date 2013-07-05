-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.jobapp.foursquaregames.com
-- Generation Time: Jul 04, 2013 at 05:04 PM
-- Server version: 5.1.56
-- PHP Version: 5.4.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `jobapp_v1`
--
CREATE DATABASE `jobapp_v1` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jobapp_v1`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `passwordhash` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `admins`
--


-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `fname` varchar(25) COLLATE utf8_bin NOT NULL,
  `lname` varchar(25) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `zipcode` varchar(10) COLLATE utf8_bin NOT NULL,
  `passwordhash` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=139 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `username`, `fname`, `lname`, `email`, `zipcode`, `passwordhash`) VALUES
(108, 'joe.rice', 'Joe', 'Rice', 'riceje7@gmail.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(109, 'ariana.colom', 'Ariana', 'Colom', 'aecolom@gmail.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(135, '1', 'Joe', 'Rice', 'joe.rice7@icloud.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(138, 'ariana.colom1', 'Ariana', 'Colom', 'aecotton37@yahoo.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98');
--
-- Database: `jobapp_v2`
--
CREATE DATABASE `jobapp_v2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jobapp_v2`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `passwordhash` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `admins`
--


-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `email` varchar(96) COLLATE utf8_bin NOT NULL,
  `first_name` varchar(25) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(25) COLLATE utf8_bin NOT NULL,
  `zip_code` varchar(10) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `password_salt` varchar(16) COLLATE utf8_bin NOT NULL,
  `password_hash` varchar(100) COLLATE utf8_bin NOT NULL,
  `activation_hash` varchar(40) COLLATE utf8_bin NOT NULL,
  `password_reset_hash` varchar(40) COLLATE utf8_bin NOT NULL,
  `password_reset_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=23 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `email`, `first_name`, `last_name`, `zip_code`, `activated`, `password_salt`, `password_hash`, `activation_hash`, `password_reset_hash`, `password_reset_timestamp`) VALUES
(022, 'riceje7@gmail.com', 'Joe', 'Rice', '18104', 1, 'PJ6Vq01HfTQNoAmV', '$6$rounds=10000$PJ6Vq01HfTQNoAmV$clr25DygZO6r9sm5H44ZHoVb2tNjD5zHKeCUCRNskjfMZ1Zi5uG1oQLTtRLG7jPC5q/', '', '', '2013-07-04 15:35:59');

-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 30, 2013 at 02:51 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `jobapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `passwordhash` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `passwordhash`) VALUES
(001, 'riceje7', '65560d02bf2f5e6d6b3ea258ecd24d98');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `fname` varchar(25) COLLATE utf8_bin NOT NULL,
  `lname` varchar(25) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `zipcode` varchar(10) COLLATE utf8_bin NOT NULL,
  `passwordhash` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=127 ;


INSERT INTO `clients` (`id`, `username`, `fname`, `lname`, `email`, `zipcode`, `passwordhash`) VALUES
(108, 'joe.rice', 'Joe', 'Rice', 'riceje7@gmail.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(109, 'ariana.colom', 'Ariana', 'Colom', 'aecolom@gmail.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(110, 'diane.colom', 'Diane', 'Colom', 'riceje7@gmail.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(111, 'ervev.rverv', 'ervev', 'rverv', 'ervr@rr.com', '22823', '3dbe00a167653a1aaee01d93e77e730e'),
(112, 'weffwe.efwfw', 'weffwe', 'efwfw', 'wef@wefw.com', '12212', '3dbe00a167653a1aaee01d93e77e730e'),
(113, 'wefwwv.wecwec', 'WEFwwv', 'wecwec', 'wefwe@ee.com', '22222', '3dbe00a167653a1aaee01d93e77e730e');

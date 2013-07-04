-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2013 at 08:39 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `jobapp_v1`
--
-- CREATE DATABASE `jobapp_v1` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `jobapp_v1`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

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
-- CREATE DATABASE `jobapp_v2` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `jobapp_v2`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `first_name` varchar(25) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(25) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `zip_code` varchar(10) COLLATE utf8_bin NOT NULL,
  `password_salt` varchar(16) COLLATE utf8_bin NOT NULL,
  `password_hash` varchar(50) COLLATE utf8_bin NOT NULL,
  `activation_hash` varchar(50) COLLATE utf8_bin NOT NULL,
  `password_reset_hash` varchar(50) COLLATE utf8_bin NOT NULL,
  `password_reset_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

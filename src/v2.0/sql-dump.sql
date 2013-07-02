-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2013 at 12:56 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `jobapp`
--
-- CREATE DATABASE `jobapp` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
-- USE `jobapp`;
 
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=139 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `username`, `fname`, `lname`, `email`, `zipcode`, `passwordhash`) VALUES
(108, 'joe.rice', 'Joe', 'Rice', 'riceje7@gmail.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(109, 'ariana.colom', 'Ariana', 'Colom', 'aecolom@gmail.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(135, '1', 'Joe', 'Rice', 'joe.rice7@icloud.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98'),
(138, 'ariana.colom1', 'Ariana', 'Colom', 'aecotton37@yahoo.com', '18104', '65560d02bf2f5e6d6b3ea258ecd24d98');

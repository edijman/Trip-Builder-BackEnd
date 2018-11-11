-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2018 at 08:36 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trip`
--

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

CREATE TABLE `airlines` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airlines`
--

INSERT INTO `airlines` (`id`, `name`, `code`) VALUES
(1, 'Air Canada', 'AC'),
(2, 'WestJet flights', 'WJ'),
(3, 'Porter Airlines', 'PAF');

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `id` int(255) NOT NULL,
  `code` varchar(25) NOT NULL,
  `city_id` varchar(25) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL,
  `country_code` varchar(25) NOT NULL,
  `region_code` varchar(25) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `timezone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `code`, `city_id`, `name`, `country_code`, `region_code`, `latitude`, `longitude`, `timezone`) VALUES
(1, 'YUL', '1', 'Pierre Elliott Trudeau International Airport', 'CAN', 'QC', 45.5859, -73.6178, 'Eastern Standard Time'),
(2, 'YYZ', '2', 'Toronto Pearson International Airport', 'CAN', 'ON', 25.2498, 55.3506, 'Eastern Standard Time'),
(3, 'YVR', '3', 'Vancouver International Airport', 'CAN', 'BC', 25.2498, 55.3506, 'Pacific Standard Time'),
(4, 'YDT', '3', 'Boundary Bay Airport', 'CAN', 'BC', 49.0084, -123.04, 'Pacific Standard Time'),
(5, 'YXX', '3', 'Abbotsford International Airport', 'CAN', 'BC', 25.2498, 55.3506, 'Pacific Standard Time');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `region_code` varchar(25) NOT NULL,
  `country_code` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `region_code`, `country_code`) VALUES
(1, 'Montreal', 'QC', 'CAN'),
(2, 'Toronto', 'ON', 'CAN'),
(3, 'Vancouver', 'BC', 'CAN');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `code`) VALUES
(1, 'Canada', 'CAN');

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `airline` varchar(25) NOT NULL,
  `number` int(25) NOT NULL,
  `departure_airport` varchar(25) NOT NULL,
  `arrival_airport` varchar(25) NOT NULL,
  `departure_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arrival_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `airline`, `number`, `departure_airport`, `arrival_airport`, `departure_time`, `arrival_time`, `price`) VALUES
(1, 'Air Canada', 200, 'YUL', 'YYZ', '2018-11-10 05:00:00', '2018-11-11 05:00:10', 59),
(2, 'Air Canada', 301, 'YUL', 'YYZ', '2018-11-10 15:00:00', '2018-11-11 18:00:00', 59),
(3, 'Porter Airlines', 302, 'YUL', 'YXX', '2018-11-10 15:00:00', '2018-11-11 18:00:00', 59),
(4, 'Porter Airlines', 345, 'YYZ', 'YUL', '2018-11-10 20:00:00', '2018-11-11 18:00:00', 59),
(5, 'Porter Airlines', 366, 'YUL', 'YYZ', '2018-11-10 15:00:00', '2018-11-11 18:00:00', 59);

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `code` varchar(25) NOT NULL,
  `country_code` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`id`, `name`, `code`, `country_code`) VALUES
(1, 'Quebec', 'QC', 'CAN'),
(2, 'Ontario', 'ON', 'CAN'),
(3, 'British Columbia', 'BC', 'CAN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airlines`
--
ALTER TABLE `airlines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `City_fk0` (`region_code`),
  ADD KEY `City_fk1` (`country_code`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `Region_fk0` (`country_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airports`
--
ALTER TABLE `airports`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `City_fk0` FOREIGN KEY (`region_code`) REFERENCES `region` (`code`),
  ADD CONSTRAINT `City_fk1` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`);

--
-- Constraints for table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `Region_fk0` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: trip
# Generation Time: 2018-11-09 20:30:22 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Airlines
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Airlines`;

CREATE TABLE `Airlines` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Airlines` WRITE;
/*!40000 ALTER TABLE `Airlines` DISABLE KEYS */;

INSERT INTO `Airlines` (`id`, `name`, `code`)
VALUES
	(1,'Air Canada','AC'),
	(2,'WestJet flights','WJ'),
	(3,'Porter Airlines flights','PAF');

/*!40000 ALTER TABLE `Airlines` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Airports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Airports`;

CREATE TABLE `Airports` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `code` varchar(25) NOT NULL,
  `city_id` varchar(25) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL,
  `country_code` varchar(25) NOT NULL,
  `region_code` varchar(25) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `timezone` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Airports` WRITE;
/*!40000 ALTER TABLE `Airports` DISABLE KEYS */;

INSERT INTO `Airports` (`id`, `code`, `city_id`, `name`, `country_code`, `region_code`, `latitude`, `longitude`, `timezone`)
VALUES
	(1,'YUL','1','Pierre Elliott Trudeau International Airport','CAN','QC',45.5859,-73.6178,'Eastern Standard Time'),
	(2,'YYZ','2','Toronto Pearson International Airport','CAN','ON',25.2498,55.3506,'Eastern Standard Time'),
	(3,'YVR','3','Vancouver International Airport','CAN','BC',25.2498,55.3506,'Pacific Standard Time'),
	(4,'YDT','3','Boundary Bay Airport','CAN','BC',49.0084,-123.04,'Pacific Standard Time'),
	(5,'YXX','3','Abbotsford International Airport','CAN','BC',25.2498,55.3506,'Pacific Standard Time');

/*!40000 ALTER TABLE `Airports` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table City
# ------------------------------------------------------------

DROP TABLE IF EXISTS `City`;

CREATE TABLE `City` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `region_code` varchar(25) NOT NULL,
  `country_code` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `City_fk0` (`region_code`),
  KEY `City_fk1` (`country_code`),
  CONSTRAINT `City_fk0` FOREIGN KEY (`region_code`) REFERENCES `Region` (`code`),
  CONSTRAINT `City_fk1` FOREIGN KEY (`country_code`) REFERENCES `Country` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `City` WRITE;
/*!40000 ALTER TABLE `City` DISABLE KEYS */;

INSERT INTO `City` (`id`, `name`, `region_code`, `country_code`)
VALUES
	(1,'Montreal','QC','CAN'),
	(2,'Toronto','ON','CAN'),
	(3,'Vancouver','BC','CAN');

/*!40000 ALTER TABLE `City` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Country`;

CREATE TABLE `Country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Country` WRITE;
/*!40000 ALTER TABLE `Country` DISABLE KEYS */;

INSERT INTO `Country` (`id`, `name`, `code`)
VALUES
	(1,'Canada','CAN');

/*!40000 ALTER TABLE `Country` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Flights
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Flights`;

CREATE TABLE `Flights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `airline` varchar(25) NOT NULL,
  `number` int(25) NOT NULL,
  `departure_airport` varchar(25) NOT NULL,
  `arrival_airport` varchar(25) NOT NULL,
  `departure_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arrival_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Flights` WRITE;
/*!40000 ALTER TABLE `Flights` DISABLE KEYS */;

INSERT INTO `Flights` (`id`, `airline`, `number`, `departure_airport`, `arrival_airport`, `departure_time`, `arrival_time`, `price`)
VALUES
	(1,'Air Canada',200,'YUL','YYZ','2018-11-09 00:00:00','2018-11-09 00:00:10',59),
	(2,'Air Canada',301,'YUL','YYZ','2018-11-09 10:00:00','2018-11-09 13:00:00',59),
	(3,'Porter Airlines flights',302,'YUL','YXX','2018-11-09 10:00:00','2018-11-09 13:00:00',59),
	(4,'Porter Airlines flights',345,'YYZ','YXX','2018-11-09 10:00:00','2018-11-09 13:00:00',59),
	(5,'Porter Airlines flights',366,'YUL','YYZ','2018-11-09 10:00:00','2018-11-09 13:00:00',59);

/*!40000 ALTER TABLE `Flights` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Region
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Region`;

CREATE TABLE `Region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `code` varchar(25) NOT NULL,
  `country_code` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`),
  KEY `Region_fk0` (`country_code`),
  CONSTRAINT `Region_fk0` FOREIGN KEY (`country_code`) REFERENCES `Country` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Region` WRITE;
/*!40000 ALTER TABLE `Region` DISABLE KEYS */;

INSERT INTO `Region` (`id`, `name`, `code`, `country_code`)
VALUES
	(1,'Quebec','QC','CAN'),
	(2,'Ontario','ON','CAN'),
	(3,'British Columbia','BC','CAN');

/*!40000 ALTER TABLE `Region` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

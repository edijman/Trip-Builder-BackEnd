CREATE TABLE `Airlines` (
	`id` int(255) NOT NULL UNIQUE,
	`name` varchar(25) NOT NULL UNIQUE,
	`code` varchar(25) NOT NULL UNIQUE,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Airports` (
	`id` int(255) NOT NULL AUTO_INCREMENT UNIQUE,
	`code` varchar(25) NOT NULL UNIQUE,
	`city_code` varchar(25) NOT NULL UNIQUE,
	`name` varchar(50) NOT NULL UNIQUE,
	`country_code` varchar(25) NOT NULL,
	`region_code` varchar(25) NOT NULL,
	`latitude` FLOAT(10) NOT NULL,
	`longitude` FLOAT(10) NOT NULL,
	`timezone` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Flights` (
	`id` int NOT NULL AUTO_INCREMENT,
	`airline` varchar(25) NOT NULL,
	`number` int(25) NOT NULL UNIQUE,
	`departure_airport` varchar(25) NOT NULL,
	`arrival_airport` varchar(25) NOT NULL,
	`departure_time` TIMESTAMP NOT NULL,
	`arrival_time` TIMESTAMP NOT NULL,
	`price` FLOAT(50) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `City` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(25) NOT NULL,
	`code` varchar(25) NOT NULL UNIQUE,
	`region_code` varchar(25) NOT NULL,
	`country_code` varchar(25) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Country` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(25) NOT NULL UNIQUE,
	`code` varchar(25) NOT NULL UNIQUE,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Region` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(25) NOT NULL UNIQUE,
	`code` varchar(25) NOT NULL UNIQUE,
	`country_code` varchar(25) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `Airports` ADD CONSTRAINT `Airports_fk0` FOREIGN KEY (`city_code`) REFERENCES `City`(`code`);

ALTER TABLE `Airports` ADD CONSTRAINT `Airports_fk1` FOREIGN KEY (`region_code`) REFERENCES `Region`(`code`);

ALTER TABLE `Flights` ADD CONSTRAINT `Flights_fk0` FOREIGN KEY (`airline`) REFERENCES `Airlines`(`code`);

ALTER TABLE `Flights` ADD CONSTRAINT `Flights_fk1` FOREIGN KEY (`departure_airport`) REFERENCES `Airports`(`code`);

ALTER TABLE `Flights` ADD CONSTRAINT `Flights_fk2` FOREIGN KEY (`arrival_airport`) REFERENCES `Airports`(`code`);

ALTER TABLE `City` ADD CONSTRAINT `City_fk0` FOREIGN KEY (`region_code`) REFERENCES `Region`(`code`);

ALTER TABLE `City` ADD CONSTRAINT `City_fk1` FOREIGN KEY (`country_code`) REFERENCES `Country`(`code`);

ALTER TABLE `Region` ADD CONSTRAINT `Region_fk0` FOREIGN KEY (`country_code`) REFERENCES `Country`(`code`);

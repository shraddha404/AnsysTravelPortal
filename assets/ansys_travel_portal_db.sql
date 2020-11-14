-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: ansys_travel_portal
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `air_bookings`
--

DROP TABLE IF EXISTS `air_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `air_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `urgent_booking` tinyint(4) DEFAULT '0',
  `booking_types` tinyint(4) DEFAULT NULL,
  `book_airline` varchar(255) DEFAULT NULL,
  `travel_from` varchar(255) DEFAULT NULL,
  `travel_to` varchar(255) DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `travel_time` varchar(255) DEFAULT NULL,
  `meal_preference` varchar(255) DEFAULT NULL,
  `visa_requirement` tinyint(4) DEFAULT '0',
  `ticket_refundable` tinyint(4) DEFAULT '0',
  `approved` enum('y','n') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `air_bookings`
--

LOCK TABLES `air_bookings` WRITE;
/*!40000 ALTER TABLE `air_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `air_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `airlines`
--

DROP TABLE IF EXISTS `airlines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airlines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('D','I') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airlines`
--

LOCK TABLES `airlines` WRITE;
/*!40000 ALTER TABLE `airlines` DISABLE KEYS */;
/*!40000 ALTER TABLE `airlines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_bookings`
--

DROP TABLE IF EXISTS `car_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `type_of_vehicle` varchar(255) DEFAULT NULL,
  `type_of_visit` varchar(255) DEFAULT NULL,
  `car_company` int(11) DEFAULT NULL,
  `approved` enum('y','n') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_bookings`
--

LOCK TABLES `car_bookings` WRITE;
/*!40000 ALTER TABLE `car_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `car_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_companies`
--

DROP TABLE IF EXISTS `car_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_companies`
--

LOCK TABLES `car_companies` WRITE;
/*!40000 ALTER TABLE `car_companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `car_companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emp_list`
--

DROP TABLE IF EXISTS `emp_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emp_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empno` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `biz_unit` varchar(200) DEFAULT NULL,
  `manager` int(11) DEFAULT NULL,
  `cname` varchar(100) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `ou` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `left_on` date DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `passport_no` varchar(255) DEFAULT NULL,
  `passport_expiry_date` date DEFAULT NULL,
  `visa_no` varchar(255) DEFAULT NULL,
  `visa_expiry_date` date DEFAULT NULL,
  `visa_country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empno` (`empno`),
  UNIQUE KEY `empno_2` (`empno`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=620 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emp_list`
--

LOCK TABLES `emp_list` WRITE;
/*!40000 ALTER TABLE `emp_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `emp_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel_bookings`
--

DROP TABLE IF EXISTS `hotel_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `booked_by` int(11) DEFAULT NULL,
  `status` enum('confirmed','not confirmed') DEFAULT NULL,
  `approved` enum('y','n') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel_bookings`
--

LOCK TABLES `hotel_bookings` WRITE;
/*!40000 ALTER TABLE `hotel_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `hotel_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotels`
--

DROP TABLE IF EXISTS `hotels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0',
  `phone` varchar(20) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `fax` varchar(10) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotels`
--

LOCK TABLES `hotels` WRITE;
/*!40000 ALTER TABLE `hotels` DISABLE KEYS */;
/*!40000 ALTER TABLE `hotels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `status` enum('pending','advance') DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `booking_type` enum('train','airline','hotel','car') DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `train_bookings`
--

DROP TABLE IF EXISTS `train_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `train_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `travel_options` tinyint(4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `train_from` varchar(255) DEFAULT NULL,
  `train_to` varchar(255) DEFAULT NULL,
  `class_of_booking` enum('FirstClass','Second Class','AC','Non-AC','Slipper') DEFAULT NULL,
  `train_id` int(11) DEFAULT NULL,
  `booking_details` varchar(255) DEFAULT NULL,
  `approved` enum('y','n') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `train_bookings`
--

LOCK TABLES `train_bookings` WRITE;
/*!40000 ALTER TABLE `train_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `train_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trains`
--

DROP TABLE IF EXISTS `trains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `city_from` varchar(255) DEFAULT NULL,
  `city_to` varchar(255) DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trains`
--

LOCK TABLES `trains` WRITE;
/*!40000 ALTER TABLE `trains` DISABLE KEYS */;
/*!40000 ALTER TABLE `trains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trip_bookings`
--

DROP TABLE IF EXISTS `trip_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trip_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) DEFAULT NULL,
  `booking_type` enum('train','car','airlines','hotel') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trip_bookings`
--

LOCK TABLES `trip_bookings` WRITE;
/*!40000 ALTER TABLE `trip_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `trip_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trips`
--

LOCK TABLES `trips` WRITE;
/*!40000 ALTER TABLE `trips` DISABLE KEYS */;
/*!40000 ALTER TABLE `trips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-30 13:15:32

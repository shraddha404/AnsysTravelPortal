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
  `travel_from` int(11) DEFAULT NULL,
  `travel_to` int(11) DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `travel_time` varchar(255) DEFAULT NULL,
  `meal_preference` varchar(255) DEFAULT NULL,
  `visa_requirement` tinyint(4) DEFAULT '0',
  `ticket_refundable` tinyint(4) DEFAULT '0',
  `approved` enum('y','n') DEFAULT NULL,
  `trip_id` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airlines`
--

LOCK TABLES `airlines` WRITE;
/*!40000 ALTER TABLE `airlines` DISABLE KEYS */;
INSERT INTO `airlines` VALUES (1,'Jet Airways','D'),(2,'IndiGo','D'),(3,'Air India','D'),(4,'SpiceJet','D'),(5,'GoAir','D'),(6,'Vistara Airlines','D'),(7,'JetLite','D'),(8,'Zexus Air','D'),(9,'Air India Express','D');
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
  `trip_id` int(11) DEFAULT NULL,
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
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(100) NOT NULL,
  `city_state` varchar(100) NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1624 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Kolhapur','Maharashtra'),(2,'Port Blair','Andaman & Nicobar Islands'),(3,'Adilabad','Andhra Pradesh'),(4,'Adoni','Andhra Pradesh'),(5,'Amadalavalasa','Andhra Pradesh'),(6,'Amalapuram','Andhra Pradesh'),(7,'Anakapalle','Andhra Pradesh'),(8,'Anantapur','Andhra Pradesh'),(9,'Badepalle','Andhra Pradesh'),(10,'Banganapalle','Andhra Pradesh'),(11,'Bapatla','Andhra Pradesh'),(12,'Bellampalle','Andhra Pradesh'),(13,'Bethamcherla','Andhra Pradesh'),(14,'Bhadrachalam','Andhra Pradesh'),(15,'Bhainsa','Andhra Pradesh'),(16,'Bheemunipatnam','Andhra Pradesh'),(17,'Bhimavaram','Andhra Pradesh'),(18,'Bhongir','Andhra Pradesh'),(19,'Bobbili','Andhra Pradesh'),(20,'Bodhan','Andhra Pradesh'),(21,'Chilakaluripet','Andhra Pradesh'),(22,'Chirala','Andhra Pradesh'),(23,'Chittoor','Andhra Pradesh'),(24,'Cuddapah','Andhra Pradesh'),(25,'Devarakonda','Andhra Pradesh'),(26,'Dharmavaram','Andhra Pradesh'),(27,'Eluru','Andhra Pradesh'),(28,'Farooqnagar','Andhra Pradesh'),(29,'Gadwal','Andhra Pradesh'),(30,'Gooty','Andhra Pradesh'),(31,'Gudivada','Andhra Pradesh'),(32,'Gudur','Andhra Pradesh'),(33,'Guntakal','Andhra Pradesh'),(34,'Guntur','Andhra Pradesh'),(35,'Hanuman Junction','Andhra Pradesh'),(36,'Hindupur','Andhra Pradesh'),(37,'Hyderabad','Andhra Pradesh'),(38,'Ichchapuram','Andhra Pradesh'),(39,'Jaggaiahpet','Andhra Pradesh'),(40,'Jagtial','Andhra Pradesh'),(41,'Jammalamadugu','Andhra Pradesh'),(42,'Jangaon','Andhra Pradesh'),(43,'Kadapa','Andhra Pradesh'),(44,'Kadiri','Andhra Pradesh'),(45,'Kagaznagar','Andhra Pradesh'),(46,'Kakinada','Andhra Pradesh'),(47,'Kalyandurg','Andhra Pradesh'),(48,'Kamareddy','Andhra Pradesh'),(49,'Kandukur','Andhra Pradesh'),(50,'Karimnagar','Andhra Pradesh'),(51,'Kavali','Andhra Pradesh'),(52,'Khammam','Andhra Pradesh'),(53,'Koratla','Andhra Pradesh'),(54,'Kothagudem','Andhra Pradesh'),(55,'Kothapeta','Andhra Pradesh'),(56,'Kovvur','Andhra Pradesh'),(57,'Kurnool','Andhra Pradesh'),(58,'Kyathampalle','Andhra Pradesh'),(59,'Macherla','Andhra Pradesh'),(60,'Machilipatnam','Andhra Pradesh'),(61,'Madanapalle','Andhra Pradesh'),(62,'Mahbubnagar','Andhra Pradesh'),(63,'Mancherial','Andhra Pradesh'),(64,'Mandamarri','Andhra Pradesh'),(65,'Mandapeta','Andhra Pradesh'),(66,'Manuguru','Andhra Pradesh'),(67,'Markapur','Andhra Pradesh'),(68,'Medak','Andhra Pradesh'),(69,'Miryalaguda','Andhra Pradesh'),(70,'Mogalthur','Andhra Pradesh'),(71,'Nagari','Andhra Pradesh'),(72,'Nagarkurnool','Andhra Pradesh'),(73,'Nandyal','Andhra Pradesh'),(74,'Narasapur','Andhra Pradesh'),(75,'Narasaraopet','Andhra Pradesh'),(76,'Narayanpet','Andhra Pradesh'),(77,'Narsipatnam','Andhra Pradesh'),(78,'Nellore','Andhra Pradesh'),(79,'Nidadavole','Andhra Pradesh'),(80,'Nirmal','Andhra Pradesh'),(81,'Nizamabad','Andhra Pradesh'),(82,'Nuzvid','Andhra Pradesh'),(83,'Ongole','Andhra Pradesh'),(84,'Palacole','Andhra Pradesh'),(85,'Palasa Kasibugga','Andhra Pradesh'),(86,'Palwancha','Andhra Pradesh'),(87,'Parvathipuram','Andhra Pradesh'),(88,'Pedana','Andhra Pradesh'),(89,'Peddapuram','Andhra Pradesh'),(90,'Pithapuram','Andhra Pradesh'),(91,'Pondur','Andhra pradesh'),(92,'Ponnur','Andhra Pradesh'),(93,'Proddatur','Andhra Pradesh'),(94,'Punganur','Andhra Pradesh'),(95,'Puttur','Andhra Pradesh'),(96,'Rajahmundry','Andhra Pradesh'),(97,'Rajam','Andhra Pradesh'),(98,'Ramachandrapuram','Andhra Pradesh'),(99,'Ramagundam','Andhra Pradesh'),(100,'Rayachoti','Andhra Pradesh'),(101,'Rayadurg','Andhra Pradesh'),(102,'Renigunta','Andhra Pradesh'),(103,'Repalle','Andhra Pradesh'),(104,'Sadasivpet','Andhra Pradesh'),(105,'Salur','Andhra Pradesh'),(106,'Samalkot','Andhra Pradesh'),(107,'Sangareddy','Andhra Pradesh'),(108,'Sattenapalle','Andhra Pradesh'),(109,'Siddipet','Andhra Pradesh'),(110,'Singapur','Andhra Pradesh'),(111,'Sircilla','Andhra Pradesh'),(112,'Srikakulam','Andhra Pradesh'),(113,'Srikalahasti','Andhra Pradesh'),(115,'Suryapet','Andhra Pradesh'),(116,'Tadepalligudem','Andhra Pradesh'),(117,'Tadpatri','Andhra Pradesh'),(118,'Tandur','Andhra Pradesh'),(119,'Tanuku','Andhra Pradesh'),(120,'Tenali','Andhra Pradesh'),(121,'Tirupati','Andhra Pradesh'),(122,'Tuni','Andhra Pradesh'),(123,'Uravakonda','Andhra Pradesh'),(124,'Venkatagiri','Andhra Pradesh'),(125,'Vicarabad','Andhra Pradesh'),(126,'Vijayawada','Andhra Pradesh'),(127,'Vinukonda','Andhra Pradesh'),(128,'Visakhapatnam','Andhra Pradesh'),(129,'Vizianagaram','Andhra Pradesh'),(130,'Wanaparthy','Andhra Pradesh'),(131,'Warangal','Andhra Pradesh'),(132,'Yellandu','Andhra Pradesh'),(133,'Yemmiganur','Andhra Pradesh'),(134,'Yerraguntla','Andhra Pradesh'),(135,'Zahirabad','Andhra Pradesh');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
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
  `location` varchar(255) DEFAULT NULL,
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
  `user_type` int(11) NOT NULL,
  `passport_copy` text,
  `visa_document` text,
  `address` text,
  `contact_no` varchar(25) DEFAULT NULL,
  `alt_contact_no` varchar(25) DEFAULT NULL,
  `emergency_no` varchar(25) DEFAULT NULL,
  `dob` date DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `empno` (`empno`),
  UNIQUE KEY `empno_2` (`empno`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=621 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emp_list`
--

LOCK TABLES `emp_list` WRITE;
/*!40000 ALTER TABLE `emp_list` DISABLE KEYS */;
INSERT INTO `emp_list` VALUES (620,NULL,'skk','',NULL,'',1,'1b73ee474e2be61e323d78b46a2fa043','',NULL,NULL,'','','','','0000-00-00','','0000-00-00','AF',0,NULL,NULL,' ','','','','0000-00-00');
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
  `trip_id` int(11) DEFAULT NULL,
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
  `city` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0',
  `phone` varchar(20) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `fax` varchar(10) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotels`
--

LOCK TABLES `hotels` WRITE;
/*!40000 ALTER TABLE `hotels` DISABLE KEYS */;
INSERT INTO `hotels` VALUES (1,'Gandharv',45,1,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Millinium',23,2,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Green Park',12,3,NULL,NULL,NULL,NULL,NULL,NULL),(4,'Blue Star',56,2,NULL,NULL,NULL,NULL,NULL,NULL),(5,'Hotel Golden',24,2,NULL,NULL,NULL,NULL,NULL,NULL),(6,'Royal Orchid Central',67,3,NULL,NULL,NULL,NULL,NULL,NULL),(7,'Godrej',67,2,NULL,NULL,NULL,NULL,NULL,NULL),(8,'The E-Square Hotel',78,3,NULL,NULL,NULL,NULL,NULL,NULL),(9,'The Pride Hotel',89,1,NULL,NULL,NULL,NULL,NULL,NULL),(10,'Hyatt',90,1,NULL,NULL,NULL,NULL,NULL,NULL),(11,'Double Tree By Hilton',987,4,NULL,NULL,NULL,NULL,NULL,NULL),(12,'Conrad',456,2,NULL,NULL,NULL,NULL,NULL,NULL);
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
  `trip_id` int(11) DEFAULT NULL,
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
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `purpose_of_visit` text NOT NULL,
  `special_mention` text NOT NULL,
  `trip_type` enum('Oneway','Round trip','Multi city') NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (3,'Admin'),(4,'Employee'),(2,'Manager'),(1,'Travel Desk');
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

-- Dump completed on 2017-04-06 14:50:03

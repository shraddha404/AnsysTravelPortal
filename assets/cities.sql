-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 16, 2018 at 10:23 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ansys_travel_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--
DROP TABLE `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(100) NOT NULL,
  `city_state` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1650 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `city_state`) VALUES
(2, 'Port Blair', 'Andaman & Nicobar Islands'),
(37, 'Hyderabad', 'Andhra Pradesh'),
(121, 'Tirupati', 'Andhra Pradesh'),
(126, 'Vijayawada', 'Andhra Pradesh'),
(128, 'Visakhapatnam', 'Andhra Pradesh'),
(154, 'Dispur', 'Assam'),
(159, 'Guwahati', 'Assam'),
(187, 'Aurangabad', 'Bihar'),
(294, 'Bilaspur', 'Chhattisgarh'),
(315, 'Raigarh', 'Chhattisgarh'),
(316, 'Raipur', 'Chhattisgarh'),
(321, 'Silvassa', 'Dadra & Nagar Haveli'),
(322, 'Daman and Diu', 'Daman & Diu'),
(325, 'Delhi', 'Delhi'),
(328, 'Madgaon', 'Goa'),
(330, 'Margao', 'Goa'),
(331, 'Marmagao', 'Goa'),
(332, 'Panaji', 'Goa'),
(333, 'Ahmedabad', 'Gujarat'),
(335, 'Anand', 'Gujarat'),
(345, 'Gandhinagar', 'Gujarat'),
(349, 'Jamnagar', 'Gujarat'),
(385, 'Rajkot', 'Gujarat'),
(408, 'Vapi', 'Gujarat'),
(441, 'Faridabad', 'Haryana'),
(446, 'Gurgaon', 'Haryana'),
(483, 'Bilaspur', 'Himachal Pradesh'),
(486, 'Dharamsala', 'Himachal Pradesh'),
(511, 'Bokaro Steel City', 'Jharkhand'),
(520, 'Dhanbad', 'Jharkhand'),
(531, 'Jamshedpur', 'Jharkhand'),
(543, 'Ranchi', 'Jharkhand'),
(560, 'Hubli', 'Karnataka'),
(583, 'Mysore', 'Karnataka'),
(653, 'Kochi', 'Kerala'),
(659, 'Kozhikode', 'Kerala'),
(696, 'Bhopal', 'Madhya Pradesh'),
(705, 'Indore', 'Madhya Pradesh'),
(707, 'Jabalpur', 'Madhya Pradesh'),
(743, 'Pithampur', 'Madhya Pradesh'),
(783, 'Ahmednagar', 'Maharashtra'),
(786, 'Aurangabad', 'Maharashtra'),
(793, 'Durgapur', 'Maharashtra'),
(796, 'Kalyan', 'Maharashtra'),
(800, 'Lonavla', 'Maharashtra'),
(817, 'Mumbai', 'Maharashtra'),
(819, 'Nagpur', 'Maharashtra'),
(826, 'Nashik', 'Maharashtra'),
(827, 'Navi Mumbai', 'Maharashtra'),
(837, 'Panvel', 'Maharashtra'),
(849, 'Pune', 'Maharashtra'),
(966, 'Bhubaneswar', 'Orissa'),
(995, 'Puri', 'Orissa'),
(998, 'Raurkela', 'Orissa'),
(1009, 'Pondicherry', 'Pondicherry'),
(1012, 'Amritsar', 'Punjab'),
(1088, 'Jaipur', 'Rajasthan'),
(1089, 'Jaisalmer', 'Rajasthan'),
(1090, 'Jodhpur', 'Rajasthan'),
(1091, 'Kota', 'Rajasthan'),
(1172, 'Chennai', 'Tamil Nadu'),
(1174, 'Coimbatore', 'Tamil Nadu'),
(1175, 'Coonoor', 'Tamil Nadu'),
(1189, 'Madurai', 'Tamil Nadu'),
(1301, 'Udaipur', 'Tripura'),
(1304, 'Agra', 'Uttar Pradesh'),
(1306, 'Allahabad', 'Uttar Pradesh'),
(1321, 'Greater Noida', 'Uttar Pradesh'),
(1329, 'Kota', 'Uttar Pradesh'),
(1337, 'Lucknow', 'Uttar Pradesh'),
(1351, 'NOIDA', 'Uttar Pradesh'),
(1448, 'Roorkee', 'Uttarakhand'),
(1469, 'Durgapur', 'West Bengal'),
(1471, 'Howrah', 'West Bengal'),
(1475, 'Kolkata', 'West Bengal'),
(1649, 'Munich ', ''),
(1648, 'Istanbul', ''),
(1647, 'Turin', ''),
(1646, 'Warsaw', ''),
(1645, 'Taipei', ''),
(1644, 'Bangkok', ''),
(1643, 'Saudi Arebia', ''),
(1642, 'Dubai', ''),
(1641, 'Italy ', ''),
(1640, 'Paris', ''),
(1639, 'Germany', ''),
(1638, 'Canada', ''),
(1637, 'Pittsburgh', ''),
(1636, 'San Francisco ', ''),
(1624, 'Canonsburg', 'PA'),
(1625, 'Lebanon', 'NH'),
(1626, 'Evanston', ' IL'),
(1627, 'Ann Arbor', 'MI'),
(1628, 'Irvine', 'CA'),
(1629, 'Newport Beach', 'CA'),
(1630, 'Milpitas', 'CA'),
(1631, 'San Jose', 'CA'),
(1632, 'Concord', 'MA'),
(1633, 'Tokyo', ''),
(1634, 'Seoul', ''),
(1635, 'Shanghai', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

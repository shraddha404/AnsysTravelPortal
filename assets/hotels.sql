-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 16, 2018 at 10:24 AM
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
-- Table structure for table `hotels`
--
DROP TABLE `hotels`;
CREATE TABLE IF NOT EXISTS `hotels` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `hotel_name`, `city`, `type`, `phone`, `website`, `fax`, `email`, `address`, `check_out_time`) VALUES
(1, 'Star', 849, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Gandharv', 849, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Millinium', 23, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Green Park', 849, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Blue Star', 417, 2, '326589789', NULL, NULL, 'bluestar@gmail.com', 'M.G.Road Adalaj', NULL),
(6, 'Hotel Golden', 24, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Royal Orchid Central', 67, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Godrej', 67, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'The E-Square Hotel', 78, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'The Pride Hotel', 849, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Hyatt', 849, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Double Tree By Hilton', 849, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Conrad', 849, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'JW Marriott Hotel', 849, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Hyatt Hotel', 849, 0, NULL, NULL, NULL, '', 'Hinjewadi', NULL),
(16, 'Courtyard Marriott', 849, 0, '', NULL, NULL, '', 'Hinjewadi', NULL),
(17, 'Lemontree Hotel', 849, 0, '', NULL, NULL, '', 'Hinjewadi', NULL),
(18, 'Taj Gateway hotel', 849, 0, '', NULL, NULL, '', 'Hinjewadi', NULL),
(19, 'Tamanna Hotel', 849, 0, '', NULL, NULL, '', 'Hinjewadi', NULL),
(20, 'The Westin Pune ', 849, 0, NULL, NULL, NULL, NULL, 'Koregaon Park ', NULL),
(21, 'St. Lauren Suits', 849, 0, NULL, NULL, NULL, NULL, 'Koregaon Park ', NULL),
(22, 'Fortune hotel', 849, 0, NULL, NULL, NULL, NULL, 'Koregaon Park ', NULL),
(23, 'The O Hotel', 849, 0, NULL, NULL, NULL, NULL, 'Koregaon Park ', NULL),
(24, 'Davanam Sarovar Portico Suits ', 549, 0, '', NULL, NULL, '', '', NULL),
(25, 'Blue Petal ', 549, 0, '', NULL, NULL, '', '', NULL),
(26, 'Fortune Select JP Cosmos ', 549, 0, '', NULL, NULL, '', 'Crescent Road ', NULL),
(27, 'My Fortune', 549, 0, '', NULL, NULL, '', 'Richmond Road', NULL),
(28, 'Fortune Select Trinity', 549, 0, '', NULL, NULL, '', 'Whitefield', NULL),
(29, 'ITC Gardenia', 549, 0, '', NULL, NULL, '', '', NULL),
(30, 'ITC Windsor ', 549, 0, '', NULL, NULL, '', '', NULL),
(31, 'Le Meridian ', 549, 0, '', NULL, NULL, '', '', NULL),
(32, 'Lemon Tree Premier', 549, 0, '', NULL, NULL, '', 'Ulsoor', NULL),
(33, 'lemon tree', 549, 0, '', NULL, NULL, '', 'whitefield', NULL),
(34, 'Lemon Tree hotel', 549, 0, '', NULL, NULL, '', 'Electronic City ', NULL),
(35, 'Royal Orchid Resort & Convention Centre', 549, 0, '', NULL, NULL, '', 'Near Airport', NULL),
(36, 'Royal Orchid KGA', 549, 0, '', NULL, NULL, '', 'Golf Course road ', NULL),
(37, 'Novotel Bengaluru', 549, 0, '', NULL, NULL, '', 'Techpark', NULL),
(38, 'Park Plaza', 549, 0, '', NULL, NULL, '', 'Marathahalli', NULL),
(39, 'Manthara Magic', 549, 0, '', NULL, NULL, '', '', NULL),
(40, 'ISIS Suits ', 549, 0, '', NULL, NULL, '', '', NULL),
(42, 'Holiday Inn', 325, 0, '', NULL, NULL, '', 'New Delhi Mayur Vihar ', NULL),
(43, 'Savoy Suits', 325, 0, '', NULL, NULL, '', 'Noida', NULL),
(44, 'Park Plaza', 325, 0, '', NULL, NULL, '', 'Noida', NULL),
(45, 'Lemon Tree Premier', 325, 0, '', NULL, NULL, '', 'Delhi Airport', NULL),
(46, 'Lemon Tree Premier', 325, 0, '', NULL, NULL, '', 'Kaushambi', NULL),
(47, 'Radisson Blu Kaushambi', 325, 0, '', NULL, NULL, '', '', NULL),
(48, 'Fortune Inn Grazia', 325, 0, '', NULL, NULL, '', '', NULL),
(49, 'Fortune Inn Grazia', 325, 0, '', NULL, NULL, '', 'Ghaziabad', NULL),
(50, 'Red Fox Hotel', 325, 0, '', NULL, NULL, '', 'East Delhi', NULL),
(51, 'The Park', 325, 0, '', NULL, NULL, '', 'Parliament Street New Delhi', NULL),
(52, 'The Lalit', 325, 0, '', NULL, NULL, '', 'Connaught Place', NULL),
(53, 'The Park', 37, 0, '', NULL, NULL, '', 'Hyderabad', NULL),
(54, 'Lemon Tree Premier', 37, 0, '', NULL, NULL, '', 'HITEC City', NULL),
(55, 'Daspalla ', 37, 0, '', NULL, NULL, '', 'Hyderabad', NULL),
(56, 'Fortune Park Vallabha', 37, 0, '', NULL, NULL, '', '', NULL),
(57, 'Green Park ', 37, 0, '', NULL, NULL, '', '', NULL),
(58, 'Hotel Hyatt Gachibowli', 37, 0, '', NULL, NULL, '', '', NULL),
(59, 'NOVOTEL Hyderabad Airport', 37, 0, '', NULL, NULL, '', '', NULL),
(60, 'Courtyard Marriott', 817, 0, '', NULL, NULL, '', 'Mumbai Airport ', NULL),
(61, 'Kohinoor Continental ', 37, 0, '', NULL, NULL, '', 'Andheri Kurla Road', NULL),
(62, 'Kohinoor Elite', 37, 0, '', NULL, NULL, '', ' Kurla (West)', NULL),
(63, 'ITC Maratha', 37, 0, '', NULL, NULL, '', '', NULL),
(64, 'Rennaissance Powai ', 37, 0, '', NULL, NULL, '', '', NULL),
(65, 'ITC Sonar ', 1475, 0, '', NULL, NULL, '', '', NULL),
(66, 'Zone by The Park Kolkata ', 1475, 0, '', NULL, NULL, '', '', NULL),
(67, 'ETHNOTEL', 1475, 0, '', NULL, NULL, '', 'Near Kolkata International Airport', NULL),
(68, 'Monotel', 1475, 0, '', NULL, NULL, '', '', NULL),
(69, 'Zone By The Park  ', 1172, 0, '', NULL, NULL, '', '', NULL),
(70, 'My Fortune Chennai ', 1172, 0, '', NULL, NULL, '', '', NULL),
(71, 'Lemon Tree Hotel', 1172, 0, '', NULL, NULL, '', 'Shimona', NULL),
(72, 'Lemon Tree Hotel', 1172, 0, '', NULL, NULL, '', 'Guindy', NULL),
(73, 'Taj Club House ', 1506, 0, '', NULL, NULL, '', '', NULL),
(74, 'Hablis Hotels ', 1172, 0, '', NULL, NULL, '', '', NULL),
(75, 'Courtyard Marriott', 1172, 0, '', NULL, NULL, '', '', NULL),
(76, 'Sheraton Park Hotel And Towers', 1172, 0, '', NULL, NULL, '', '', NULL),
(77, 'Zone By The Park', 1507, 0, '', NULL, NULL, '', '', NULL),
(78, 'Aloft Coimbatore', 1507, 0, '', NULL, NULL, '', '', NULL),
(79, 'Fortune Park', 333, 0, '', NULL, NULL, '', '', NULL),
(80, 'Fortune Landmark', 333, 0, '', NULL, NULL, '', '', NULL),
(81, 'Comfort Inn Sunset', 333, 0, '', NULL, NULL, '', 'Airport circle ', NULL),
(82, 'Pride Plaza Hotel', 333, 0, '', NULL, NULL, '', '', NULL),
(83, 'Four Points by Sheraton', 333, 0, '', NULL, NULL, '', '', NULL),
(84, 'Royal Orchid Ahmedabad ', 333, 0, '', NULL, NULL, '', '', NULL),
(85, 'Sarovar Portico', 333, 0, '', NULL, NULL, '', '', NULL),
(86, 'Lemon Tree Hotel ', 333, 0, '', NULL, NULL, '', '', NULL),
(87, 'The Gateway Hotel Ummed ', 333, 0, '', NULL, NULL, '', '', NULL),
(88, 'Courtyard by Marriott ', 333, 0, '', NULL, NULL, '', '', NULL),
(89, 'Sayaji Hotels ', 705, 0, '', NULL, NULL, '', '', NULL),
(90, 'Fortune hotels ', 705, 0, '', NULL, NULL, '', '', NULL),
(91, 'Royal Orchid Central', 406, 0, '', NULL, NULL, '', '', NULL),
(92, 'Sayaji hotel Vadodra ', 406, 0, '', NULL, NULL, '', '', NULL),
(93, 'lemon tree', 1018, 0, '', NULL, NULL, '', '', NULL),
(94, 'The Alcor', 531, 0, '', NULL, NULL, '', '', NULL),
(95, 'Classic Sarovar Portico Trivendrum', 685, 0, '', NULL, NULL, '', '', NULL),
(96, 'ITC Fortune South Park, Trivendrum', 685, 0, '', NULL, NULL, '', '', NULL),
(97, 'Fortune Hotel The South Park', 685, 0, '', NULL, NULL, '', '', NULL),
(98, 'Hotel Daspalla Trivendrum', 685, 0, '', NULL, NULL, '', '', NULL),
(99, ' Homewood Suites by Hilton Pittsburgh-Southpointe', 1624, 0, '', NULL, NULL, '', '', NULL),
(100, ' Hilton Garden Inn Pittsburgh/Southpointe', 1624, 0, '', NULL, NULL, '', '', NULL),
(101, 'Holiday Inn Express', 1624, 0, '', NULL, NULL, '', '', NULL),
(102, 'Courtyard Marriott', 1625, 0, '', NULL, NULL, '', '', NULL),
(103, 'Residence Inn by Marriott', 1625, 0, '', NULL, NULL, '', '', NULL),
(104, 'Element by Westin', 1625, 0, '', NULL, NULL, '', '', NULL),
(105, 'Hilton Garden Inn Chicago North Shore/Evanston', 1626, 0, '', NULL, NULL, '', '', NULL),
(106, 'Hilton Orrington/Evanston', 1626, 0, '', NULL, NULL, '', '', NULL),
(107, 'The Homestead', 1626, 0, '', NULL, NULL, '', '', NULL),
(108, 'Residence Inn Ann Arbor', 1627, 0, '', NULL, NULL, '', '', NULL),
(109, 'Fairfield InnFairfield Inn Ann Arbor', 1627, 0, '', NULL, NULL, '', '', NULL),
(110, 'Hilton Irvine/Orange County Airport', 1628, 0, '', NULL, NULL, '', '', NULL),
(111, 'Fairmont Newport Beach', 1629, 0, '', NULL, NULL, '', '', NULL),
(112, 'Larkspur Landing Milpitas', 1630, 0, '', NULL, NULL, '', '', NULL),
(113, 'Residence Inn San Jose Airport', 1631, 0, '', NULL, NULL, '', '', NULL),
(114, 'Springhill Suites by Marriott', 1631, 0, '', NULL, NULL, '', '', NULL),
(115, 'Best Western at Historic Concord', 1632, 0, '', NULL, NULL, '', '', NULL),
(116, 'Colonial Inn Bed & Breakfast', 1632, 0, '', NULL, NULL, '', '', NULL),
(117, 'Keio Plaza', 1633, 0, '', NULL, NULL, '', '', NULL),
(118, 'Shinjuku Washington Hotel', 1633, 0, '', NULL, NULL, '', '', NULL),
(119, 'Hyatt Regency ', 1633, 0, '', NULL, NULL, '', '', NULL),
(120, 'Hilton ', 1633, 0, '', NULL, NULL, '', '', NULL),
(121, 'Hotel Peyto Samseong', 1634, 0, '', NULL, NULL, '', '', NULL),
(122, 'Grand Intercontinental Seoul Parnas', 1634, 0, '', NULL, NULL, '', '', NULL),
(123, 'Intercontinental Seoul COEX', 1634, 0, '', NULL, NULL, '', '', NULL),
(124, 'IBIS', 1634, 0, '', NULL, NULL, '', '', NULL),
(125, 'Park Hotel Shanghai', 1635, 0, '', NULL, NULL, '', '', NULL),
(126, 'JW Marriott Hotel Shanghai at Tomorrow Square', 1635, 0, '', NULL, NULL, '', '', NULL),
(127, 'Other', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

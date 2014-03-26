-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2012 at 08:44 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cdarin5_bom`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `PN` char(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `uom` varchar(5) NOT NULL,
  `rev` varchar(2) NOT NULL,
  `lifecycle` varchar(10) NOT NULL,
  PRIMARY KEY (`PN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` VALUES('A', 'AAAANUS', 'BUY', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('C', 'CEEZ ON MY KNEES!', 'B', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('D', 'BIG DS', 'ROUTABLE', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('DAVE', 'DAVES FAVORITE PART', 'BUY', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('B', 'BLAH', 'BUY', 'EA', '1', 'PRODUCTION');
INSERT INTO `item` VALUES('02-2223', 'HELLO FRIENDS', 'routable', 'ea', '', 'PRODUCTION');
INSERT INTO `item` VALUES('04-1234', 'little chiuauauas', 'routable', 'OZ', '', 'RD');
INSERT INTO `item` VALUES('05-2342', 'DOS PUPPIES', 'routable', 'KG', '', 'RD');
INSERT INTO `item` VALUES('11-1111', 'UNOS PEPITOS', 'routable', 'KG', '', 'RD');
INSERT INTO `item` VALUES('02-1235', 'POOP', 'buy', 'EA', '', 'PRODUCTION');
INSERT INTO `item` VALUES('02-1445', 'TESTINH', 'buy', 'EA', '', 'PRODUCTION');
INSERT INTO `item` VALUES('at-moms', 'DUDE!', 'buy', 'EA', '', 'PRODUCTION');
INSERT INTO `item` VALUES('02-1555', 'TESTINH', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('76-999999-22', 'MAN, SECRET DOCS', 'phantom', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('76-999999-23', 'MAN, SECRET DOCS', 'phantom', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('76-999999-24', 'MAN, SECRET DOCS', 'phantom', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('75-999999-24', 'MAN, SECRET DOCS', 'phantom', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('02-123453-00', 'HI DUDE!', 'buy', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('02-123453-01', 'HI DUDE!', 'buy', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('02-123453-10', 'HI DUDE!', 'buy', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('02-123453-11', 'HI DUDE!', 'buy', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-222222-00', 'WEINERS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('23-343443-23', 'PEE PEE PANTS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-12', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-13', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-14', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-15', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-16', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-17', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-18', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-19', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-21', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-22', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-23', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-24', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-25', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-26', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-27', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-28', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-29', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-30', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-31', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-32', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-33', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-34', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-35', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-36', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-37', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-38', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-39', 'POO OPP LOINS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('22-222222-22', 'NO', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('22-222222-23', 'NO', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('22-222222-24', 'NO', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-122323-12', 'SDA', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-14', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-15', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-16', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-17', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-18', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-19', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-01', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-02', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-03', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-04', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-05', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('99-123123-06', 'STUFF  & ALL THAT', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-33', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-34', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-35', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-36', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-37', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-38', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-39', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-40', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-41', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-42', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-44', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-46', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-47', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-48', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-49', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-50', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-51', 'K', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-52', 'KJRLWQKEJRLKQWJEQJEQWL;ERJQLWJ', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-53', 'KJRLW KEJRLKQWJEQJEQWL;ERJQLWJ', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-54', 'KJRLW KEJRLKQW EQJEQWL;ERJQLWJ', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-211111-55', 'KJRLW KEJRLKQW EQJEQWL;ERJQLWJ', 'buy', 'OZ', '1', 'RD');
INSERT INTO `item` VALUES('11-211111-57', 'A ', 'buy', 'OZ', '1', 'RD');
INSERT INTO `item` VALUES('11-211111-58', 'A ', 'buy', 'OZ', '1', 'RD');
INSERT INTO `item` VALUES('23-233223-25', 'HELLLO FRIENDS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('23-233223-26', 'HELLLO FRIENDS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('23-233223-27', 'HELLLO FRIENDS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('23-233223-28', 'HELLLO FRIENDS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('23-233223-29', 'HELLLO FRIENDS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('23-233223-30', 'HELLLO FRIENDS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('12-121212-99', 'HI', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-111111-00', 'DFS', 'routable', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('11-111119-99', 'BIG PART', 'buy', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('11-111111-11', 'B0NERS540', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('02-322332-23', 'LKAJSDF', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('E', 'EEEZ ON MY KNEES', 'BUY', 'EA', '5', 'PRODUCTION');
INSERT INTO `item` VALUES('33-333333-33', 'DAVE LOVES BANANAS', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-444444-44', 'NO DONT BE BROKEN!', 'buy', 'EA', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('33-333333-34', 'MATT DAMON', 'buy', 'FT', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('22-222222-25', 'SFA', 'phantom', 'CM', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('22-121222-11', 'DELETE ME SOME FILES', 'buy', 'FT', '1', 'RD');
INSERT INTO `item` VALUES('22-121222-12', 'DELETE ME SOME FILES', 'buy', 'FT', '1', 'RD');
INSERT INTO `item` VALUES('22-121222-13', 'DELETE ME SOME FILES', 'buy', 'FT', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-55', 'TEST', 'routable', 'FT', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-56', 'WHOA ARE YOU DELETING THIS', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-57', 'MAMAWAMA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-58', 'AW IM NOT THE WORST PROGRAMMER', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-59', 'AW IM NOT THE WORST PROGRAMMER', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-60', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-61', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-62', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-63', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-64', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-65', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-66', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-67', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-68', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-69', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-70', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-71', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-72', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-73', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-74', 'WAWAWEEWA', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('55-555555-75', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-76', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-77', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-78', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-79', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-80', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-81', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-82', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-83', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-84', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-85', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-86', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-87', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-88', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-89', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-90', 'JUST TESTIN', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-91', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-92', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-94', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-95', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-96', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-97', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-98', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-99', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-11', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-12', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-13', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-14', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-15', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('55-555555-16', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-16', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-17', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-18', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-19', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-20', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-21', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-22', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-23', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-24', 'COME ON', 'routable', 'IN', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('44-555555-25', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-26', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-27', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-28', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-29', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-30', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-31', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-32', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-33', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-34', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-35', 'COME ON', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-36', 'SLAWEIO', 'routable', 'IN', '23', 'RD');
INSERT INTO `item` VALUES('44-555555-37', 'SLAWEIO', 'routable', 'IN', '23', 'RD');
INSERT INTO `item` VALUES('44-555555-38', 'SLAWEIO', 'routable', 'IN', '23', 'RD');
INSERT INTO `item` VALUES('44-555555-39', 'SLAWEIO', 'routable', 'IN', '23', 'RD');
INSERT INTO `item` VALUES('44-555555-40', 'SLAWEIO', 'routable', 'IN', '23', 'RD');
INSERT INTO `item` VALUES('44-555555-41', 'SLAWEIO', 'routable', 'IN', '23', 'RD');
INSERT INTO `item` VALUES('44-555555-42', 'SLAWEIO', 'routable', 'IN', '23', 'RD');
INSERT INTO `item` VALUES('44-555555-43', 'SLAWEIO', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-44', 'STOREME', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-45', 'STOREME', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-47', 'SORE THIS NOW', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-50', 'GET REAL', 'routable', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-51', 'GET REAL', 'routable', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-52', 'GET REAL', 'routable', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-53', 'GET REAL', 'routable', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-54', 'GET REAL', 'routable', 'EA', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-55', 'SORE THIS NOW', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-56', 'SORE THIS NOW', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-57', 'SORE THIS NOW', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-58', 'SORE THIS NOW', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-59', 'SORE THIS NOW', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-60', 'COME ON BABY GRRL', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-61', 'HERE IT IS', 'routable', 'M', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-62', 'HERE IT IS 2WICE', 'routable', 'M', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-63', 'PLEASE JUST WORK', 'buy', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('44-555555-64', 'PLEASE JUST WORK', 'buy', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('32-425045-24', 'SCRAMBLED EGGS ALL OVER MY FAC', 'routable', 'G', 'A', 'PRODUCTION');
INSERT INTO `item` VALUES('22-112112-00', 'INAPPROPRIATE', 'routable', 'IN', '1', 'RD');
INSERT INTO `item` VALUES('22-112112-01', 'INAPPROPRIATE', 'routable', 'IN', '1', 'RD');

-- --------------------------------------------------------

--
-- Table structure for table `parentchild`
--

CREATE TABLE `parentchild` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `parent` char(12) NOT NULL,
  `child` char(12) NOT NULL,
  `itemnum` int(3) NOT NULL,
  `qty` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `parentchild`
--

INSERT INTO `parentchild` VALUES(1, 'A', 'B', 1, 3);
INSERT INTO `parentchild` VALUES(2, 'D', 'E', 1, 1);
INSERT INTO `parentchild` VALUES(3, 'A', 'D', 2, 5);
INSERT INTO `parentchild` VALUES(4, 'A', '11-222222-00', 3, 3);
INSERT INTO `parentchild` VALUES(10, 'A', '33-333333-33', 4, 0);
INSERT INTO `parentchild` VALUES(6, 'E', 'B', 2, 0);
INSERT INTO `parentchild` VALUES(7, 'D', 'B', 2, 0);
INSERT INTO `parentchild` VALUES(12, 'A', '55-555555-90', 6, 0);
INSERT INTO `parentchild` VALUES(9, 'B', '33-333333-33', 2, 0);
INSERT INTO `parentchild` VALUES(11, 'A', '33-333333-34', 5, 0);

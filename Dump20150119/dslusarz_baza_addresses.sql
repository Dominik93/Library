CREATE DATABASE  IF NOT EXISTS `dslusarz_baza` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `dslusarz_baza`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: dslusarz_baza
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_street_id` int(11) DEFAULT NULL,
  `address_post_code_id` int(11) DEFAULT NULL,
  `address_nr_house_id` int(11) DEFAULT NULL,
  `address_country_id` int(11) DEFAULT NULL,
  `address_city_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `fk_addresses_country_idx` (`address_country_id`),
  KEY `fk_addresses_city_idx` (`address_city_id`),
  KEY `fk_addresses_street_idx` (`address_street_id`),
  KEY `fk_addresses_post_code_idx` (`address_post_code_id`),
  KEY `fk_addresses_house_number_idx` (`address_nr_house_id`),
  CONSTRAINT `fk_addresses_city` FOREIGN KEY (`address_city_id`) REFERENCES `cities` (`city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_addresses_country` FOREIGN KEY (`address_country_id`) REFERENCES `countries` (`country_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_addresses_house_number` FOREIGN KEY (`address_nr_house_id`) REFERENCES `house_numbers` (`house_number_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_addresses_post_code` FOREIGN KEY (`address_post_code_id`) REFERENCES `post_codes` (`post_code_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_addresses_street` FOREIGN KEY (`address_street_id`) REFERENCES `streets` (`street_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,1,1,1,1,5),(2,4,4,4,1,2),(7,9,9,9,3,10);
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-19 21:54:21

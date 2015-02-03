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
-- Table structure for table `logs_readers`
--

DROP TABLE IF EXISTS `logs_readers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs_readers` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_reader_id` int(11) DEFAULT NULL,
  `log_reader_login` tinytext COLLATE utf8_bin,
  `log_reader_email` tinytext COLLATE utf8_bin,
  `log_reader_name` tinytext COLLATE utf8_bin,
  `log_reader_surname` tinytext COLLATE utf8_bin,
  `log_reader_active_account` date DEFAULT NULL,
  `log_reader_address_id` int(11) DEFAULT NULL,
  `log_reader_acces_right_id` int(11) DEFAULT NULL,
  `log_reader_action` tinytext COLLATE utf8_bin,
  `log_reader_who` int(11) DEFAULT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs_readers`
--

LOCK TABLES `logs_readers` WRITE;
/*!40000 ALTER TABLE `logs_readers` DISABLE KEYS */;
INSERT INTO `logs_readers` VALUES (27,2,'reader1','reader1@reader.pl','imie reader1','nazwisko reader1','2016-01-09',0,2,'Update',0,'2015-01-11 20:45:45'),(28,2,'reader1','reader1@reader.pl','aktywny','nazwisko reader1','2016-01-09',0,2,'Update',0,'2015-01-11 20:47:50'),(29,1,'reader','reader@reader.pl','nieaktywny','nazwisko','2015-12-13',0,2,'Update',0,'2015-01-12 12:34:18'),(30,1,'reader','reader@reader.pl','nieaktywny','nazwisko','2015-12-13',0,3,'Update',0,'2015-01-12 12:34:32'),(31,1,'reader','reader@reader.pl','nieaktywny','nazwisko','2014-12-13',0,3,'Update',0,'2015-01-12 13:33:30'),(32,2,'reader1','reader1@reader.pl','aktywny','nazwisko reader1','2016-01-09',0,2,'Update',0,'2015-01-12 13:33:42'),(33,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2014-12-13',0,3,'Update',0,'2015-01-12 23:00:00'),(34,4,'reader3','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',0,2,'Update',0,'2015-01-12 23:00:00'),(35,4,'reader3','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',0,3,'Update',0,'2015-01-13 14:56:16'),(36,4,'reader2','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',0,3,'Update',0,'2015-01-13 14:56:25'),(37,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2014-12-13',0,3,'Update',0,'2015-01-13 23:00:00'),(38,4,'reader3','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',0,3,'Update',0,'2015-01-13 23:00:00'),(39,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2014-12-13',0,3,'Update',0,'2015-01-14 23:00:00'),(40,4,'reader3','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',0,3,'Update',0,'2015-01-14 23:00:00'),(41,2,'reader1','reader1@reader.pl','aktywny','czytelnik','2016-01-09',0,2,'Update',0,'2015-01-15 22:07:40'),(42,2,'reader1','reader1@reader.pl','aktywny','czytelnik','2016-01-09',0,2,'Update',0,'2015-01-15 22:09:20'),(43,2,'reader1','reader1@reader.pl','aktywny','czytelnik','2016-01-09',0,2,'Update',0,'2015-01-15 22:12:20'),(44,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2014-12-13',0,3,'Update',0,'2015-01-15 23:00:00'),(45,4,'reader3','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',0,3,'Update',0,'2015-01-15 23:00:00'),(46,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2014-12-13',0,3,'Update',NULL,'2015-01-17 14:03:38'),(47,2,'reader1','reader1@reader.pl','aktywny','czytelnik','2016-01-09',0,2,'Update',NULL,'2015-01-17 14:03:46'),(48,4,'reader3','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',0,3,'Update',NULL,'2015-01-17 14:03:46'),(49,5,'reader9','reader9@reader.pl','imie reader9','nazwisko reader9','2016-01-17',0,2,'Update',NULL,'2015-01-17 14:03:46'),(50,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2014-12-13',1,3,'Update',NULL,'2015-01-17 14:22:24'),(51,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2014-12-13',1,2,'Update',NULL,'2015-01-17 14:22:24'),(55,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2016-01-17',1,2,'Update',NULL,'2015-01-17 15:33:34'),(56,1,'reader','reader@reader.pl','nieaktywny','czytelnik','2016-01-17',1,2,'Update',NULL,'2015-01-17 15:33:49'),(57,1,'reader','reader@reader.pl','aktywny','czytelnik','2016-01-17',1,2,'Update',NULL,'2015-01-17 15:38:00'),(58,1,'reader','reader@reader.pl','aktywny','czytelnik','2016-01-17',1,2,'Update',NULL,'2015-01-17 15:39:25'),(59,5,'reader9','reader9@reader.pl','imie reader9','nazwisko reader9','2016-01-17',1,2,'Update',NULL,'2015-01-17 19:10:15'),(60,4,'reader3','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',2,3,'Update',NULL,'2015-01-17 23:00:00'),(63,4,'reader3','reader3@reader.pl','nieaktywny','czytelnik','2015-01-12',2,3,'Update',NULL,'2015-01-18 23:00:00');
/*!40000 ALTER TABLE `logs_readers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-19 21:54:48

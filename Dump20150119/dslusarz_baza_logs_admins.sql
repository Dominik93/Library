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
-- Table structure for table `logs_admins`
--

DROP TABLE IF EXISTS `logs_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs_admins` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_admin_id` int(11) DEFAULT NULL,
  `log_admin_login` tinytext COLLATE utf8_bin,
  `log_admin_email` tinytext COLLATE utf8_bin,
  `log_admin_name` tinytext COLLATE utf8_bin,
  `log_admin_surname` tinytext COLLATE utf8_bin,
  `log_admin_action` tinytext COLLATE utf8_bin,
  `log_afmin_who` int(11) DEFAULT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs_admins`
--

LOCK TABLES `logs_admins` WRITE;
/*!40000 ALTER TABLE `logs_admins` DISABLE KEYS */;
INSERT INTO `logs_admins` VALUES (31,5,'nazwisko admin3','nowy admin','admin3','admin3@admin.pl','Update',0,'2015-01-12 13:38:41'),(32,5,'administrator','admin3','nazwisko admin3','admin3@admin.pl','Update',0,'2015-01-12 13:40:08'),(33,5,'admin1','admin3@admin.pl','imie admin3','administrator','Update',0,'2015-01-12 13:40:26'),(34,6,'admin3','admin3@admin.pl','imie admin3','nazwisko admin3','Update',NULL,'2015-01-17 19:06:42'),(35,6,'admin3','admin3@admin.pl','imie admin3','nazwisko admin3','Update',NULL,'2015-01-17 19:07:15');
/*!40000 ALTER TABLE `logs_admins` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-19 21:54:53

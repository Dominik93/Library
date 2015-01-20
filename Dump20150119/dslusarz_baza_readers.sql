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
-- Table structure for table `readers`
--

DROP TABLE IF EXISTS `readers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `readers` (
  `reader_id` int(11) NOT NULL AUTO_INCREMENT,
  `reader_login` tinytext COLLATE utf8_bin,
  `reader_email` tinytext COLLATE utf8_bin,
  `reader_password` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `reader_name` tinytext COLLATE utf8_bin,
  `reader_surname` tinytext COLLATE utf8_bin,
  `reader_active_account` date DEFAULT NULL,
  `reader_address_id` int(11) DEFAULT NULL,
  `reader_acces_right_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`reader_id`),
  KEY `fk_readers_acces_right` (`reader_acces_right_id`),
  CONSTRAINT `fk_readers_acces_rights` FOREIGN KEY (`reader_acces_right_id`) REFERENCES `acces_rights` (`acces_right_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `readers`
--

LOCK TABLES `readers` WRITE;
/*!40000 ALTER TABLE `readers` DISABLE KEYS */;
INSERT INTO `readers` VALUES (1,'reader','reader@reader.pl','e84a93d2c2b0930ab16a6bb07bdf527333bb6284','aktywny','czytelnik','2016-01-17',1,2),(2,'reader1','reader1@reader.pl','13ea88ac8e6b1e53a46a1121cd9c5c819d24e1f4','aktywny','czytelnik','2016-01-09',1,2),(4,'reader3','reader3@reader.pl','0f3c60c85d50c04dc56293520c48e1f7d529a033','nieaktywny','czytelnik','2015-01-12',2,3),(5,'jnowak','jnowak@pai.pl','3816eebe72e079900aa8faf88134eb45950a121b','Jacek','Nowak','2016-01-17',1,2),(6,'login','login@login.pl','8a47a0e73ebdbe285acc8c778ee6946de0efa0a8','login','login','2016-01-18',7,2);
/*!40000 ALTER TABLE `readers` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dslusarz`@`%`*/ /*!50003 TRIGGER `dslusarz_baza`.`readers_BEFORE_UPDATE` BEFORE UPDATE ON `readers` FOR EACH ROW
begin
INSERT INTO `dslusarz_baza`.`logs_readers`
(`log_reader_id`,
`log_reader_login`,
`log_reader_email`,
`log_reader_name`,
`log_reader_surname`,
`log_reader_active_account`,
`log_reader_address_id`,
`log_reader_acces_right_id`,
`log_reader_action`,
`log_date`)
VALUES
(OLD.reader_id, OLD.reader_login, OLD.reader_email,
OLD.reader_name, OLD.reader_surname, OLD.reader_active_account, OLD.reader_address_id,
OLD.reader_acces_right_id, "Update", now());

end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dslusarz`@`%`*/ /*!50003 TRIGGER `dslusarz_baza`.`readers_BEFORE_DELETE` BEFORE DELETE ON `readers` FOR EACH ROW
    begin
INSERT INTO `dslusarz_baza`.`logs_readers`
(`log_reader_id`,
`log_reader_login`,
`log_reader_email`,
`log_reader_name`,
`log_reader_surname`,
`log_reader_active_account`,
`log_reader_address_id`,
`log_reader_acces_right_id`,
`log_reader_action`,
`log_date`)
VALUES
(OLD.reader_id, OLD.reader_login, OLD.reader_email,
OLD.reader_name, OLD.reader_surname, OLD.reader_active_account, OLD.reader_address_id,
OLD.reader_acces_right_id, "Update", now());

end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-19 21:54:25

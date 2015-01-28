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
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_isbn` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `book_original_title` tinytext COLLATE utf8_bin,
  `book_title` tinytext COLLATE utf8_bin,
  `book_original_publisher_house_id` int(11) DEFAULT NULL,
  `book_publisher_house_id` int(11) DEFAULT NULL,
  `book_nr_page` smallint(6) DEFAULT NULL,
  `book_edition` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `book_premiere` year(4) DEFAULT NULL,
  `book_number` int(11) DEFAULT NULL,
  `book_cover` tinytext COLLATE utf8_bin,
  PRIMARY KEY (`book_id`),
  KEY `fk_books_publisher_houses_idx` (`book_publisher_house_id`),
  CONSTRAINT `fk_books_publisher_houses` FOREIGN KEY (`book_publisher_house_id`) REFERENCES `publisher_houses` (`publisher_house_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (6,'978-83-7574-280-0','Ostří oceli','Krawędź Żelaza Tom II',6,1,421,'II',2011,10,'Miękka'),(7,'978-83-247-2033-0','The First Rule','Pierwsza Zasada',3,2,258,'I',2008,1,'Miękka'),(8,'978-83-247-0746-1','Schlank im schlaf','Chudnij podczas snu',5,2,189,'I',2008,5,'Twarda'),(9,'978-83-89595-44-7','Ani słowa prawdy','Ani słowa prawdy',4,4,608,'II',2008,2,'Miękka'),(20,'978-83-7574-003-5','Вампир поневоле','Wampir z przypadku',13,1,288,'I',2009,8,'Miękka'),(33,'978-83-7885-896-6','Nightmares and dreamscapes','Marzenia i Koszmary',24,25,751,'XI',2014,23,'Miękka');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-19 21:54:34

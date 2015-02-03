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
-- Temporary table structure for view `view_books`
--

DROP TABLE IF EXISTS `view_books`;
/*!50001 DROP VIEW IF EXISTS `view_books`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_books` (
  `book_id` tinyint NOT NULL,
  `book_isbn` tinyint NOT NULL,
  `book_original_title` tinyint NOT NULL,
  `book_title` tinyint NOT NULL,
  `book_nr_page` tinyint NOT NULL,
  `book_edition` tinyint NOT NULL,
  `book_premiere` tinyint NOT NULL,
  `book_number` tinyint NOT NULL,
  `book_cover` tinyint NOT NULL,
  `publisher_house_name` tinyint NOT NULL,
  `publisher_house_country` tinyint NOT NULL,
  `original_publisher_house_name` tinyint NOT NULL,
  `original_publisher_house_country` tinyint NOT NULL,
  `free_books` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_readers`
--

DROP TABLE IF EXISTS `view_readers`;
/*!50001 DROP VIEW IF EXISTS `view_readers`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_readers` (
  `reader_id` tinyint NOT NULL,
  `reader_login` tinyint NOT NULL,
  `reader_email` tinyint NOT NULL,
  `reader_password` tinyint NOT NULL,
  `reader_name` tinyint NOT NULL,
  `reader_surname` tinyint NOT NULL,
  `reader_active_account` tinyint NOT NULL,
  `acces_right_name` tinyint NOT NULL,
  `country_name` tinyint NOT NULL,
  `city_name` tinyint NOT NULL,
  `post_code_name` tinyint NOT NULL,
  `street_name` tinyint NOT NULL,
  `house_number_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_addresses`
--

DROP TABLE IF EXISTS `view_addresses`;
/*!50001 DROP VIEW IF EXISTS `view_addresses`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_addresses` (
  `address_id` tinyint NOT NULL,
  `country_name` tinyint NOT NULL,
  `post_code_name` tinyint NOT NULL,
  `city_name` tinyint NOT NULL,
  `street_name` tinyint NOT NULL,
  `house_number_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_publisher_houses`
--

DROP TABLE IF EXISTS `view_publisher_houses`;
/*!50001 DROP VIEW IF EXISTS `view_publisher_houses`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_publisher_houses` (
  `publisher_house_id` tinyint NOT NULL,
  `publisher_house_name` tinyint NOT NULL,
  `country_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_borrows`
--

DROP TABLE IF EXISTS `view_borrows`;
/*!50001 DROP VIEW IF EXISTS `view_borrows`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_borrows` (
  `borrow_id` tinyint NOT NULL,
  `borrow_book_id` tinyint NOT NULL,
  `borrow_reader_id` tinyint NOT NULL,
  `borrow_date_borrow` tinyint NOT NULL,
  `borrow_return` tinyint NOT NULL,
  `borrow_received` tinyint NOT NULL,
  `borrow_delay` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_books`
--

/*!50001 DROP TABLE IF EXISTS `view_books`*/;
/*!50001 DROP VIEW IF EXISTS `view_books`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dslusarz`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_books` AS select `books`.`book_id` AS `book_id`,`books`.`book_isbn` AS `book_isbn`,`books`.`book_original_title` AS `book_original_title`,`books`.`book_title` AS `book_title`,`books`.`book_nr_page` AS `book_nr_page`,`books`.`book_edition` AS `book_edition`,`books`.`book_premiere` AS `book_premiere`,`books`.`book_number` AS `book_number`,`books`.`book_cover` AS `book_cover`,`publisher`.`publisher_house_name` AS `publisher_house_name`,`country`.`country_name` AS `publisher_house_country`,`origin_publisher`.`publisher_house_name` AS `original_publisher_house_name`,`oryginal_country`.`country_name` AS `original_publisher_house_country`,(`books`.`book_number` - (select count(0) from `borrows` where (`borrows`.`borrow_book_id` = `books`.`book_id`) group by `borrows`.`borrow_book_id`)) AS `free_books` from ((((`books` join `publisher_houses` `publisher` on((`publisher`.`publisher_house_id` = `books`.`book_publisher_house_id`))) join `countries` `country` on((`publisher`.`publisher_house_country_id` = `country`.`country_id`))) join `publisher_houses` `origin_publisher` on((`origin_publisher`.`publisher_house_id` = `books`.`book_original_publisher_house_id`))) join `countries` `oryginal_country` on((`origin_publisher`.`publisher_house_country_id` = `oryginal_country`.`country_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_readers`
--

/*!50001 DROP TABLE IF EXISTS `view_readers`*/;
/*!50001 DROP VIEW IF EXISTS `view_readers`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dslusarz`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_readers` AS select `readers`.`reader_id` AS `reader_id`,`readers`.`reader_login` AS `reader_login`,`readers`.`reader_email` AS `reader_email`,`readers`.`reader_password` AS `reader_password`,`readers`.`reader_name` AS `reader_name`,`readers`.`reader_surname` AS `reader_surname`,`readers`.`reader_active_account` AS `reader_active_account`,`acces_rights`.`acces_right_name` AS `acces_right_name`,`countries`.`country_name` AS `country_name`,`cities`.`city_name` AS `city_name`,`post_codes`.`post_code_name` AS `post_code_name`,`streets`.`street_name` AS `street_name`,`house_numbers`.`house_number_name` AS `house_number_name` from (((((((`readers` join `addresses` on((`addresses`.`address_id` = `readers`.`reader_address_id`))) join `countries` on((`countries`.`country_id` = `addresses`.`address_country_id`))) join `post_codes` on((`post_codes`.`post_code_id` = `addresses`.`address_post_code_id`))) join `cities` on((`cities`.`city_id` = `addresses`.`address_city_id`))) join `streets` on((`streets`.`street_id` = `addresses`.`address_street_id`))) join `house_numbers` on((`house_numbers`.`house_number_id` = `addresses`.`address_nr_house_id`))) join `acces_rights` on((`acces_rights`.`acces_right_id` = `readers`.`reader_acces_right_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_addresses`
--

/*!50001 DROP TABLE IF EXISTS `view_addresses`*/;
/*!50001 DROP VIEW IF EXISTS `view_addresses`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dslusarz`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_addresses` AS select `addresses`.`address_id` AS `address_id`,`countries`.`country_name` AS `country_name`,`post_codes`.`post_code_name` AS `post_code_name`,`cities`.`city_name` AS `city_name`,`streets`.`street_name` AS `street_name`,`house_numbers`.`house_number_name` AS `house_number_name` from (((((`addresses` join `countries` on((`countries`.`country_id` = `addresses`.`address_country_id`))) join `post_codes` on((`post_codes`.`post_code_id` = `addresses`.`address_post_code_id`))) join `cities` on((`cities`.`city_id` = `addresses`.`address_city_id`))) join `streets` on((`streets`.`street_id` = `addresses`.`address_street_id`))) join `house_numbers` on((`house_numbers`.`house_number_id` = `addresses`.`address_nr_house_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_publisher_houses`
--

/*!50001 DROP TABLE IF EXISTS `view_publisher_houses`*/;
/*!50001 DROP VIEW IF EXISTS `view_publisher_houses`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dslusarz`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_publisher_houses` AS (select `publisher_houses`.`publisher_house_id` AS `publisher_house_id`,`publisher_houses`.`publisher_house_name` AS `publisher_house_name`,`countries`.`country_name` AS `country_name` from (`publisher_houses` join `countries` on((`countries`.`country_id` = `publisher_houses`.`publisher_house_country_id`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_borrows`
--

/*!50001 DROP TABLE IF EXISTS `view_borrows`*/;
/*!50001 DROP VIEW IF EXISTS `view_borrows`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dslusarz`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_borrows` AS select `borrows`.`borrow_id` AS `borrow_id`,`borrows`.`borrow_book_id` AS `borrow_book_id`,`borrows`.`borrow_reader_id` AS `borrow_reader_id`,`borrows`.`borrow_date_borrow` AS `borrow_date_borrow`,`borrows`.`borrow_return` AS `borrow_return`,`borrows`.`borrow_received` AS `borrow_received`,(to_days(now()) - to_days(`borrows`.`borrow_return`)) AS `borrow_delay` from `borrows` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-19 21:55:14

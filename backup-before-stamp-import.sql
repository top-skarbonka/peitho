/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: peitho
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_point_logs`
--

DROP TABLE IF EXISTS `client_point_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_point_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned NOT NULL,
  `points` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_point_logs`
--

LOCK TABLES `client_point_logs` WRITE;
/*!40000 ALTER TABLE `client_point_logs` DISABLE KEYS */;
INSERT INTO `client_point_logs` VALUES
(1,1,36,100,1000,'2026-03-09 20:10:29'),
(2,4,38,10,100,'2026-03-09 21:27:53'),
(3,1,38,12,120,'2026-03-09 22:08:04'),
(4,5,38,10,100,'2026-03-09 22:08:28'),
(5,5,38,10,100,'2026-03-09 22:18:39'),
(6,6,38,10,100,'2026-03-09 22:39:41'),
(7,1,38,10,100,'2026-03-09 22:44:05'),
(8,1,38,5,50,'2026-03-09 22:53:09'),
(9,1,38,20,200,'2026-03-09 23:04:52'),
(10,1,38,10,100,'2026-03-09 23:07:28'),
(11,1,38,15,150,'2026-03-09 23:19:54'),
(12,1,38,10,100,'2026-03-09 23:22:13'),
(13,1,38,20,200,'2026-03-09 23:43:33'),
(14,1,38,10,100,'2026-03-10 09:08:18'),
(15,1,38,2,20,'2026-03-10 09:18:15'),
(16,1,38,10,100,'2026-03-10 09:37:02'),
(17,1,38,30,300,'2026-03-10 09:47:34'),
(18,1,38,30,300,'2026-03-10 11:22:57'),
(19,1,39,10,100,'2026-03-24 15:07:09'),
(20,5,39,10,100,'2026-03-24 15:07:55'),
(21,1,39,50,500,'2026-03-24 15:30:57'),
(22,1,40,500,500,'2026-03-24 20:37:06'),
(23,1,40,1000,1000,'2026-03-24 20:53:19'),
(24,1,40,100,100,'2026-03-25 08:26:54'),
(25,1,40,500,500,'2026-03-25 08:27:23'),
(26,1,40,300,300,'2026-03-25 08:41:27'),
(27,1,40,1000,1000,'2026-03-25 08:47:09'),
(28,1,40,100,100,'2026-03-25 09:54:28'),
(29,1,40,-600,0,'2026-03-25 10:14:21'),
(30,1,40,-200,0,'2026-03-25 15:31:47'),
(31,1,40,-1000,0,'2026-03-25 15:32:06'),
(32,1,40,-1000,0,'2026-03-25 15:32:20'),
(33,1,40,-200,0,'2026-03-25 15:36:49'),
(34,5,40,1000,1000,'2026-03-25 16:11:08'),
(35,1,40,-200,0,'2026-03-25 17:25:31'),
(37,5,41,100,100,'2026-03-26 18:18:05'),
(44,5,41,400,400,'2026-03-26 19:34:14'),
(45,5,42,20,200,'2026-03-26 19:53:30'),
(46,5,42,100,200,'2026-03-26 20:07:44'),
(47,11,42,250,500,'2026-03-26 20:08:17'),
(48,5,42,250,500,'2026-03-26 20:09:05'),
(49,1,43,100,100,'2026-03-27 07:59:24'),
(50,1,43,400,400,'2026-03-27 08:01:01'),
(51,1,43,-500,0,'2026-03-27 08:01:11'),
(52,12,43,100,100,'2026-03-27 11:07:25'),
(53,12,43,200,200,'2026-03-27 11:10:02'),
(54,12,43,-200,0,'2026-03-27 11:17:21'),
(55,12,43,5,5,'2026-03-27 11:22:43'),
(56,13,43,166,166,'2026-03-27 11:44:57'),
(57,18,43,85,85,'2026-03-28 09:06:02'),
(58,19,43,208,209,'2026-03-28 09:13:05'),
(59,20,43,277,278,'2026-03-28 09:20:23'),
(60,21,43,268,268,'2026-03-28 09:24:48'),
(61,22,43,110,110,'2026-03-28 09:28:20'),
(62,16,43,179,179,'2026-03-28 09:31:51'),
(63,23,43,80,80,'2026-03-28 09:35:28'),
(64,23,43,35,35,'2026-03-28 09:36:28'),
(65,25,43,441,441,'2026-03-28 09:39:39'),
(66,19,43,182,182,'2026-03-28 09:41:40'),
(67,26,43,75,75,'2026-03-28 09:44:23'),
(68,24,43,109,109,'2026-03-28 09:47:37'),
(69,24,43,12,12,'2026-03-28 09:48:06'),
(70,27,43,335,335,'2026-03-28 09:56:37'),
(71,28,43,143,143,'2026-03-28 10:10:41'),
(72,29,43,152,152,'2026-03-28 10:12:56'),
(73,30,43,68,68,'2026-03-28 10:16:42'),
(74,31,43,318,318,'2026-03-28 10:26:17'),
(75,32,43,183,183,'2026-03-28 10:31:45'),
(76,33,43,64,64,'2026-03-28 10:36:51'),
(77,34,43,20,20,'2026-03-28 10:55:08'),
(78,35,43,62,62,'2026-03-28 11:00:25'),
(79,1,43,202,202,'2026-03-28 11:02:38'),
(80,37,43,52,52,'2026-03-28 11:05:42'),
(81,37,43,28,28,'2026-03-28 11:11:52'),
(82,40,43,20,21,'2026-03-28 11:16:17'),
(83,41,43,75,75,'2026-03-28 11:25:49'),
(84,42,43,60,60,'2026-03-28 11:38:36'),
(85,39,43,139,139,'2026-03-28 11:44:30'),
(86,38,43,77,77,'2026-03-28 11:48:15'),
(87,43,43,68,68,'2026-03-28 12:04:37'),
(88,44,43,21,21,'2026-03-28 12:06:22'),
(89,45,43,67,67,'2026-03-28 12:17:55'),
(90,46,43,66,66,'2026-03-28 12:20:53'),
(91,47,43,100,100,'2026-03-28 12:33:08'),
(92,48,43,42,42,'2026-03-28 12:46:13'),
(93,49,43,78,78,'2026-03-28 12:53:35'),
(94,50,43,34,34,'2026-03-28 13:07:24'),
(95,51,43,576,576,'2026-03-28 13:13:03'),
(96,52,43,271,271,'2026-03-28 13:23:02'),
(97,53,43,187,187,'2026-03-28 13:44:04'),
(98,54,43,25,25,'2026-03-28 14:25:03'),
(99,56,43,77,77,'2026-03-28 15:43:44'),
(100,57,43,39,39,'2026-03-28 15:44:57'),
(101,58,43,58,58,'2026-03-28 16:38:35'),
(102,58,43,5,6,'2026-03-28 16:40:38'),
(103,59,43,16,16,'2026-03-28 16:41:50'),
(105,1,41,200,200,'2026-03-28 18:26:16');
/*!40000 ALTER TABLE `client_point_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_points`
--

DROP TABLE IF EXISTS `client_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_points` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_points`
--

LOCK TABLES `client_points` WRITE;
/*!40000 ALTER TABLE `client_points` DISABLE KEYS */;
INSERT INTO `client_points` VALUES
(1,1,36,100,NULL,'2026-03-09 20:10:29'),
(2,4,38,10,NULL,'2026-03-09 21:27:53'),
(5,5,38,10,NULL,'2026-03-09 22:18:39'),
(6,6,38,10,NULL,'2026-03-09 22:39:41'),
(13,1,38,102,NULL,'2026-03-10 11:22:57'),
(14,1,39,60,NULL,'2026-03-24 15:30:57'),
(15,5,39,10,NULL,'2026-03-24 15:07:55'),
(16,1,40,300,NULL,'2026-03-25 17:25:31'),
(17,5,40,1000,'2026-03-25 16:11:08','2026-03-25 16:11:08'),
(19,5,41,500,'2026-03-26 18:18:05','2026-03-26 19:34:14'),
(23,5,42,370,'2026-03-26 19:53:30','2026-03-26 20:09:05'),
(24,11,42,250,'2026-03-26 20:08:17','2026-03-26 20:08:17'),
(25,1,43,202,'2026-03-27 07:59:24','2026-03-28 11:02:38'),
(26,12,43,105,'2026-03-27 11:07:25','2026-03-27 11:22:43'),
(27,13,43,166,'2026-03-27 11:44:57','2026-03-27 11:44:57'),
(28,18,43,85,'2026-03-28 09:06:02','2026-03-28 09:06:02'),
(29,19,43,390,'2026-03-28 09:13:05','2026-03-28 09:41:40'),
(30,20,43,277,'2026-03-28 09:20:23','2026-03-28 09:20:23'),
(31,21,43,268,'2026-03-28 09:24:48','2026-03-28 09:24:48'),
(32,22,43,110,'2026-03-28 09:28:20','2026-03-28 09:28:20'),
(33,16,43,179,'2026-03-28 09:31:51','2026-03-28 09:31:51'),
(34,23,43,115,'2026-03-28 09:35:28','2026-03-28 09:36:28'),
(35,25,43,441,'2026-03-28 09:39:39','2026-03-28 09:39:39'),
(36,26,43,75,'2026-03-28 09:44:23','2026-03-28 09:44:23'),
(37,24,43,121,'2026-03-28 09:47:37','2026-03-28 09:48:06'),
(38,27,43,335,'2026-03-28 09:56:37','2026-03-28 09:56:37'),
(39,28,43,143,'2026-03-28 10:10:41','2026-03-28 10:10:41'),
(40,29,43,152,'2026-03-28 10:12:56','2026-03-28 10:12:56'),
(41,30,43,68,'2026-03-28 10:16:42','2026-03-28 10:16:42'),
(42,31,43,318,'2026-03-28 10:26:17','2026-03-28 10:26:17'),
(43,32,43,183,'2026-03-28 10:31:45','2026-03-28 10:31:45'),
(44,33,43,64,'2026-03-28 10:36:51','2026-03-28 10:36:51'),
(45,34,43,20,'2026-03-28 10:55:08','2026-03-28 10:55:08'),
(46,35,43,62,'2026-03-28 11:00:25','2026-03-28 11:00:25'),
(47,37,43,80,'2026-03-28 11:05:42','2026-03-28 11:11:52'),
(48,40,43,20,'2026-03-28 11:16:17','2026-03-28 11:16:17'),
(49,41,43,75,'2026-03-28 11:25:49','2026-03-28 11:25:49'),
(50,42,43,60,'2026-03-28 11:38:36','2026-03-28 11:38:36'),
(51,39,43,139,'2026-03-28 11:44:30','2026-03-28 11:44:30'),
(52,38,43,77,'2026-03-28 11:48:15','2026-03-28 11:48:15'),
(53,43,43,68,'2026-03-28 12:04:37','2026-03-28 12:04:37'),
(54,44,43,21,'2026-03-28 12:06:22','2026-03-28 12:06:22'),
(55,45,43,67,'2026-03-28 12:17:55','2026-03-28 12:17:55'),
(56,46,43,66,'2026-03-28 12:20:53','2026-03-28 12:20:53'),
(57,47,43,100,'2026-03-28 12:33:08','2026-03-28 12:33:08'),
(58,48,43,42,'2026-03-28 12:46:13','2026-03-28 12:46:13'),
(59,49,43,78,'2026-03-28 12:53:35','2026-03-28 12:53:35'),
(60,50,43,34,'2026-03-28 13:07:24','2026-03-28 13:07:24'),
(61,51,43,576,'2026-03-28 13:13:03','2026-03-28 13:13:03'),
(62,52,43,271,'2026-03-28 13:23:02','2026-03-28 13:23:02'),
(63,53,43,187,'2026-03-28 13:44:04','2026-03-28 13:44:04'),
(64,54,43,25,'2026-03-28 14:25:03','2026-03-28 14:25:03'),
(65,56,43,77,'2026-03-28 15:43:44','2026-03-28 15:43:44'),
(66,57,43,39,'2026-03-28 15:44:57','2026-03-28 15:44:57'),
(67,58,43,63,'2026-03-28 16:38:35','2026-03-28 16:40:38'),
(68,59,43,16,'2026-03-28 16:41:50','2026-03-28 16:41:50'),
(70,1,41,200,'2026-03-28 18:26:16','2026-03-28 18:26:16');
/*!40000 ALTER TABLE `client_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_registration_tokens`
--

DROP TABLE IF EXISTS `client_registration_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_registration_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_registration_tokens_token_unique` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_registration_tokens`
--

LOCK TABLES `client_registration_tokens` WRITE;
/*!40000 ALTER TABLE `client_registration_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_registration_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned DEFAULT NULL,
  `program_id` bigint(20) unsigned NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `sms_marketing_consent` tinyint(1) NOT NULL DEFAULT 0,
  `sms_marketing_consent_at` timestamp NULL DEFAULT NULL,
  `sms_marketing_withdrawn_at` timestamp NULL DEFAULT NULL COMMENT 'Data i godzina cofnięcia zgody marketingowej (RODO)',
  `terms_accepted_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `password_set` tinyint(1) NOT NULL DEFAULT 0,
  `activation_token` varchar(64) DEFAULT NULL,
  `activation_token_expires_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_activation_token_unique` (`activation_token`),
  UNIQUE KEY `clients_firm_phone_unique` (`firm_id`,`phone`),
  KEY `clients_program_id_foreign` (`program_id`),
  KEY `clients_password_set_index` (`password_set`),
  KEY `clients_activation_token_expires_at_index` (`activation_token_expires_at`),
  KEY `clients_firm_id_index` (`firm_id`),
  KEY `clients_last_activity_at_index` (`last_activity_at`),
  CONSTRAINT `clients_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES
(1,NULL,1,NULL,NULL,'732287103',NULL,NULL,0,NULL,NULL,NULL,'2026-03-09 13:46:56',0,'2026-03-01 15:02:10','2026-03-24 22:03:00','$2y$12$fc.8CogoNaoctkhqOMp1WORUV.QezzZ5ptlwd4Y4xSIqtKcBv5NbG',NULL,1,'dB0ZVyipsuOhVBbZkqXA3j2qjhfD7UBTt86U7LO6qRQg5NbN','2026-03-04 16:16:48'),
(3,22,1,NULL,'DAMIANO','732287105',NULL,'dominika-bielen-5815',1,'2026-03-06 08:46:16',NULL,'2026-03-06 08:46:16',NULL,0,'2026-03-06 08:46:17','2026-03-06 08:46:17','$2y$12$VkNtVxbCUZcEw15wp1Ta../8DJNNo/lqeOLo9Zrx8YzvuxyhbaZua',NULL,0,NULL,NULL),
(4,NULL,1,NULL,NULL,'100200300',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-09 21:27:53','2026-03-09 21:27:53',NULL,NULL,0,NULL,NULL),
(5,NULL,1,NULL,NULL,'799838830',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-09 22:08:28','2026-03-24 15:19:34','$2y$12$ZPSLTS1VX233PP.N/O4fH.JlgHrWyk4ajXYocyB/6yyn4jgePB0XS',NULL,0,NULL,NULL),
(6,NULL,1,NULL,NULL,'200345876',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-09 22:39:41','2026-03-09 22:39:41',NULL,NULL,0,NULL,NULL),
(7,39,1,NULL,'dominika','799838839',NULL,NULL,0,NULL,NULL,'2026-03-24 15:09:38',NULL,0,'2026-03-24 15:09:39','2026-03-24 15:09:39','$2y$12$RCRYQPYnskP2hEA3SX0IMujzF3OI7FsT1MHVDmkTyXmlEYIFY8pai',NULL,0,NULL,NULL),
(10,42,1,NULL,'Dominika','798838830',NULL,NULL,0,NULL,NULL,'2026-03-26 19:54:15',NULL,0,'2026-03-26 19:54:15','2026-03-26 19:54:15','$2y$12$h3Mbo3Z81xMJfguyH5tJUu5YOmLy7VBgbKR2vU7UQmx.lz.vZrssC',NULL,0,NULL,NULL),
(11,42,1,NULL,NULL,'799038830',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-26 20:08:17','2026-03-26 20:08:17',NULL,NULL,0,NULL,NULL),
(12,43,1,NULL,NULL,'668406981',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-27 11:07:25','2026-03-27 11:08:55','$2y$12$xYFm8IzS9.cj23uigt2zduUr23/TteGbgsxlCAuizbQWCtEAOUiJW',NULL,0,NULL,NULL),
(13,43,1,NULL,'Piotr','725297330',NULL,NULL,1,'2026-03-27 11:43:29',NULL,'2026-03-27 11:43:29',NULL,0,'2026-03-27 11:43:29','2026-03-27 11:43:29','$2y$12$LnctMzgQU3ygctAPpGWZkutjhEPAOQ1OMeTa8H8HFZLImu/BC4HhG',NULL,0,NULL,NULL),
(14,43,1,NULL,'Justyna','665476822',NULL,'39-432',1,'2026-03-27 13:23:00',NULL,'2026-03-27 13:23:00',NULL,0,'2026-03-27 13:23:01','2026-03-27 13:23:01','$2y$12$YL3p5YztDy26q67bA7/ApunyJhNJg/V95TERndymzRAY88dzeiYxG',NULL,0,NULL,NULL),
(15,43,1,NULL,'Marcin','730170071',NULL,'37-450',0,NULL,NULL,'2026-03-27 13:37:52',NULL,0,'2026-03-27 13:37:52','2026-03-27 13:37:52','$2y$12$Z3mW1bF0WH0eowMdMi9j8uEjAwcbBn.lAAif843l66GgtpIEwSFom',NULL,0,NULL,NULL),
(16,43,1,NULL,'Tomasz','889402548',NULL,'37-450',1,'2026-03-28 08:47:20',NULL,'2026-03-28 08:47:20',NULL,0,'2026-03-28 08:47:20','2026-03-28 08:47:20','$2y$12$AnGnnRcvYyOnw/oGRP/cIud6DtdUY3SDyN82PoC3axo0NMmGTu6xG',NULL,0,NULL,NULL),
(17,43,1,NULL,'Barbara','733005945',NULL,'37-450',1,'2026-03-28 08:47:30',NULL,'2026-03-28 08:47:30',NULL,0,'2026-03-28 08:47:30','2026-03-28 08:47:30','$2y$12$LFXcIgvzDZ8vTR4FpVYz.uXHg7o.u0ns5DA645T4TJWnvbxw7fhI2',NULL,0,NULL,NULL),
(18,43,1,NULL,'Paweł','723006601',NULL,'37433',1,'2026-03-28 09:04:43',NULL,'2026-03-28 09:04:43',NULL,0,'2026-03-28 09:04:43','2026-03-28 09:04:43','$2y$12$oagAp7/ou2IHPFfCgnno6eswPgLDGj3O90.sveUMYbllypiQRVt32',NULL,0,NULL,NULL),
(19,43,1,NULL,'Piotr','663327749',NULL,'37-450',0,NULL,NULL,'2026-03-28 09:11:49',NULL,0,'2026-03-28 09:11:49','2026-03-28 09:11:49','$2y$12$5JpqTfJyEobmFB72IjZY3.eOFlRnQ3xceQkOn9kadRTb.O7fSSplC',NULL,0,NULL,NULL),
(20,43,1,NULL,NULL,'500012384',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 09:20:23','2026-03-28 09:21:01','$2y$12$M2TCptbnya6rsuJMZidsyOHIVDtU5MfGi9LwOL6jjkyQqj5lyxtja',NULL,0,NULL,NULL),
(21,43,1,NULL,NULL,'665209021',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 09:24:48','2026-03-28 09:25:46','$2y$12$ygJuWD3Lu/6xOx/GJDCJWudxTe/MLsOFAGlVuanAZS837B8GdDbgy',NULL,0,NULL,NULL),
(22,43,1,NULL,NULL,'574965078',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 09:28:20','2026-03-28 09:28:20',NULL,NULL,0,NULL,NULL),
(23,43,1,NULL,NULL,'534862358',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 09:35:28','2026-03-28 09:53:42','$2y$12$3S1Tg.GMwCm7JDYKoyYvO.Uz9CZcWwK56ZSFrporFTLFASpjz4L3G',NULL,0,NULL,NULL),
(24,43,1,NULL,'Arkadiusz','791993293',NULL,'37-464',1,'2026-03-28 09:37:27',NULL,'2026-03-28 09:37:27',NULL,0,'2026-03-28 09:37:27','2026-03-28 09:37:27','$2y$12$bbBYbrqOOaVCEDGVoKvy2eD/7/Et7NYlRZUSTsuB8.nQ9rBdKX.CW',NULL,0,NULL,NULL),
(25,43,1,NULL,NULL,'693362359',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 09:39:39','2026-03-28 11:22:26','$2y$12$HLOeEs/dQUz1kChAt/zFx.kZ9K27faHP2UQ8nYhqCmwK.2JkcnlD.',NULL,0,NULL,NULL),
(26,43,1,NULL,NULL,'508609249',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 09:44:23','2026-03-28 09:44:23',NULL,NULL,0,NULL,NULL),
(27,43,1,NULL,NULL,'664699283',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 09:56:37','2026-03-29 09:46:47','$2y$12$z1pnlPWs7nM4l0c3LfBRledCGjwLlEujKWSATJu5FGTqJSZe26mLe',NULL,0,NULL,NULL),
(28,43,1,NULL,NULL,'691530893',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 10:10:41','2026-03-28 10:10:41',NULL,NULL,0,NULL,NULL),
(29,43,1,NULL,NULL,'663644482',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 10:12:56','2026-03-28 12:28:14','$2y$12$hSW4QebAnLkqf8zPOIzpK.aBQNZsWEn5s2h6LZl/zTGAjaLrHUgc6',NULL,0,NULL,NULL),
(30,43,1,NULL,NULL,'533022442',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 10:16:42','2026-03-28 10:24:01','$2y$12$WE/Pj4vxgBbbUwKdkFXiku0fd83ss0ndCiX1TtpskxIjcxEnQoL5G',NULL,0,NULL,NULL),
(31,43,1,NULL,NULL,'786144316',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 10:26:17','2026-03-28 10:26:17',NULL,NULL,0,NULL,NULL),
(32,43,1,NULL,NULL,'693736386',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 10:31:45','2026-03-28 10:31:45',NULL,NULL,0,NULL,NULL),
(33,43,1,NULL,NULL,'662808232',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 10:36:51','2026-03-28 20:28:34','$2y$12$OOVldMyzLAU9vyCYaRtj0ug6xprKcsV.Zb.jjTgdpQ2T15OeuqCTG',NULL,0,NULL,NULL),
(34,43,1,NULL,NULL,'725415458',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 10:55:08','2026-03-28 11:02:53','$2y$12$gSxEsHEFlCUZJ3Ay0LyM3.oOBcJaPrhWUXUK4vsCZ2Duqewi7CY4S',NULL,0,NULL,NULL),
(35,43,1,NULL,NULL,'795863806',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 11:00:25','2026-03-28 11:00:25',NULL,NULL,0,NULL,NULL),
(36,43,1,NULL,'Radek','660387354',NULL,'37-415',0,NULL,NULL,'2026-03-28 11:05:13',NULL,0,'2026-03-28 11:05:13','2026-03-28 11:05:13','$2y$12$m6wF1wMXTM1nPL62dAsZpuoC4JHiJI3oWlCSHPRNCnG9BIs7QGlQq',NULL,0,NULL,NULL),
(37,43,1,NULL,NULL,'605893629',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 11:05:42','2026-03-28 11:43:52','$2y$12$XObPyEc9TLyUUI2uy5KrfejAfzEcYDotapdVFqP9KbT8iAELFVXmG',NULL,0,NULL,NULL),
(38,43,1,NULL,NULL,'512085655',NULL,NULL,0,NULL,NULL,'2026-03-28 11:06:05',NULL,0,'2026-03-28 11:06:05','2026-03-28 11:06:05','$2y$12$lsoa.3KsR5tDX4/sN9anoOe/m7dYZhmS/KvctcelP8BfAGE.JZP.6',NULL,0,NULL,NULL),
(39,43,1,NULL,'Damian','508284757',NULL,NULL,1,'2026-03-28 11:06:07',NULL,'2026-03-28 11:06:07',NULL,0,'2026-03-28 11:06:07','2026-03-28 11:06:07','$2y$12$IfYXq8m39HtUXcAXPXDrLuph3TqGwglOm754lEMUBpeYQA.pQT5tO',NULL,0,NULL,NULL),
(40,43,1,NULL,NULL,'7257305090',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 11:16:17','2026-03-28 11:16:17',NULL,NULL,0,NULL,NULL),
(41,43,1,NULL,NULL,'510480227',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 11:25:49','2026-03-28 11:27:40','$2y$12$GLhX7zuasQUAe4Nj2A9J4eDvrZIXlzMrpdns.DyX8ihK.U3vcfQcy',NULL,0,NULL,NULL),
(42,43,1,NULL,NULL,'883626822',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 11:38:36','2026-03-28 11:38:36',NULL,NULL,0,NULL,NULL),
(43,43,1,NULL,NULL,'504854275',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 12:04:37','2026-03-28 12:04:37',NULL,NULL,0,NULL,NULL),
(44,43,1,NULL,NULL,'883487195',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 12:06:22','2026-03-28 12:06:22',NULL,NULL,0,NULL,NULL),
(45,43,1,NULL,NULL,'693059214',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 12:17:55','2026-03-28 12:17:55',NULL,NULL,0,NULL,NULL),
(46,43,1,NULL,NULL,'512064505',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 12:20:53','2026-03-28 12:20:53',NULL,NULL,0,NULL,NULL),
(47,43,1,NULL,NULL,'693870331',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 12:33:08','2026-03-28 12:33:08',NULL,NULL,0,NULL,NULL),
(48,43,1,NULL,NULL,'698997267',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 12:46:13','2026-03-28 12:48:09','$2y$12$Bkj.HcSeyL7KvTGjmFLtWe91Va/1URHRfuk8zSMi3vbdOvergThDu',NULL,0,NULL,NULL),
(49,43,1,NULL,NULL,'694677309',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 12:53:35','2026-03-28 17:48:53','$2y$12$cKr/xW6.6jRvt6GU1TAvwewkTNjHhRH9RTgZ1gitVoQhTKWRhRTc2',NULL,0,NULL,NULL),
(50,43,1,NULL,NULL,'609747803',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 13:07:24','2026-03-28 13:07:24',NULL,NULL,0,NULL,NULL),
(51,43,1,NULL,NULL,'507157336',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 13:13:03','2026-03-28 13:51:47','$2y$12$B5sW4dsP.9bMYMrienoVveB9SiJk5pdO/BpVOdLv/fRhaGtB0nNM2',NULL,0,NULL,NULL),
(52,43,1,NULL,NULL,'667361672',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 13:23:02','2026-03-28 13:23:36','$2y$12$f/jBOhbTHWYzLRnbgT.KN.KKeWj1yGYM6wuo.bt80bLT5TYrhT.P.',NULL,0,NULL,NULL),
(53,43,1,NULL,NULL,'609392154',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 13:44:04','2026-03-28 13:44:04',NULL,NULL,0,NULL,NULL),
(54,43,1,NULL,NULL,'690218450',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 14:25:03','2026-03-28 14:46:38','$2y$12$9iMDs6R7OBvjK.Ga.35ahOtkXYpGQCkKEj2jhhHIP2IFNWUsk55d6',NULL,0,NULL,NULL),
(55,43,1,NULL,'Sławomir','517656072',NULL,'37-450',1,'2026-03-28 15:38:42',NULL,'2026-03-28 15:38:42',NULL,0,'2026-03-28 15:38:42','2026-03-28 15:38:42','$2y$12$V/zFM2U4IjDz115IJGH49.mjkbeiKW0xkEZeLYtYbLQLJgMQMzDhC',NULL,0,NULL,NULL),
(56,43,1,NULL,NULL,'795073440',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 15:43:44','2026-03-28 15:43:44',NULL,NULL,0,NULL,NULL),
(57,43,1,NULL,NULL,'884802750',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 15:44:57','2026-03-28 15:44:57',NULL,NULL,0,NULL,NULL),
(58,43,1,NULL,NULL,'571808059',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 16:38:35','2026-03-28 16:41:21','$2y$12$tbqwD9pOLPxyH5Mrqi/VF.8LJ8Yp3ZAG0/ShvZMgO7RyPXY4JhGSm',NULL,0,NULL,NULL),
(59,43,1,NULL,NULL,'507477112',NULL,NULL,0,NULL,NULL,NULL,NULL,0,'2026-03-28 16:41:50','2026-03-28 20:34:30','$2y$12$4LDILXj.PeqoqyIpVLko3.UId5BnwJ33s6ZpAOQV45dtZZsG1yXm2',NULL,0,NULL,NULL),
(60,43,1,NULL,'Marcin','785598503',NULL,NULL,1,'2026-03-29 09:49:24',NULL,'2026-03-29 09:49:24',NULL,0,'2026-03-29 09:49:24','2026-03-29 09:49:24','$2y$12$4G5x6cFZeeuOonfBX3LcTO46A9pkNb5F4sH5cqCmBXtExYVV5FPzm',NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_pass_types`
--

DROP TABLE IF EXISTS `company_pass_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_pass_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `entries` int(10) unsigned NOT NULL,
  `price_gross_cents` int(10) unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_pass_types_firm_id_is_active_index` (`firm_id`,`is_active`),
  CONSTRAINT `company_pass_types_firm_id_foreign` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_pass_types`
--

LOCK TABLES `company_pass_types` WRITE;
/*!40000 ALTER TABLE `company_pass_types` DISABLE KEYS */;
INSERT INTO `company_pass_types` VALUES
(1,1,'Karnet 5 wejść',5,10000,1,'2026-02-27 16:18:13','2026-02-27 16:18:13'),
(2,1,'startowy',2,200,1,'2026-02-27 21:05:34','2026-02-27 21:05:34'),
(3,35,'Starter',10,200,1,'2026-02-28 20:49:56','2026-02-28 20:49:56'),
(4,35,'Damian',10,200,1,'2026-03-01 10:25:20','2026-03-01 10:25:20'),
(5,36,'Startowy 2 wędki',10,400,1,'2026-03-01 15:02:01','2026-03-01 15:02:01'),
(6,36,'Starter',5,5,1,'2026-03-03 14:50:27','2026-03-03 14:50:27');
/*!40000 ALTER TABLE `company_pass_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consent_logs`
--

DROP TABLE IF EXISTS `consent_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `consent_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `loyalty_card_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned NOT NULL,
  `old_value` tinyint(4) DEFAULT NULL,
  `new_value` tinyint(4) DEFAULT NULL,
  `ip_address` varchar(64) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `source` varchar(32) NOT NULL DEFAULT 'client_wallet',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consent_logs_client_id_firm_id_index` (`client_id`,`firm_id`),
  KEY `consent_logs_loyalty_card_id_index` (`loyalty_card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consent_logs`
--

LOCK TABLES `consent_logs` WRITE;
/*!40000 ALTER TABLE `consent_logs` DISABLE KEYS */;
INSERT INTO `consent_logs` VALUES
(1,25,1,19,0,1,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','client_wallet','2026-02-13 12:03:53','2026-02-13 12:03:53'),
(2,26,1,4,NULL,1,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','client_register','2026-02-13 12:21:49','2026-02-13 12:21:49'),
(3,27,1,21,NULL,1,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','client_register','2026-02-17 14:45:58','2026-02-17 14:45:58'),
(4,28,1,22,NULL,1,'176.107.36.121','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','client_register','2026-02-23 16:01:20','2026-02-23 16:01:20'),
(5,29,25,4,NULL,1,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','client_register','2026-03-01 11:37:44','2026-03-01 11:37:44'),
(6,1,1,36,NULL,1,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','client_register','2026-03-04 00:10:42','2026-03-04 00:10:42'),
(7,2,3,22,NULL,1,'176.107.36.121','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','client_register','2026-03-06 08:46:16','2026-03-06 08:46:16'),
(8,3,1,38,NULL,1,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36','client_register','2026-03-09 23:44:22','2026-03-09 23:44:22'),
(9,4,7,39,NULL,0,'91.234.131.32','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36','client_register','2026-03-24 15:09:38','2026-03-24 15:09:38'),
(10,5,5,39,NULL,0,'91.234.131.32','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36','client_register','2026-03-24 15:19:34','2026-03-24 15:19:34'),
(11,6,1,40,NULL,1,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36','client_register','2026-03-24 20:44:23','2026-03-24 20:44:23'),
(12,7,1,41,NULL,1,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36','client_register','2026-03-26 09:57:45','2026-03-26 09:57:45'),
(13,8,8,41,NULL,1,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36','client_register','2026-03-26 16:56:36','2026-03-26 16:56:36'),
(14,9,5,41,NULL,1,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36','client_register','2026-03-26 17:49:42','2026-03-26 17:49:42'),
(15,10,1,41,NULL,1,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36','client_register','2026-03-26 18:59:25','2026-03-26 18:59:25');
/*!40000 ALTER TABLE `consent_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `firms`
--

DROP TABLE IF EXISTS `firms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `firms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` bigint(20) unsigned DEFAULT 1,
  `has_stickers` tinyint(1) NOT NULL DEFAULT 0,
  `has_points` tinyint(1) NOT NULL DEFAULT 0,
  `has_passes` tinyint(1) NOT NULL DEFAULT 0,
  `slug` varchar(255) NOT NULL,
  `pass_qr_token` varchar(64) DEFAULT NULL,
  `program_type` varchar(255) NOT NULL DEFAULT 'cards',
  `plan` varchar(255) NOT NULL DEFAULT 'starter',
  `billing_period` varchar(255) NOT NULL DEFAULT 'monthly',
  `subscription_status` varchar(255) NOT NULL DEFAULT 'trial',
  `subscription_forced_status` varchar(255) DEFAULT NULL,
  `subscription_ends_at` timestamp NULL DEFAULT NULL,
  `card_template` varchar(255) NOT NULL DEFAULT 'classic',
  `promotion_text` text DEFAULT NULL,
  `opening_hours` text DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `google_review_url` varchar(255) DEFAULT NULL,
  `google_url` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `firm_id` varchar(255) NOT NULL,
  `registration_token` char(36) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `program_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `stamps_required` tinyint(3) unsigned NOT NULL DEFAULT 10,
  `start_stamps` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subscription_reminder_sent_at` timestamp NULL DEFAULT NULL,
  `subscription_expired_sent_at` timestamp NULL DEFAULT NULL,
  `subscription_blocked_sent_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `firms_slug_unique` (`slug`),
  UNIQUE KEY `firms_registration_token_unique` (`registration_token`),
  UNIQUE KEY `firms_pass_qr_token_unique` (`pass_qr_token`),
  KEY `firms_plan_id_foreign` (`plan_id`),
  CONSTRAINT `firms_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `firms`
--

LOCK TABLES `firms` WRITE;
/*!40000 ALTER TABLE `firms` DISABLE KEYS */;
INSERT INTO `firms` VALUES
(22,1,1,0,0,'artystyczny-dekorstyl-pawel-puzio-8249','UiRY06ZvaXvv7tt52DZ956cqqvWqr5gL','cards','starter','monthly','active',NULL,'2027-03-09 15:55:49','florist',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'artystyczny-dekorstyl-pawel-puzio-8249',NULL,'Artystyczny DekorStyl Paweł Puzio','kontakt@looply.net.pl','$2y$12$Do75gNpacr.jntCVhKCyhef6PY0joDqykfflPbRYhXfz74MPC17rS',NULL,1,10,0,'2026-02-23 15:55:49','2026-03-01 19:54:26',NULL,'Bieszczadzka 59 (obok Circle K)','Nowa Dęba','39-460',NULL,'531 158 010','2026-02-23 15:56:01',NULL,NULL),
(36,1,0,0,0,'lowisko-rybka-3200','cZJySTT6qOkw3tqqTJOGHNY4QcVh5Kxp','passes','starter','monthly','blocked',NULL,'2026-03-15 14:30:43','florist',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'lowisko-rybka-3200',NULL,'Łowisko Rybka','jddfoto@gmail.com','$2y$12$.47iX0ul25ZOsPAIUz.iseYvoAPtHPMFI5piYlkNcfaGQpS2VGWWS',NULL,1,10,0,'2026-03-01 14:30:43','2026-03-23 17:00:02',NULL,'Zawidza','zawidza 789','39-460',NULL,'732287103','2026-03-01 15:00:02','2026-03-15 15:00:02','2026-03-23 17:00:02'),
(37,1,0,0,0,'sklep-wedkarki-7843',NULL,'cards','starter','monthly','grace',NULL,'2026-03-23 15:43:23','florist',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sklep-wedkarki-7843',NULL,'Sklep wędkarki','damianb1988@proton.me','$2y$12$5tPhsvs7MUU6IQQOddBX.OjbrfEfHZ6FxJKSZZp596fk56l1jrp/G',NULL,1,10,0,'2026-03-09 15:43:23','2026-03-23 18:00:01',NULL,'d','fd','39-460',NULL,'732287104','2026-03-09 16:00:02','2026-03-23 18:00:01',NULL),
(38,1,0,1,0,'centrum-oplat-8953',NULL,'cards','starter','monthly','grace',NULL,'2026-03-23 20:56:17','workshop',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'centrum-oplat-8953',NULL,'Centrum Opłat','pyrytd@poczta.onet.pl','$2y$12$9FWSeADOQ/ogCm9vAfYa9.6dizTiQtTyDGCQKlVu8jo3.1flyh01q',NULL,1,10,0,'2026-03-09 20:56:17','2026-03-23 21:00:02',NULL,'Nowa Dęba','al. Zwycięstwa 1a','39-460',NULL,'799838830','2026-03-09 21:00:02','2026-03-23 21:00:02',NULL),
(39,1,0,0,0,'test-8859',NULL,'points','starter','monthly','active',NULL,'2026-04-07 14:51:21','florist',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'test-8859',NULL,'Test','damianb1988@proton.me','$2y$12$r5GyB6sJcZd/oWY1xGPP5.8X2pXcBAB6W.h7RorbK/cqVb5rl5gYK',NULL,1,10,0,'2026-03-24 14:51:21','2026-03-24 18:30:29',NULL,'Nowa Dęba','lfredówka 191','39-460',NULL,'7322871189','2026-03-24 14:57:01',NULL,NULL),
(40,1,0,1,0,'dani-6132',NULL,'points','starter','monthly','active',NULL,'2026-04-07 16:19:11','florist',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'dani-6132',NULL,'dani','jddfoto@gmail.com','$2y$12$fWZy1OPb2PVs4nC3jBe/quVmSaW6xO94w4QajOiy19wRP6xQ4293W',NULL,1,10,0,'2026-03-24 16:19:11','2026-03-24 20:29:25',NULL,'sas','ascd','39-260',NULL,'732287103','2026-03-24 17:00:02',NULL,NULL),
(41,1,0,0,0,'test-wdrozenie-01-9552',NULL,'points','starter','monthly','active',NULL,'2026-04-09 08:49:15','workshop',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'test-wdrozenie-01-9552',NULL,'TEST WDROŻENIE 01','jddfoto@gmail.com','$2y$12$xd5f6BptRhjteEMI3zCZCu60qFlY45w/byOaFC1DkSsxDEOTBqMuW',NULL,1,10,0,'2026-03-26 08:49:15','2026-03-26 09:00:02',NULL,'sca','asc','39-460',NULL,'732287103','2026-03-26 09:00:02',NULL,NULL),
(42,1,0,0,0,'dominika-4496',NULL,'points','starter','monthly','active',NULL,'2026-04-09 19:49:22','florist',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'dominika-4496',NULL,'Dominika','pyrytd@poczta.onet.pl','$2y$12$JBgRve/kPf19giTd1/xnX.IFwO05OHFpFp1lon8Zdv5yS2fjGJ04a',NULL,1,10,0,'2026-03-26 19:49:22','2026-03-26 20:00:02',NULL,'skjais','sadas','39-450',NULL,'799838830','2026-03-26 20:00:02',NULL,NULL),
(43,1,0,0,0,'dani-fishing-daniel-poryczynski-3740',NULL,'points','starter','monthly','active',NULL,'2026-04-10 07:44:50','workshop',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'dani-fishing-daniel-poryczynski-3740',NULL,'Dani-Fishing Daniel Poryczyński','dani.fishing.gorzyce@gmail.com','$2y$12$T.FER.CD3zeWlc.LlHT.RuCFgfC5zRwEnrVKenJwX5ee2oKWMAakS',NULL,1,10,0,'2026-03-27 07:44:50','2026-03-27 08:00:02',NULL,'ul. ks. Adama Osetka 9','Gorzyce','39-432',NULL,'668406981','2026-03-27 08:00:01',NULL,NULL);
/*!40000 ALTER TABLE `firms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gift_vouchers`
--

DROP TABLE IF EXISTS `gift_vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `gift_vouchers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned DEFAULT NULL,
  `type` enum('amount','service') NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) NOT NULL,
  `status` enum('active','used','expired') NOT NULL DEFAULT 'active',
  `valid_until` date DEFAULT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `recipient_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gift_vouchers_qr_code_unique` (`qr_code`),
  KEY `gift_vouchers_program_id_foreign` (`program_id`),
  KEY `gift_vouchers_firm_id_foreign` (`firm_id`),
  CONSTRAINT `gift_vouchers_firm_id_foreign` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE SET NULL,
  CONSTRAINT `gift_vouchers_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gift_vouchers`
--

LOCK TABLES `gift_vouchers` WRITE;
/*!40000 ALTER TABLE `gift_vouchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `gift_vouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loyalty_cards`
--

DROP TABLE IF EXISTS `loyalty_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `loyalty_cards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned DEFAULT NULL,
  `program_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `max_stamps` int(11) NOT NULL DEFAULT 10,
  `current_stamps` int(11) NOT NULL DEFAULT 0,
  `reward` varchar(255) DEFAULT NULL,
  `status` enum('active','completed','redeemed','reset') NOT NULL DEFAULT 'active',
  `qr_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `qr_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `marketing_consent` tinyint(1) NOT NULL DEFAULT 0,
  `marketing_consent_at` timestamp NULL DEFAULT NULL,
  `marketing_consent_revoked_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loyalty_cards_qr_token_unique` (`qr_token`),
  UNIQUE KEY `firm_phone_unique` (`firm_id`,`phone`),
  KEY `loyalty_cards_program_id_foreign` (`program_id`),
  KEY `loyalty_cards_client_id_foreign` (`client_id`),
  KEY `loyalty_cards_firm_id_index` (`firm_id`),
  KEY `loyalty_cards_phone_index` (`phone`),
  CONSTRAINT `loyalty_cards_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loyalty_cards_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loyalty_cards`
--

LOCK TABLES `loyalty_cards` WRITE;
/*!40000 ALTER TABLE `loyalty_cards` DISABLE KEYS */;
INSERT INTO `loyalty_cards` VALUES
(1,36,NULL,1,10,1,NULL,'active',NULL,'2026-03-04 00:10:42','2026-03-24 20:44:37',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'2026-03-24 20:44:37'),
(2,22,NULL,3,10,0,NULL,'active',NULL,'2026-03-06 08:46:17','2026-03-06 08:46:17',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL),
(3,38,NULL,1,10,0,NULL,'active',NULL,'2026-03-09 23:44:23','2026-03-24 20:44:36',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'2026-03-24 20:44:36'),
(4,39,NULL,7,10,0,NULL,'active',NULL,'2026-03-24 15:09:39','2026-03-24 15:09:39',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL),
(5,39,NULL,5,10,0,NULL,'active',NULL,'2026-03-24 15:19:34','2026-03-24 15:19:34',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL),
(6,40,NULL,1,10,0,NULL,'active',NULL,'2026-03-24 20:44:23','2026-03-24 20:44:33',NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-24 20:44:33',NULL),
(9,41,NULL,5,10,0,NULL,'active',NULL,'2026-03-26 17:49:42','2026-03-26 18:55:26',NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-26 18:55:26',NULL);
/*!40000 ALTER TABLE `loyalty_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loyalty_stamps`
--

DROP TABLE IF EXISTS `loyalty_stamps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `loyalty_stamps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `loyalty_card_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loyalty_stamps_loyalty_card_id_foreign` (`loyalty_card_id`),
  KEY `loyalty_stamps_firm_id_foreign` (`firm_id`),
  CONSTRAINT `loyalty_stamps_firm_id_foreign` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loyalty_stamps_loyalty_card_id_foreign` FOREIGN KEY (`loyalty_card_id`) REFERENCES `loyalty_cards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loyalty_stamps`
--

LOCK TABLES `loyalty_stamps` WRITE;
/*!40000 ALTER TABLE `loyalty_stamps` DISABLE KEYS */;
INSERT INTO `loyalty_stamps` VALUES
(1,1,1,'Naklejka','2026-02-02 22:14:18','2026-02-02 22:14:18'),
(2,2,1,'Naklejka','2026-02-02 22:40:20','2026-02-02 22:40:20'),
(3,2,1,'Naklejka','2026-02-02 22:52:34','2026-02-02 22:52:34'),
(4,1,1,'Naklejka','2026-02-02 22:55:36','2026-02-02 22:55:36'),
(5,2,1,'Naklejka','2026-02-02 23:28:27','2026-02-02 23:28:27'),
(6,1,1,'Naklejka','2026-02-02 23:28:28','2026-02-02 23:28:28'),
(7,1,1,'Naklejka','2026-02-02 23:36:58','2026-02-02 23:36:58'),
(8,1,1,'Naklejka','2026-02-02 23:47:19','2026-02-02 23:47:19'),
(9,2,1,'Naklejka','2026-02-02 23:47:52','2026-02-02 23:47:52'),
(10,1,1,'Naklejka','2026-02-03 00:37:45','2026-02-03 00:37:45'),
(11,2,1,'Naklejka','2026-02-03 00:37:46','2026-02-03 00:37:46'),
(12,1,1,'Naklejka','2026-02-03 01:28:43','2026-02-03 01:28:43'),
(13,2,1,'Naklejka','2026-02-03 01:28:45','2026-02-03 01:28:45'),
(14,2,1,'Naklejka','2026-02-03 01:47:56','2026-02-03 01:47:56'),
(15,1,1,'Naklejka','2026-02-03 01:47:59','2026-02-03 01:47:59'),
(16,1,1,'Naklejka','2026-02-03 09:34:16','2026-02-03 09:34:16'),
(17,2,1,'Naklejka','2026-02-03 10:37:07','2026-02-03 10:37:07'),
(18,2,1,'Naklejka','2026-02-03 10:41:52','2026-02-03 10:41:52'),
(19,1,1,'Naklejka (QR)','2026-02-03 11:03:17','2026-02-03 11:03:17'),
(20,2,1,'Naklejka (QR)','2026-02-03 11:35:45','2026-02-03 11:35:45'),
(21,3,1,'Naklejka (QR)','2026-02-03 11:52:39','2026-02-03 11:52:39'),
(22,3,1,'Naklejka (QR)','2026-02-03 18:39:45','2026-02-03 18:39:45'),
(23,3,1,'Naklejka (ręcznie)','2026-02-04 16:47:27','2026-02-04 16:47:27'),
(24,4,2,'Naklejka (ręcznie)','2026-02-05 13:00:23','2026-02-05 13:00:23'),
(25,4,2,'Naklejka (ręcznie)','2026-02-05 13:00:24','2026-02-05 13:00:24'),
(26,3,1,'Naklejka (ręcznie)','2026-02-06 12:39:34','2026-02-06 12:39:34'),
(27,3,1,'Naklejka (ręcznie)','2026-02-06 12:44:29','2026-02-06 12:44:29'),
(28,6,4,'Naklejka (ręcznie)','2026-02-06 18:15:57','2026-02-06 18:15:57'),
(29,6,4,'Naklejka (ręcznie)','2026-02-06 18:16:09','2026-02-06 18:16:09'),
(30,6,4,'Naklejka (ręcznie)','2026-02-06 18:27:20','2026-02-06 18:27:20'),
(37,3,1,'Naklejka (ręcznie)','2026-02-07 14:22:48','2026-02-07 14:22:48'),
(38,12,5,'Naklejka (ręcznie)','2026-02-07 16:12:16','2026-02-07 16:12:16'),
(39,12,5,'Naklejka (ręcznie)','2026-02-07 19:40:52','2026-02-07 19:40:52'),
(40,3,1,'Naklejka (ręcznie)','2026-02-08 10:59:26','2026-02-08 10:59:26'),
(41,3,1,'Naklejka (ręcznie)','2026-02-11 11:23:27','2026-02-11 11:23:27'),
(42,23,18,'Naklejka (ręcznie)','2026-02-11 12:47:28','2026-02-11 12:47:28'),
(43,23,18,'Naklejka (ręcznie)','2026-02-11 13:34:30','2026-02-11 13:34:30'),
(44,23,18,'Naklejka (ręcznie)','2026-02-11 13:34:30','2026-02-11 13:34:30'),
(45,23,18,'Naklejka (ręcznie)','2026-02-11 13:34:31','2026-02-11 13:34:31'),
(46,23,18,'Naklejka (ręcznie)','2026-02-11 13:34:31','2026-02-11 13:34:31'),
(47,23,18,'Naklejka (ręcznie)','2026-02-11 13:34:33','2026-02-11 13:34:33'),
(48,23,18,'Naklejka (ręcznie)','2026-02-11 13:34:34','2026-02-11 13:34:34'),
(49,3,1,'Naklejka (ręcznie)','2026-02-11 16:27:12','2026-02-11 16:27:12'),
(50,23,18,'Naklejka (ręcznie)','2026-02-11 16:28:00','2026-02-11 16:28:00'),
(51,23,18,'Naklejka (ręcznie)','2026-02-11 16:28:01','2026-02-11 16:28:01'),
(52,23,18,'Naklejka (ręcznie)','2026-02-11 16:28:14','2026-02-11 16:28:14'),
(54,4,2,'Naklejka (ręcznie)','2026-02-14 08:40:28','2026-02-14 08:40:28'),
(55,27,21,'Naklejka (ręcznie)','2026-02-17 20:00:37','2026-02-17 20:00:37'),
(56,27,21,'Naklejka (ręcznie)','2026-02-17 20:00:53','2026-02-17 20:00:53'),
(57,28,22,'Naklejka (ręcznie)','2026-02-23 16:01:38','2026-02-23 16:01:38'),
(58,3,1,'Naklejka (ręcznie)','2026-02-26 13:13:14','2026-02-26 13:13:14'),
(59,27,21,'Naklejka (ręcznie)','2026-02-28 17:36:26','2026-02-28 17:36:26'),
(60,27,21,'Naklejka (ręcznie)','2026-02-28 17:38:44','2026-02-28 17:38:44'),
(61,1,36,'Naklejka (ręcznie)','2026-03-09 13:46:56','2026-03-09 13:46:56');
/*!40000 ALTER TABLE `loyalty_stamps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_12_09_231652_create_programs_table',1),
(5,'2025_12_09_231653_create_clients_table',1),
(6,'2025_12_09_231653_create_firms_table',1),
(7,'2025_12_09_231653_create_program_settings_table',1),
(8,'2025_12_09_231653_create_services_table',1),
(9,'2025_12_10_170301_create_loyalty_cards_table',1),
(10,'2025_12_10_170450_create_loyalty_stamps_table',1),
(11,'2025_12_10_170628_create_gift_vouchers_table',1),
(12,'2025_12_11_185325_add_points_rate_to_programs_table',1),
(13,'2025_12_11_185336_add_points_rate_to_programs_table',1),
(14,'2025_12_11_190443_add_program_id_to_firms_table',1),
(15,'2025_12_11_203031_create_transactions_table',1),
(16,'2025_12_15_174855_create_loyalty_cards_table',2),
(17,'2025_12_15_174855_create_loyalty_stamps_table',3),
(18,'2025_12_21_202152_add_client_auth_fields_to_clients_table',3),
(19,'2025_12_21_212313_make_city_nullable_in_clients_table',4),
(20,'2025_12_21_xxxxxx_make_city_nullable_in_clients_table',4),
(21,'2025_12_21_214756_add_firm_id_to_loyalty_cards_table',5),
(22,'2025_12_21_215103_fix_clients_required_fields',6),
(23,'2025_12_21_215128_fix_loyalty_cards_schema',7),
(24,'2025_12_22_211159_add_firm_id_to_users_table',8),
(25,'2025_12_23_150000_add_firm_id_to_clients_table',9),
(26,'2025_12_23_150016_add_firm_id_to_loyalty_stamps_table',9),
(27,'2025_12_23_161145_add_client_card_fields_to_loyalty_cards_table',10),
(28,'2025_12_23_161508_add_client_auth_fields_to_loyalty_cards_table',10),
(29,'2025_12_23_xxxxxx_add_client_auth_fields_to_loyalty_cards_table',10),
(30,'2025_12_31_104759_make_clients_postal_code_nullable',11),
(31,'XXXX_make_clients_postal_code_nullable',11),
(32,'2025_12_31_105136_add_qr_code_to_loyalty_cards',12),
(33,'2026_01_01_152911_create_registration_tokens_table',13),
(34,'2026_01_01_183750_make_program_id_nullable_in_loyalty_cards',14),
(35,'2026_01_04_201533_add_marketing_fields_to_clients_table',15),
(36,'2026_01_04_201544_add_marketing_fields_to_clients_table',15),
(37,'2026_01_05_133118_create_registration_hits_table',16),
(38,'2026_01_05_134629_add_firm_id_to_registration_hits_table',17),
(39,'xxxx_add_firm_id_to_registration_hits_table',17),
(40,'2026_01_06_184716_add_slug_to_firms_table',18),
(41,'2026_01_07_000000_add_card_template_and_socials_to_firms',18),
(42,'2026_01_07_000000_add_loyalty_config_to_firms_table',19),
(43,'2026_01_08_011944_add_loyalty_rules_to_firms_and_cards',20),
(44,'2026_01_08_xxxxxx_add_loyalty_rules_to_firms_and_cards',20),
(45,'2026_01_08_092815_add_registration_token_to_firms_table',21),
(46,'2026_01_08_095231_add_registration_token_to_firms_table',22),
(47,'2026_01_20_203755_add_terms_accepted_at_to_clients_table',23),
(48,'XXXX_add_terms_accepted_at_to_clients_table',23),
(49,'2026_01_20_230325_add_sms_marketing_withdrawn_at_to_clients_table',24),
(50,'2026_01_21_134637_create_security_logs_table',25),
(51,'2026_01_27_103652_add_logo_path_to_firms_table',26),
(52,'2026_01_27_153830_fix_logo_path_column_type_in_firms_table',27),
(53,'2026_01_27_201114_add_password_changed_at_to_firms_table',28),
(54,'2026_01_28_140837_change_clients_phone_unique_to_firm_phone_unique',29),
(55,'2026_01_29_185641_add_last_activity_at_to_firms_table',30),
(56,'2026_02_03_112536_create_qr_scan_logs_table',31),
(57,'2026_02_04_103732_add_subscription_fields_to_firms_table',32),
(58,'XXXX_add_subscription_fields_to_firms_table',32),
(59,'2026_02_04_add_forced_subscription_status_to_firms',33),
(60,'2026_02_04_182312_add_subscription_mail_flags_to_firms_table',34),
(61,'2026_02_06_121342_add_last_activity_at_to_clients_table',35),
(62,'2026_02_07_111303_change_google_url_to_text_in_firms_table',36),
(63,'2026_02_08_182533_add_marketing_consents_to_loyalty_cards_table',37),
(64,'2026_02_11_102229_add_youtube_and_opening_hours_to_firms_table',38),
(67,'2026_02_13_100648_create_consent_logs_table',39),
(68,'2026_02_27_163338_create_company_pass_types_table',40),
(69,'2026_02_27_163631_create_user_passes_table',41),
(70,'2026_02_27_163812_create_pass_usages_table',42),
(71,'2026_02_27_164039_create_otp_codes_table',43),
(72,'2026_02_27_164320_create_sms_logs_table',44),
(73,'2026_02_27_165736_add_pass_qr_token_to_firms_table',45),
(74,'2026_02_28_180449_add_program_type_to_firms_table',46),
(75,'2026_02_28_210107_create_pass_entry_logs_table',47),
(76,'2026_03_03_231621_create_plans_table',48),
(77,'2026_03_03_231845_add_plan_id_to_firms_table',48),
(78,'2026_03_03_232813_set_default_plan_on_firms',49),
(79,'2026_03_09_202441_add_loyalty_programs_to_firms_table',50),
(80,'2026_03_09_214514_create_client_registration_tokens_table',51),
(81,'2026_03_24_211149_add_password_reset_token_to_clients_table',52),
(82,'2026_03_24_211841_add_password_reset_token_to_clients_table',53),
(83,'2026_03_24_212108_add_password_reset_token_to_clients_table',999),
(84,'2026_03_25_075935_create_point_rewards_table',1000);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otp_codes`
--

DROP TABLE IF EXISTS `otp_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `otp_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `phone` varchar(32) NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `expires_at` timestamp NOT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otp_codes_firm_id_phone_index` (`firm_id`,`phone`),
  KEY `otp_codes_client_id_firm_id_index` (`client_id`,`firm_id`),
  KEY `otp_codes_expires_at_index` (`expires_at`),
  CONSTRAINT `otp_codes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `otp_codes_firm_id_foreign` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otp_codes`
--

LOCK TABLES `otp_codes` WRITE;
/*!40000 ALTER TABLE `otp_codes` DISABLE KEYS */;
INSERT INTO `otp_codes` VALUES
(1,1,1,'732287103','$2y$12$g5YibS0zU6AW97RdwRU1euTsxbSjSdY/MGWu47WzKaLs9/BKM0aa.',1,'2026-02-27 17:54:36','2026-02-27 17:52:14',NULL,'2026-02-27 17:51:36','2026-02-27 17:52:14'),
(2,1,24,'48732287103','$2y$12$AXhuRlVijV2XQHfKwr7an.CdlQR6nlpIrf5a9HjQWTGRgQw6hZbX2',0,'2026-02-27 19:28:25',NULL,'2026-02-27 19:28:14','2026-02-27 19:23:25','2026-02-27 19:28:14'),
(3,1,24,'48732287103','$2y$12$s.wVsvRA2m7Pe0hLLjdXK.Dqavjanqhs37Fb2GCB9ev70CldYkFZK',0,'2026-02-27 19:33:14',NULL,'2026-02-27 19:29:13','2026-02-27 19:28:14','2026-02-27 19:29:13'),
(4,1,24,'48732287103','$2y$12$oZ4MgcD1n96DnN7NobL6DOovajbuwYlfqhuKWVhVWprNN2408iCci',0,'2026-02-27 19:34:13',NULL,'2026-02-27 19:39:02','2026-02-27 19:29:13','2026-02-27 19:39:02'),
(5,1,24,'48732287103','$2y$12$n3RrYdhvjcxj4uqKHysZYOY//MZbloQljFdLZAAQtZUSr93DRd.RW',1,'2026-02-27 19:44:02','2026-02-27 19:39:49',NULL,'2026-02-27 19:39:02','2026-02-27 19:39:49'),
(6,2,1,'732287103','$2y$12$MoX71nBfdiUtcuLrGhVl1OejBGLlLnBC/90fnfBKKaQGoAXsnTa6S',1,'2026-02-27 22:43:18',NULL,NULL,'2026-02-27 22:38:19','2026-02-27 22:38:53'),
(7,1,1,'732287103','$2y$12$WLQc3V6xLHrtz8/37Py6yu8jwyvudiz2QHS7KsE6bLrN.yqxM6a.6',1,'2026-02-27 22:47:10','2026-02-27 22:42:49',NULL,'2026-02-27 22:42:10','2026-02-27 22:42:49'),
(8,1,1,'732287103','$2y$12$RJyCxfLO8ivU3wzoq82vPuPaICpI201XXxMd1qdH6qQkRM6pNgNtC',1,'2026-02-27 22:58:57','2026-02-27 22:54:29',NULL,'2026-02-27 22:53:57','2026-02-27 22:54:29'),
(9,35,1,'732287103','$2y$12$Sy7R19w8Sxr8jx.BFOHghu7..YXqrPbbNrzWb8LzxszJRZ98a4Dpy',0,'2026-02-28 21:39:09',NULL,'2026-02-28 21:35:24','2026-02-28 21:34:10','2026-02-28 21:35:24'),
(10,35,1,'732287103','$2y$12$gAHNyfFe2Shb3VZbbYpBkeL10LwYMnSQPkM8Q1ljq1g1F2AS5xof6',1,'2026-02-28 21:40:24','2026-02-28 21:37:01',NULL,'2026-02-28 21:35:24','2026-02-28 21:37:01'),
(11,35,1,'732287103','$2y$12$ARmqLxV8l.vGRlZwuUv/f.5yX9vaHJl9ZiO0emc3Sru3ZLXJ96w3.',0,'2026-02-28 21:56:51',NULL,'2026-02-28 21:52:36','2026-02-28 21:51:51','2026-02-28 21:52:36'),
(12,35,1,'732287103','$2y$12$5uhEUBL6NTR6Ssp690RT4evECFPEPnuJZiha9hOchgChukiitghva',1,'2026-02-28 21:57:36','2026-02-28 21:52:57',NULL,'2026-02-28 21:52:37','2026-02-28 21:52:57'),
(13,35,1,'732287103','$2y$12$a7pBglQm0wP5eOhILOj3HOB4VhpyG2Mp7K5dwl//3lEzMe7TUsM96',0,'2026-03-01 11:14:44',NULL,'2026-03-01 11:10:36','2026-03-01 11:09:44','2026-03-01 11:10:36'),
(14,35,1,'732287103','$2y$12$QiNWxCp4P3DI7q8nf4vZAefuoUOyjyAFOwomHIk/YIZ.cfSENRiCS',1,'2026-03-01 11:15:35','2026-03-01 11:11:00',NULL,'2026-03-01 11:10:36','2026-03-01 11:11:00'),
(15,36,1,'732287103','$2y$12$uH7B.ZlB1bNwBv1kQRhc1usstegJX6Ajr2ihwvUnYzS08lS8IVbU2',3,'2026-03-01 15:08:20',NULL,'2026-03-01 15:17:35','2026-03-01 15:03:21','2026-03-01 15:17:35'),
(16,36,1,'732287103','$2y$12$7hLfls8mS9yobqmSQ3hOGuFG8qQisyjtuxxM2jvsKTRivLtj/HN9W',3,'2026-03-01 15:22:35',NULL,'2026-03-01 15:33:59','2026-03-01 15:17:35','2026-03-01 15:33:59'),
(17,36,1,'732287103','$2y$12$0LYKxh/o/wBdQ9LraspOveE5rk6cjxDg3N0BxNBZ3.SbZMeDOXW46',0,'2026-03-01 15:38:59',NULL,'2026-03-02 14:49:20','2026-03-01 15:33:59','2026-03-02 14:49:20'),
(18,36,1,'732287103','$2y$12$fAd2I1RAZ2C0Q9.TYtsGX.ET8hSNE5eWYbfQzZpIeiE.eRdxcdBoi',0,'2026-03-02 14:54:20',NULL,'2026-03-03 13:52:15','2026-03-02 14:49:20','2026-03-03 13:52:15'),
(19,36,1,'732287103','$2y$12$Cgu/X6Wmpinf83UC2WaV1OryIMVchx55CfzzJuKeB/bbu4aDubA7u',0,'2026-03-03 13:57:15',NULL,'2026-03-03 14:43:17','2026-03-03 13:52:15','2026-03-03 14:43:17'),
(20,36,1,'732287103','$2y$12$pvYWwcP0Ihfi4NgSqfbERuUiTTGg8YzOxD.rkj0HDIuCYVRErjXD2',1,'2026-03-03 14:48:17','2026-03-03 14:43:34',NULL,'2026-03-03 14:43:18','2026-03-03 14:43:34'),
(21,36,1,'732287103','$2y$12$GO2KJreG0uhG/MgHf/HgT.oFYhNXvg/19..VCH4Fv7tKTF6fH0EIi',0,'2026-03-04 00:48:17',NULL,'2026-03-04 00:49:52','2026-03-04 00:43:18','2026-03-04 00:49:52'),
(22,36,1,'732287103','$2y$12$uhsr2HJZnWv1IlDHOZbLSu30U1eQEXSjkEaYg28fJt8FOtGvE4E3.',0,'2026-03-04 00:54:52',NULL,'2026-03-04 07:57:27','2026-03-04 00:49:53','2026-03-04 07:57:27'),
(23,36,1,'732287103','$2y$12$/s9hYg/ZvagOkVrPma4lxODblvb9Msysxki1ze3j/n4jlSGz.KZDC',1,'2026-03-04 08:02:27','2026-03-04 07:59:41',NULL,'2026-03-04 07:57:27','2026-03-04 07:59:41'),
(24,36,1,'732287103','$2y$12$.IrCjsAMNHJIiZVc/0xyoOUe.PfQglBY89eh/.FXrVhKCJ7wSzBh.',0,'2026-03-04 08:11:27','2026-03-04 08:06:44',NULL,'2026-03-04 08:06:28','2026-03-04 08:06:44'),
(25,36,1,'732287103','$2y$12$I09Qz67QbD3u5rZNfwCtDOw07FidJ5Ejf5JfnIQJjB/YGDhuVOfoO',0,'2026-03-04 08:21:09','2026-03-04 08:16:42',NULL,'2026-03-04 08:16:09','2026-03-04 08:16:42'),
(26,36,1,'732287103','$2y$12$8yL4DMPphJ58K4eEL9osUOTGq34Tw/s/vnWPcmA9x3.JHebR/B6tS',0,'2026-03-04 08:33:23','2026-03-04 08:28:42',NULL,'2026-03-04 08:28:24','2026-03-04 08:28:42'),
(27,36,1,'732287103','$2y$12$keHJHu7uL.8c7j/tVkn1ee3RYch05IAqELCYZbYh01tQqE9OMxXB6',0,'2026-03-04 08:44:25','2026-03-04 08:39:40',NULL,'2026-03-04 08:39:26','2026-03-04 08:39:40'),
(28,36,1,'732287103','$2y$12$iof1eHHri4FsG/LJBOla5eTw9GL3GBBLBGstCJEX51iP3JdhiTaQa',0,'2026-03-04 08:47:30','2026-03-04 08:42:47',NULL,'2026-03-04 08:42:31','2026-03-04 08:42:47'),
(29,36,1,'732287103','$2y$12$Yb2UuatfpN2PhCL3LhNlBeb462di.z3gtY9nUJ2WHhlQ9yHMc7Isy',0,'2026-03-04 08:54:45','2026-03-04 08:50:19',NULL,'2026-03-04 08:49:45','2026-03-04 08:50:19'),
(30,36,1,'732287103','$2y$12$mskncbQVEAkq./6lRAjEeuSjFtlDWsCt09CZkAUAnPqywVsrlHiKK',0,'2026-03-04 09:02:43','2026-03-04 08:57:58',NULL,'2026-03-04 08:57:43','2026-03-04 08:57:58');
/*!40000 ALTER TABLE `otp_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pass_entry_logs`
--

DROP TABLE IF EXISTS `pass_entry_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pass_entry_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `phone` varchar(32) NOT NULL,
  `pass_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `remaining_after` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pass_entry_logs_firm_id_index` (`firm_id`),
  KEY `pass_entry_logs_client_id_index` (`client_id`),
  KEY `pass_entry_logs_pass_id_index` (`pass_id`),
  KEY `pass_entry_logs_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pass_entry_logs`
--

LOCK TABLES `pass_entry_logs` WRITE;
/*!40000 ALTER TABLE `pass_entry_logs` DISABLE KEYS */;
INSERT INTO `pass_entry_logs` VALUES
(1,36,1,'732287103',8,'success',9,'2026-03-03 14:43:33','2026-03-03 14:43:33'),
(2,36,1,'732287103',13,'entry',4,'2026-03-04 08:57:58','2026-03-04 08:57:58');
/*!40000 ALTER TABLE `pass_entry_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pass_usages`
--

DROP TABLE IF EXISTS `pass_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pass_usages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_pass_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned NOT NULL,
  `used_at` timestamp NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `source` varchar(30) NOT NULL DEFAULT 'qr_company',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pass_usages_firm_id_used_at_index` (`firm_id`,`used_at`),
  KEY `pass_usages_client_id_used_at_index` (`client_id`,`used_at`),
  KEY `pass_usages_user_pass_id_used_at_index` (`user_pass_id`,`used_at`),
  CONSTRAINT `pass_usages_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pass_usages_firm_id_foreign` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pass_usages_user_pass_id_foreign` FOREIGN KEY (`user_pass_id`) REFERENCES `user_passes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pass_usages`
--

LOCK TABLES `pass_usages` WRITE;
/*!40000 ALTER TABLE `pass_usages` DISABLE KEYS */;
INSERT INTO `pass_usages` VALUES
(2,3,24,1,'2026-02-27 19:39:49',NULL,NULL,'qr_company','2026-02-27 19:39:49','2026-02-27 19:39:49');
/*!40000 ALTER TABLE `pass_usages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `otp_daily_limit` int(10) unsigned NOT NULL DEFAULT 30,
  `otp_ip_10m_limit` int(10) unsigned NOT NULL DEFAULT 20,
  `otp_phone_60s_lock` int(10) unsigned NOT NULL DEFAULT 60,
  `otp_verify_5m_limit` int(10) unsigned NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plans_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES
(1,'basic','Basic',30,20,60,5,'2026-03-03 23:20:57','2026-03-03 23:20:57'),
(2,'pro','Pro',200,60,60,10,'2026-03-03 23:20:57','2026-03-03 23:20:57'),
(3,'enterprise','Enterprise',1000000,300,30,20,'2026-03-03 23:20:57','2026-03-03 23:20:57');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `point_rewards`
--

DROP TABLE IF EXISTS `point_rewards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `point_rewards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned NOT NULL,
  `points_required` int(11) NOT NULL,
  `reward_value` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `point_rewards_firm_id_index` (`firm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `point_rewards`
--

LOCK TABLES `point_rewards` WRITE;
/*!40000 ALTER TABLE `point_rewards` DISABLE KEYS */;
INSERT INTO `point_rewards` VALUES
(1,40,200,10,'10 zł',NULL,NULL),
(2,40,300,15,'15 zł',NULL,NULL),
(3,40,400,20,'20 zł',NULL,NULL),
(4,40,500,25,'25 zł',NULL,NULL),
(5,40,600,30,'30 zł',NULL,NULL),
(6,40,700,35,'35 zł',NULL,NULL),
(7,40,800,40,'40 zł',NULL,NULL),
(8,40,900,45,'45 zł',NULL,NULL),
(9,40,1000,50,'50 zł',NULL,NULL),
(10,41,200,10,'10 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(11,41,300,15,'15 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(12,41,400,20,'20 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(13,41,500,25,'25 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(14,41,600,30,'30 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(15,41,700,35,'35 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(16,41,800,40,'40 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(17,41,900,45,'45 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(18,41,1000,50,'50 zł','2026-03-26 19:28:48','2026-03-26 19:28:48'),
(28,42,200,10,'10 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(29,42,300,15,'15 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(30,42,400,20,'20 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(31,42,500,25,'25 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(32,42,600,30,'30 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(33,42,700,35,'35 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(34,42,800,40,'40 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(35,42,900,45,'45 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(36,42,1000,50,'50 zł','2026-03-27 07:55:24','2026-03-27 07:55:24'),
(37,43,200,10,'10 zł','2026-03-27 07:58:01','2026-03-27 07:58:01'),
(38,43,300,15,'15 zł','2026-03-27 07:58:01','2026-03-27 07:58:01'),
(39,43,400,20,'20 zł','2026-03-27 07:58:01','2026-03-27 07:58:01'),
(40,43,500,25,'25 zł','2026-03-27 07:58:01','2026-03-27 07:58:01'),
(41,43,600,30,'30 zł','2026-03-27 07:58:01','2026-03-27 07:58:01'),
(42,43,700,35,'35 zł','2026-03-27 07:58:01','2026-03-27 07:58:01'),
(43,43,800,40,'40 zł','2026-03-27 07:58:01','2026-03-27 07:58:01'),
(44,43,900,45,'45 zł','2026-03-27 07:58:01','2026-03-27 07:58:01'),
(45,43,1000,50,'50 zł','2026-03-27 07:58:01','2026-03-27 07:58:01');
/*!40000 ALTER TABLE `point_rewards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_settings`
--

DROP TABLE IF EXISTS `program_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned DEFAULT NULL,
  `program_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `birthday_sms` tinyint(1) NOT NULL DEFAULT 0,
  `marketing_sms` tinyint(1) NOT NULL DEFAULT 0,
  `auto_bonus` tinyint(1) NOT NULL DEFAULT 0,
  `auto_bonus_value` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `points_per_currency` int(11) NOT NULL DEFAULT 10,
  PRIMARY KEY (`id`),
  KEY `program_settings_program_id_foreign` (`program_id`),
  CONSTRAINT `program_settings_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_settings`
--

LOCK TABLES `program_settings` WRITE;
/*!40000 ALTER TABLE `program_settings` DISABLE KEYS */;
INSERT INTO `program_settings` VALUES
(1,37,1,0,0,0,0,NULL,'2026-03-09 16:47:26',10),
(2,40,1,0,0,0,0,NULL,'2026-03-24 20:36:56',1),
(3,41,1,0,0,0,0,'2026-03-26 09:04:28','2026-03-26 09:04:28',1),
(4,42,1,0,0,0,0,'2026-03-27 07:55:24','2026-03-27 07:55:24',1),
(5,43,1,0,0,0,0,'2026-03-27 07:57:29','2026-03-27 07:57:29',1);
/*!40000 ALTER TABLE `program_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `programs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `points_rate` decimal(8,2) NOT NULL DEFAULT 1.00,
  `subdomain` varchar(255) NOT NULL,
  `points_name` varchar(255) NOT NULL DEFAULT 'punkty',
  `point_ratio` decimal(8,2) NOT NULL DEFAULT 0.50,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `programs_subdomain_unique` (`subdomain`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programs`
--

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;
INSERT INTO `programs` VALUES
(1,'Domyślny program',1.00,'default1','punktów',1.00,'2025-12-11 21:11:40',NULL);
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qr_scan_logs`
--

DROP TABLE IF EXISTS `qr_scan_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `qr_scan_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qr_scan_logs`
--

LOCK TABLES `qr_scan_logs` WRITE;
/*!40000 ALTER TABLE `qr_scan_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `qr_scan_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_hits`
--

DROP TABLE IF EXISTS `registration_hits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `registration_hits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registration_hits_firm_id_index` (`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_hits`
--

LOCK TABLES `registration_hits` WRITE;
/*!40000 ALTER TABLE `registration_hits` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration_hits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_tokens`
--

DROP TABLE IF EXISTS `registration_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `registration_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `firm_id` bigint(20) unsigned NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registration_tokens_token_unique` (`token`),
  KEY `registration_tokens_firm_id_foreign` (`firm_id`),
  CONSTRAINT `registration_tokens_firm_id_foreign` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_tokens`
--

LOCK TABLES `registration_tokens` WRITE;
/*!40000 ALTER TABLE `registration_tokens` DISABLE KEYS */;
INSERT INTO `registration_tokens` VALUES
(32,'2805f62e-0a57-4d04-9779-9199b982ea30',1,'2026-03-13 13:17:43','2026-02-11 13:17:43','2026-02-11 13:17:43'),
(33,'e77dc8c9-156d-45c7-aff1-eeec5f5768dd',2,'2026-03-16 08:40:32','2026-02-14 08:40:32','2026-02-14 08:40:32');
/*!40000 ALTER TABLE `registration_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security_logs`
--

DROP TABLE IF EXISTS `security_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `security_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `actor_type` varchar(255) NOT NULL,
  `actor_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `target` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_logs`
--

LOCK TABLES `security_logs` WRITE;
/*!40000 ALTER TABLE `security_logs` DISABLE KEYS */;
INSERT INTO `security_logs` VALUES
(1,'system',NULL,'test_log','manual_test','127.0.0.1','tinker','2026-01-21 13:55:04'),
(2,'admin',NULL,'export_consents','firm_id=8','37.225.89.218','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-01-21 13:59:55'),
(3,'admin',NULL,'login_failed','admin_panel','176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-05 18:54:31'),
(4,'admin',NULL,'login_failed','admin_panel','176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-05 18:54:35'),
(5,'firm',1,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 12:39:34'),
(6,'firm',1,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 12:44:29'),
(7,'firm',4,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 18:15:57'),
(8,'firm',4,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 18:16:09'),
(9,'firm',4,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 18:27:20'),
(10,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 19:17:26'),
(11,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 19:18:34'),
(12,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 19:21:32'),
(13,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 19:24:04'),
(14,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-06 19:38:47'),
(15,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-06 21:02:45'),
(16,'firm',1,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-07 14:22:48'),
(17,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-07 16:12:16'),
(18,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-07 19:40:52'),
(19,'firm',1,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36','2026-02-08 10:59:26'),
(20,'firm',1,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-11 11:23:27'),
(21,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 12:47:28'),
(22,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 13:34:30'),
(23,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 13:34:30'),
(24,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 13:34:31'),
(25,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 13:34:31'),
(26,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 13:34:33'),
(27,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 13:34:34'),
(28,'firm',1,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-11 16:27:12'),
(29,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 16:28:00'),
(30,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 16:28:01'),
(31,'firm',18,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-11 16:28:14'),
(32,'firm',5,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-12 08:54:00'),
(33,'admin',NULL,'export_consents','firm_id=19','176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-13 12:34:42'),
(34,'firm',2,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36','2026-02-14 08:40:28'),
(35,'firm',21,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-17 20:00:37'),
(36,'firm',21,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-17 20:00:53'),
(37,'firm',22,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-02-23 16:01:38'),
(38,'firm',1,'add_stamp_manual',NULL,'37.225.93.227','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36','2026-02-26 13:13:14'),
(39,'firm',21,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-28 17:36:26'),
(40,'firm',21,'add_stamp_manual',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-02-28 17:38:44'),
(41,'firm',36,'add_stamp_manual',NULL,'37.225.91.66','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-03-09 13:46:56');
/*!40000 ALTER TABLE `security_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_program_id_foreign` (`program_id`),
  CONSTRAINT `services_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('6B4DAPAeoABYEebcZJw4W3l0QGE4s55zvbFN3x0M',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoibHFVclk2U0FYcWFYVXFOemNzdDFGZkRteHV5YXk5VGtWU3BzaW42ZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbG9vcGx5Lm5ldC5wbC9hZG1pbi9maXJtcyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4uZmlybXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjg6ImFkbWluX29rIjtiOjE7czo1NDoibG9naW5fY29tcGFueV81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1770314306),
('74a8h2TDWuJOjRHIP6VtOaPSsVFARQSSAhfKVj5V',NULL,'185.247.137.29','Mozilla/5.0 (compatible; InternetMeasurement/1.0; +https://internet-measurement.com/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVF5TUFIMnZ5WElzbFVpSTdScU9CSGRWZmdWWGs1eVJNVFJDUW1zcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vNTEuNjguMTM5LjE2MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1770312215),
('iI8krVXx7n5h5F5EzhS3us1Ym8lLm2c931n45CFD',NULL,'193.142.147.209','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQnl1cXhyM05HazNLMVdGRHVWZVRwcVo0ZVRQeUxOMVBVZGhySTcxTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vbG9vcGx5Lm5ldC5wbCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1770313538),
('M3QYHKAfMMup71JPDOwZ9lIjfjOSY7Hhn2bxbZXN',NULL,'193.142.147.209','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnRPS0dGbDhQN1ZVbmxFZnNGbVB3MGJkMlg1Z2FYTzJGM3U1Vk9sVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vbG9vcGx5Lm5ldC5wbCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1770309808),
('Mm7aCxkSBHJIjw4QM324TpcO50Os7ZazrOeP2t4h',NULL,'62.201.244.25','Mozilla/5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUFVOaUJqTzBQbmVhZWRoZEZnM3RiU0JiUjB2cmRIcnRCVU15SW9abyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vbG9vcGx5Lm5ldC5wbCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1770313988),
('pcPUMYPGm4VyqCfLpcCEOO4PwyYuBc3JEE7qpBFh',NULL,'167.99.196.246','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:130.0) Gecko/20100101 Firefox/130.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDUyTU1hOVJySTJ3UTRid1JaTlFPbGZYdmg5MEwxNmJ5ck9wUzJSViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vNTEuNjguMTM5LjE2MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1770310748),
('pKz50QuJj4HsCEhI35L9MRYM3Ce9KoBsW5gMDSQh',NULL,'43.157.38.131','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoidWZxUGxlbWoyR25hbHpES011elBUaWRkUVVwY0pQSWY2N0lzeDdyRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vbG9vcGx5Lm5ldC5wbCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1770311224),
('qJosI3gsuw6Jced69EHHK1LybmgwGiyJSolfZXP3',NULL,'64.225.97.136','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:130.0) Gecko/20100101 Firefox/130.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0V3djNmSzVBaHJhZTNIRnRuRXFFTDFmR1dQNTZzNEpGNlBvRHJVeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vNTEuNjguMTM5LjE2MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1770311118);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_logs`
--

DROP TABLE IF EXISTS `sms_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `provider_message_id` varchar(191) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_logs`
--

LOCK TABLES `sms_logs` WRITE;
/*!40000 ALTER TABLE `sms_logs` DISABLE KEYS */;
INSERT INTO `sms_logs` VALUES
(1,1,24,'48732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-27 19:23:25','2026-02-27 19:23:25'),
(2,1,24,'48732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-27 19:28:14','2026-02-27 19:28:14'),
(3,1,24,'48732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-27 19:29:13','2026-02-27 19:29:13'),
(4,1,24,'48732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-27 19:39:02','2026-02-27 19:39:02'),
(5,2,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-27 22:38:19','2026-02-27 22:38:19'),
(6,1,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-27 22:42:10','2026-02-27 22:42:10'),
(7,1,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-27 22:53:57','2026-02-27 22:53:57'),
(8,35,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-28 21:34:10','2026-02-28 21:34:10'),
(9,35,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-28 21:35:24','2026-02-28 21:35:24'),
(10,35,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-28 21:51:51','2026-02-28 21:51:51'),
(11,35,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-02-28 21:52:36','2026-02-28 21:52:36'),
(12,35,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-03-01 11:09:44','2026-03-01 11:09:44'),
(13,35,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-03-01 11:10:36','2026-03-01 11:10:36'),
(14,36,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-03-01 15:03:20','2026-03-01 15:03:20'),
(15,36,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-03-01 15:17:35','2026-03-01 15:17:35'),
(16,36,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-03-01 15:33:59','2026-03-01 15:33:59'),
(17,36,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-03-02 14:49:20','2026-03-02 14:49:20'),
(18,36,1,'732287103','otp','smsapi',NULL,'sent',NULL,'2026-03-03 13:52:15','2026-03-03 13:52:15'),
(19,36,1,'732287103','otp','smsapi','69A6E5756536311D59592889','sent',NULL,'2026-03-03 14:43:17','2026-03-03 14:43:17'),
(20,36,1,'732287103','pass_issued','smsapi',NULL,'failed','Invalid content encoding! Windows-1250 expected','2026-03-03 16:16:48','2026-03-03 16:16:48'),
(21,36,1,'732287103','wallet_set_password','smsapi','69A6FB60653631CDD7C08544','sent',NULL,'2026-03-03 16:16:48','2026-03-03 16:16:48'),
(22,36,2,'48732287103','pass_issued','smsapi',NULL,'failed','Invalid content encoding! Windows-1250 expected','2026-03-03 16:27:57','2026-03-03 16:27:57'),
(23,36,2,'48732287103','wallet_set_password','smsapi','69A6FDFE6536316140E08DDB','sent',NULL,'2026-03-03 16:27:58','2026-03-03 16:27:58'),
(24,36,1,'48732287103','pass_issued','smsapi',NULL,'failed','Invalid content encoding! Windows-1250 expected','2026-03-03 19:11:41','2026-03-03 19:11:41'),
(25,36,1,'732287103','otp','smsapi','69A772166536313631847439','sent',NULL,'2026-03-04 00:43:18','2026-03-04 00:43:18'),
(26,36,1,'732287103','otp','smsapi','69A773A06536315F26C07BFB','sent',NULL,'2026-03-04 00:49:52','2026-03-04 00:49:52'),
(27,36,1,'732287103','otp','smsapi','69A7D7D76536313662C1B0FE','sent',NULL,'2026-03-04 07:57:27','2026-03-04 07:57:27'),
(28,36,1,'732287103','otp','smsapi','69A7D9F4653631276E17C355','sent',NULL,'2026-03-04 08:06:28','2026-03-04 08:06:28'),
(29,36,1,'732287103','otp','smsapi','69A7DC3965363129D4B2A28F','sent',NULL,'2026-03-04 08:16:09','2026-03-04 08:16:09'),
(30,36,1,'732287103','otp','smsapi','69A7DF176536312ACABD652A','sent',NULL,'2026-03-04 08:28:23','2026-03-04 08:28:23'),
(31,36,1,'732287103','otp','smsapi','69A7E1AD6536312A2601FBD8','sent',NULL,'2026-03-04 08:39:25','2026-03-04 08:39:25'),
(32,36,1,'732287103','otp','smsapi','69A7E26765363129C619F658','sent',NULL,'2026-03-04 08:42:31','2026-03-04 08:42:31'),
(33,36,1,'732287103','otp','smsapi','69A7E41965363129CA24F949','sent',NULL,'2026-03-04 08:49:45','2026-03-04 08:49:45'),
(34,36,1,'732287103','otp','smsapi','69A7E5F76536312A08D328F3','sent',NULL,'2026-03-04 08:57:43','2026-03-04 08:57:43'),
(35,38,6,'48200345876','points_invite','smsapi',NULL,'sent',NULL,'2026-03-09 22:39:41','2026-03-09 22:39:41'),
(36,38,1,'48732287103','points_invite','smsapi',NULL,'sent',NULL,'2026-03-09 22:44:06','2026-03-09 22:44:06'),
(37,38,1,'48732287103','points_invite','smsapi',NULL,'sent',NULL,'2026-03-09 22:53:09','2026-03-09 22:53:09'),
(38,38,1,'48732287103','points_invite','smsapi',NULL,'sent',NULL,'2026-03-09 23:04:52','2026-03-09 23:04:52'),
(39,38,1,'48732287103','points_invite','smsapi',NULL,'sent',NULL,'2026-03-09 23:07:28','2026-03-09 23:07:28'),
(40,38,1,'48732287103','points_invite','smsapi',NULL,'sent',NULL,'2026-03-09 23:19:54','2026-03-09 23:19:54'),
(41,38,1,'48732287103','points_invite','smsapi','69AF481565363176853E4756','sent',NULL,'2026-03-09 23:22:13','2026-03-09 23:22:13'),
(42,38,1,'48732287103','points_invite','smsapi','69AF4D15653631D651FE3510','sent',NULL,'2026-03-09 23:43:33','2026-03-09 23:43:33'),
(43,39,1,'48732287103','points_invite','smsapi','69C29A8D65363157537CB784','sent',NULL,'2026-03-24 15:07:09','2026-03-24 15:07:09'),
(44,39,5,'48799838830','points_invite','smsapi','69C29ABB653631BDF791FDEF','sent',NULL,'2026-03-24 15:07:55','2026-03-24 15:07:55'),
(45,40,1,'48732287103','points_invite','smsapi','69C2E7E2653631312D322A6E','sent',NULL,'2026-03-24 20:37:06','2026-03-24 20:37:06'),
(46,41,9,'4873287103','points_invite','smsapi',NULL,'sent',NULL,'2026-03-26 19:13:26','2026-03-26 19:13:26'),
(47,41,1,'48732287103','points_invite','smsapi','69C5780B653631AC5F6200B7','sent',NULL,'2026-03-26 19:16:43','2026-03-26 19:16:43'),
(48,41,1,'48732287103','points_invite','smsapi','69C57976653631AC5A91233F','sent',NULL,'2026-03-26 19:22:46','2026-03-26 19:22:46'),
(49,42,5,'48799838830','points_invite','smsapi','69C580AA653631AC62F89E33','sent',NULL,'2026-03-26 19:53:30','2026-03-26 19:53:30'),
(50,42,11,'48799038830','points_invite','smsapi','69C584216536312FE9B12752','sent',NULL,'2026-03-26 20:08:17','2026-03-26 20:08:17'),
(51,43,1,'48732287103','points_invite','smsapi','69C62ACC65363129D681FAB6','sent',NULL,'2026-03-27 07:59:24','2026-03-27 07:59:24'),
(52,43,12,'48668406981','points_invite','smsapi','69C656DD6536313D36D028D1','sent',NULL,'2026-03-27 11:07:25','2026-03-27 11:07:25'),
(53,43,13,'48725297330','points_invite','smsapi','69C65FA9653631644118C770','sent',NULL,'2026-03-27 11:44:58','2026-03-27 11:44:58'),
(54,43,18,'48723006601','points_invite','smsapi','69C78BEA653631EDAB93F136','sent',NULL,'2026-03-28 09:06:02','2026-03-28 09:06:02'),
(55,43,19,'48663327749','points_invite','smsapi','69C78D92653631ECF360E94C','sent',NULL,'2026-03-28 09:13:06','2026-03-28 09:13:06'),
(56,43,20,'48500012384','points_invite','smsapi','69C78F48653631EDA5C2796C','sent',NULL,'2026-03-28 09:20:24','2026-03-28 09:20:24'),
(57,43,21,'48665209021','points_invite','smsapi','69C79051653631ECF6A653C3','sent',NULL,'2026-03-28 09:24:49','2026-03-28 09:24:49'),
(58,43,22,'48574965078','points_invite','smsapi','69C79124653631ECB1799A93','sent',NULL,'2026-03-28 09:28:20','2026-03-28 09:28:20'),
(59,43,16,'48889402548','points_invite','smsapi','69C791F7653631EE03F1BF00','sent',NULL,'2026-03-28 09:31:51','2026-03-28 09:31:51'),
(60,43,23,'48534862358','points_invite','smsapi','69C792D06536313887278375','sent',NULL,'2026-03-28 09:35:28','2026-03-28 09:35:28'),
(61,43,25,'48693362359','points_invite','smsapi','69C793CB653631EDF8AFFFDB','sent',NULL,'2026-03-28 09:39:39','2026-03-28 09:39:39'),
(62,43,26,'48508609249','points_invite','smsapi','69C794E7653631ECF18661AB','sent',NULL,'2026-03-28 09:44:23','2026-03-28 09:44:23'),
(63,43,24,'48791993293','points_invite','smsapi','69C795A9653631ECB3A322E1','sent',NULL,'2026-03-28 09:47:37','2026-03-28 09:47:37'),
(64,43,27,'48664699283','points_invite','smsapi','69C797C6653631EDABAD75EE','sent',NULL,'2026-03-28 09:56:38','2026-03-28 09:56:38'),
(65,43,28,'48691530893','points_invite','smsapi','69C79B1265363199AF54CFE2','sent',NULL,'2026-03-28 10:10:42','2026-03-28 10:10:42'),
(66,43,29,'48663644482','points_invite','smsapi','69C79B986536319906E00312','sent',NULL,'2026-03-28 10:12:56','2026-03-28 10:12:56'),
(67,43,30,'48533022442','points_invite','smsapi','69C79C7A65363199BC2FE633','sent',NULL,'2026-03-28 10:16:42','2026-03-28 10:16:42'),
(68,43,31,'48786144316','points_invite','smsapi','69C79EB9653631EDF2483B0E','sent',NULL,'2026-03-28 10:26:17','2026-03-28 10:26:17'),
(69,43,32,'48693736386','points_invite','smsapi','69C7A001653631EE09296547','sent',NULL,'2026-03-28 10:31:45','2026-03-28 10:31:45'),
(70,43,33,'48662808232','points_invite','smsapi','69C7A133653631EDF5DB9D2E','sent',NULL,'2026-03-28 10:36:51','2026-03-28 10:36:51'),
(71,43,34,'48725415458','points_invite','smsapi','69C7A57C653631958B35CD2E','sent',NULL,'2026-03-28 10:55:08','2026-03-28 10:55:08'),
(72,43,35,'48795863806','points_invite','smsapi','69C7A6BA653631986789DAC8','sent',NULL,'2026-03-28 11:00:26','2026-03-28 11:00:26'),
(73,43,37,'48605893629','points_invite','smsapi','69C7A7F665363199E040E688','sent',NULL,'2026-03-28 11:05:42','2026-03-28 11:05:42'),
(74,43,40,'487257305090','points_invite','smsapi',NULL,'sent',NULL,'2026-03-28 11:16:17','2026-03-28 11:16:17'),
(75,43,41,'48510480227','points_invite','smsapi','69C7ACAD653631EDF212C36D','sent',NULL,'2026-03-28 11:25:49','2026-03-28 11:25:49'),
(76,43,42,'48883626822','points_invite','smsapi','69C7AFAC65363199C38179FB','sent',NULL,'2026-03-28 11:38:36','2026-03-28 11:38:36'),
(77,43,39,'48508284757','points_invite','smsapi','69C7B10F653631EE032D92F4','sent',NULL,'2026-03-28 11:44:31','2026-03-28 11:44:31'),
(78,43,38,'48512085655','points_invite','smsapi','69C7B1EF653631387C685C93','sent',NULL,'2026-03-28 11:48:15','2026-03-28 11:48:15'),
(79,43,43,'48504854275','points_invite','smsapi','69C7B5C665363153D943EEB7','sent',NULL,'2026-03-28 12:04:38','2026-03-28 12:04:38'),
(80,43,44,'48883487195','points_invite','smsapi','69C7B62E65363199C4B4E8EF','sent',NULL,'2026-03-28 12:06:22','2026-03-28 12:06:22'),
(81,43,45,'48693059214','points_invite','smsapi','69C7B8E365363199AA8531C1','sent',NULL,'2026-03-28 12:17:55','2026-03-28 12:17:55'),
(82,43,46,'48512064505','points_invite','smsapi','69C7B995653631E4EEA64F94','sent',NULL,'2026-03-28 12:20:53','2026-03-28 12:20:53'),
(83,43,47,'48693870331','points_invite','smsapi','69C7BC7465363153AB234266','sent',NULL,'2026-03-28 12:33:08','2026-03-28 12:33:08'),
(84,43,48,'48698997267','points_invite','smsapi','69C7BF85653631E0F624814D','sent',NULL,'2026-03-28 12:46:13','2026-03-28 12:46:13'),
(85,43,49,'48694677309','points_invite','smsapi','69C7C14065363153A9ADAD53','sent',NULL,'2026-03-28 12:53:36','2026-03-28 12:53:36'),
(86,43,50,'48609747803','points_invite','smsapi','69C7C47C65363179320A9707','sent',NULL,'2026-03-28 13:07:24','2026-03-28 13:07:24'),
(87,43,51,'48507157336','points_invite','smsapi','69C7C5CF65363153DB4A9975','sent',NULL,'2026-03-28 13:13:03','2026-03-28 13:13:03'),
(88,43,52,'48667361672','points_invite','smsapi','69C7C826653631E430514741','sent',NULL,'2026-03-28 13:23:02','2026-03-28 13:23:02'),
(89,43,53,'48609392154','points_invite','smsapi','69C7CD1465363199BC83CD22','sent',NULL,'2026-03-28 13:44:04','2026-03-28 13:44:04'),
(90,43,54,'48690218450','points_invite','smsapi','69C7D6AF65363153161F5957','sent',NULL,'2026-03-28 14:25:03','2026-03-28 14:25:03'),
(91,43,56,'48795073440','points_invite','smsapi','69C7E920653631DB7A308EDF','sent',NULL,'2026-03-28 15:43:44','2026-03-28 15:43:44'),
(92,43,57,'48884802750','points_invite','smsapi','69C7E96965363152784698AB','sent',NULL,'2026-03-28 15:44:57','2026-03-28 15:44:57'),
(93,43,58,'48571808059','points_invite','smsapi','69C7F5FB653631E519DEB84D','sent',NULL,'2026-03-28 16:38:35','2026-03-28 16:38:35'),
(94,43,59,'48507477112','points_invite','smsapi','69C7F6BE65363179169AC7AD','sent',NULL,'2026-03-28 16:41:50','2026-03-28 16:41:50'),
(95,41,1,'48732287103','points_invite','smsapi','69C80D1A65363153164901BB','sent',NULL,'2026-03-28 18:17:14','2026-03-28 18:17:14'),
(96,41,1,'48732287103','points_invite','smsapi','69C80F3865363153136BDD9F','sent',NULL,'2026-03-28 18:26:16','2026-03-28 18:26:16');
/*!40000 ALTER TABLE `sms_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned DEFAULT NULL,
  `program_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `points` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_passes`
--

DROP TABLE IF EXISTS `user_passes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_passes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `firm_id` bigint(20) unsigned NOT NULL,
  `pass_type_id` bigint(20) unsigned NOT NULL,
  `total_entries` int(10) unsigned NOT NULL,
  `remaining_entries` int(10) unsigned NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `activated_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_passes_firm_id_foreign` (`firm_id`),
  KEY `user_passes_pass_type_id_foreign` (`pass_type_id`),
  KEY `user_passes_client_id_firm_id_status_index` (`client_id`,`firm_id`,`status`),
  CONSTRAINT `user_passes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_passes_firm_id_foreign` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_passes_pass_type_id_foreign` FOREIGN KEY (`pass_type_id`) REFERENCES `company_pass_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_passes`
--

LOCK TABLES `user_passes` WRITE;
/*!40000 ALTER TABLE `user_passes` DISABLE KEYS */;
INSERT INTO `user_passes` VALUES
(3,24,1,1,5,4,'active','2026-02-27 18:19:19',NULL,'2026-02-27 18:19:19','2026-02-27 19:39:49'),
(7,25,35,3,10,10,'active','2026-03-01 11:36:17',NULL,'2026-03-01 11:36:17','2026-03-01 11:36:17'),
(13,1,36,5,10,4,'active','2026-03-03 19:11:40',NULL,'2026-03-03 19:11:40','2026-03-04 08:57:58');
/*!40000 ALTER TABLE `user_passes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,NULL,'Damian','admin@firma.pl',NULL,'$2y$12$ICg/zjMZJ3xPbuP5FftrCONiYaf3RH9rgc9Nl3H3.aZ/tMKW2Hj8K',NULL,'2025-12-22 21:16:51','2025-12-22 21:16:51'),
(2,NULL,'Administrator','admin@looply.pl',NULL,'$2y$12$o903UPJfLivrTcq2jmWJpeds9XU6ljfDzgUHnMf0dhj0u5KQNVlba',NULL,'2026-02-28 17:59:48','2026-02-28 17:59:48');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-29 15:42:06

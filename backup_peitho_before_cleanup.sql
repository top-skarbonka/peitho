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
  `points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
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
  CONSTRAINT `clients_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES
(3,NULL,1,'test@test.pl',NULL,'500600700','Tarnobrzeg','39-400',0,NULL,NULL,NULL,1468770,'2025-12-11 21:11:52','2026-01-04 13:26:07','$2y$12$wFmCTvPUaPuFFQfljxbSpOXRBI7nKTIl0493BB7/9geXcNmdShDEK',0,NULL,NULL),
(4,NULL,1,'damianb1988@proton.me',NULL,'732287103','','39-460',0,NULL,NULL,NULL,0,'2025-12-21 21:45:49','2026-01-01 18:35:01','$2y$12$EapTfw.PRGStvNElhVnLx.EGkEARjdk0jUTnvBYCVEGqavctMjOSC',0,NULL,NULL),
(5,NULL,1,'janek12@wp.pl',NULL,'732287104',NULL,'39-460',0,NULL,NULL,NULL,0,'2025-12-22 00:25:22','2025-12-22 00:25:22',NULL,0,NULL,NULL),
(6,NULL,1,'pyrytd@poczta.onet.pl',NULL,'732287105',NULL,'38-460',0,NULL,NULL,NULL,0,'2025-12-22 18:09:35','2025-12-22 18:09:35',NULL,0,NULL,NULL),
(7,NULL,1,'damain1988@wpp.pl',NULL,'654456789',NULL,'39-460',0,NULL,NULL,NULL,0,'2025-12-22 23:28:07','2025-12-22 23:28:07',NULL,0,NULL,NULL),
(8,2,1,'daw@wp.pl',NULL,'765567232',NULL,'39-767',0,NULL,NULL,NULL,0,'2025-12-23 19:08:18','2025-12-23 19:08:18',NULL,0,NULL,NULL),
(10,2,1,'daw@wp.pl',NULL,'765567235',NULL,'39-767',0,NULL,NULL,NULL,0,'2025-12-23 19:18:14','2025-12-23 19:18:14',NULL,0,NULL,NULL),
(12,2,1,'daw@wp.pl',NULL,'765567230',NULL,'39-767',0,NULL,NULL,NULL,0,'2025-12-23 19:56:42','2025-12-23 19:56:42',NULL,0,NULL,NULL),
(13,2,1,'dadsa@wp.pl',NULL,'507976567',NULL,'39-460',0,NULL,NULL,NULL,0,'2025-12-27 12:32:38','2025-12-27 12:32:38',NULL,0,NULL,NULL),
(14,2,1,'daassadsa@wp.pl',NULL,'788790890',NULL,'39-460',0,NULL,NULL,NULL,0,'2025-12-27 12:33:07','2025-12-27 12:33:07',NULL,0,NULL,NULL),
(15,2,1,'daasassadsa@wp.pl',NULL,'799838830',NULL,'39-460',0,NULL,NULL,NULL,0,'2025-12-27 12:58:06','2025-12-27 12:58:06',NULL,0,NULL,NULL),
(16,2,1,'lenovo@wp.pl',NULL,'732297104',NULL,'39-460',0,NULL,NULL,NULL,0,'2025-12-27 13:37:56','2025-12-27 13:37:56',NULL,0,NULL,NULL),
(17,NULL,1,NULL,NULL,'732287110',NULL,NULL,0,NULL,NULL,NULL,0,'2025-12-31 10:49:56','2025-12-31 10:49:56',NULL,0,NULL,NULL),
(18,NULL,1,NULL,NULL,'732287119',NULL,NULL,0,NULL,NULL,NULL,0,'2025-12-31 10:58:48','2025-12-31 10:58:48',NULL,0,NULL,NULL),
(19,NULL,1,NULL,NULL,'732287120',NULL,'',0,NULL,NULL,NULL,0,'2025-12-31 11:06:49','2025-12-31 11:06:49',NULL,0,NULL,NULL),
(20,NULL,1,NULL,NULL,'800838830',NULL,NULL,0,NULL,NULL,NULL,0,'2025-12-31 14:43:29','2025-12-31 14:43:29',NULL,0,NULL,NULL),
(21,NULL,1,NULL,NULL,'400500600',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-04 15:03:32','2026-01-04 15:03:32','$2y$12$bNVYF1suPrp6T5bqQIZmT.1yvCFOAdycApxwNi3RUH4ShzDISQIb2',0,NULL,NULL),
(22,NULL,1,NULL,NULL,'665785395',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-04 20:49:51','2026-01-04 20:49:51','$2y$12$GKp8EtczL6akib3s5IOw9urkjUdJFjlEpZsmI7JstOP.VpKfHNmNW',0,NULL,NULL),
(23,NULL,1,NULL,NULL,'150300450',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-06 16:01:10','2026-01-06 16:01:10','$2y$12$dpTWVEPHXGa0cl9qNQP/0O139/qHQ0jtLBJkI8NRKgbKJUBGvDvfi',0,NULL,NULL),
(24,NULL,1,NULL,NULL,'300200150',NULL,'39-560',0,NULL,NULL,NULL,0,'2026-01-06 19:28:10','2026-01-06 19:28:10','$2y$12$/UYzk3Db.Hy.oVehsfqzVO8yhC29TGMgmNVdX5GMMbApIWuzBscRy',0,NULL,NULL),
(25,NULL,1,NULL,NULL,'245678987',NULL,'39-460',0,NULL,NULL,NULL,0,'2026-01-06 19:37:59','2026-01-06 19:37:59','$2y$12$6dA9QZggwNyErs3TZwBU2OaAmORZrkQa/YPEFjK4xXgCt.E6vjq8u',0,NULL,NULL),
(26,NULL,1,NULL,NULL,'509548908',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-07 18:44:06','2026-01-07 18:44:06','$2y$12$nAzlS5EX8zpyzjG8DYLrXu83BklTL4a1AJL7fsF2eYVtfqBRykbGa',0,NULL,NULL),
(27,NULL,1,NULL,NULL,'500678908',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-07 20:07:36','2026-01-07 20:07:36','$2y$12$SwhZD0tRp.g1YgGsNYv/rux2LHPgYLahKTPfKTwDsY50DYLoJpk.O',0,NULL,NULL),
(28,NULL,1,NULL,NULL,'100200309',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-08 01:07:02','2026-01-08 01:07:02','$2y$12$uphP3PxRc0Cl4nUvXwiyKeLSi.aK5ZO37xhIGyr1I7g6OBMIZhPgi',0,NULL,NULL),
(29,NULL,1,NULL,NULL,'132098899',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-08 09:49:35','2026-01-08 09:49:35','$2y$12$wM0dTRcSzkm8OUO39TJFjOR/08dzlEcmzU8YhSUaJXDGp3KxPKKOq',0,NULL,NULL),
(30,11,1,NULL,NULL,'123456789',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-08 21:13:36','2026-01-08 21:13:36','$2y$12$AtHdwcQG4S/DmDtjaQW/9.Vnh6uucuoi17SdFM5zWDJH2nAEqtBWe',0,NULL,NULL),
(31,1,1,NULL,NULL,'100200300',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-08 22:16:17','2026-01-08 22:16:17','$2y$12$I8vCAiuy3ssFyT.Nt0WHnezRu484n8plBhoDpaZECW/8.j6V/Rdre',0,NULL,NULL),
(33,15,1,NULL,NULL,'100200304',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-08 22:38:58','2026-01-08 22:38:58','$2y$12$cVU0zqjQMbxHSL3lsRHCM.xSupYBZSp6PQaY7mgbHrLGsoFniixo6',0,NULL,NULL),
(35,16,1,NULL,NULL,'101201301',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-15 18:49:35','2026-01-15 18:49:35','$2y$12$zNCCW/7I6.33cPLCuJn8Tu8T4R24yOB/lG5EnYoBbnR8a3SoK823O',0,NULL,NULL),
(36,16,1,NULL,NULL,'103104105',NULL,'39-460',0,NULL,NULL,NULL,0,'2026-01-15 22:51:56','2026-01-15 22:51:56','$2y$12$kFquHPQMMIlAyou1L5toI.zerRK4eMCJ2j0W9gsb1PYwdzla08ace',0,NULL,NULL),
(37,16,1,NULL,NULL,'150160170',NULL,'39-460',0,NULL,NULL,NULL,0,'2026-01-20 18:50:40','2026-01-20 18:50:40','$2y$12$Z6AYJ5Yx11TFy..ks9RFfe15Sc8q26ZWmfLjj9tv2Y3N7g4VRtEgu',0,NULL,NULL),
(38,16,1,NULL,NULL,'200300400',NULL,'39-460',0,NULL,NULL,NULL,0,'2026-01-20 19:51:45','2026-01-20 19:51:45','$2y$12$IUMvlRhdNLEtMbbxNgl5wuGbtMZ2Du09iaSdQb7JUtVqm2zA5olX2',0,NULL,NULL),
(39,16,1,NULL,'Janek','900800710',NULL,'39-460',0,NULL,NULL,'2026-01-20 21:14:22',0,'2026-01-20 21:14:22','2026-01-20 21:14:22','$2y$12$iqgm941VOxj1FsJ0rjwkVONL9qWo8h604G9JKgF4osfulevYhzY5a',0,NULL,NULL),
(40,16,1,NULL,NULL,'987765543',NULL,'39-456',0,NULL,NULL,NULL,0,'2026-01-20 21:21:41','2026-01-20 21:21:41','$2y$12$DTlla/hIo5E7IC/snMmxQeawCl1gYKdnuwN17Y1JX5f02BWmCu.dC',0,NULL,NULL),
(41,16,1,NULL,NULL,'098890987',NULL,'39-360',0,NULL,NULL,NULL,0,'2026-01-20 21:25:18','2026-01-20 21:25:18','$2y$12$.IxUSiiKnJX4Fw3idD7BIeb9f6ilLKuumoNx17KAHOYeqoVcH9kuq',0,NULL,NULL),
(42,16,1,NULL,NULL,'234532543',NULL,'39-460',0,NULL,NULL,NULL,0,'2026-01-20 21:33:40','2026-01-20 21:33:40','$2y$12$./k4sX12tP4VqyqR3pcjkuLv4pVO4Dc2e8wCm9NGa3QvtPyBC6OVe',0,NULL,NULL),
(43,16,1,NULL,NULL,'565432156',NULL,'39-450',0,NULL,NULL,NULL,0,'2026-01-20 21:54:10','2026-01-20 21:54:10','$2y$12$jsszVrzgDWLvmsNDzbA9e.C.AwF9LClieaGGJyJKaRLYhCaCceeKW',0,NULL,NULL),
(44,16,1,NULL,NULL,'5890098',NULL,'39-988',0,NULL,NULL,NULL,0,'2026-01-20 21:55:15','2026-01-20 21:55:15','$2y$12$I6/xiZ67FbuKiHbKSQsa/.Itcd.Llw3You8mUTgtCSv3fxbSE6op.',0,NULL,NULL),
(45,16,1,NULL,NULL,'678909654',NULL,'39-461',0,NULL,NULL,NULL,0,'2026-01-20 22:00:17','2026-01-20 22:00:17','$2y$12$twkKfN7kZmKvmg1.aBGVZOEL.c.ZMHLMg.11GPrdYEePw6MZVpMyi',0,NULL,NULL),
(46,16,1,NULL,NULL,'456765432',NULL,'39-456',0,NULL,NULL,NULL,0,'2026-01-20 22:04:00','2026-01-20 22:04:00','$2y$12$uOOlzrJNFhsHVg19Cx1YLOMvElLAG2X8ep0sOFM/locodbLNTMbZe',0,NULL,NULL),
(47,16,1,NULL,NULL,'q09876678',NULL,'39-560',0,NULL,NULL,NULL,0,'2026-01-20 22:04:32','2026-01-20 22:04:32','$2y$12$SOEG9sDl1oc1SSjAyA2o3OdaRQbQQGdDIA2YUbjRXKLtULH8P3gpq',0,NULL,NULL),
(48,16,1,NULL,NULL,'000000000',NULL,'39-567',0,NULL,NULL,NULL,0,'2026-01-20 22:05:48','2026-01-20 22:05:48','$2y$12$Adk4BaPyuetl3xAykpv8Juv1kQtBi4UOEZIgp1VhU04FtDV4viGu.',0,NULL,NULL),
(49,16,1,NULL,NULL,'999999999',NULL,'39-678',0,NULL,NULL,NULL,0,'2026-01-20 22:06:09','2026-01-20 22:06:09','$2y$12$Kp6/S60UCZDOHQ.nHeixBe7i.aBjtv56CsRv/YOfvFzSZf12PhxXe',0,NULL,NULL),
(50,16,1,NULL,NULL,'567765432',NULL,NULL,0,NULL,NULL,NULL,0,'2026-01-20 22:19:38','2026-01-20 22:19:38','$2y$12$2gTlP/qP/Y1TY4Y1pN6RAeEPTDfxym.VZ5r8ag5TXa/gJFbT1SNGC',0,NULL,NULL),
(51,16,1,NULL,NULL,'098765567',NULL,'39-430',0,NULL,NULL,NULL,0,'2026-01-20 22:20:14','2026-01-20 22:20:14','$2y$12$.ja63xhagAW9hHogZQJ8w.b.FMl.lmw/GfMlrUG0jiBQD5IiKFjhC',0,NULL,NULL),
(52,16,1,NULL,NULL,'200100900',NULL,'39-462',1,'2026-01-20 22:33:30',NULL,NULL,0,'2026-01-20 22:33:30','2026-01-20 22:33:30','$2y$12$Y9Pk/mcXZxKyR7AlZHzGr.y2rSIvzlrBwG4EYnYhWa.eSCw6zj7gO',0,NULL,NULL),
(53,16,1,NULL,NULL,'100900100',NULL,NULL,1,'2026-01-20 22:33:52',NULL,NULL,0,'2026-01-20 22:33:53','2026-01-20 22:33:53','$2y$12$MIoLYaVT9mF2d5CrFWeBtuTrXQJWmr7oY/4R14OP94oW7a92.XJKC',0,NULL,NULL),
(54,16,1,NULL,NULL,'503653783',NULL,NULL,1,'2026-01-20 22:36:26',NULL,'2026-01-20 22:36:26',0,'2026-01-20 22:36:26','2026-01-20 22:36:26','$2y$12$RL0nNeM/webYBcFXTCqK4eimVBx17hr6cOM9n4UXnjR48TkTCHBti',0,NULL,NULL),
(55,16,1,NULL,'Damianek','900800700',NULL,NULL,1,'2026-01-22 14:33:17',NULL,'2026-01-22 14:33:17',0,'2026-01-22 14:33:18','2026-01-22 14:33:18','$2y$12$gQe5oV8HtkRVyavauKfscuTSk/YzQ8ZOrCFRr3uwT86xgAwVEOFye',0,NULL,NULL),
(56,17,1,NULL,'Damian','011022033',NULL,'39-460',1,'2026-01-27 11:15:55',NULL,'2026-01-27 11:15:55',0,'2026-01-27 11:15:55','2026-01-27 11:15:55','$2y$12$BkhVKEG4MpGx/hPGiT6Lu.LdUfWuCXfG4VX0692Z1Sv5OmaqBEY5u',0,NULL,NULL),
(57,17,1,NULL,NULL,'123654234',NULL,NULL,1,'2026-01-27 11:28:55',NULL,'2026-01-27 11:28:55',0,'2026-01-27 11:28:55','2026-01-27 11:28:55','$2y$12$.JWXyDIhAifa7uHxkLv6.e8.uX9gUtjLYSZSaqTlwheUa.8MdxsG2',0,NULL,NULL),
(60,22,1,NULL,'gowno chuj','012345678',NULL,'39-460',1,'2026-01-27 23:39:05',NULL,'2026-01-27 23:39:05',0,'2026-01-27 23:39:05','2026-01-27 23:39:05','$2y$12$GRFqyzo22Ul.8cY2Te61..NoEudnGVlBwwAZ8iLuxUVrLSRPKD1iK',0,NULL,NULL),
(61,22,1,NULL,'pcelak','654567981',NULL,'39-460',1,'2026-01-28 09:11:01',NULL,'2026-01-28 09:11:01',0,'2026-01-28 09:11:01','2026-01-28 09:11:01','$2y$12$TV3G48Sy8UJgPQSJ3CZv8eVrO6ZjIEaxG8mnvWdRYFZ/BbmCvVetC',0,NULL,NULL),
(62,23,1,NULL,'Damian','732287103',NULL,'39-460',1,'2026-01-28 14:19:32',NULL,'2026-01-28 14:19:32',0,'2026-01-28 14:19:32','2026-01-28 14:19:32','$2y$12$nr8Sie4bHAJwMtaazBueiedqd/0WuuuScdoor8tMF1Mr4K8fpn9CG',0,NULL,NULL),
(63,23,1,NULL,NULL,'732287104',NULL,'39-460',1,'2026-01-28 16:50:00',NULL,'2026-01-28 16:50:00',0,'2026-01-28 16:50:00','2026-01-28 16:50:00','$2y$12$e63vpRx1jK0jtHpTTFOtvOMYLFUHQuMiG19SfCv//ew2b.qLV/v0u',0,NULL,NULL),
(64,24,1,NULL,'dmian','1234567765',NULL,'39-469',1,'2026-01-28 18:45:27',NULL,'2026-01-28 18:45:27',0,'2026-01-28 18:45:28','2026-01-28 18:45:28','$2y$12$9tPSR/Dx/ZvuItPbIGFsheMDALZitHOo07ctkTAUdUI0vFSduFbNe',0,NULL,NULL),
(65,26,1,NULL,'Dominika','799838831',NULL,'89-098',1,'2026-01-28 20:24:39',NULL,'2026-01-28 20:24:39',0,'2026-01-28 20:24:39','2026-01-28 20:24:39','$2y$12$a1mof4wfPKnvFu2nmfsUhuJn0a0a/MlUOvbR7uZPf8juEH9uOb1eq',0,NULL,NULL),
(66,25,1,NULL,'sdosjo','8274398729',NULL,'39-460',1,'2026-01-28 20:26:41',NULL,'2026-01-28 20:26:41',0,'2026-01-28 20:26:41','2026-01-28 20:26:41','$2y$12$FEThxRGkc4dpc/F/wk43q.ToZpkNIPFPMAVUyBJdWFhNwtRMcwIuG',0,NULL,NULL),
(67,24,1,NULL,'ojfoisdjfsoi','8127642783628',NULL,'91892',1,'2026-01-28 20:27:30',NULL,'2026-01-28 20:27:30',0,'2026-01-28 20:27:30','2026-01-28 20:27:30','$2y$12$iIJNjKSNi3gIbUN0/xzI.e5RKJHgsKzMB5WSsVT.MgTod7E4VV6yy',0,NULL,NULL),
(68,27,1,NULL,'Damianek','321234654',NULL,NULL,1,'2026-02-02 21:50:32',NULL,'2026-02-02 21:50:32',0,'2026-02-02 21:50:32','2026-02-02 21:50:32','$2y$12$MSuAEldGGuVquv7k8l5YyuQcuip8x375rqDECxYJrV8mSL5Yf7XV2',0,NULL,NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
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
  `slug` varchar(255) NOT NULL,
  `card_template` varchar(255) NOT NULL DEFAULT 'classic',
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `google_review_url` varchar(255) DEFAULT NULL,
  `google_url` varchar(255) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `firms_slug_unique` (`slug`),
  UNIQUE KEY `firms_registration_token_unique` (`registration_token`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `firms`
--

LOCK TABLES `firms` WRITE;
/*!40000 ALTER TABLE `firms` DISABLE KEYS */;
INSERT INTO `firms` VALUES
(1,'damian-1','gold',NULL,NULL,NULL,NULL,NULL,'firm_1','7c55a0ca-01a2-4d0d-80b1-ef092ff4f6cd','damian',NULL,'$2y$12$FBKrSovm8buKX74jtLCwd.yvkP4AVW/f41tdlDREQge1GY6/FPErq',NULL,1,10,0,'2025-12-11 21:38:51','2026-01-29 18:58:24','2026-01-29 18:58:24',NULL,NULL,NULL,NULL,NULL),
(2,'market-reklamy-2','classic',NULL,NULL,NULL,NULL,NULL,'firm_2','ffa18028-0226-40e4-b035-6f53ade52ee9','Market Reklamy','damianb1988@wp.pl','$2y$12$PTRwaEz1B9vaXZ3ZDXq7B.UFQYjsalFeoPhB8KOoiOtXcKu5b3iXC',NULL,1,10,0,'2025-12-22 23:04:54','2026-01-29 18:58:24','2026-01-29 18:58:24','Nowa Dęba','Jana Pawła II','39-460','8141685116','732287103'),
(3,'kwiaciarnia-3','classic',NULL,NULL,NULL,NULL,NULL,'firm_3','f91d28cd-05b6-43e3-889f-ec7f5e8987af','Kwiaciarnia','damian1988@wp.pl','$2y$12$R9jleSDQAv1ibY3mUNULCuLWtTDP9UDtNQtdUqvaUqbowsMF.nXhW',NULL,1,10,0,'2025-12-22 23:16:30','2026-01-29 18:58:24','2026-01-29 18:58:24','Majdan Królewski','rzeszowska 1','39-110','8672161216','732287106'),
(4,'test-4','classic',NULL,NULL,NULL,NULL,NULL,'firm_4','dc61c9b2-f3b4-483f-bfa3-74740e059c1a','test','wawsdh@w.ppl','$2y$12$IT4f13lxmOsT7TaAV1Fb0ev337WxDhD0zbVFulTWLdTJHrVFnD472',NULL,1,10,0,'2025-12-28 16:23:44','2026-01-29 18:58:24','2026-01-29 18:58:24',NULL,NULL,NULL,NULL,NULL),
(5,'market-reklamy-5','classic',NULL,NULL,NULL,NULL,NULL,'firm_5','20c09191-48d7-443e-94c1-64e97cfcd2ea','Market Reklamy','damianb@proton.me','$2y$12$9lqjcViBYw4NlWtslg7VIupYwIjqaqVWXE8bsnwfcr0n8Rj/tuG5O',NULL,1,10,0,'2025-12-28 16:36:51','2026-01-29 18:58:24','2026-01-29 18:58:24','nowa deba','adsdasd. 31','39-980','8217887654','732 287104'),
(6,'ble-ble-ble-6','classic',NULL,NULL,NULL,NULL,NULL,'ble-ble-ble-3416','28a37133-b19c-4928-96b4-6507fc4328d5','ble ble ble','dasdja@wp.pl','$2y$12$DMBR8lZnNFC6oMEVTEg3VOfvHmNqrSQT.V7u7oHDvaoRlS.RCOUKS',NULL,1,10,0,'2025-12-29 17:39:52','2026-01-29 18:58:24','2026-01-29 18:58:24','bu bu bu','bu 72','39-360','8766752436','654456721'),
(7,'ghyv-7','classic',NULL,NULL,NULL,NULL,NULL,'ghyv-2603','8dc863af-1897-4009-a579-b03b04ccad91','ghyv','we@wp.pl','$2y$12$sn0gjmA.KldSw6XvgcFbaO9gbZjFZH.nSTz0C/FRB/r3l6QY0m2cq',NULL,1,10,0,'2025-12-30 14:59:40','2026-01-29 18:58:24','2026-01-29 18:58:24','jbkjb','kjb','47-789','65676','7656567898'),
(8,'centrum-oplat-8','classic',NULL,NULL,NULL,NULL,NULL,'centrum-oplat-8048','41405db4-3783-4346-83a4-f0b3b0144696','Centrum Opłat','oplaty@nowadeba.eu','$2y$12$RqzZiBezByQeoCCKuWkxde6gockl01zG9HqrG.Bj8v8n676kyNHwu',NULL,1,10,0,'2026-01-04 13:50:04','2026-01-29 18:58:24','2026-01-29 18:58:24','Nowa Dęba','Zwycięstwa 1a','39-460','8141685116','799838830'),
(9,'das-9','classic',NULL,NULL,NULL,NULL,NULL,'das-3661','1faa0ec9-6c11-4572-af4c-d343093bc4a6','das','dasd@wp.pl','$2y$12$.exi9aIZH5G/EJFJIY6i0.2oNwrYx6.iH4PX7qQo8YArzOssUQDGC',NULL,1,10,0,'2026-01-06 13:52:36','2026-01-29 18:58:24','2026-01-29 18:58:24','asda','dasc','39-460','876543234','768009232'),
(10,'loopy-1-695e9aa7417b4','classic',NULL,NULL,NULL,NULL,NULL,'loopy-1-9947','7ed5c6f4-c20d-42b1-a589-34e10e904016','LOOPY 1','LO@wp.pl','$2y$12$b8qhGOA.K.18NopqXxDAZOA89imfJ7RrzO8hrKkE92L2rRFuJqa5a',NULL,1,10,0,'2026-01-07 18:40:55','2026-01-29 18:58:24','2026-01-29 18:58:24','nowa','deba','39-460',NULL,'743567876'),
(11,'loopytest-695e9adeb912c','gold',NULL,NULL,NULL,NULL,NULL,'loopytest-5762','2db05495-79fd-423c-9347-135992d6f66f','LOOPYtest','LO@wp.pl','$2y$12$XypdgDLZUJ1TiM37OB9wMuisHUYlkouVLTXR4In4hVN65nBeQdMxa',NULL,1,10,0,'2026-01-07 18:41:51','2026-01-29 18:58:24','2026-01-29 18:58:24','nowa','deba','39-460',NULL,'743567876'),
(12,'loopy-test-695eae37032dc','modern','https://www.instagram.com/','https://www.facebook.com/',NULL,NULL,NULL,'loopy-test-2456','bb03fe9a-ba0f-48de-9e8b-96282fea4acf','Loopy test','test@wp.pl','$2y$12$/NdAkiinZhsmz4lEXB43P.l.RdwVEzcCIWwZEn6X87MERVoGwe0U2',NULL,1,10,0,'2026-01-07 20:04:23','2026-01-29 18:58:24','2026-01-29 18:58:24','Nowa Dęba ul. Kościuszki 12/24','Nowa Dęba ul. Kościuszki 12/24','48-098',NULL,'656786675'),
(13,'loopy-9490','classic','https://www.facebook.com/','https://www.instagram.com/',NULL,NULL,NULL,'loopy-9490','8910f452-4b5c-44f7-a6a5-c52e9c446b01','loopy','JK@WP.PL','$2y$12$0rQYcBKqTixX5dugvoi0pu16JXcU2rCf6CxFOVs11D/MAqpOl.CUG',NULL,1,10,0,'2026-01-08 01:05:26','2026-01-29 18:58:24','2026-01-29 18:58:24','Alfredówka 191','Nowa Dęba','39-460',NULL,'767898765'),
(14,'loopytest-6641','classic','https://www.facebook.com/','https://www.instagram.com/',NULL,NULL,NULL,'loopytest-6641','8c3b52fd-32e7-4504-9bde-98ca5e773868','loopytest','loppytest@wp.pl','$2y$12$gVRhcAfX0IDV3gySSJ9iAu89AjFKoJ4F2yiOcSgKNq6R26oXFkLDW',NULL,1,10,0,'2026-01-08 01:31:39','2026-01-29 18:58:24','2026-01-29 18:58:24','Alfredówka 191','Nowa Dęba','39-460',NULL,'767898761'),
(15,'loopynow-5987','classic','https://www.facebook.com/','https://www.instagram.com/',NULL,NULL,NULL,'loopynow-5987',NULL,'Loopynow','loopy@wp.pl','$2y$12$OQdgPr97TShjqyzXbcSiIORA9LD8e5ECPbo8U2dPzpa6XsbEsxuLm',NULL,1,10,0,'2026-01-08 22:35:41','2026-01-29 18:58:24','2026-01-29 18:58:24','Alfredowka','Alfredowka','39-460',NULL,'765567876'),
(16,'dreamy-3112','classic','https://www.facebook.pl','https://www.instagram.pl',NULL,'https://www.example-client.pl',NULL,'dreamy-3112',NULL,'Dreamy','dre@wp.pl','$2y$12$xRq.CBILwwFxyy2gEWNYNOSTxrPjEiT/LFvmzu1YD7luAvi2m9p0C',NULL,1,10,0,'2026-01-15 18:21:20','2026-01-29 18:58:24','2026-01-29 18:58:24','asjksdkajs','daksdjalks','39-460',NULL,'190876254'),
(17,'xyz-7307','florist',NULL,NULL,NULL,'https://www.facebook.com/photo/?fbid=122102127813187518&set=a.122102119305187518','logos/cBgDiBKkI2GAKVQ3paIUw2PSQQ62trXkAf7J1Ywu.jpg','xyz-7307',NULL,'Decor styl','xyz@wp.pl','$2y$12$G5J0YIqSR2NlxX/TfNXVLupxR5/gLwsImhbkChQPW6kSLEEFobnyO',NULL,1,10,0,'2026-01-27 11:14:09','2026-01-29 18:58:24','2026-01-29 18:58:24','Nowa Dęba','Nowa Dęba','39-460',NULL,'011022033'),
(18,'test-ostatezny-5296','florist',NULL,NULL,NULL,NULL,NULL,'test-ostatezny-5296',NULL,'test ostatezny','kontakt@market-reklamy.pl','$2y$12$/InrJ37tQ7g3I.sR6fR2tOcoI/0AHdC/aubjkrfLjhgkP8eitRrwG',NULL,1,10,0,'2026-01-27 19:49:17','2026-01-29 18:58:24','2026-01-29 18:58:24','alfa','alfa','39-460',NULL,'789987765'),
(19,'damian-bielen-7761','florist',NULL,NULL,NULL,NULL,NULL,'damian-bielen-7761',NULL,'Damian Bielen','kontakt@market-reklamy.pl','$2y$12$.wZrObX/5qYIFAJkOQkMeuRlVVYTbiPZ2/8Cf5iF3Qr3OpkTnCxoW',NULL,1,10,0,'2026-01-27 20:05:00','2026-01-29 18:58:24','2026-01-29 18:58:24','nd','alfa','39-987',NULL,'123456789'),
(20,'damian-bielen-1-2186','florist',NULL,NULL,NULL,NULL,NULL,'damian-bielen-1-2186',NULL,'Damian Bielen 1','kontakt@market-reklamy.pl','$2y$12$67urat7pQCL0IPaT7349FOv8NrUQk2HoNrZYU5k9CrPrQ4UR08mHS',NULL,1,10,0,'2026-01-27 20:09:12','2026-01-29 18:58:24','2026-01-29 18:58:24','nd','alfa','39-987',NULL,'123456789'),
(21,'dominika-bielen-6629','florist',NULL,NULL,NULL,NULL,NULL,'dominika-bielen-6629',NULL,'Dominika Bielen','kontakt@markt-reklamy.pl','$2y$12$5s.Cjg3IuJzKcT8iIqEU6OQshqKNCdjzsj4gK3A.3Y84v9D5WPz8i',NULL,1,10,0,'2026-01-27 20:20:46','2026-01-29 18:58:24','2026-01-29 18:58:24','s','s','s',NULL,'987678876'),
(22,'dominika-bielen-5815','florist',NULL,NULL,NULL,NULL,NULL,'dominika-bielen-5815',NULL,'Dominika Bielen','kontakt@market-reklamy.pl','$2y$12$Pzo6uYXaGpvhfpJmSGGJmu7gZGBN7lmP3QEq/gyyQjZsa6bBN.oPK','2026-01-27 22:42:05',1,10,0,'2026-01-27 20:21:26','2026-01-29 18:58:24','2026-01-29 18:58:24','s','s','s',NULL,'987678876'),
(23,'artystyczny-dekorstyl-3404','florist',NULL,NULL,NULL,NULL,NULL,'artystyczny-dekorstyl-3404',NULL,'Artystyczny DekorStyl','kontakt@market-reklamy.pl','$2y$12$fynWHrkno8VrmTBOiHmi7OsVxffaWH5FWeDmeNM54C8zkOximZRYy','2026-01-28 15:14:59',1,10,0,'2026-01-28 13:59:28','2026-01-29 18:58:24','2026-01-29 18:58:24','Majdan Królewski','Krzątka','36-110',NULL,'876123432'),
(24,'dmian-3946','florist',NULL,NULL,NULL,NULL,NULL,'dmian-3946',NULL,'dmian','kontakt@wp.pl','$2y$12$3qfvM6SDu5eNomkuoOYAau8zQxaDjkCX9.ECQcDshn5KI5aGDxzIq',NULL,1,10,0,'2026-01-28 18:32:04','2026-01-29 18:58:24','2026-01-29 18:58:24','a','b','39-460',NULL,'732987103'),
(25,'maja-6300','florist',NULL,NULL,NULL,NULL,NULL,'maja-6300',NULL,'maja','sadas@wp.pl','$2y$12$V2nWTNR1o7nCHzd/xh0bq.2y8yoe1vO08D29VTMOJ6iqdGVyGC5qO',NULL,1,10,0,'2026-01-28 20:21:57','2026-01-29 18:58:24','2026-01-29 18:58:24','1','2','w',NULL,'765667765'),
(26,'sassa-5710','florist',NULL,NULL,NULL,NULL,NULL,'sassa-5710',NULL,'sassa','kontakt@market-reklamy.pl','$2y$12$bUI4l0TFz5Xpl/gz4lV0outAo6rr3mBX01dETTLihFOU2DrH8EFpa',NULL,1,10,0,'2026-01-28 20:22:35','2026-01-29 18:58:24','2026-01-29 18:58:24','a','a','a',NULL,'76556765'),
(27,'dam-1978','florist',NULL,NULL,NULL,NULL,NULL,'dam-1978',NULL,'dam','wp@wp.pl','$2y$12$FW0nKLujRHYLITAb8vj9DOsuH34hEodQZ5nG.fu7U9ekIoEECK5Ry',NULL,1,10,0,'2026-01-29 17:01:35','2026-01-29 18:58:24','2026-01-29 18:58:24','3','3','34-456',NULL,'83972834');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `loyalty_cards_qr_token_unique` (`qr_token`),
  UNIQUE KEY `firm_phone_unique` (`firm_id`,`phone`),
  KEY `loyalty_cards_program_id_foreign` (`program_id`),
  KEY `loyalty_cards_client_id_foreign` (`client_id`),
  KEY `loyalty_cards_firm_id_index` (`firm_id`),
  KEY `loyalty_cards_phone_index` (`phone`),
  CONSTRAINT `loyalty_cards_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loyalty_cards_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loyalty_cards`
--

LOCK TABLES `loyalty_cards` WRITE;
/*!40000 ALTER TABLE `loyalty_cards` DISABLE KEYS */;
INSERT INTO `loyalty_cards` VALUES
(1,5,1,3,10,10,NULL,'redeemed',NULL,'2025-12-15 19:21:27','2025-12-27 15:21:41','732287104',NULL,NULL,NULL,NULL,NULL),
(2,NULL,1,4,10,2,NULL,'active',NULL,'2025-12-21 21:53:58','2025-12-21 22:53:08',NULL,NULL,NULL,NULL,NULL,NULL),
(3,NULL,1,5,10,10,NULL,'redeemed',NULL,'2025-12-22 00:25:22','2025-12-22 18:18:31',NULL,NULL,NULL,NULL,NULL,NULL),
(4,NULL,1,6,10,0,NULL,'active',NULL,'2025-12-22 18:09:35','2025-12-22 18:09:35',NULL,NULL,NULL,NULL,NULL,NULL),
(5,NULL,1,7,10,0,NULL,'active',NULL,'2025-12-22 23:28:07','2025-12-22 23:28:07',NULL,NULL,NULL,NULL,NULL,NULL),
(7,2,1,13,10,0,'Gratis','active',NULL,'2025-12-27 12:32:38','2025-12-27 12:32:38','507976567','dadsa@wp.pl','39-460','$2y$12$EmnFYGk3cIYjr1ekZGmtvOP8AnDflb4dhinHvG6miy.UF.0AWrBdO','c1166173-1172-4fc9-9946-991b93127bb7',NULL),
(8,2,1,14,10,0,'Gratis','active',NULL,'2025-12-27 12:33:08','2025-12-27 12:33:08','788790890','daassadsa@wp.pl','39-460','$2y$12$wHgBWeKeyBAmO6Vaf8kNTuudag13B3UYEpySG/Lk9uEvSZqtI1DSC','82e15baa-814c-43cc-93c2-145ae9ca5510',NULL),
(9,2,1,15,10,0,'Gratis','active',NULL,'2025-12-27 12:58:06','2025-12-27 12:58:06','799838830','daasassadsa@wp.pl','39-460','$2y$12$D5izjaPFKV7fq8c40yf87..OfZq1YL3WmG/tRyuk01jvPG0C5Mqmm','011a8c0c-7caf-40b4-836c-96464c32129a',NULL),
(10,2,1,16,10,0,'Gratis','active',NULL,'2025-12-27 13:37:56','2025-12-27 13:37:56','732297104','lenovo@wp.pl','39-460','$2y$12$oAzIUfcVPCFOGmkx2uBHS.CAKK/QcF29Onm2cXTebKu4pDhn7CANC','48e09494-a45c-4f6d-8c8b-f043c87a19c2',NULL),
(11,NULL,1,17,10,0,NULL,'active','d011a43f-2526-4a3c-beff-3835313e569c','2025-12-31 10:54:17','2025-12-31 10:54:17',NULL,NULL,NULL,NULL,NULL,NULL),
(12,NULL,1,18,10,0,NULL,'active',NULL,'2025-12-31 10:58:48','2025-12-31 10:58:48',NULL,NULL,NULL,NULL,NULL,NULL),
(13,NULL,1,19,10,0,NULL,'active','24b192e4-cebd-4045-a17b-848592863970','2025-12-31 11:06:49','2025-12-31 11:06:49',NULL,NULL,NULL,NULL,NULL,NULL),
(14,NULL,1,20,10,0,NULL,'active','c1e354cd-60ca-47f3-b6f9-ec16470ee337','2025-12-31 14:43:29','2025-12-31 14:43:29',NULL,NULL,NULL,NULL,NULL,NULL),
(15,NULL,1,20,10,0,NULL,'active','43e3b6c7-9f8f-4f8d-9c36-a8fcc3606107','2025-12-31 14:44:29','2025-12-31 14:44:29',NULL,NULL,NULL,NULL,NULL,NULL),
(16,7,NULL,4,10,5,NULL,'active',NULL,'2026-01-01 18:39:26','2026-01-01 22:37:54',NULL,NULL,NULL,NULL,NULL,NULL),
(17,7,NULL,15,10,1,NULL,'active',NULL,'2026-01-01 22:54:25','2026-01-01 22:58:52',NULL,NULL,NULL,NULL,NULL,NULL),
(18,8,NULL,21,10,1,NULL,'active',NULL,'2026-01-04 15:03:32','2026-01-04 15:11:06',NULL,NULL,NULL,NULL,NULL,NULL),
(19,8,NULL,22,10,3,NULL,'active',NULL,'2026-01-04 20:49:51','2026-01-05 16:10:53',NULL,NULL,NULL,NULL,NULL,NULL),
(20,9,NULL,23,10,0,NULL,'active',NULL,'2026-01-06 16:01:10','2026-01-06 16:01:10',NULL,NULL,NULL,NULL,NULL,NULL),
(21,1,NULL,24,10,1,NULL,'active',NULL,'2026-01-06 19:28:10','2026-01-08 22:24:47',NULL,NULL,NULL,NULL,NULL,NULL),
(22,9,NULL,25,10,1,NULL,'active',NULL,'2026-01-06 19:37:59','2026-01-06 19:38:06',NULL,NULL,NULL,NULL,NULL,NULL),
(23,11,NULL,26,10,10,NULL,'active',NULL,'2026-01-07 18:44:06','2026-02-01 17:52:52',NULL,NULL,NULL,NULL,NULL,NULL),
(24,12,NULL,27,10,10,NULL,'completed',NULL,'2026-01-07 20:07:36','2026-01-07 21:05:51',NULL,NULL,NULL,NULL,NULL,NULL),
(25,13,NULL,28,10,1,NULL,'active',NULL,'2026-01-08 01:07:02','2026-01-08 01:07:14',NULL,NULL,NULL,NULL,NULL,NULL),
(26,14,NULL,23,10,9,NULL,'active',NULL,'2026-01-08 01:33:59','2026-01-08 01:35:05',NULL,NULL,NULL,NULL,NULL,NULL),
(27,11,NULL,29,10,1,NULL,'active',NULL,'2026-01-08 09:49:35','2026-02-01 17:52:56',NULL,NULL,NULL,NULL,NULL,NULL),
(28,1,NULL,31,10,1,NULL,'active',NULL,'2026-01-08 22:16:17','2026-01-08 22:24:45',NULL,NULL,NULL,NULL,NULL,NULL),
(29,15,NULL,33,10,3,NULL,'active',NULL,'2026-01-08 22:38:58','2026-01-09 01:04:55',NULL,NULL,NULL,NULL,NULL,NULL),
(30,16,NULL,35,10,10,NULL,'completed',NULL,'2026-01-15 18:49:35','2026-01-15 22:42:52',NULL,NULL,NULL,NULL,NULL,NULL),
(31,16,NULL,36,10,1,NULL,'active',NULL,'2026-01-15 22:51:56','2026-01-15 22:52:10',NULL,NULL,NULL,NULL,NULL,NULL),
(32,16,NULL,37,10,1,NULL,'active',NULL,'2026-01-20 18:50:40','2026-01-20 22:46:07',NULL,NULL,NULL,NULL,NULL,NULL),
(33,16,NULL,38,10,1,NULL,'active',NULL,'2026-01-20 19:51:45','2026-01-20 22:46:05',NULL,NULL,NULL,NULL,NULL,NULL),
(34,16,NULL,39,10,1,NULL,'active',NULL,'2026-01-20 21:14:22','2026-01-20 22:46:01',NULL,NULL,NULL,NULL,NULL,NULL),
(35,16,NULL,40,10,1,NULL,'active',NULL,'2026-01-20 21:21:41','2026-01-20 22:45:59',NULL,NULL,NULL,NULL,NULL,NULL),
(36,16,NULL,41,10,1,NULL,'active',NULL,'2026-01-20 21:25:18','2026-01-20 22:45:57',NULL,NULL,NULL,NULL,NULL,NULL),
(37,16,NULL,42,10,1,NULL,'active',NULL,'2026-01-20 21:33:40','2026-01-20 22:45:54',NULL,NULL,NULL,NULL,NULL,NULL),
(38,16,NULL,43,10,1,NULL,'active',NULL,'2026-01-20 21:54:10','2026-01-20 22:45:46',NULL,NULL,NULL,NULL,NULL,NULL),
(39,16,NULL,44,10,2,NULL,'active',NULL,'2026-01-20 21:55:15','2026-01-20 22:45:52',NULL,NULL,NULL,NULL,NULL,NULL),
(40,16,NULL,45,10,1,NULL,'active',NULL,'2026-01-20 22:00:17','2026-01-20 22:45:34',NULL,NULL,NULL,NULL,NULL,NULL),
(41,16,NULL,46,10,2,NULL,'active',NULL,'2026-01-20 22:04:00','2026-01-20 22:45:49',NULL,NULL,NULL,NULL,NULL,NULL),
(42,16,NULL,47,10,1,NULL,'active',NULL,'2026-01-20 22:04:32','2026-01-20 22:45:28',NULL,NULL,NULL,NULL,NULL,NULL),
(43,16,NULL,48,10,1,NULL,'active',NULL,'2026-01-20 22:05:48','2026-01-20 22:45:24',NULL,NULL,NULL,NULL,NULL,NULL),
(44,16,NULL,49,10,1,NULL,'active',NULL,'2026-01-20 22:06:09','2026-01-20 22:06:54',NULL,NULL,NULL,NULL,NULL,NULL),
(45,16,NULL,50,10,1,NULL,'active',NULL,'2026-01-20 22:19:38','2026-01-20 22:45:21',NULL,NULL,NULL,NULL,NULL,NULL),
(46,16,NULL,51,10,1,NULL,'active',NULL,'2026-01-20 22:20:14','2026-01-20 22:45:11',NULL,NULL,NULL,NULL,NULL,NULL),
(47,16,NULL,52,10,1,NULL,'active',NULL,'2026-01-20 22:33:30','2026-01-20 22:45:10',NULL,NULL,NULL,NULL,NULL,NULL),
(48,16,NULL,53,10,2,NULL,'active',NULL,'2026-01-20 22:33:53','2026-02-01 22:22:21',NULL,NULL,NULL,NULL,NULL,NULL),
(49,16,NULL,54,10,4,NULL,'active',NULL,'2026-01-20 22:36:26','2026-02-01 22:40:34',NULL,NULL,NULL,NULL,NULL,NULL),
(50,16,NULL,55,10,0,NULL,'active',NULL,'2026-01-22 14:33:18','2026-01-22 14:33:18',NULL,NULL,NULL,NULL,NULL,NULL),
(51,17,NULL,56,10,0,NULL,'active',NULL,'2026-01-27 11:15:55','2026-01-27 11:15:55',NULL,NULL,NULL,NULL,NULL,NULL),
(52,17,NULL,57,10,0,NULL,'active',NULL,'2026-01-27 11:28:55','2026-01-27 11:28:55',NULL,NULL,NULL,NULL,NULL,NULL),
(53,22,NULL,60,10,10,NULL,'active',NULL,'2026-01-27 23:39:05','2026-02-01 20:19:24',NULL,NULL,NULL,NULL,NULL,NULL),
(54,22,NULL,61,10,10,NULL,'active',NULL,'2026-01-28 09:11:01','2026-02-01 17:44:46',NULL,NULL,NULL,NULL,NULL,NULL),
(55,23,NULL,62,10,2,NULL,'active',NULL,'2026-01-28 14:19:32','2026-01-28 15:33:38',NULL,NULL,NULL,NULL,NULL,NULL),
(56,23,NULL,63,10,0,NULL,'active',NULL,'2026-01-28 16:50:00','2026-01-28 16:50:00',NULL,NULL,NULL,NULL,NULL,NULL),
(57,24,NULL,64,10,10,NULL,'completed',NULL,'2026-01-28 18:45:28','2026-01-28 20:25:59',NULL,NULL,NULL,NULL,NULL,NULL),
(58,26,NULL,65,10,0,NULL,'active',NULL,'2026-01-28 20:24:39','2026-01-28 20:24:39',NULL,NULL,NULL,NULL,NULL,NULL),
(59,25,NULL,66,10,0,NULL,'active',NULL,'2026-01-28 20:26:41','2026-01-28 20:26:41',NULL,NULL,NULL,NULL,NULL,NULL),
(60,24,NULL,67,10,4,NULL,'active',NULL,'2026-01-28 20:27:30','2026-02-01 21:01:02',NULL,NULL,NULL,NULL,NULL,NULL),
(61,27,NULL,68,10,3,NULL,'active',NULL,'2026-02-02 21:50:32','2026-02-02 22:02:20',NULL,NULL,NULL,NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loyalty_stamps`
--

LOCK TABLES `loyalty_stamps` WRITE;
/*!40000 ALTER TABLE `loyalty_stamps` DISABLE KEYS */;
INSERT INTO `loyalty_stamps` VALUES
(1,1,1,'Dodano naklejkę','2025-12-15 19:27:59','2025-12-15 19:27:59'),
(2,1,1,'Dodano naklejkę','2025-12-15 19:28:03','2025-12-15 19:28:03'),
(3,1,1,'Dodano naklejkę','2025-12-15 20:26:53','2025-12-15 20:26:53'),
(4,1,1,'Dodano naklejkę','2025-12-15 20:38:26','2025-12-15 20:38:26'),
(5,1,1,'Dodano naklejkę','2025-12-15 20:38:28','2025-12-15 20:38:28'),
(6,1,1,'Dodano naklejkę','2025-12-15 20:38:29','2025-12-15 20:38:29'),
(7,1,1,'Dodano naklejkę','2025-12-15 20:38:30','2025-12-15 20:38:30'),
(8,1,1,'Reset karty','2025-12-15 20:45:01','2025-12-15 20:45:01'),
(9,1,1,'Dodano naklejkę','2025-12-15 20:52:37','2025-12-15 20:52:37'),
(10,1,1,'Dodano naklejkę','2025-12-15 20:52:38','2025-12-15 20:52:38'),
(11,1,1,'Dodano naklejkę','2025-12-15 20:52:39','2025-12-15 20:52:39'),
(12,1,1,'Dodano naklejkę','2025-12-15 20:52:40','2025-12-15 20:52:40'),
(13,1,1,'Dodano naklejkę','2025-12-15 20:52:41','2025-12-15 20:52:41'),
(14,1,1,'Dodano naklejkę','2025-12-15 20:52:44','2025-12-15 20:52:44'),
(15,1,1,'Dodano naklejkę','2025-12-15 20:52:45','2025-12-15 20:52:45'),
(16,1,1,'Dodano naklejkę','2025-12-15 20:52:46','2025-12-15 20:52:46'),
(17,1,1,'Dodano naklejkę','2025-12-15 20:52:48','2025-12-15 20:52:48'),
(18,1,1,'Dodano naklejkę','2025-12-15 20:52:49','2025-12-15 20:52:49'),
(19,1,1,'Reset karty','2025-12-15 20:52:52','2025-12-15 20:52:52'),
(20,1,1,'Dodano naklejkę','2025-12-15 20:57:29','2025-12-15 20:57:29'),
(21,1,1,'Dodano naklejkę','2025-12-15 20:57:30','2025-12-15 20:57:30'),
(22,1,1,'Dodano naklejkę','2025-12-15 20:57:31','2025-12-15 20:57:31'),
(23,1,1,'Dodano naklejkę','2025-12-15 20:57:32','2025-12-15 20:57:32'),
(24,1,1,'Dodano naklejkę','2025-12-15 20:57:32','2025-12-15 20:57:32'),
(25,1,1,'Dodano naklejkę','2025-12-15 20:57:33','2025-12-15 20:57:33'),
(26,1,1,'Dodano naklejkę','2025-12-15 20:57:34','2025-12-15 20:57:34'),
(27,1,1,'Dodano naklejkę','2025-12-15 20:57:35','2025-12-15 20:57:35'),
(28,1,1,'Dodano naklejkę','2025-12-15 20:57:35','2025-12-15 20:57:35'),
(29,1,1,'Dodano naklejkę','2025-12-15 20:57:36','2025-12-15 20:57:36'),
(30,1,1,'Dodano naklejkę','2025-12-15 21:28:51','2025-12-15 21:28:51'),
(31,1,1,'Dodano naklejkę','2025-12-15 21:28:56','2025-12-15 21:28:56'),
(32,1,1,'Dodano naklejkę','2025-12-15 21:28:58','2025-12-15 21:28:58'),
(33,1,1,'Dodano naklejkę','2025-12-15 21:28:59','2025-12-15 21:28:59'),
(34,1,1,'Dodano naklejkę','2025-12-15 21:28:59','2025-12-15 21:28:59'),
(35,1,1,'Dodano naklejkę','2025-12-15 21:29:00','2025-12-15 21:29:00'),
(36,1,1,'Dodano naklejkę','2025-12-15 21:29:01','2025-12-15 21:29:01'),
(37,1,1,'Dodano naklejkę','2025-12-15 21:29:02','2025-12-15 21:29:02'),
(38,1,1,'Dodano naklejkę','2025-12-15 21:29:03','2025-12-15 21:29:03'),
(39,1,1,'Dodano naklejkę','2025-12-15 21:29:04','2025-12-15 21:29:04'),
(40,1,1,'Odebrano nagrodę','2025-12-15 21:35:29','2025-12-15 21:35:29'),
(41,1,1,'Dodano naklejkę','2025-12-15 21:35:35','2025-12-15 21:35:35'),
(42,1,1,'Dodano naklejkę','2025-12-15 21:35:36','2025-12-15 21:35:36'),
(43,1,1,'Dodano naklejkę','2025-12-15 21:35:37','2025-12-15 21:35:37'),
(44,1,1,'Dodano naklejkę','2025-12-15 21:35:38','2025-12-15 21:35:38'),
(45,1,1,'Dodano naklejkę','2025-12-15 21:35:39','2025-12-15 21:35:39'),
(46,1,1,'Dodano naklejkę','2025-12-15 21:35:39','2025-12-15 21:35:39'),
(47,1,1,'Dodano naklejkę','2025-12-15 21:35:40','2025-12-15 21:35:40'),
(48,1,1,'Dodano naklejkę','2025-12-15 21:35:41','2025-12-15 21:35:41'),
(49,1,1,'Dodano naklejkę','2025-12-15 21:35:42','2025-12-15 21:35:42'),
(50,1,1,'Dodano naklejkę','2025-12-15 21:35:43','2025-12-15 21:35:43'),
(51,1,1,'Odebrano nagrodę','2025-12-15 21:35:44','2025-12-15 21:35:44'),
(52,2,1,'Dodano naklejkę','2025-12-21 22:53:05','2025-12-21 22:53:05'),
(53,2,1,'Dodano naklejkę','2025-12-21 22:53:08','2025-12-21 22:53:08'),
(54,3,1,'Dodano naklejkę','2025-12-22 00:27:27','2025-12-22 00:27:27'),
(55,16,7,'Naklejka','2026-01-01 20:48:09','2026-01-01 20:48:09'),
(56,16,7,'Naklejka','2026-01-01 20:48:38','2026-01-01 20:48:38'),
(57,16,7,'Naklejka','2026-01-01 22:17:22','2026-01-01 22:17:22'),
(58,16,7,'Naklejka','2026-01-01 22:37:53','2026-01-01 22:37:53'),
(59,16,7,'Naklejka','2026-01-01 22:37:54','2026-01-01 22:37:54'),
(60,17,7,'Naklejka','2026-01-01 22:58:52','2026-01-01 22:58:52'),
(61,18,8,'Naklejka','2026-01-04 15:11:06','2026-01-04 15:11:06'),
(62,19,8,'Naklejka','2026-01-04 21:57:43','2026-01-04 21:57:43'),
(63,19,8,'Naklejka','2026-01-05 16:10:51','2026-01-05 16:10:51'),
(64,19,8,'Naklejka','2026-01-05 16:10:53','2026-01-05 16:10:53'),
(65,22,9,'Naklejka','2026-01-06 19:38:06','2026-01-06 19:38:06'),
(66,23,11,'Naklejka','2026-01-07 18:44:22','2026-01-07 18:44:22'),
(67,24,12,'Naklejka','2026-01-07 20:32:49','2026-01-07 20:32:49'),
(68,24,12,'Naklejka','2026-01-07 20:32:50','2026-01-07 20:32:50'),
(69,24,12,'Naklejka','2026-01-07 20:33:05','2026-01-07 20:33:05'),
(70,24,12,'Naklejka','2026-01-07 21:03:39','2026-01-07 21:03:39'),
(71,24,12,'Naklejka','2026-01-07 21:05:40','2026-01-07 21:05:40'),
(72,24,12,'Naklejka','2026-01-07 21:05:41','2026-01-07 21:05:41'),
(73,24,12,'Naklejka','2026-01-07 21:05:41','2026-01-07 21:05:41'),
(74,24,12,'Naklejka','2026-01-07 21:05:42','2026-01-07 21:05:42'),
(75,24,12,'Naklejka','2026-01-07 21:05:50','2026-01-07 21:05:50'),
(76,24,12,'Naklejka','2026-01-07 21:05:51','2026-01-07 21:05:51'),
(77,25,13,'Naklejka','2026-01-08 01:07:14','2026-01-08 01:07:14'),
(78,26,14,'Naklejka','2026-01-08 01:34:59','2026-01-08 01:34:59'),
(79,26,14,'Naklejka','2026-01-08 01:35:00','2026-01-08 01:35:00'),
(80,26,14,'Naklejka','2026-01-08 01:35:00','2026-01-08 01:35:00'),
(81,26,14,'Naklejka','2026-01-08 01:35:01','2026-01-08 01:35:01'),
(82,26,14,'Naklejka','2026-01-08 01:35:02','2026-01-08 01:35:02'),
(83,26,14,'Naklejka','2026-01-08 01:35:03','2026-01-08 01:35:03'),
(84,26,14,'Naklejka','2026-01-08 01:35:03','2026-01-08 01:35:03'),
(85,26,14,'Naklejka','2026-01-08 01:35:04','2026-01-08 01:35:04'),
(86,26,14,'Naklejka','2026-01-08 01:35:05','2026-01-08 01:35:05'),
(87,27,11,'Naklejka','2026-01-08 09:49:53','2026-01-08 09:49:53'),
(88,28,1,'Naklejka','2026-01-08 22:24:45','2026-01-08 22:24:45'),
(89,21,1,'Naklejka','2026-01-08 22:24:47','2026-01-08 22:24:47'),
(101,29,15,'Naklejka','2026-01-09 00:59:17','2026-01-09 00:59:17'),
(102,29,15,'Naklejka','2026-01-09 01:03:13','2026-01-09 01:03:13'),
(103,29,15,'Naklejka','2026-01-09 01:04:55','2026-01-09 01:04:55'),
(104,27,11,'Naklejka','2026-01-10 01:04:10','2026-01-10 01:04:10'),
(105,27,11,'Naklejka','2026-01-10 01:04:13','2026-01-10 01:04:13'),
(106,27,11,'Naklejka','2026-01-10 01:06:06','2026-01-10 01:06:06'),
(107,27,11,'Naklejka','2026-01-10 01:08:40','2026-01-10 01:08:40'),
(108,27,11,'Naklejka','2026-01-10 01:11:03','2026-01-10 01:11:03'),
(109,27,11,'Naklejka','2026-01-10 01:25:11','2026-01-10 01:25:11'),
(110,27,11,'Naklejka','2026-01-10 01:25:35','2026-01-10 01:25:35'),
(111,27,11,'Naklejka','2026-01-10 01:30:26','2026-01-10 01:30:26'),
(112,27,11,'Naklejka','2026-01-10 01:30:37','2026-01-10 01:30:37'),
(113,23,11,'Naklejka','2026-01-14 20:47:19','2026-01-14 20:47:19'),
(114,23,11,'Naklejka','2026-01-14 20:47:23','2026-01-14 20:47:23'),
(115,23,11,'Naklejka','2026-01-14 21:17:59','2026-01-14 21:17:59'),
(116,23,11,'Naklejka','2026-01-14 21:21:55','2026-01-14 21:21:55'),
(117,23,11,'Naklejka','2026-01-14 21:22:57','2026-01-14 21:22:57'),
(118,23,11,'Naklejka','2026-01-14 21:30:31','2026-01-14 21:30:31'),
(119,23,11,'Naklejka','2026-01-14 21:33:06','2026-01-14 21:33:06'),
(120,23,11,'Naklejka','2026-01-15 17:53:58','2026-01-15 17:53:58'),
(121,30,16,'Naklejka','2026-01-15 18:58:50','2026-01-15 18:58:50'),
(122,30,16,'Naklejka','2026-01-15 19:45:34','2026-01-15 19:45:34'),
(123,30,16,'Naklejka','2026-01-15 19:49:10','2026-01-15 19:49:10'),
(124,30,16,'Naklejka','2026-01-15 19:54:10','2026-01-15 19:54:10'),
(125,30,16,'Naklejka','2026-01-15 21:01:37','2026-01-15 21:01:37'),
(126,30,16,'Naklejka','2026-01-15 21:10:07','2026-01-15 21:10:07'),
(127,30,16,'Naklejka','2026-01-15 21:14:09','2026-01-15 21:14:09'),
(128,30,16,'Naklejka','2026-01-15 21:33:24','2026-01-15 21:33:24'),
(129,30,16,'Naklejka','2026-01-15 22:32:03','2026-01-15 22:32:03'),
(130,30,16,'Naklejka','2026-01-15 22:42:52','2026-01-15 22:42:52'),
(131,31,16,'Naklejka','2026-01-15 22:52:10','2026-01-15 22:52:10'),
(132,44,16,'Naklejka','2026-01-20 22:06:54','2026-01-20 22:06:54'),
(133,49,16,'Naklejka','2026-01-20 22:45:07','2026-01-20 22:45:07'),
(134,48,16,'Naklejka','2026-01-20 22:45:09','2026-01-20 22:45:09'),
(135,47,16,'Naklejka','2026-01-20 22:45:10','2026-01-20 22:45:10'),
(136,46,16,'Naklejka','2026-01-20 22:45:11','2026-01-20 22:45:11'),
(137,45,16,'Naklejka','2026-01-20 22:45:21','2026-01-20 22:45:21'),
(138,43,16,'Naklejka','2026-01-20 22:45:24','2026-01-20 22:45:24'),
(139,42,16,'Naklejka','2026-01-20 22:45:28','2026-01-20 22:45:28'),
(140,41,16,'Naklejka','2026-01-20 22:45:31','2026-01-20 22:45:31'),
(141,40,16,'Naklejka','2026-01-20 22:45:34','2026-01-20 22:45:34'),
(142,39,16,'Naklejka','2026-01-20 22:45:44','2026-01-20 22:45:44'),
(143,38,16,'Naklejka','2026-01-20 22:45:46','2026-01-20 22:45:46'),
(144,41,16,'Naklejka','2026-01-20 22:45:49','2026-01-20 22:45:49'),
(145,39,16,'Naklejka','2026-01-20 22:45:52','2026-01-20 22:45:52'),
(146,37,16,'Naklejka','2026-01-20 22:45:54','2026-01-20 22:45:54'),
(147,36,16,'Naklejka','2026-01-20 22:45:57','2026-01-20 22:45:57'),
(148,35,16,'Naklejka','2026-01-20 22:45:59','2026-01-20 22:45:59'),
(149,34,16,'Naklejka','2026-01-20 22:46:01','2026-01-20 22:46:01'),
(150,33,16,'Naklejka','2026-01-20 22:46:05','2026-01-20 22:46:05'),
(151,32,16,'Naklejka','2026-01-20 22:46:07','2026-01-20 22:46:07'),
(152,53,22,'Naklejka','2026-01-27 23:43:43','2026-01-27 23:43:43'),
(153,53,22,'Naklejka','2026-01-27 23:44:07','2026-01-27 23:44:07'),
(154,55,23,'Naklejka','2026-01-28 15:16:19','2026-01-28 15:16:19'),
(155,55,23,'Naklejka','2026-01-28 15:33:38','2026-01-28 15:33:38'),
(156,57,24,'Naklejka','2026-01-28 18:45:38','2026-01-28 18:45:38'),
(157,57,24,'Naklejka','2026-01-28 19:09:31','2026-01-28 19:09:31'),
(158,57,24,'Naklejka','2026-01-28 19:10:49','2026-01-28 19:10:49'),
(159,57,24,'Naklejka','2026-01-28 19:14:37','2026-01-28 19:14:37'),
(160,57,24,'Naklejka','2026-01-28 19:58:15','2026-01-28 19:58:15'),
(161,57,24,'Naklejka','2026-01-28 20:01:33','2026-01-28 20:01:33'),
(162,57,24,'Naklejka','2026-01-28 20:04:12','2026-01-28 20:04:12'),
(163,57,24,'Naklejka','2026-01-28 20:20:56','2026-01-28 20:20:56'),
(164,57,24,'Naklejka','2026-01-28 20:25:43','2026-01-28 20:25:43'),
(165,57,24,'Naklejka','2026-01-28 20:25:59','2026-01-28 20:25:59'),
(166,60,24,'Naklejka','2026-01-28 20:27:36','2026-01-28 20:27:36'),
(167,54,22,'Naklejka','2026-01-29 09:11:36','2026-01-29 09:11:36'),
(168,53,22,'Naklejka','2026-01-29 09:30:22','2026-01-29 09:30:22'),
(169,54,22,'Naklejka','2026-01-29 17:35:56','2026-01-29 17:35:56'),
(170,54,22,'Naklejka','2026-01-29 17:35:59','2026-01-29 17:35:59'),
(171,54,22,'Naklejka','2026-01-29 17:36:01','2026-01-29 17:36:01'),
(172,53,22,'Naklejka','2026-01-29 17:41:27','2026-01-29 17:41:27'),
(173,54,22,'Naklejka','2026-01-29 21:30:18','2026-01-29 21:30:18'),
(174,54,22,'Naklejka','2026-01-29 21:42:06','2026-01-29 21:42:06'),
(175,54,22,'Naklejka','2026-01-29 21:42:08','2026-01-29 21:42:08'),
(176,54,22,'Naklejka','2026-02-01 13:07:19','2026-02-01 13:07:19'),
(177,54,22,'Naklejka','2026-02-01 13:07:20','2026-02-01 13:07:20'),
(178,60,24,'Naklejka','2026-02-01 21:01:02','2026-02-01 21:01:02'),
(179,49,16,'Naklejka','2026-02-01 22:09:43','2026-02-01 22:09:43'),
(180,48,16,'Naklejka','2026-02-01 22:22:21','2026-02-01 22:22:21'),
(181,49,16,'Naklejka','2026-02-01 22:22:28','2026-02-01 22:22:28'),
(182,49,16,'Naklejka','2026-02-01 22:40:34','2026-02-01 22:40:34'),
(183,61,27,'Naklejka','2026-02-02 22:01:02','2026-02-02 22:01:02'),
(184,61,27,'Naklejka','2026-02-02 22:02:18','2026-02-02 22:02:18'),
(185,61,27,'Naklejka','2026-02-02 22:02:20','2026-02-02 22:02:20');
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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
(55,'2026_01_29_185641_add_last_activity_at_to_firms_table',30);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
-- Table structure for table `program_settings`
--

DROP TABLE IF EXISTS `program_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` bigint(20) unsigned NOT NULL,
  `birthday_sms` tinyint(1) NOT NULL DEFAULT 0,
  `marketing_sms` tinyint(1) NOT NULL DEFAULT 0,
  `auto_bonus` tinyint(1) NOT NULL DEFAULT 0,
  `auto_bonus_value` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `program_settings_program_id_foreign` (`program_id`),
  CONSTRAINT `program_settings_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_settings`
--

LOCK TABLES `program_settings` WRITE;
/*!40000 ALTER TABLE `program_settings` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_tokens`
--

LOCK TABLES `registration_tokens` WRITE;
/*!40000 ALTER TABLE `registration_tokens` DISABLE KEYS */;
INSERT INTO `registration_tokens` VALUES
(2,'9891ac92-c014-4e0d-bbcf-73cc10879418',7,'2026-01-31 22:54:00','2026-01-01 22:54:00','2026-01-01 22:54:00'),
(10,'2bc5f78e-1f5f-4dd6-b21d-cc9f9d9923ec',8,'2026-02-04 14:33:25','2026-01-05 14:33:25','2026-01-05 14:33:25'),
(18,'589fc713-c5e4-4351-b97d-829e662edd60',9,'2026-02-05 19:44:06','2026-01-06 19:44:06','2026-01-06 19:44:06'),
(23,'ac74eea1-bc7e-4d16-9401-f90b0710717a',14,'2026-02-07 01:41:52','2026-01-08 01:41:52','2026-01-08 01:41:52'),
(26,'139d92f0-4a16-42b6-b0de-2d3887cfca37',11,'2026-02-09 01:19:04','2026-01-10 01:19:04','2026-01-10 01:19:04'),
(29,'3a66445c-a22a-48ef-8216-97dab37428e3',16,'2026-02-19 19:09:12','2026-01-20 19:09:12','2026-01-20 19:09:12');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_logs`
--

LOCK TABLES `security_logs` WRITE;
/*!40000 ALTER TABLE `security_logs` DISABLE KEYS */;
INSERT INTO `security_logs` VALUES
(1,'system',NULL,'test_log','manual_test','127.0.0.1','tinker','2026-01-21 13:55:04'),
(2,'admin',NULL,'export_consents','firm_id=8','37.225.89.218','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','2026-01-21 13:59:55');
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
('cod0dx6bkJp6mLRlbN1e99f1zUzhOx2HqNDaHUaJ',NULL,'193.142.147.209','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicHU2bllXTEd3Y3piRGtpTFBteTE2OExmRE51T2ExM3c4Z3ZxR2pXSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vNTEuNjguMTM5LjE2MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1766843376),
('i4EdB8HYBqWLPiqab1JKGI9AAaK0xeCE4eVai5IH',NULL,'43.157.170.13','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWZQRG9jdEl5Q0Y1dzllNUNKVmliM2VjSTFENmxtamFRVktiam1kYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vNTEuNjguMTM5LjE2MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1766841210),
('L2w16Z6OUkviSo186v5EWuxB6XuNQdieV6w1Ahc7',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoieDVDYWNQZzV1eXBscXB6a0hGU1M0azVSbWxUcDhaVEt1dTFaUGd2ZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vNTEuNjguMTM5LjE2MC9jYXJkL2xvZ2luIjtzOjU6InJvdXRlIjtzOjE3OiJjbGllbnQuY2FyZC5sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTQ6ImNsaWVudF9jYXJkX2lkIjtpOjg7czo1ODoibG9naW5fY2xpZW50X2NhcmRfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=',1766844245),
('O08YDcfwBdI0LOYE87yhKz3fKHs4I3BP7oe7cq5X',NULL,'170.106.163.48','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFpkTGZjc2x5OVlPN3prcXpYRXBHaFhoV3JsVFh2UzhPaTQxMEk2OSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vNTEuNjguMTM5LjE2MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1766835127),
('Ow1HYfS9JiCZccHc5rluinIksBL5zQo6Bs3aUYsy',NULL,'167.86.107.35','Mozilla/5.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFNyM25KMDJlWHVJanhXcHpqVlZZSzdRckZXU2hvbkp1bHJxWlFacyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vNTEuNjguMTM5LjE2MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1766834792),
('sRpopckKq4zizNbszfjib6rmelaZgZgjzfAm5L2U',NULL,'176.107.36.121','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRXN3a1NielFiWEFPRGJ2cm9oalJSYndIUVBWR2c5SW9rSmtCY2RMaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vNTEuNjguMTM5LjE2MC9jYXJkL2xvZ2luIjtzOjU6InJvdXRlIjtzOjE3OiJjbGllbnQuY2FyZC5sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTg6ImxvZ2luX2NsaWVudF9jYXJkXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTt9',1766926783),
('v9YDnQ7dxhISKURTnoTVuR0filGkeopV89Rvx5JI',NULL,'79.124.40.174','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMktUR2hOaDVDVzBNMjI4VnpJakFRanRjZkNoZ1BhZHNvUWJqTmc1OCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vNTEuNjguMTM5LjE2MC8/WERFQlVHX1NFU1NJT05fU1RBUlQ9cGhwc3Rvcm0iO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1766841410);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES
(1,3,NULL,1,'purchase',100.00,100,NULL,'2025-12-11 21:11:57','2025-12-11 21:11:57'),
(2,3,NULL,1,'purchase',100.00,100,NULL,'2025-12-11 21:23:02','2025-12-11 21:23:02'),
(3,3,NULL,1,'purchase',1000.00,1000,NULL,'2025-12-11 21:29:09','2025-12-11 21:29:09'),
(4,3,NULL,1,'purchase',400.00,400,'test','2025-12-11 21:29:24','2025-12-11 21:29:24'),
(5,3,1,1,'purchase',100.00,100,NULL,'2025-12-11 21:43:37','2025-12-11 21:43:37'),
(6,3,1,1,'purchase',10000.00,10000,NULL,'2025-12-11 21:43:49','2025-12-11 21:43:49'),
(7,3,1,1,'purchase',250.00,250,NULL,'2025-12-11 21:43:57','2025-12-11 21:43:57'),
(8,3,1,1,'purchase',1000000.00,1000000,NULL,'2025-12-11 22:05:18','2025-12-11 22:05:18'),
(9,3,1,1,'purchase',100.00,100,NULL,'2025-12-15 17:57:25','2025-12-15 17:57:25'),
(10,3,1,1,'purchase',50.00,50,NULL,'2025-12-16 16:00:41','2025-12-16 16:00:41'),
(11,3,1,1,'purchase',1200.00,1200,NULL,'2025-12-16 16:01:23','2025-12-16 16:01:23'),
(12,3,1,1,'purchase',100000.00,100000,NULL,'2025-12-16 16:02:05','2025-12-16 16:02:05'),
(13,3,1,1,'purchase',5000.00,5000,NULL,'2025-12-16 18:59:53','2025-12-16 18:59:53'),
(14,3,1,1,'purchase',NULL,250000,NULL,'2025-12-16 19:25:12','2025-12-16 19:25:12'),
(15,3,1,1,'purchase',NULL,100,NULL,'2025-12-16 20:03:11','2025-12-16 20:03:11'),
(16,3,1,1,'manual',540.00,270,'Ręczne naliczenie punktów','2025-12-16 21:23:53','2025-12-16 21:23:53'),
(17,3,1,1,'manual',100.00,50,'Ręczne naliczenie punktów','2025-12-16 21:24:59','2025-12-16 21:24:59'),
(18,3,1,1,'manual',100.20,50,'test janek','2025-12-16 22:33:21','2025-12-16 22:33:21'),
(19,3,1,1,'manual',200000.00,100000,'Ręczne naliczenie punktów','2025-12-21 13:07:58','2025-12-21 13:07:58');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,NULL,'Damian','admin@firma.pl',NULL,'$2y$12$ICg/zjMZJ3xPbuP5FftrCONiYaf3RH9rgc9Nl3H3.aZ/tMKW2Hj8K',NULL,'2025-12-22 21:16:51','2025-12-22 21:16:51');
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

-- Dump completed on 2026-02-02 21:05:56

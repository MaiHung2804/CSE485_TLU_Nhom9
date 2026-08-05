-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cse485_sports_booking
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `booking_details`
--

DROP TABLE IF EXISTS `booking_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) unsigned NOT NULL,
  `court_id` bigint(20) unsigned NOT NULL,
  `booking_date` date NOT NULL,
  `time_slot_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_details_booking_id_foreign` (`booking_id`),
  KEY `booking_details_time_slot_id_foreign` (`time_slot_id`),
  KEY `booking_details_lookup_idx` (`court_id`,`booking_date`,`time_slot_id`),
  KEY `booking_details_booking_date_index` (`booking_date`),
  CONSTRAINT `booking_details_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_details_court_id_foreign` FOREIGN KEY (`court_id`) REFERENCES `courts` (`id`),
  CONSTRAINT `booking_details_time_slot_id_foreign` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slots` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_details`
--

LOCK TABLES `booking_details` WRITE;
/*!40000 ALTER TABLE `booking_details` DISABLE KEYS */;
INSERT INTO `booking_details` VALUES (1,1,1,'2026-08-10',1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(2,2,2,'2026-08-04',3,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(3,3,4,'2026-08-02',3,'2026-08-03 01:26:05','2026-08-03 01:26:05');
/*!40000 ALTER TABLE `booking_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `player_count` int(10) unsigned NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_approved_by_foreign` (`approved_by`),
  KEY `bookings_status_index` (`status`),
  CONSTRAINT `bookings_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,3,'Tập bóng đá sinh viên năm nhất',12,'0900123456','pending',NULL,NULL,NULL,NULL,NULL,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(2,3,'Buổi tập định kỳ của câu lạc bộ bóng chuyền',10,'0900234567','approved',1,'2026-08-03 03:22:00',NULL,NULL,NULL,'2026-08-03 01:26:05','2026-08-03 03:22:00'),(3,3,'Buổi tập kỹ thuật bóng rổ',8,'0900345678','completed',1,'2026-08-01 03:22:00',NULL,NULL,NULL,'2026-08-03 01:26:05','2026-08-03 03:22:00');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `court_schedules`
--

DROP TABLE IF EXISTS `court_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `court_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `court_id` bigint(20) unsigned NOT NULL,
  `day_of_week` tinyint(3) unsigned NOT NULL,
  `time_slot_id` bigint(20) unsigned NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `court_schedule_unique_slot` (`court_id`,`day_of_week`,`time_slot_id`),
  KEY `court_schedules_time_slot_id_foreign` (`time_slot_id`),
  CONSTRAINT `court_schedules_court_id_foreign` FOREIGN KEY (`court_id`) REFERENCES `courts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `court_schedules_time_slot_id_foreign` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slots` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `court_schedules`
--

LOCK TABLES `court_schedules` WRITE;
/*!40000 ALTER TABLE `court_schedules` DISABLE KEYS */;
INSERT INTO `court_schedules` VALUES (1,1,1,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(2,1,1,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(3,1,1,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(4,1,1,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(5,1,1,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(6,1,2,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(7,1,2,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(8,1,2,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(9,1,2,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(10,1,2,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(11,1,3,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(12,1,3,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(13,1,3,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(14,1,3,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(15,1,3,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(16,1,4,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(17,1,4,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(18,1,4,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(19,1,4,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(20,1,4,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(21,1,5,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(22,1,5,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(23,1,5,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(24,1,5,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(25,1,5,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(26,1,6,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(27,1,6,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(28,1,6,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(29,1,6,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(30,1,6,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(31,2,1,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(32,2,1,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(33,2,1,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(34,2,1,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(35,2,1,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(36,2,2,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(37,2,2,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(38,2,2,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(39,2,2,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(40,2,2,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(41,2,3,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(42,2,3,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(43,2,3,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(44,2,3,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(45,2,3,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(46,2,4,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(47,2,4,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(48,2,4,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(49,2,4,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(50,2,4,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(51,2,5,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(52,2,5,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(53,2,5,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(54,2,5,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(55,2,5,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(56,2,6,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(57,2,6,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(58,2,6,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(59,2,6,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(60,2,6,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(61,3,1,1,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(62,3,1,2,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(63,3,1,3,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(64,3,1,4,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(65,3,1,5,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(66,3,2,1,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(67,3,2,2,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(68,3,2,3,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(69,3,2,4,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(70,3,2,5,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(71,3,3,1,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(72,3,3,2,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(73,3,3,3,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(74,3,3,4,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(75,3,3,5,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(76,3,4,1,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(77,3,4,2,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(78,3,4,3,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(79,3,4,4,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(80,3,4,5,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(81,3,5,1,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(82,3,5,2,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(83,3,5,3,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(84,3,5,4,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(85,3,5,5,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(86,3,6,1,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(87,3,6,2,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(88,3,6,3,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(89,3,6,4,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(90,3,6,5,0,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(91,4,1,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(92,4,1,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(93,4,1,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(94,4,1,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(95,4,1,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(96,4,2,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(97,4,2,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(98,4,2,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(99,4,2,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(100,4,2,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(101,4,3,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(102,4,3,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(103,4,3,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(104,4,3,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(105,4,3,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(106,4,4,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(107,4,4,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(108,4,4,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(109,4,4,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(110,4,4,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(111,4,5,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(112,4,5,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(113,4,5,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(114,4,5,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(115,4,5,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(116,4,6,1,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(117,4,6,2,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(118,4,6,3,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(119,4,6,4,1,'2026-08-03 01:26:05','2026-08-03 01:26:05'),(120,4,6,5,1,'2026-08-03 01:26:05','2026-08-03 01:26:05');
/*!40000 ALTER TABLE `court_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courts`
--

DROP TABLE IF EXISTS `courts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sport_type_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `capacity` int(10) unsigned NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courts_code_unique` (`code`),
  KEY `courts_sport_type_id_foreign` (`sport_type_id`),
  KEY `courts_status_index` (`status`),
  CONSTRAINT `courts_sport_type_id_foreign` FOREIGN KEY (`sport_type_id`) REFERENCES `sport_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courts`
--

LOCK TABLES `courts` WRITE;
/*!40000 ALTER TABLE `courts` DISABLE KEYS */;
INSERT INTO `courts` VALUES (1,1,'Sân bóng đá A','FB-A','Khuôn viên phía Bắc',14,'active','Sân cỏ nhân tạo dành cho các trận bóng đá 7 người.','2026-08-03 01:26:05','2026-08-03 01:26:05'),(2,2,'Sân bóng chuyền B','VB-B','Trung tâm sinh viên',12,'active','Sân ngoài trời dành cho luyện tập và sinh hoạt câu lạc bộ.','2026-08-03 01:26:05','2026-08-03 01:26:05'),(3,3,'Sân cầu lông 01','BD-01','Nhà thi đấu',4,'maintenance','Sân trong nhà đang tạm đóng để bảo trì mặt sàn.','2026-08-03 01:26:05','2026-08-03 01:26:05'),(4,4,'Sân bóng rổ C','BK-C','Khuôn viên phía Tây',10,'active','Nửa sân đa năng phục vụ tập luyện và giao lưu.','2026-08-03 01:26:05','2026-08-03 01:26:05'),(5,3,'Sân Cầu Lông 02','BD-02','Nhà thi đấu',8,'active',NULL,'2026-08-03 01:36:01','2026-08-03 01:36:01');
/*!40000 ALTER TABLE `courts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'2026_08_03_051522_create_sport_types_table',1),(3,'2026_08_03_051523_create_courts_table',1),(4,'2026_08_03_051523_create_time_slots_table',1),(5,'2026_08_03_051524_create_bookings_table',1),(6,'2026_08_03_051524_create_court_schedules_table',1),(7,'2026_08_03_051525_create_booking_details_table',1),(8,'2026_08_03_051525_create_usage_logs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sport_types`
--

DROP TABLE IF EXISTS `sport_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sport_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sport_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sport_types`
--

LOCK TABLES `sport_types` WRITE;
/*!40000 ALTER TABLE `sport_types` DISABLE KEYS */;
INSERT INTO `sport_types` VALUES (1,'Bóng đá','Các sân bóng đá mini phục vụ đội sinh viên và hoạt động phong trào trong trường.','2026-08-03 01:26:05','2026-08-03 01:26:05'),(2,'Bóng chuyền','Sân bóng chuyền ngoài trời gần khu dịch vụ sinh viên.','2026-08-03 01:26:05','2026-08-03 01:26:05'),(3,'Cầu lông','Sân cầu lông trong nhà có đèn chiếu sáng cơ bản.','2026-08-03 01:26:05','2026-08-03 01:26:05'),(4,'Bóng rổ','Khu sân nửa sân và toàn sân phục vụ tập luyện, giao lưu.','2026-08-03 01:26:05','2026-08-03 01:26:05');
/*!40000 ALTER TABLE `sport_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_slots`
--

DROP TABLE IF EXISTS `time_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_slots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `time_slots_label_unique` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_slots`
--

LOCK TABLES `time_slots` WRITE;
/*!40000 ALTER TABLE `time_slots` DISABLE KEYS */;
INSERT INTO `time_slots` VALUES (1,'Ca sáng 1','07:00:00','09:00:00','2026-08-03 01:26:05','2026-08-03 01:26:05'),(2,'Ca sáng 2','09:00:00','11:00:00','2026-08-03 01:26:05','2026-08-03 01:26:05'),(3,'Ca chiều 1','13:00:00','15:00:00','2026-08-03 01:26:05','2026-08-03 01:26:05'),(4,'Ca chiều 2','15:00:00','17:00:00','2026-08-03 01:26:05','2026-08-03 01:26:05'),(5,'Ca tối','17:00:00','19:00:00','2026-08-03 01:26:05','2026-08-03 01:26:05');
/*!40000 ALTER TABLE `time_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usage_logs`
--

DROP TABLE IF EXISTS `usage_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usage_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `booking_detail_id` bigint(20) unsigned NOT NULL,
  `checked_by` bigint(20) unsigned DEFAULT NULL,
  `used_status` varchar(20) NOT NULL DEFAULT 'used',
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `checked_out_at` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usage_logs_booking_detail_id_unique` (`booking_detail_id`),
  KEY `usage_logs_checked_by_foreign` (`checked_by`),
  CONSTRAINT `usage_logs_booking_detail_id_foreign` FOREIGN KEY (`booking_detail_id`) REFERENCES `booking_details` (`id`) ON DELETE CASCADE,
  CONSTRAINT `usage_logs_checked_by_foreign` FOREIGN KEY (`checked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usage_logs`
--

LOCK TABLES `usage_logs` WRITE;
/*!40000 ALTER TABLE `usage_logs` DISABLE KEYS */;
INSERT INTO `usage_logs` VALUES (1,3,1,'used','2026-08-02 03:22:00','2026-08-02 05:22:00','Dữ liệu mẫu phục vụ báo cáo sử dụng sân trên bảng điều khiển.','2026-08-03 01:26:05','2026-08-03 03:22:00');
/*!40000 ALTER TABLE `usage_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'student',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Quản trị viên sân thể thao','admin@campus.local',NULL,'$2y$12$P2hR1SlKxu7TDaCaZtQSOejBcD6/RUqELtzkNKUIUK.5h3ib/E7/G','admin',NULL,'2026-08-03 01:26:05','2026-08-03 03:22:00'),(3,'Nguyen Van A','student1@campus.local',NULL,'$2y$12$/Zovlq2poBtMteY/cfdMYO0ExvoKFuVfYrH2zjRSHnxPEhyzP87di','student',NULL,'2026-08-03 01:26:05','2026-08-03 03:22:00'),(4,'Tran Thi B','student2@campus.local',NULL,'$2y$12$Apz9aWiy1EyBSiYg3q1nB.Oh3M0gUdoH8hFPQl2RVfe/nk9spQU7C','student',NULL,'2026-08-03 01:26:05','2026-08-03 03:22:00');
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

-- Dump completed on 2026-08-03 17:22:09

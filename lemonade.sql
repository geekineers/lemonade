-- MySQL dump 10.13  Distrib 5.6.20, for osx10.8 (x86_64)
--
-- Host: localhost    Database: lemonade_dev
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branches` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(100) NOT NULL,
  `branch_description` text,
  `branch_address` text NOT NULL,
  `branch_contact_number` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'Capas Branch','','','','2014-08-07 13:42:38','2014-08-07 13:42:38',NULL);
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) NOT NULL,
  `department_description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'IT Department','','2014-08-07 13:43:05','2014-08-07 13:43:05',NULL);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `file_description` text,
  `file_name` text NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,1,'Resume File','asdasdsad','53e3cf238d3ad.pdf','222529','application/pdf','pdf','2014-08-08 03:10:27','2014-08-08 03:10:27',NULL);
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `full_address` varchar(255) NOT NULL,
  `birthdate` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `marital_status` varchar(100) NOT NULL,
  `spouse_name` varchar(255) NOT NULL,
  `employee_type` varchar(100) NOT NULL,
  `payroll_period` varchar(100) NOT NULL,
  `job_position` int(5) NOT NULL,
  `department` int(5) NOT NULL,
  `role_id` int(5) NOT NULL,
  `branch_id` int(5) NOT NULL,
  `date_hired` varchar(100) NOT NULL,
  `date_ended` varchar(100) NOT NULL,
  `basic_pay` varchar(100) NOT NULL,
  `tin_number` varchar(100) NOT NULL,
  `sss_number` varchar(100) NOT NULL,
  `pagibig_number` varchar(100) NOT NULL,
  `dependents` int(5) NOT NULL,
  `profile_picture` varchar(100) NOT NULL,
  `contact_number` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'2','Mark','Penaranda','Angel','#8 Robina Roaddasd','birthdate','Male','Single','','Regular','Daily',1,1,0,1,'07/07/1992','none','25,000','123123','123','13123',0,'53e3121e449fc.jpg','09066009622','eloisa.corpuz','mark@sourcescript.ph','2014-08-07 13:43:59','2014-08-08 02:23:17',NULL),(2,'','Eloisa ','Corpuz','Luzanos','#8 Robina Road','02/07/1992','Female','Single','','Regular','Monthly',1,1,1,1,'07/07/1992','none','12,000','1212111','1212111','121211',0,'53e32f6e3da47.jpg','09066009622','eloisa.corpuz','eloisa@sourcescript.ph','2014-08-07 15:49:02','2014-08-07 17:53:26',NULL),(3,'','','','','','','','Single','','Regular','Daily',1,1,1,1,'','none','','','','',0,'53e3d5fd77504','','','','2014-08-08 03:39:41','2014-08-08 03:39:41',NULL),(4,'','John','Doe','Dee','Amsterdam','02/07/1992','Male','Single','','Regular','Daily',1,1,1,1,'07/07/1992','none','25,000','123123','123','13123',4,'53e3dbefe96cb.jpg','09066009622','eloisa.corpuz','employee@lemon.com','2014-08-08 04:05:07','2014-08-08 04:05:07',NULL),(5,'3','Jen','Dela Cruz','Dee ','Matatalaib Tarlac','02/07/1992','Female','Single','','Regular','Daily',1,1,1,1,'07/07/1992','none','25,000','123123','123','13123',0,'53e3dd865bf56.jpg','09066009622','eloisa.corpuz','employee@lemon.com','2014-08-08 04:11:50','2014-08-08 04:11:50',NULL);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'HR Manager',NULL,'2014-07-29 10:16:23','2014-07-29 10:16:23'),(2,'HR Admin',NULL,'2014-07-29 10:18:46','2014-07-29 10:18:46'),(3,'Super Admin',NULL,'2014-07-29 10:22:51','2014-07-29 10:22:51'),(4,'kjhkh','{\"user\":1,\"user_create\":1,\"user_delete\":1}','2014-07-29 11:17:16','2014-07-29 11:17:16'),(5,'Employee',NULL,'2014-07-30 04:10:39','2014-07-30 04:10:39');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_position`
--

DROP TABLE IF EXISTS `job_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_position` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `job_position` varchar(100) NOT NULL,
  `job_description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_position`
--

LOCK TABLES `job_position` WRITE;
/*!40000 ALTER TABLE `job_position` DISABLE KEYS */;
INSERT INTO `job_position` VALUES (1,'Web Developer','','2014-08-07 13:42:55','2014-08-07 13:42:55',NULL);
/*!40000 ALTER TABLE `job_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_settings`
--

DROP TABLE IF EXISTS `payroll_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payroll_settings` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `form_name` varchar(100) NOT NULL,
  `json_config` text,
  `date_published` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_settings`
--

LOCK TABLES `payroll_settings` WRITE;
/*!40000 ALTER TABLE `payroll_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `payroll_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `throttle`
--

DROP TABLE IF EXISTS `throttle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(4) NOT NULL DEFAULT '0',
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `throttle`
--

LOCK TABLES `throttle` WRITE;
/*!40000 ALTER TABLE `throttle` DISABLE KEYS */;
INSERT INTO `throttle` VALUES (1,1,'::1',0,0,0,NULL,NULL,NULL),(2,2,'::1',0,0,0,NULL,NULL,NULL),(3,3,'::1',0,0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `throttle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(4) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'admin@lemon.com','$2y$10$mOVSzydNV6stv5WcPGlxdeuVpDJZOxytzGc9UrVMHDBEEZohkJkG.',NULL,1,NULL,NULL,'2014-08-08 08:31:46','$2y$10$B8Kc.zMj95y6Upnaygn2H.SC5swKuIU18YE0SyUwEzFTnxongTXQG',NULL,'Admininstrator','Lemon','2014-07-25 18:50:46','2014-08-08 00:31:46'),(3,'employee@lemon.com','$2y$10$flrt0fpK7mE2cxDPenqWCeDSkSeh8jq2.uDxlyED4h1Nrrt2B4VIO',NULL,1,NULL,NULL,'2014-08-08 04:13:16','$2y$10$fAqtBHdtPwc0dX/OYw4WeuQRy8MHJVNqABqjEYIRUb6ej8m2yV.aq',NULL,NULL,NULL,'2014-08-07 20:11:49','2014-08-07 20:13:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,3,1);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-08  8:36:32

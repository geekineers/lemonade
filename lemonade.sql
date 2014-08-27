-- MySQL dump 10.13  Distrib 5.6.20, for osx10.9 (x86_64)
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
-- Table structure for table `allowances`
--

DROP TABLE IF EXISTS `allowances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allowances` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `allowance_name` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allowances`
--

LOCK TABLES `allowances` WRITE;
/*!40000 ALTER TABLE `allowances` DISABLE KEYS */;
INSERT INTO `allowances` VALUES (1,'Food Meal','1','2014-08-18 13:01:14','2014-08-18 13:01:14',NULL,NULL),(2,'Hotel and Room','1','2014-08-27 23:16:20','2014-08-27 23:16:20',NULL,1);
/*!40000 ALTER TABLE `allowances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcement` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `author` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcement`
--

LOCK TABLES `announcement` WRITE;
/*!40000 ALTER TABLE `announcement` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `basic_pay_adjustments`
--

DROP TABLE IF EXISTS `basic_pay_adjustments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basic_pay_adjustments` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(5) NOT NULL,
  `created_by` int(5) NOT NULL,
  `current_basic_pay` float NOT NULL,
  `new_basic_pay` float NOT NULL,
  `effective_date` date NOT NULL,
  `adjustment_date` date NOT NULL,
  `adjustment_reason` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basic_pay_adjustments`
--

LOCK TABLES `basic_pay_adjustments` WRITE;
/*!40000 ALTER TABLE `basic_pay_adjustments` DISABLE KEYS */;
INSERT INTO `basic_pay_adjustments` VALUES (1,1,2,25000,80000,'2014-08-11','2014-08-11','Malupit na bata','2014-08-11 16:05:00','2014-08-11 16:05:00',NULL);
/*!40000 ALTER TABLE `basic_pay_adjustments` ENABLE KEYS */;
UNLOCK TABLES;

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
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'Capas Branch','','','','2014-08-07 13:42:38','2014-08-07 13:42:38',NULL,NULL);
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `company_description` text,
  `company_address` text NOT NULL,
  `company_contact_number` varchar(30) NOT NULL,
  `company_logo` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_sss` varchar(100) DEFAULT NULL,
  `line_of_business` varchar(100) DEFAULT NULL,
  `company_tin` varchar(100) DEFAULT NULL,
  `company_zip` varchar(100) DEFAULT NULL,
  `company_rdo` varchar(100) DEFAULT NULL,
  `company_philhealth` varchar(100) DEFAULT NULL,
  `company_tel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Lemonade Company','aldkasjdlas                                                \r\n                                            ','#8 Robina road Novalicjes','info@8layer.com','53fdd9becfcd4.png','2014-08-18 15:15:17','2014-08-27 21:14:38',NULL,'113123123123','Web Development',NULL,'12312313','12312312321',NULL,'41213123123'),(4,'Lemonade Company','aldkasjdlas                                                \r\n                                            ','#8 Robina road Novalicjes','info@8layer.com','53fdd7bf7fc16','2014-08-27 21:06:07','2014-08-27 21:06:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'Lemonade Company','aldkasjdlas                                                \r\n                                            ','#8 Robina road Novalicjes','info@8layer.com','53fdd8291f40f','2014-08-27 21:07:53','2014-08-27 21:07:53',NULL,'113123123123','Web Development',NULL,'12312313','12312312321',NULL,NULL),(6,'Lemonade Company','aldkasjdlas                                                \r\n                                            ','#8 Robina road Novalicjes','info@8layer.com','53fdd83601011','2014-08-27 21:08:06','2014-08-27 21:08:06',NULL,'113123123123','Web Development',NULL,'12312313','12312312321',NULL,NULL);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deductions`
--

DROP TABLE IF EXISTS `deductions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deductions` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `deduction_name` varchar(100) NOT NULL,
  `deduction_type` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deductions`
--

LOCK TABLES `deductions` WRITE;
/*!40000 ALTER TABLE `deductions` DISABLE KEYS */;
INSERT INTO `deductions` VALUES (1,'Car Loan','fix_amount','1','2014-08-08 12:22:12','2014-08-08 12:22:12',NULL,1),(2,'Car Loan','fix_amount','1','2014-08-08 12:22:24','2014-08-08 12:22:24',NULL,NULL),(3,'Car Loan','fix_amount','1','2014-08-08 12:24:21','2014-08-08 12:24:21',NULL,NULL),(4,'Food Deduction','fix_amount','1','2014-08-27 23:14:14','2014-08-27 23:14:14',NULL,1);
/*!40000 ALTER TABLE `deductions` ENABLE KEYS */;
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
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'IT Department','Information Technology Department','2014-08-09 17:59:22','2014-08-09 17:59:22',NULL,NULL);
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
-- Table structure for table `employee_allowances`
--

DROP TABLE IF EXISTS `employee_allowances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_allowances` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(5) NOT NULL,
  `allowance_id` int(5) NOT NULL,
  `recurring` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_allowances`
--

LOCK TABLES `employee_allowances` WRITE;
/*!40000 ALTER TABLE `employee_allowances` DISABLE KEYS */;
INSERT INTO `employee_allowances` VALUES (1,1,1,'Yes',1500,'2014-08-14','2015-04-09','2014-08-18 13:03:23','2014-08-18 13:03:23',NULL);
/*!40000 ALTER TABLE `employee_allowances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_deductions`
--

DROP TABLE IF EXISTS `employee_deductions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_deductions` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(5) NOT NULL,
  `deduction_id` int(5) NOT NULL,
  `recurring` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_deductions`
--

LOCK TABLES `employee_deductions` WRITE;
/*!40000 ALTER TABLE `employee_deductions` DISABLE KEYS */;
INSERT INTO `employee_deductions` VALUES (1,1,1,'Yes',500,'2014-08-14','2015-02-19','2014-08-18 12:50:09','2014-08-18 12:50:09',NULL);
/*!40000 ALTER TABLE `employee_deductions` ENABLE KEYS */;
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
  `birthdate` date NOT NULL,
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
  `withholding_tax_type` varchar(100) DEFAULT NULL,
  `expanded_withholding_tax` float DEFAULT NULL,
  `entitled_night_differential` int(5) DEFAULT NULL,
  `night_differential_rate` float DEFAULT NULL,
  `entitled_overtime_pay` int(5) DEFAULT NULL,
  `overtime_pay_rate` float DEFAULT NULL,
  `timesheet_required` int(5) DEFAULT NULL,
  `deduct_sss` tinyint(1) DEFAULT NULL,
  `fixed_sss_amount` float DEFAULT NULL,
  `deduct_hdmf` tinyint(1) DEFAULT NULL,
  `fixed_hdmf_amount` float DEFAULT NULL,
  `deduct_philhealth` tinyint(1) DEFAULT NULL,
  `fixed_philhealth_amount` float DEFAULT NULL,
  `timeshift_start` time DEFAULT NULL,
  `timeshift_end` time DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'2','Mark','Penaranda','Angel','#8 Robina Roaddasdzdczxc','1992-09-03','Male','Single','','Regular','Monthly',1,1,3,1,'07/07/1992','none','25000','123123','123','13123',0,'53e3121e449fc.jpg','09066009622','eloisa.corpuz','mark@sourcescript.ph','2014-08-07 13:43:59','2014-08-27 07:34:16',NULL,'Compensation',0,1,0,0,0,NULL,1,0,1,0,1,0,'07:30:00','07:30:00',1),(2,'','Eloisa ','Corpuz','Luzanos','#8 Robina Road','1992-09-03','Female','Single','','Regular','Monthly',1,1,1,1,'07/07/1992','none','25000','1212111','1212111','121211',0,'53e32f6e3da47.jpg','09066009622','eloisa.corpuz','eloisa@sourcescript.ph','2014-08-07 15:49:02','2014-08-07 17:53:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(4,'','John','Doe','Dee','Amsterdam','1992-02-10','Male','Single','','Regular','Daily',1,1,1,1,'07/07/1992','none','25000','123123','123','13123',4,'53e3dbefe96cb.jpg','09066009622','eloisa.corpuz','employee@lemon.com','2014-08-08 04:05:07','2014-08-08 04:05:07',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(5,'3','Jen','Dela Cruz','Dee ','Matatalaib Tarlac','1992-01-10','Female','Single','','Regular','Daily',1,1,2,1,'07/07/1992','none','25000','123123','123','13123',0,'53e3dd865bf56.jpg','09066009622','eloisa.corpuz','employee@lemon.com','2014-08-08 04:11:50','2014-08-27 11:06:35',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'11:00:00','11:00:00',1),(8,'6','Ben','Thompson','Ron','#3 Sesame Street Pasig City','2014-07-27','Male','Single','','Regular','Monthly',1,1,6,1,'2014-08-22','none','25000','','','',0,'53fcb181175f0.jpeg','09066009622','mark.a.penaranda','reg@lemon.com','2014-08-27 00:10:41','2014-08-27 00:10:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluations`
--

DROP TABLE IF EXISTS `evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evaluations` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_name` varchar(100) NOT NULL,
  `employee_id` int(5) NOT NULL,
  `created_by` int(5) NOT NULL,
  `evaluation_from` datetime NOT NULL,
  `evaluation_to` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `evaluation_description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluations`
--

LOCK TABLES `evaluations` WRITE;
/*!40000 ALTER TABLE `evaluations` DISABLE KEYS */;
INSERT INTO `evaluations` VALUES (1,'Promotion Review',1,1,'2014-08-05 00:00:00','2014-08-08 00:00:00','2014-08-26 11:44:42','2014-08-26 11:44:42',NULL,NULL);
/*!40000 ALTER TABLE `evaluations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_application`
--

DROP TABLE IF EXISTS `form_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_application` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `form_type` text NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `prepared_by` int(11) DEFAULT NULL,
  `effective_date` datetime NOT NULL,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `status` text NOT NULL,
  `form_data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_application`
--

LOCK TABLES `form_application` WRITE;
/*!40000 ALTER TABLE `form_application` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forms` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `form_name` varchar(100) NOT NULL,
  `form_content` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms`
--

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
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
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'HR Manager','{\"user_view\":1,\"user_create\":1,\"user_delete\":1,\"job_position_create\":1,\"job_position_view\":1,\"job_position_delete\":1,\"department_create\":1,\"department_view\":1,\"department_delete\":1,\"payroll_group_create\":1,\"payroll_group_view\":1,\"company_setting_edit\":1,\"deductions_create\":1,\"deductions_view\":1,\"deductions_delete\":1,\"allowance_create\":1,\"allowance_view\":1,\"allowance_delete\":1,\"holiday_create\":1,\"holiday_delete\":1,\"employee_create\":1,\"employee_view\":1,\"employee_delete\":1,\"employee_edit\":1,\"employee_schedule_evaluation\":1,\"employee_send_memo\":1,\"generate_payroll\":1,\"settings_view\":1,\"timesheet_import\":1,\"timesheet_view\":1}','2014-07-29 10:16:23','2014-08-27 02:57:19',NULL),(2,'HR Admin',NULL,'2014-07-29 10:18:46','2014-07-29 10:18:46',NULL),(3,'Super Admin','{\"user_view\":1,\"user_create\":1,\"user_delete\":1,\"branch_create\":1,\"branch_delete\":1,\"branch_view\":1,\"job_position_create\":1,\"job_position_view\":1,\"job_position_delete\":1,\"department_create\":1,\"department_view\":1,\"department_delete\":1,\"payroll_group_create\":1,\"payroll_group_view\":1,\"company_setting_edit\":1,\"deductions_create\":1,\"deductions_view\":1,\"deductions_delete\":1,\"allowance_create\":1,\"allowance_view\":1,\"allowance_delete\":1,\"holiday_create\":1,\"holiday_delete\":1,\"employee_create\":1,\"employee_view\":1,\"employee_delete\":1,\"employee_edit\":1,\"employee_schedule_evaluation\":1,\"employee_send_memo\":1,\"employee_add_allowance\":1,\"employee_add_deductions\":1,\"employee_add_files\":1,\"post_announcement\":1,\"generate_payroll\":1,\"settings_view\":1,\"timesheet_import\":1,\"timesheet_view\":1}','2014-07-29 10:22:51','2014-08-26 18:18:20',NULL),(5,'Employee',NULL,'2014-07-30 04:10:39','2014-07-30 04:10:39',NULL),(6,'Regular Employee','{\"user_view\":1,\"job_position_view\":1,\"deductions_view\":1,\"allowance_view\":1,\"employee_view\":1}','2014-08-26 15:37:39','2014-08-26 15:37:39',NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holiday_years`
--

DROP TABLE IF EXISTS `holiday_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holiday_years` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(100) NOT NULL,
  `created_by` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holiday_years`
--

LOCK TABLES `holiday_years` WRITE;
/*!40000 ALTER TABLE `holiday_years` DISABLE KEYS */;
INSERT INTO `holiday_years` VALUES (3,'2014',2,'2014-08-26 16:56:33','2014-08-26 16:56:33',NULL,NULL),(4,'2014',2,'2014-08-27 23:17:08','2014-08-27 23:17:08',NULL,1),(5,'2014',2,'2014-08-27 23:17:21','2014-08-27 23:17:21',NULL,1);
/*!40000 ALTER TABLE `holiday_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holidays` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(100) NOT NULL,
  `holiday_year_id` int(5) NOT NULL,
  `holiday_name` varchar(100) NOT NULL,
  `holiday_type` varchar(100) NOT NULL,
  `holiday_from` date NOT NULL,
  `holiday_to` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
INSERT INTO `holidays` VALUES (1,'2014',2014,'Bagong Taon','regular','2014-01-01','2014-01-01','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(2,'2014',2014,'Maulid un-Nabi','common local','2014-01-14','2014-01-14','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(3,'2014',2014,'Chinese Lunar New Year\'s Day','regular','2014-01-31','2014-01-31','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(4,'2014',2014,'People Power Anniversary','observance','2014-02-25','2014-02-25','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(5,'2014',2014,'March equinox','season','2014-03-20','2014-01-01','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(6,'2014',2014,'The Day of Valor','regular','2014-04-09','2014-04-09','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(7,'2014',2014,'Maundy Thursday','regular','2014-04-17','2014-04-17','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(8,'2014',2014,'Good Friday','special non-working','2014-04-19','2014-04-19','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(9,'2014',2014,'Easter Sunday','observance','2014-04-20','2014-01-01','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(10,'2014',2014,'Labor Day','regular','2014-05-01','2014-05-01','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(11,'2014',2014,'Lailatul Isra Wal Raj','regular','2014-05-27','2014-05-27','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(12,'2014',2014,'Independence Day','common local','2014-06-12','2014-06-12','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(13,'2014',2014,'June Solstice','season','2014-06-21','2014-06-21','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(14,'2014',2014,'Eidul-Fitar','common local','2014-07-29','2014-07-29','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(15,'2014',2014,'Ninoy Aquino Day','special non-working','2014-08-21','2014-08-21','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(16,'2014',2014,'National Heroes Day','regular','2014-08-24','2014-08-24','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(17,'2014',2014,'National Heroes Day Holiday','regular','2014-08-25','2014-08-25','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(18,'2014',2014,'September equinox','season','2014-09-23','2014-09-23','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(19,'2014',2014,'Id-ul-Adha (Feast of the Sacrifice)','common local','2014-10-04','2014-10-04','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(20,'2014',2014,'Amun Jadid','common local','2014-10-25','2014-10-25','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(21,'2014',2014,'All Saints\' Day','','2014-11-01','2014-11-01','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(22,'2014',2014,'All Souls\' Day','observance','2014-11-02','2014-11-02','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(23,'2014',2014,'December Solstice','regular','2014-12-21','2014-12-21','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(24,'2014',2014,'Christmas Eve','special non-working','2014-12-24','2014-12-24','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(25,'2014',2014,'Christmas Day','regular','2014-12-25','2014-12-25','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(26,'2014',2014,'Special Day after Christmas','special non-working','2014-01-01','2014-01-01','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(27,'2014',2014,'Rizal Day','regular','2014-12-30','2014-12-30','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(28,'2014',2014,'New Year\'s Eve','special non-working','2014-12-31','2014-12-31','2014-08-26 16:56:33','2014-08-26 18:16:42',NULL,NULL),(29,'2014',2014,'Foundation Day','regular','2014-08-08','2014-08-08','2014-08-26 18:36:13','2014-08-26 18:36:13',NULL,NULL);
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
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
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_position`
--

LOCK TABLES `job_position` WRITE;
/*!40000 ALTER TABLE `job_position` DISABLE KEYS */;
INSERT INTO `job_position` VALUES (1,'Web Developer','','2014-08-07 13:42:55','2014-08-07 13:42:55',NULL,1),(2,'Accountant','Helping other people','2014-08-27 00:57:28','2014-08-27 00:57:28',NULL,NULL),(3,'Product Manager','','2014-08-27 00:58:43','2014-08-27 00:58:43',NULL,NULL);
/*!40000 ALTER TABLE `job_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memos`
--

DROP TABLE IF EXISTS `memos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memos` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(100) NOT NULL,
  `to` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memos`
--

LOCK TABLES `memos` WRITE;
/*!40000 ALTER TABLE `memos` DISABLE KEYS */;
INSERT INTO `memos` VALUES (1,'1','1','Hi you have a pending form here in the HR Department.','2014-08-20 04:20:17','2014-08-20 04:20:17',NULL),(3,'1','1','You there?','2014-08-20 04:26:41','2014-08-20 04:26:41',NULL),(4,'5','1','Mark','2014-08-26 23:47:57','2014-08-26 23:47:57',NULL);
/*!40000 ALTER TABLE `memos` ENABLE KEYS */;
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
INSERT INTO `migrations` VALUES (27),(27);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_group`
--

DROP TABLE IF EXISTS `payroll_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payroll_group` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `group_name` text,
  `period` text,
  `prepared_by` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_group`
--

LOCK TABLES `payroll_group` WRITE;
/*!40000 ALTER TABLE `payroll_group` DISABLE KEYS */;
INSERT INTO `payroll_group` VALUES (1,1,'Regular','Monthly','2','2014-08-18 12:07:10','2014-08-18 12:07:10',NULL,NULL),(2,1,'Irregular','Monthly','2','2014-08-20 14:14:47','2014-08-20 14:14:47',NULL,NULL);
/*!40000 ALTER TABLE `payroll_group` ENABLE KEYS */;
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
-- Table structure for table `payslips`
--

DROP TABLE IF EXISTS `payslips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payslips` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `payroll_group` text,
  `sss` int(11) DEFAULT NULL,
  `philhealth` text,
  `pagibig` text,
  `other_deductions` int(11) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` text,
  `net` text,
  `gross` date DEFAULT NULL,
  `prepared_by` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payslips`
--

LOCK TABLES `payslips` WRITE;
/*!40000 ALTER TABLE `payslips` DISABLE KEYS */;
/*!40000 ALTER TABLE `payslips` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `throttle`
--

LOCK TABLES `throttle` WRITE;
/*!40000 ALTER TABLE `throttle` DISABLE KEYS */;
INSERT INTO `throttle` VALUES (1,1,'::1',0,0,0,NULL,NULL,NULL),(2,2,'::1',0,0,0,NULL,NULL,NULL),(3,3,'::1',0,0,0,NULL,NULL,NULL),(4,6,'::1',0,0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `throttle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timesheet`
--

DROP TABLE IF EXISTS `timesheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timesheet` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(5) NOT NULL,
  `source` varchar(100) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `cookie_registry` varchar(255) DEFAULT NULL,
  `company_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timesheet`
--

LOCK TABLES `timesheet` WRITE;
/*!40000 ALTER TABLE `timesheet` DISABLE KEYS */;
INSERT INTO `timesheet` VALUES (10,1,'Payroll Login','2014-08-12 22:28:53','2014-08-13 05:29:18','2014-08-12 03:28:53','2014-08-12 03:29:18',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$wfYofwIBvdHcFSrWHQOMY.YJBFNCv6gxZiA1KbhRN8P3I4NJhIBnm\";}',NULL),(11,1,'Payroll Login','2014-08-12 03:29:43','2014-08-12 03:30:09','2014-08-12 03:29:43','2014-08-12 03:30:09',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$GnurC6PxCVVJlzo4IqDRgOyC6cAlSg9sRa0FO4d3WqR8i1hXh63gm\";}',NULL),(12,1,'Payroll Login','2014-08-12 03:57:40','2014-08-12 03:58:31','2014-08-12 03:57:40','2014-08-12 03:58:31',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$nYQtGEXJ4PEEM2C5e0KlyunHDoV/Kjsr21LsKvU7Bw70v32ZKMdJS\";}',NULL),(13,1,'Payroll Login','2014-08-12 03:58:58','2014-08-13 11:27:43','2014-08-12 03:58:58','2014-08-13 11:27:43',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$lh2Vt3diQ7KGSdNNn9OOV.pipDeL6rWEb15L62r1CfypbBdsHxm1W\";}',NULL),(14,1,'Payroll Login','2014-08-13 11:27:58','2014-08-13 11:31:36','2014-08-13 11:27:58','2014-08-13 11:31:36',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$CjH68c6U8YkD0sZ1yCWaHuf9SqOFsfaQgLojOhy2eyMEmZhGiqplS\";}',NULL),(15,1,'Payroll Login','2014-08-26 11:38:12','2014-08-26 22:22:48','2014-08-26 11:38:12','2014-08-26 22:22:48',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$Ksfb5Mj2PfGTAr9CpnyYA.yHe4hBqeCgJPiZvW/ZmRZV99gHxXb46\";}',NULL),(16,5,'Payroll Login','2014-08-26 22:22:57','2014-08-26 23:22:17','2014-08-26 22:22:57','2014-08-26 23:22:17',NULL,'a:2:{i:0;s:1:\"3\";i:1;s:60:\"$2y$10$./Hn8TD6rEyjw304RxMNVewB.IFOC/XeW8U70oL89DkuQTjcSKdP6\";}',NULL),(17,1,'Payroll Login','2014-08-26 23:48:41','2014-08-27 00:08:04','2014-08-26 23:48:41','2014-08-27 00:08:04',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$mAS6o9tPJfSPo3MPVK7NxeowmRK4l1luxEZUdnJZEYG2c8bFNpj.2\";}',NULL),(18,1,'Payroll Login','2014-08-27 00:08:21','2014-08-27 00:11:02','2014-08-27 00:08:21','2014-08-27 00:11:02',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$.VmBfIj4sRbpJQbdP1gtrOepSjNyuk5/hJP1H3Sw8IhokitFxyYXi\";}',NULL),(19,8,'Payroll Login','2014-08-27 00:11:10','2014-08-27 01:40:50','2014-08-27 00:11:10','2014-08-27 01:40:50',NULL,'a:2:{i:0;s:1:\"6\";i:1;s:60:\"$2y$10$hGRuMnywsbxUGsWv5Ixd.uUXEbxuDbD/IVK2l7fGWYlVn5yPaF.E.\";}',NULL),(20,8,'Payroll Login','2014-08-27 02:19:09','2014-08-27 02:20:08','2014-08-27 02:19:09','2014-08-27 02:20:08',NULL,'a:2:{i:0;s:1:\"6\";i:1;s:60:\"$2y$10$Yx0cDIfGaZMxNjSLNtTuP.S7ZyeLqxzQ.P8J/q/72V7fKOj0Mq6iO\";}',NULL),(21,1,'Payroll Login','2014-08-27 02:20:28','2014-08-27 03:28:11','2014-08-27 02:20:28','2014-08-27 03:28:11',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$DWNdhjh9jAnTcBPDiaE03u0MvRx47hMbXy7uqrmjleE.SbpuXVlJy\";}',NULL),(22,8,'Payroll Login','2014-08-27 03:28:45','2014-08-27 03:29:23','2014-08-27 03:28:45','2014-08-27 03:29:23',NULL,'a:2:{i:0;s:1:\"6\";i:1;s:60:\"$2y$10$xqVqzTibFiBXSkptSzlVEuqqTCslmSEgAXvIZsd4QBvOVPfO69sR6\";}',NULL),(23,1,'Payroll Login','2014-08-27 04:07:00','2014-08-27 04:08:58','2014-08-27 04:07:00','2014-08-27 04:08:58',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$QrkZeLlRvpg8t8bU8XDY0.WWaEMlAyt5h2TusgKAizzvyhcwZLMH6\";}',NULL),(24,8,'Payroll Login','2014-08-27 04:09:07','2014-08-27 04:09:12','2014-08-27 04:09:07','2014-08-27 04:09:12',NULL,'a:2:{i:0;s:1:\"6\";i:1;s:60:\"$2y$10$FQUnrS9jQR3aI0FhTgBUNuTj0QJiVcPANMyf6eZ4ZjnJ0pacws0ni\";}',NULL),(25,1,'Payroll Login','2014-08-27 04:09:23','2014-08-27 07:34:23','2014-08-27 04:09:23','2014-08-27 07:34:23',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$WTySB9yipIV8OJ2DUJ6O7OByr7J879L7aQCZyWgI5HApC9V9pftQe\";}',NULL),(26,8,'Payroll Login','2014-08-27 07:34:46','2014-08-27 07:34:52','2014-08-27 07:34:46','2014-08-27 07:34:52',NULL,'a:2:{i:0;s:1:\"6\";i:1;s:60:\"$2y$10$Yj3Pbk.xgiFxS8TLAFi9LOglTlTHyjNn7NRuDvPP50MDLTGyvTJMK\";}',NULL),(27,1,'Payroll Login','2014-08-27 07:35:01','2014-08-27 07:35:23','2014-08-27 07:35:01','2014-08-27 07:35:23',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$gIcKPtSpRce.ejYNM5GJL.6NVsvffnGZ11RMFm4CKb8aB3jcgh0x.\";}',NULL),(28,5,'Payroll Login','2014-08-27 07:35:37','2014-08-27 07:35:48','2014-08-27 07:35:37','2014-08-27 07:35:48',NULL,'a:2:{i:0;s:1:\"3\";i:1;s:60:\"$2y$10$0xo.HN8UCTdIDxdHPCzQ2O73OIygFRxLvfWD802oDCCnDGraz1uNW\";}',NULL),(29,1,'Payroll Login','2014-08-27 07:36:07','2014-08-27 07:36:10','2014-08-27 07:36:07','2014-08-27 07:36:10',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$Th/BphcpnANO46r0AqHi7O3wmKHGDUKY8E06iBZzTtIsuFIKLKHbi\";}',NULL),(30,1,'Payroll Login','2014-08-27 07:43:02','2014-08-27 07:43:06','2014-08-27 07:43:02','2014-08-27 07:43:06',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$hL.UJSE3zyoCV7FDxQLLneViYdgKx3ZneGNE7GPIZAMOtFBH244Su\";}',NULL),(31,1,'Payroll Login','2014-08-27 07:56:26','2014-08-27 10:02:49','2014-08-27 07:56:26','2014-08-27 10:02:49',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$gpO6LmQQhlx7vbZpGqt0t.vy5z6bs5x31gpb..EsMdojCeUcFSww6\";}',NULL),(32,1,'Payroll Login','2014-08-27 10:03:01','2014-08-27 10:07:14','2014-08-27 10:03:01','2014-08-27 10:07:14',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$0hYe3mgO6NYulYq6v0fkuevTADuY2T9298n5Jyrl6hk8iisYVSoLe\";}',NULL),(33,1,'Payroll Login','2014-08-27 10:03:33','2014-08-27 10:07:14','2014-08-27 10:03:33','2014-08-27 10:07:14',NULL,'a:2:{i:0;s:1:\"2\";i:1;s:60:\"$2y$10$0hYe3mgO6NYulYq6v0fkuevTADuY2T9298n5Jyrl6hk8iisYVSoLe\";}',NULL),(34,8,'Payroll Login','2014-08-27 10:07:27','2014-08-27 10:17:33','2014-08-27 10:07:27','2014-08-27 10:17:33',NULL,'a:2:{i:0;s:1:\"6\";i:1;s:60:\"$2y$10$ywnyKuuah.YoMPDAJq99ge2a0GHxstxZzv1RwWlQhfsK4tTtL4BjS\";}',NULL);
/*!40000 ALTER TABLE `timesheet` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'admin@lemon.com','$2y$10$mOVSzydNV6stv5WcPGlxdeuVpDJZOxytzGc9UrVMHDBEEZohkJkG.',NULL,1,NULL,NULL,'2014-08-27 23:57:44','$2y$10$m1/yyf.RJpRqGatIS7X2GezdStf8i6giK1GF6tr9q7aF/ypUvGSom',NULL,'Admininstrator','Lemon','2014-07-25 18:50:46','2014-08-27 15:57:44'),(3,'employee@lemon.com','$2y$10$flrt0fpK7mE2cxDPenqWCeDSkSeh8jq2.uDxlyED4h1Nrrt2B4VIO',NULL,1,NULL,NULL,'2014-08-27 10:59:06','$2y$10$tk9o7zKGrWPHaItF2FF9Yum/dbVnOdUqzPJIzu22s7sD7KmA./iuG',NULL,NULL,NULL,'2014-08-07 20:11:49','2014-08-27 02:59:06'),(4,'markangelpenaranda@gmail.com123213','$2y$10$7s80dXiXmoXAzGG26zd1B..v0sAbyPN53c16cAlZ0XoxhNDPuSVuS',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-22 10:18:41','2014-08-22 10:18:41'),(5,'regemp@lemon.com','$2y$10$M5U0GG8AEIkRbeIu3AMWH.9Z0OO2zh2I/e/Br6h4nEEXXgv2eEvUC',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-26 15:59:09','2014-08-26 15:59:09'),(6,'reg@lemon.com','$2y$10$/N0mbS7W4TjZZzrY0h6vD.sxjYMk3gp4ma.63SeqHRE/8DS6IR2wi',NULL,1,NULL,NULL,'2014-08-27 10:42:48','$2y$10$c7i/E7aeS5GAo00IK4b13O5XrEXQI2unyC0CClFHCGGUDBB3A9F36',NULL,NULL,NULL,'2014-08-26 16:10:41','2014-08-27 02:42:48');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (2,4,1),(3,5,6),(4,6,6),(5,2,3),(9,3,2);
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

-- Dump completed on 2014-08-28  0:00:22

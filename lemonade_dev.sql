-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2014 at 05:22 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lemonade_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE IF NOT EXISTS `allowances` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `allowance_name` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `allowance_name`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Food Meal', '1', '2014-08-18 13:01:14', '2014-08-18 13:01:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE IF NOT EXISTS `announcement` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `author` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `author`, `title`, `content`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 1, 'Announcement to all', 'We have new features', '2014-08-20 11:13:53', '2014-08-20 11:13:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `basic_pay_adjustments`
--

CREATE TABLE IF NOT EXISTS `basic_pay_adjustments` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `basic_pay_adjustments`
--

INSERT INTO `basic_pay_adjustments` (`id`, `employee_id`, `created_by`, `current_basic_pay`, `new_basic_pay`, `effective_date`, `adjustment_date`, `adjustment_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 25000, 80000, '2014-08-11', '2014-08-11', 'Malupit na bata', '2014-08-11 16:05:00', '2014-08-11 16:05:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(100) NOT NULL,
  `branch_description` text,
  `branch_address` text NOT NULL,
  `branch_contact_number` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `branch_description`, `branch_address`, `branch_contact_number`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Capas Branch', '', '', '', '2014-08-07 13:42:38', '2014-08-07 13:42:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `company_description` text,
  `company_address` text NOT NULL,
  `company_contact_number` varchar(30) NOT NULL,
  `company_logo` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `company_description`, `company_address`, `company_contact_number`, `company_logo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lemonade Company', 'aldkasjdlas                                                \r\n                                            ', '#8 Robina road Novalicjes', 'info@8layer.com', '53f1a80551652.png', '2014-08-18 15:15:17', '2014-08-18 15:15:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE IF NOT EXISTS `deductions` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `deduction_name` varchar(100) NOT NULL,
  `deduction_type` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `deduction_name`, `deduction_type`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Car Loan', 'fix_amount', '1', '2014-08-08 12:22:12', '2014-08-08 12:22:12', NULL),
(2, 'Car Loan', 'fix_amount', '1', '2014-08-08 12:22:24', '2014-08-08 12:22:24', NULL),
(3, 'Car Loan', 'fix_amount', '1', '2014-08-08 12:24:21', '2014-08-08 12:24:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) NOT NULL,
  `department_description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department_name`, `department_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'IT Department', 'Information Technology Department', '2014-08-09 17:59:22', '2014-08-09 17:59:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `employee_id`, `name`, `file_description`, `file_name`, `file_size`, `file_type`, `file_extension`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Resume File', 'asdasdsad', '53e3cf238d3ad.pdf', '222529', 'application/pdf', 'pdf', '2014-08-08 03:10:27', '2014-08-08 03:10:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `first_name`, `last_name`, `middle_name`, `full_address`, `birthdate`, `gender`, `marital_status`, `spouse_name`, `employee_type`, `payroll_period`, `job_position`, `department`, `role_id`, `branch_id`, `date_hired`, `date_ended`, `basic_pay`, `tin_number`, `sss_number`, `pagibig_number`, `dependents`, `profile_picture`, `contact_number`, `fb`, `email`, `created_at`, `updated_at`, `deleted_at`, `withholding_tax_type`, `expanded_withholding_tax`, `entitled_night_differential`, `night_differential_rate`, `entitled_overtime_pay`, `overtime_pay_rate`, `timesheet_required`, `deduct_sss`, `fixed_sss_amount`, `deduct_hdmf`, `fixed_hdmf_amount`, `deduct_philhealth`, `fixed_philhealth_amount`, `timeshift_start`, `timeshift_end`) VALUES
(1, '2', 'Mark', 'Penaranda', 'Angel', '#8 Robina Roaddasdzdczxc', '1992-09-03', 'Male', 'Single', '', 'Regular', 'Monthly', 1, 1, 0, 1, '07/07/1992', 'none', '25000', '123123', '123', '13123', 0, '53e3121e449fc.jpg', '09066009622', 'eloisa.corpuz', 'mark@sourcescript.ph', '2014-08-07 13:43:59', '2014-08-18 05:37:24', NULL, 'Compensation', 0, 1, 0, 0, 0, NULL, 1, 0, 1, 0, 1, 0, '05:30:00', '23:30:00'),
(2, '', 'Eloisa ', 'Corpuz', 'Luzanos', '#8 Robina Road', '1992-09-03', 'Female', 'Single', '', 'Regular', 'Monthly', 1, 1, 1, 1, '07/07/1992', 'none', '25000', '1212111', '1212111', '121211', 0, '53e32f6e3da47.jpg', '09066009622', 'eloisa.corpuz', 'eloisa@sourcescript.ph', '2014-08-07 15:49:02', '2014-08-07 17:53:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '', 'John', 'Doe', 'Dee', 'Amsterdam', '1992-02-10', 'Male', 'Single', '', 'Regular', 'Daily', 1, 1, 1, 1, '07/07/1992', 'none', '25000', '123123', '123', '13123', 4, '53e3dbefe96cb.jpg', '09066009622', 'eloisa.corpuz', 'employee@lemon.com', '2014-08-08 04:05:07', '2014-08-08 04:05:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '3', 'Jen', 'Dela Cruz', 'Dee ', 'Matatalaib Tarlac', '1992-01-10', 'Female', 'Single', '', 'Regular', 'Daily', 1, 1, 1, 1, '07/07/1992', 'none', '25000', '123123', '123', '13123', 0, '53e3dd865bf56.jpg', '09066009622', 'eloisa.corpuz', 'employee@lemon.com', '2014-08-08 04:11:50', '2014-08-08 04:11:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_allowances`
--

CREATE TABLE IF NOT EXISTS `employee_allowances` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `employee_allowances`
--

INSERT INTO `employee_allowances` (`id`, `employee_id`, `allowance_id`, `recurring`, `amount`, `valid_from`, `valid_to`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Yes', 1500, '2014-08-14', '2015-04-09', '2014-08-18 13:03:23', '2014-08-18 13:03:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_deductions`
--

CREATE TABLE IF NOT EXISTS `employee_deductions` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `employee_deductions`
--

INSERT INTO `employee_deductions` (`id`, `employee_id`, `deduction_id`, `recurring`, `amount`, `valid_from`, `valid_to`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Yes', 500, '2014-08-14', '2015-02-19', '2014-08-18 12:50:09', '2014-08-18 12:50:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `form_name` varchar(100) NOT NULL,
  `form_content` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'HR Manager', NULL, '2014-07-29 10:16:23', '2014-07-29 10:16:23'),
(2, 'HR Admin', NULL, '2014-07-29 10:18:46', '2014-07-29 10:18:46'),
(3, 'Super Admin', NULL, '2014-07-29 10:22:51', '2014-07-29 10:22:51'),
(4, 'kjhkh', '{"user":1,"user_create":1,"user_delete":1}', '2014-07-29 11:17:16', '2014-07-29 11:17:16'),
(5, 'Employee', NULL, '2014-07-30 04:10:39', '2014-07-30 04:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `job_position`
--

CREATE TABLE IF NOT EXISTS `job_position` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `job_position` varchar(100) NOT NULL,
  `job_description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `job_position`
--

INSERT INTO `job_position` (`id`, `job_position`, `job_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Web Developer', '', '2014-08-07 13:42:55', '2014-08-07 13:42:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `memos`
--

CREATE TABLE IF NOT EXISTS `memos` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(100) NOT NULL,
  `to` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `memos`
--

INSERT INTO `memos` (`id`, `from`, `to`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', '1', 'Hi you have a pending form here in the HR Department.', '2014-08-20 04:20:17', '2014-08-20 04:20:17', NULL),
(3, '1', '1', 'You there?', '2014-08-20 04:26:41', '2014-08-20 04:26:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(20),
(20);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_group`
--

CREATE TABLE IF NOT EXISTS `payroll_group` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `group_name` text,
  `period` text,
  `prepared_by` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payroll_group`
--

INSERT INTO `payroll_group` (`id`, `branch_id`, `group_name`, `period`, `prepared_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Regular', 'Monthly', '2', '2014-08-18 12:07:10', '2014-08-18 12:07:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_settings`
--

CREATE TABLE IF NOT EXISTS `payroll_settings` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `form_name` varchar(100) NOT NULL,
  `json_config` text,
  `date_published` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE IF NOT EXISTS `payslips` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `ip_address`, `attempts`, `suspended`, `banned`, `last_attempt_at`, `suspended_at`, `banned_at`) VALUES
(1, 1, '::1', 0, 0, 0, NULL, NULL, NULL),
(2, 2, '::1', 0, 0, 0, NULL, NULL, NULL),
(3, 3, '::1', 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE IF NOT EXISTS `timesheet` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(5) NOT NULL,
  `source` varchar(100) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `cookie_registry` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`id`, `employee_id`, `source`, `time_in`, `time_out`, `created_at`, `updated_at`, `deleted_at`, `cookie_registry`) VALUES
(10, 1, 'Payroll Login', '2014-08-12 03:28:53', '2014-08-12 03:29:18', '2014-08-12 03:28:53', '2014-08-12 03:29:18', NULL, 'a:2:{i:0;s:1:"2";i:1;s:60:"$2y$10$wfYofwIBvdHcFSrWHQOMY.YJBFNCv6gxZiA1KbhRN8P3I4NJhIBnm";}'),
(11, 1, 'Payroll Login', '2014-08-12 03:29:43', '2014-08-12 03:30:09', '2014-08-12 03:29:43', '2014-08-12 03:30:09', NULL, 'a:2:{i:0;s:1:"2";i:1;s:60:"$2y$10$GnurC6PxCVVJlzo4IqDRgOyC6cAlSg9sRa0FO4d3WqR8i1hXh63gm";}'),
(12, 1, 'Payroll Login', '2014-08-12 03:57:40', '2014-08-12 03:58:31', '2014-08-12 03:57:40', '2014-08-12 03:58:31', NULL, 'a:2:{i:0;s:1:"2";i:1;s:60:"$2y$10$nYQtGEXJ4PEEM2C5e0KlyunHDoV/Kjsr21LsKvU7Bw70v32ZKMdJS";}'),
(13, 1, 'Payroll Login', '2014-08-12 03:58:58', '2014-08-13 11:27:43', '2014-08-12 03:58:58', '2014-08-13 11:27:43', NULL, 'a:2:{i:0;s:1:"2";i:1;s:60:"$2y$10$lh2Vt3diQ7KGSdNNn9OOV.pipDeL6rWEb15L62r1CfypbBdsHxm1W";}'),
(14, 1, 'Payroll Login', '2014-08-13 11:27:58', '2014-08-13 11:31:36', '2014-08-13 11:27:58', '2014-08-13 11:31:36', NULL, 'a:2:{i:0;s:1:"2";i:1;s:60:"$2y$10$CjH68c6U8YkD0sZ1yCWaHuf9SqOFsfaQgLojOhy2eyMEmZhGiqplS";}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(2, 'admin@lemon.com', '$2y$10$mOVSzydNV6stv5WcPGlxdeuVpDJZOxytzGc9UrVMHDBEEZohkJkG.', NULL, 1, NULL, NULL, '2014-08-17 13:47:50', '$2y$10$yP4s2aFcnpwTIDtrpyBS9.lBQxUNNo1J4bSZQVq5XnbW57xt3toHW', NULL, 'Admininstrator', 'Lemon', '2014-07-25 18:50:46', '2014-08-17 05:47:50'),
(3, 'employee@lemon.com', '$2y$10$flrt0fpK7mE2cxDPenqWCeDSkSeh8jq2.uDxlyED4h1Nrrt2B4VIO', NULL, 1, NULL, NULL, '2014-08-08 04:13:16', '$2y$10$fAqtBHdtPwc0dX/OYw4WeuQRy8MHJVNqABqjEYIRUb6ej8m2yV.aq', NULL, NULL, NULL, '2014-08-07 20:11:49', '2014-08-07 20:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 3, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

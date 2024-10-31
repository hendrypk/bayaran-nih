-- MySQL dump 10.16  Distrib 10.1.48-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: db
-- ------------------------------------------------------
-- Server version	10.1.48-MariaDB-0+deb9u2

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
-- Table structure for table `biodatas`
--

DROP TABLE IF EXISTS `biodatas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `biodatas` (
  `id` varchar(0) DEFAULT NULL,
  `user_id` varchar(0) DEFAULT NULL,
  `first_name` varchar(0) DEFAULT NULL,
  `last_name` varchar(0) DEFAULT NULL,
  `whatsapp` varchar(0) DEFAULT NULL,
  `email` varchar(0) DEFAULT NULL,
  `last_education` varchar(0) DEFAULT NULL,
  `gender` varchar(0) DEFAULT NULL,
  `location` varchar(0) DEFAULT NULL,
  `month_start` varchar(0) DEFAULT NULL,
  `year_start` varchar(0) DEFAULT NULL,
  `month_end` varchar(0) DEFAULT NULL,
  `year_end` varchar(0) DEFAULT NULL,
  `about` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `biodatas`
--

LOCK TABLES `biodatas` WRITE;
/*!40000 ALTER TABLE `biodatas` DISABLE KEYS */;
/*!40000 ALTER TABLE `biodatas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(0) DEFAULT NULL,
  `value` varchar(0) DEFAULT NULL,
  `expiration` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(0) DEFAULT NULL,
  `owner` varchar(0) DEFAULT NULL,
  `expiration` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(11) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'Sales','','',''),(2,'Operational','','','');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `division`
--

DROP TABLE IF EXISTS `division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `division` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(11) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `division`
--

LOCK TABLES `division` WRITE;
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
INSERT INTO `division` VALUES (1,'Hospitality','','',''),(2,'Embrodiery','','','');
/*!40000 ALTER TABLE `division` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_status`
--

DROP TABLE IF EXISTS `employee_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_status` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(8) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_status`
--

LOCK TABLES `employee_status` WRITE;
/*!40000 ALTER TABLE `employee_status` DISABLE KEYS */;
INSERT INTO `employee_status` VALUES (1,'Contract','','','');
/*!40000 ALTER TABLE `employee_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
Query SQL: Salin


CREATE TABLE `employees` (
  `id` tinyint(4) DEFAULT NULL,
  `eid` smallint(6) DEFAULT NULL,
  `name` varchar(11) DEFAULT NULL,
  `position` varchar(16) DEFAULT NULL,
  `jobTitle` varchar(10) DEFAULT NULL,
  `division` varchar(11) DEFAULT NULL,
  `department` varchar(11) DEFAULT NULL,
  `joiningDate` varchar(10) DEFAULT NULL,
  `workSchedule` varchar(4) DEFAULT NULL,
  `workCalendar` varchar(4) DEFAULT NULL,
  `employeeStatus` varchar(8) DEFAULT NULL,
  `salesStatus` varchar(2) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL,
  `status` varchar(0) DEFAULT NULL,
  `city` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
MySQL menyatakan: Dokumentasi

#1005 - Can't create table `sips4226_bayaran`.`employees` (errno: 150 "Foreign key constraint is incorrectly formed") (Rincian…)
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (6,5006,'Hafidz','Customer Service','Staff','Hospitality','Sales','2022-07-05','Umum','Umum','Contract','No','','','','',''),(7,3009,'Abdul Rosid','Select position','Supervisor','Embrodiery','Operational','1995-01-03','2','Umum','Contract','No','','','','',''),(8,5008,'hendry','Customer Service','Staff','Hospitality','Sales','2023-11-11','1','Umum','Contract','No','','','','','');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` varchar(0) DEFAULT NULL,
  `uuid` varchar(0) DEFAULT NULL,
  `connection` varchar(0) DEFAULT NULL,
  `queue` varchar(0) DEFAULT NULL,
  `payload` varchar(0) DEFAULT NULL,
  `exception` varchar(0) DEFAULT NULL,
  `failed_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade_pa`
--

DROP TABLE IF EXISTS `grade_pa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade_pa` (
  `id` tinyint(4) DEFAULT NULL,
  `eid` tinyint(4) DEFAULT NULL,
  `month` varchar(7) DEFAULT NULL,
  `year` smallint(6) DEFAULT NULL,
  `appraisal_id` tinyint(4) DEFAULT NULL,
  `grade` tinyint(4) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade_pa`
--

LOCK TABLES `grade_pa` WRITE;
/*!40000 ALTER TABLE `grade_pa` DISABLE KEYS */;
INSERT INTO `grade_pa` VALUES (21,6,'January',2014,1,60,'',''),(22,6,'January',2014,2,70,'',''),(23,6,'January',2014,3,80,'','');
/*!40000 ALTER TABLE `grade_pa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(0) DEFAULT NULL,
  `name` varchar(0) DEFAULT NULL,
  `total_jobs` varchar(0) DEFAULT NULL,
  `pending_jobs` varchar(0) DEFAULT NULL,
  `failed_jobs` varchar(0) DEFAULT NULL,
  `failed_job_ids` varchar(0) DEFAULT NULL,
  `options` varchar(0) DEFAULT NULL,
  `cancelled_at` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `finished_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_titles`
--

DROP TABLE IF EXISTS `job_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_titles` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(10) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL,
  `section` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_titles`
--

LOCK TABLES `job_titles` WRITE;
/*!40000 ALTER TABLE `job_titles` DISABLE KEYS */;
INSERT INTO `job_titles` VALUES (1,'Staff','','','',5),(2,'Supervisor','','','',3);
/*!40000 ALTER TABLE `job_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` varchar(0) DEFAULT NULL,
  `queue` varchar(0) DEFAULT NULL,
  `payload` varchar(0) DEFAULT NULL,
  `attempts` varchar(0) DEFAULT NULL,
  `reserved_at` varchar(0) DEFAULT NULL,
  `available_at` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` tinyint(4) DEFAULT NULL,
  `migration` varchar(49) DEFAULT NULL,
  `batch` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_07_10_134838_add_colung',2),(5,'2024_07_06_155535_biodatas',3),(6,'2024_07_06_160824_biodatas',3),(7,'2024_08_19_140550_employees',4),(8,'2024_08_20_064824_addemployee',5),(9,'2024_08_20_070117_tableemplo',6),(10,'2024_08_20_070330_deleteeid',7),(11,'2024_08_20_070928_editeid',8),(12,'2024_08_20_071302_del',9),(13,'2024_08_20_072959_options',10),(14,'2024_08_20_091219_editposition',11),(15,'2024_08_20_091617_epo',12),(16,'2024_08_21_023638_editjobtitle',13),(17,'2024_08_21_024527_edijob',14),(18,'2024_08_21_060700_renamjob',15),(19,'2024_08_21_060901_renamjobb',16),(20,'2024_08_21_063036_renampos',17),(21,'2024_08_21_071821_updatedivision',18),(22,'2024_08_21_072010_aaupdatedivision',19),(23,'2024_08_21_073031_editdepartment',20),(24,'2024_08_21_073649_edepert',21),(25,'2024_08_22_022406_sales',22),(26,'2024_08_22_042954_presence',23),(27,'2024_08_22_082816_on_day_calendar',24),(28,'2024_08_22_084642_edit_on_day_calendar',25),(29,'2024_08_22_112501_editsalesperson',26),(30,'2024_08_22_112746_edittsales',27),(31,'2024_08_22_113028_edittsaless',28),(32,'2024_08_22_113330_edittsalessss',29),(33,'2024_08_23_071804_aaposition',30),(34,'2024_08_23_090756_jobposkuwalik',31),(35,'2024_08_23_091244_addsecjob',32),(36,'2024_08_24_043241_options',33),(37,'2024_08_26_040243_workload',34),(38,'2024_08_26_040953_rename_work',35),(39,'2024_08_26_044255_sales_edit',36),(40,'2024_08_26_044602_ssales_edit',37),(41,'2024_08_27_043959_employee_status',38),(42,'2024_08_27_061027_add_status_employee',39),(43,'2024_08_28_024740_schedulee',40),(44,'2024_08_28_081151_overrr',41),(45,'2024_08_28_104043_oover',42),(46,'2024_08_28_104450_ooover',43),(47,'2024_08_28_132959_city_employee',44),(48,'2024_08_28_134704_city_employeedd',45),(49,'2024_08_28_165052_eidpres',46),(50,'2024_08_28_165238_eidpresaa',47),(51,'2024_08_28_165338_eidpresaaaa',48),(52,'2024_08_29_043619_presenlate',49),(53,'2024_08_29_081018_presns',50),(54,'2024_09_02_042913_grade_pa',51),(55,'2024_09_02_043057_performance_appraisals',52),(56,'2024_09_02_043529_performance_kpis',53),(57,'2024_09_02_050054_rename_performance_appraisals',54),(58,'2024_09_02_155105_add_index_to_work_schedule_name',55),(59,'2024_09_03_024255_payrolls',56),(60,'2024_09_03_043637_drop_job_kpi',57),(61,'2024_09_03_090412_delete_kpi',58),(62,'2024_09_03_101616_kpi_optionsss',59),(63,'2024_09_04_022602_kpi_id_positio',60),(64,'2024_09_04_024842_aa_kpi_id_positio',61),(65,'2024_09_04_025155_aga_kpi_id_positio',62),(66,'2024_09_04_030242_kkaga_kpi_id_positio',63),(67,'2024_09_04_030549_hhkkaga_kpi_id_positio',64);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `on_day_calendar`
--

DROP TABLE IF EXISTS `on_day_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `on_day_calendar` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(4) DEFAULT NULL,
  `jan` tinyint(4) DEFAULT NULL,
  `feb` tinyint(4) DEFAULT NULL,
  `mar` tinyint(4) DEFAULT NULL,
  `apr` tinyint(4) DEFAULT NULL,
  `may` tinyint(4) DEFAULT NULL,
  `jun` tinyint(4) DEFAULT NULL,
  `jul` tinyint(4) DEFAULT NULL,
  `aug` tinyint(4) DEFAULT NULL,
  `sep` tinyint(4) DEFAULT NULL,
  `oct` tinyint(4) DEFAULT NULL,
  `nov` tinyint(4) DEFAULT NULL,
  `dec` tinyint(4) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `on_day_calendar`
--

LOCK TABLES `on_day_calendar` WRITE;
/*!40000 ALTER TABLE `on_day_calendar` DISABLE KEYS */;
INSERT INTO `on_day_calendar` VALUES (1,'Umum',26,26,26,26,26,26,26,26,26,26,26,26,'','');
/*!40000 ALTER TABLE `on_day_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` varchar(0) DEFAULT NULL,
  `name` varchar(0) DEFAULT NULL,
  `type` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `overtime`
--

DROP TABLE IF EXISTS `overtime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `overtime` (
  `id` tinyint(4) DEFAULT NULL,
  `eid` smallint(6) DEFAULT NULL,
  `employee_name` varchar(11) DEFAULT NULL,
  `date` varchar(0) DEFAULT NULL,
  `start_at` varchar(5) DEFAULT NULL,
  `end_at` varchar(5) DEFAULT NULL,
  `total` tinyint(4) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `overtime`
--

LOCK TABLES `overtime` WRITE;
/*!40000 ALTER TABLE `overtime` DISABLE KEYS */;
INSERT INTO `overtime` VALUES (3,3009,'Abdul Rosid','','16:05','16:47',42,'','','');
/*!40000 ALTER TABLE `overtime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(0) DEFAULT NULL,
  `token` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_options`
--

DROP TABLE IF EXISTS `payroll_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payroll_options` (
  `id` varchar(0) DEFAULT NULL,
  `eid` varchar(0) DEFAULT NULL,
  `name` varchar(0) DEFAULT NULL,
  `basic` varchar(0) DEFAULT NULL,
  `health` varchar(0) DEFAULT NULL,
  `meal` varchar(0) DEFAULT NULL,
  `dicipline` varchar(0) DEFAULT NULL,
  `performance` varchar(0) DEFAULT NULL,
  `comission` varchar(0) DEFAULT NULL,
  `overtime` varchar(0) DEFAULT NULL,
  `uang_pisah` varchar(0) DEFAULT NULL,
  `leave_cahsed` varchar(0) DEFAULT NULL,
  `absence` varchar(0) DEFAULT NULL,
  `lateness` varchar(0) DEFAULT NULL,
  `meal_deduction` varchar(0) DEFAULT NULL,
  `dicipline_deduction` varchar(0) DEFAULT NULL,
  `check_out_early` varchar(0) DEFAULT NULL,
  `penalty` varchar(0) DEFAULT NULL,
  `comission_deduction` varchar(0) DEFAULT NULL,
  `loan` varchar(0) DEFAULT NULL,
  `sallary_adjustment` varchar(0) DEFAULT NULL,
  `kpi_percent` varchar(0) DEFAULT NULL,
  `pa_percent` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_options`
--

LOCK TABLES `payroll_options` WRITE;
/*!40000 ALTER TABLE `payroll_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `payroll_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `performance`
--

DROP TABLE IF EXISTS `performance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `performance` (
  `id` varchar(0) DEFAULT NULL,
  `eid` varchar(0) DEFAULT NULL,
  `employee_name` varchar(0) DEFAULT NULL,
  `kpi` varchar(0) DEFAULT NULL,
  `pa` varchar(0) DEFAULT NULL,
  `grade` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `performance`
--

LOCK TABLES `performance` WRITE;
/*!40000 ALTER TABLE `performance` DISABLE KEYS */;
/*!40000 ALTER TABLE `performance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `performance_appraisal`
--

DROP TABLE IF EXISTS `performance_appraisal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `performance_appraisal` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(12) DEFAULT NULL,
  `description` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `performance_appraisal`
--

LOCK TABLES `performance_appraisal` WRITE;
/*!40000 ALTER TABLE `performance_appraisal` DISABLE KEYS */;
INSERT INTO `performance_appraisal` VALUES (1,'Kepatuhan','','',''),(2,'Kebersihan','','',''),(3,'Komunikasi','','',''),(4,'kedisiplinan','','','');
/*!40000 ALTER TABLE `performance_appraisal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `performance_kpis`
--

DROP TABLE IF EXISTS `performance_kpis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `performance_kpis` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(6) DEFAULT NULL,
  `target` tinyint(4) DEFAULT NULL,
  `bobot` tinyint(4) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `position_id` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `performance_kpis`
--

LOCK TABLES `performance_kpis` WRITE;
/*!40000 ALTER TABLE `performance_kpis` DISABLE KEYS */;
INSERT INTO `performance_kpis` VALUES (1,'Masok',14,12,'','','1'),(2,'Inilah',14,15,'','','SPK Designer');
/*!40000 ALTER TABLE `performance_kpis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `position` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(17) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` VALUES (1,'Customer Servicea','','',''),(2,'SPK Designer','','','');
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presence_summary`
--

DROP TABLE IF EXISTS `presence_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presence_summary` (
  `id` varchar(0) DEFAULT NULL,
  `eid` varchar(0) DEFAULT NULL,
  `name` varchar(0) DEFAULT NULL,
  `late_arrival` varchar(0) DEFAULT NULL,
  `late_checkin` varchar(0) DEFAULT NULL,
  `total_latecheckin` varchar(0) DEFAULT NULL,
  `total_overtime` varchar(0) DEFAULT NULL,
  `average_overtime` varchar(0) DEFAULT NULL,
  `average_working_hour` varchar(0) DEFAULT NULL,
  `total_chekout_early` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presence_summary`
--

LOCK TABLES `presence_summary` WRITE;
/*!40000 ALTER TABLE `presence_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `presence_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presences`
--

DROP TABLE IF EXISTS `presences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presences` (
  `id` smallint(6) DEFAULT NULL,
  `eid` mediumint(9) DEFAULT NULL,
  `employee_name` varchar(19) DEFAULT NULL,
  `date` varchar(0) DEFAULT NULL,
  `check_in` varchar(8) DEFAULT NULL,
  `check_out` varchar(8) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL,
  `lateness` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presences`
--

LOCK TABLES `presences` WRITE;
/*!40000 ALTER TABLE `presences` DISABLE KEYS */;
INSERT INTO `presences` VALUES (1,30024,'Rahmadanti','','08:01:00','08:30:00','','','',''),(2,3012,'Abdul Rosid','','07:37:15','16:17:13','','','',''),(3,3012,'Abdul Rosid','','07:49:09','16:06:21','','','',''),(4,3012,'Abdul Rosid','','07:42:43','16:12:23','','','',''),(5,3012,'Abdul Rosid','','07:40:46','16:13:23','','','',''),(6,3012,'Abdul Rosid','','07:44:37','16:25:26','','','',''),(7,3012,'Abdul Rosid','','07:42:20','16:08:55','','','',''),(8,3012,'Abdul Rosid','','07:50:50','16:01:42','','','',''),(9,3012,'Abdul Rosid','','07:40:50','16:06:28','','','',''),(10,3012,'Abdul Rosid','','07:23:13','16:01:00','','','',''),(11,3012,'Abdul Rosid','','07:51:58','16:08:36','','','',''),(12,3012,'Abdul Rosid','','07:38:26','16:04:59','','','',''),(13,3012,'Abdul Rosid','','07:34:14','16:11:33','','','',''),(14,3012,'Abdul Rosid','','07:43:13','16:14:33','','','',''),(15,3012,'Abdul Rosid','','07:42:40','16:03:50','','','',''),(16,3012,'Abdul Rosid','','07:13:45','16:02:28','','','',''),(17,3012,'Abdul Rosid','','07:19:51','12:00:00','','','',''),(18,3012,'Abdul Rosid','','07:47:41','16:16:24','','','',''),(19,3012,'Abdul Rosid','','07:41:10','16:19:42','','','',''),(20,3012,'Abdul Rosid','','07:41:26','16:13:43','','','',''),(21,3012,'Abdul Rosid','','07:52:32','16:07:30','','','',''),(22,3011,'Fatoni','','07:44:10','16:06:27','','','',''),(23,3011,'Fatoni','','07:42:05','16:06:15','','','',''),(24,3011,'Fatoni','','07:43:32','16:01:00','','','',''),(25,3011,'Fatoni','','07:37:32','16:35:06','','','',''),(26,3011,'Fatoni','','07:39:02','15:39:31','','','',''),(27,3011,'Fatoni','','07:40:37','16:10:29','','','',''),(28,3011,'Fatoni','','07:40:12','16:04:46','','','',''),(29,3011,'Fatoni','','07:40:28','16:09:53','','','',''),(30,3011,'Fatoni','','07:41:55','16:02:01','','','',''),(31,3011,'Fatoni','','07:41:25','16:12:19','','','',''),(32,3011,'Fatoni','','07:45:18','16:01:48','','','',''),(33,3011,'Fatoni','','07:41:46','16:03:08','','','',''),(34,3011,'Fatoni','','07:40:39','16:08:56','','','',''),(35,3011,'Fatoni','','07:35:49','16:06:47','','','',''),(36,3011,'Fatoni','','07:40:40','16:02:17','','','',''),(37,3011,'Fatoni','','07:33:56','16:16:19','','','',''),(38,3011,'Fatoni','','07:35:42','16:25:26','','','',''),(39,3011,'Fatoni','','07:39:50','15:02:50','','','',''),(40,3011,'Fatoni','','07:23:15','15:35:25','','','',''),(41,3010,'Rahmadanti','','07:39:06','16:10:12','','','',''),(42,3010,'Rahmadanti','','07:44:24','16:00:42','','','',''),(43,3010,'Rahmadanti','','07:43:01','16:16:28','','','',''),(44,3010,'Rahmadanti','','07:44:02','16:02:18','','','',''),(45,3010,'Rahmadanti','','07:43:17','16:03:24','','','',''),(46,3010,'Rahmadanti','','07:42:09','16:02:34','','','',''),(47,3010,'Rahmadanti','','07:43:20','16:03:27','','','',''),(48,3010,'Rahmadanti','','07:37:45','16:08:54','','','',''),(49,3010,'Rahmadanti','','07:41:59','16:00:34','','','',''),(50,3010,'Rahmadanti','','07:44:38','16:04:34','','','',''),(51,3010,'Rahmadanti','','07:44:07','18:17:49','','','',''),(52,3010,'Rahmadanti','','07:45:57','16:07:05','','','',''),(53,3010,'Rahmadanti','','07:43:50','17:40:02','','','',''),(54,3010,'Rahmadanti','','07:43:26','17:00:11','','','',''),(55,3010,'Rahmadanti','','07:54:58','17:48:36','','','',''),(56,3010,'Rahmadanti','','07:49:24','16:04:37','','','',''),(57,3010,'Rahmadanti','','07:46:15','16:18:35','','','',''),(58,3010,'Rahmadanti','','07:39:52','16:02:41','','','',''),(59,3010,'Rahmadanti','','07:44:16','16:06:50','','','',''),(60,3010,'Rahmadanti','','07:41:43','16:00:41','','','',''),(61,3014,'Nuri Firmansyah','','07:42:58','16:06:31','','','',''),(62,3014,'Nuri Firmansyah','','07:43:24','16:00:59','','','',''),(63,3014,'Nuri Firmansyah','','07:43:43','16:10:16','','','',''),(64,3014,'Nuri Firmansyah','','07:48:07','16:14:14','','','',''),(65,3014,'Nuri Firmansyah','','07:43:07','16:00:12','','','',''),(66,3014,'Nuri Firmansyah','','07:43:46','16:09:40','','','',''),(67,3014,'Nuri Firmansyah','','07:47:33','16:06:02','','','',''),(68,3014,'Nuri Firmansyah','','07:43:50','16:06:21','','','',''),(69,3014,'Nuri Firmansyah','','07:59:24','16:05:05','','','',''),(70,3014,'Nuri Firmansyah','','07:41:35','16:01:00','','','',''),(71,3014,'Nuri Firmansyah','','07:44:57','16:08:43','','','',''),(72,3014,'Nuri Firmansyah','','07:43:54','16:13:32','','','',''),(73,3014,'Nuri Firmansyah','','07:42:27','16:08:34','','','',''),(74,3014,'Nuri Firmansyah','','07:44:34','12:00:00','','','',''),(75,3014,'Nuri Firmansyah','','07:39:59','16:06:33','','','',''),(76,3014,'Nuri Firmansyah','','07:51:24','16:10:39','','','',''),(77,3014,'Nuri Firmansyah','','07:41:15','16:04:15','','','',''),(78,3014,'Nuri Firmansyah','','07:44:00','16:01:00','','','',''),(79,3014,'Nuri Firmansyah','','07:46:16','16:13:41','','','',''),(80,3014,'Nuri Firmansyah','','07:42:30','16:20:19','','','',''),(81,3014,'Nuri Firmansyah','','07:40:56','16:07:51','','','',''),(82,3016,'Andika Yoga Pratama','','08:33:00','16:09:00','','','',''),(83,3016,'Andika Yoga Pratama','','08:15:00','16:04:59','','','',''),(84,3016,'Andika Yoga Pratama','','07:46:00','16:06:59','','','',''),(85,3016,'Andika Yoga Pratama','','07:53:00','16:08:00','','','',''),(86,3016,'Andika Yoga Pratama','','08:12:00','18:34:00','','','',''),(87,3016,'Andika Yoga Pratama','','08:16:00','16:16:00','','','',''),(88,3016,'Andika Yoga Pratama','','07:51:00','22:20:00','','','',''),(89,3016,'Andika Yoga Pratama','','08:56:00','17:57:00','','','',''),(90,3016,'Andika Yoga Pratama','','07:53:00','16:03:59','','','',''),(91,3016,'Andika Yoga Pratama','','08:11:00','16:22:00','','','',''),(92,3016,'Andika Yoga Pratama','','08:29:00','20:18:00','','','',''),(93,3016,'Andika Yoga Pratama','','08:29:00','17:46:00','','','',''),(94,3016,'Andika Yoga Pratama','','08:34:00','17:08:00','','','',''),(95,3016,'Andika Yoga Pratama','','08:32:00','20:09:00','','','',''),(96,3016,'Andika Yoga Pratama','','08:35:00','16:17:00','','','',''),(97,3016,'Andika Yoga Pratama','','08:29:00','16:30:00','','','',''),(98,3016,'Andika Yoga Pratama','','08:31:00','17:13:00','','','',''),(99,3007,'Abdul Rosid','','07:37:14','16:17:12','','','',''),(100,3007,'Abdul Rosid','','07:49:08','16:06:21','','','',''),(101,3007,'Abdul Rosid','','07:42:43','16:12:23','','','',''),(102,3007,'Abdul Rosid','','07:40:46','16:13:22','','','',''),(103,3007,'Abdul Rosid','','07:44:37','16:25:27','','','',''),(104,3007,'Abdul Rosid','','07:42:20','16:08:54','','','',''),(105,3007,'Abdul Rosid','','07:50:50','16:01:41','','','',''),(106,3007,'Abdul Rosid','','07:40:49','16:06:27','','','',''),(107,3007,'Abdul Rosid','','07:23:13','16:00:59','','','',''),(108,3007,'Abdul Rosid','','07:51:58','16:08:36','','','',''),(109,3007,'Abdul Rosid','','07:38:27','16:04:59','','','',''),(110,3007,'Abdul Rosid','','07:34:14','16:11:33','','','',''),(111,3007,'Abdul Rosid','','07:43:14','16:14:33','','','',''),(112,3007,'Abdul Rosid','','07:42:39','16:03:50','','','',''),(113,3007,'Abdul Rosid','','07:13:45','16:02:28','','','',''),(114,3007,'Abdul Rosid','','07:19:51','12:00:00','','','',''),(115,3007,'Abdul Rosid','','07:47:41','16:16:24','','','',''),(116,3007,'Abdul Rosid','','07:41:10','16:19:42','','','',''),(117,3007,'Abdul Rosid','','07:41:26','16:13:43','','','',''),(118,3007,'Abdul Rosid','','07:52:31','16:07:30','','','',''),(119,3007,'Abdul Rosid','','07:37:14','16:17:12','','','',''),(120,3007,'Abdul Rosid','','07:49:08','16:06:21','','','',''),(121,3007,'Abdul Rosid','','07:42:43','16:12:23','','','',''),(122,3007,'Abdul Rosid','','07:40:46','16:13:22','','','',''),(123,3007,'Abdul Rosid','','07:44:37','16:25:27','','','',''),(124,3007,'Abdul Rosid','','07:42:20','16:08:54','','','',''),(125,3007,'Abdul Rosid','','07:50:50','16:01:41','','','',''),(126,3007,'Abdul Rosid','','07:40:49','16:06:27','','','',''),(127,3007,'Abdul Rosid','','07:23:13','16:00:59','','','',''),(128,3007,'Abdul Rosid','','07:51:58','16:08:36','','','',''),(129,3007,'Abdul Rosid','','07:38:27','16:04:59','','','',''),(130,3007,'Abdul Rosid','','07:34:14','16:11:33','','','',''),(131,3007,'Abdul Rosid','','07:43:14','16:14:33','','','',''),(132,3007,'Abdul Rosid','','07:42:39','16:03:50','','','',''),(133,3007,'Abdul Rosid','','07:13:45','16:02:28','','','',''),(134,3007,'Abdul Rosid','','07:19:51','12:00:00','','','',''),(135,3007,'Abdul Rosid','','07:47:41','16:16:24','','','',''),(136,3007,'Abdul Rosid','','07:41:10','16:19:42','','','',''),(137,3007,'Abdul Rosid','','07:41:26','16:13:43','','','',''),(138,3007,'Abdul Rosid','','07:52:31','16:07:30','','','',''),(139,3007,'Abdul Rosid','','07:37:14','16:17:12','','','',''),(140,3007,'Abdul Rosid','','07:49:08','16:06:21','','','',''),(141,3007,'Abdul Rosid','','07:42:43','16:12:23','','','',''),(142,3007,'Abdul Rosid','','07:40:46','16:13:22','','','',''),(143,3007,'Abdul Rosid','','07:44:37','16:25:27','','','',''),(144,3007,'Abdul Rosid','','07:42:20','16:08:54','','','',''),(145,3007,'Abdul Rosid','','07:50:50','16:01:41','','','',''),(146,3007,'Abdul Rosid','','07:40:49','16:06:27','','','',''),(147,3007,'Abdul Rosid','','07:23:13','16:00:59','','','',''),(148,3007,'Abdul Rosid','','07:51:58','16:08:36','','','',''),(149,3007,'Abdul Rosid','','07:38:27','16:04:59','','','',''),(150,3007,'Abdul Rosid','','07:34:14','16:11:33','','','',''),(151,3007,'Abdul Rosid','','07:43:14','16:14:33','','','',''),(152,3007,'Abdul Rosid','','07:42:39','16:03:50','','','',''),(153,3007,'Abdul Rosid','','07:13:45','16:02:28','','','',''),(154,3007,'Abdul Rosid','','07:19:51','12:00:00','','','',''),(155,3007,'Abdul Rosid','','07:47:41','16:16:24','','','',''),(156,3007,'Abdul Rosid','','07:41:10','16:19:42','','','',''),(157,3007,'Abdul Rosid','','07:41:26','16:13:43','','','',''),(158,3007,'Abdul Rosid','','07:52:31','16:07:30','','','',''),(159,3007,'Abdul Rosid','','07:37:14','16:17:12','','','',''),(160,3007,'Abdul Rosid','','07:49:08','16:06:21','','','',''),(161,3007,'Abdul Rosid','','07:42:43','16:12:23','','','',''),(162,3007,'Abdul Rosid','','07:40:46','16:13:22','','','',''),(163,3007,'Abdul Rosid','','07:44:37','16:25:27','','','',''),(164,3007,'Abdul Rosid','','07:42:20','16:08:54','','','',''),(165,3007,'Abdul Rosid','','07:50:50','16:01:41','','','',''),(166,3007,'Abdul Rosid','','07:40:49','16:06:27','','','',''),(167,3007,'Abdul Rosid','','07:23:13','16:00:59','','','',''),(168,3007,'Abdul Rosid','','07:51:58','16:08:36','','','',''),(169,3007,'Abdul Rosid','','07:38:27','16:04:59','','','',''),(170,3007,'Abdul Rosid','','07:34:14','16:11:33','','','',''),(171,3007,'Abdul Rosid','','07:43:14','16:14:33','','','',''),(172,3007,'Abdul Rosid','','07:42:39','16:03:50','','','',''),(173,3007,'Abdul Rosid','','07:13:45','16:02:28','','','',''),(174,3007,'Abdul Rosid','','07:19:51','12:00:00','','','',''),(175,3007,'Abdul Rosid','','07:47:41','16:16:24','','','',''),(176,3007,'Abdul Rosid','','07:41:10','16:19:42','','','',''),(177,3007,'Abdul Rosid','','07:41:26','16:13:43','','','',''),(178,3007,'Abdul Rosid','','07:52:31','16:07:30','','','',''),(179,3009,'Abdul Rosid','','07:37:14','16:17:12','','','',''),(180,3009,'Abdul Rosid','','07:49:08','16:06:21','','','',''),(181,3009,'Abdul Rosid','','07:42:43','16:12:23','','','',''),(182,3009,'Abdul Rosid','','07:40:46','16:13:22','','','',''),(183,3009,'Abdul Rosid','','07:44:37','16:25:27','','','',''),(184,3009,'Abdul Rosid','','07:42:20','16:08:54','','','',''),(185,3009,'Abdul Rosid','','07:50:50','16:01:41','','','',''),(186,3009,'Abdul Rosid','','07:40:49','16:06:27','','','',''),(187,3009,'Abdul Rosid','','07:23:13','16:00:59','','','',''),(188,3009,'Abdul Rosid','','07:51:58','16:08:36','','','',''),(189,3009,'Abdul Rosid','','07:38:27','16:04:59','','','',''),(190,3009,'Abdul Rosid','','07:34:14','16:11:33','','','',''),(191,3009,'Abdul Rosid','','07:43:14','16:14:33','','','',''),(192,3009,'Abdul Rosid','','07:42:39','16:03:50','','','',''),(193,3009,'Abdul Rosid','','07:13:45','16:02:28','','','',''),(194,3009,'Abdul Rosid','','07:19:51','12:00:00','','','',''),(195,3009,'Abdul Rosid','','07:47:41','16:16:24','','','',''),(196,3009,'Abdul Rosid','','07:41:10','16:19:42','','','',''),(197,3009,'Abdul Rosid','','07:41:26','16:13:43','','','',''),(198,3009,'Abdul Rosid','','07:52:31','16:07:30','','','','');
/*!40000 ALTER TABLE `presences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` varchar(0) DEFAULT NULL,
  `month` varchar(0) DEFAULT NULL,
  `year` varchar(0) DEFAULT NULL,
  `person` varchar(0) DEFAULT NULL,
  `qtyAllin` varchar(0) DEFAULT NULL,
  `qtyMakloon` varchar(0) DEFAULT NULL,
  `total` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_person`
--

DROP TABLE IF EXISTS `sales_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_person` (
  `id` varchar(0) DEFAULT NULL,
  `eid` varchar(0) DEFAULT NULL,
  `employee_name` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_person`
--

LOCK TABLES `sales_person` WRITE;
/*!40000 ALTER TABLE `sales_person` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(40) DEFAULT NULL,
  `user_id` varchar(0) DEFAULT NULL,
  `ip_address` varchar(9) DEFAULT NULL,
  `user_agent` varchar(70) DEFAULT NULL,
  `payload` text,
  `last_activity` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('KXcgXeO85PqZCSOA7YPm5nM4vpwAdFU12ADIgVqf','','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:129.0) Gecko/20100101 Firefox/129.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWdDRVFLVzZKalNtbXlybWpCVjRlNnNGSGNMVWV2ODNaeGlGYm5XbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vcHRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1725415224),('Nhq1x9l0arixOCFZne658nMgXXv9ojJ0Fu9ldgdC','','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:129.0) Gecko/20100101 Firefox/129.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMUZLRlUwOTdRRlNKWTRSV0Y2Ylp6cjhnWUd5TWJ5aEhDWW80dFdaYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXJmb3JtYW5jZS9hcHByYWlzYWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1725423231);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sqlite_sequence`
--

DROP TABLE IF EXISTS `sqlite_sequence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sqlite_sequence` (
  `name` varchar(21) DEFAULT NULL,
  `seq` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sqlite_sequence`
--

LOCK TABLES `sqlite_sequence` WRITE;
/*!40000 ALTER TABLE `sqlite_sequence` DISABLE KEYS */;
INSERT INTO `sqlite_sequence` VALUES ('migrations',67),('position',2),('job_titles',2),('division',2),('department',2),('employee_status',1),('work_schedule',2),('performance_appraisal',4),('on_day_calendar',1),('employees',8),('grade_pa',23),('overtime',3),('presences',198),('performance_kpis',2);
/*!40000 ALTER TABLE `sqlite_sequence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` varchar(0) DEFAULT NULL,
  `name` varchar(0) DEFAULT NULL,
  `email` varchar(0) DEFAULT NULL,
  `email_verified_at` varchar(0) DEFAULT NULL,
  `password` varchar(0) DEFAULT NULL,
  `remember_token` varchar(0) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `google_id` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_schedule`
--

DROP TABLE IF EXISTS `work_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_schedule` (
  `id` tinyint(4) DEFAULT NULL,
  `name` varchar(4) DEFAULT NULL,
  `start_at` varchar(5) DEFAULT NULL,
  `end_at` varchar(5) DEFAULT NULL,
  `created_at` varchar(0) DEFAULT NULL,
  `deleted_at` varchar(0) DEFAULT NULL,
  `updated_at` varchar(0) DEFAULT NULL,
  `arrival` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_schedule`
--

LOCK TABLES `work_schedule` WRITE;
/*!40000 ALTER TABLE `work_schedule` DISABLE KEYS */;
INSERT INTO `work_schedule` VALUES (1,'Umum','08:00','16:00','','','','07:45'),(2,'Umm','07:15','18:00','','','','07:00');
/*!40000 ALTER TABLE `work_schedule` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-30 16:42:55

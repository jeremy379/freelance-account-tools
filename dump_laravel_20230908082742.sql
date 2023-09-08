-- MySQL dump 10.13  Distrib 8.0.34, for Linux (aarch64)
--
-- Host: mysql    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `balance_transaction`
--

DROP TABLE IF EXISTS `balance_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `balance_transaction` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('expense','bill') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `occurred_on` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `balance_transaction_reference_index` (`reference`),
  KEY `balance_transaction_occurred_on_index` (`occurred_on`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance_transaction`
--

LOCK TABLES `balance_transaction` WRITE;
/*!40000 ALTER TABLE `balance_transaction` DISABLE KEYS */;
INSERT INTO `balance_transaction` VALUES (67,'bill','2023-001',6000,'2023-05-20 00:00:00','2023-09-07 19:37:53','2023-09-07 19:37:53'),(68,'bill','2023-002',30000,'2023-05-21 00:00:00','2023-09-07 19:38:38','2023-09-07 19:38:38'),(69,'bill','2023-004',306823,'2023-05-20 00:00:00','2023-09-07 19:38:57','2023-09-07 19:38:57'),(70,'bill','2023-005',964167,'2023-06-30 00:00:00','2023-09-07 19:39:13','2023-09-07 19:39:13'),(71,'bill','2023-006',925529,'2023-07-20 00:00:00','2023-09-07 19:39:29','2023-09-07 19:39:29'),(72,'bill','2023-009',17568,'2023-09-01 00:00:00','2023-09-07 19:40:06','2023-09-07 19:40:06'),(73,'expense','001-ovh',-25795,'2023-03-12 00:00:00','2023-09-07 19:44:06','2023-09-07 19:44:06'),(74,'expense','002-vistaprint',-3053,'2023-03-16 00:00:00','2023-09-07 19:45:23','2023-09-07 19:45:23'),(75,'expense','003-Lizy',-805860,'2023-03-17 00:00:00','2023-09-07 19:45:47','2023-09-07 19:45:47'),(76,'expense','004-Ag-Rc_pro',-23991,'2023-03-29 00:00:00','2023-09-07 19:46:26','2023-09-07 19:46:26'),(77,'expense','005-Fiduwin',-13988,'2023-04-01 00:00:00','2023-09-07 19:46:57','2023-09-07 19:46:57'),(78,'expense','006-Amazon',-27413,'2023-04-12 00:00:00','2023-09-07 19:47:29','2023-09-07 19:47:29'),(79,'expense','007-Lizy',-145295,'2023-04-20 00:00:00','2023-09-07 19:48:10','2023-09-07 19:48:10'),(80,'expense','008-Fiduwin',-13988,'2023-05-01 00:00:00','2023-09-07 19:48:34','2023-09-07 19:48:34'),(81,'expense','009-Skoda',-1240,'2023-05-10 00:00:00','2023-09-07 19:49:20','2023-09-07 19:49:20'),(82,'expense','010-luminus-charge',-265,'2023-05-15 00:00:00','2023-09-07 19:50:55','2023-09-07 19:50:55'),(83,'expense','011-luminus-charge',-7825,'2023-05-15 00:00:00','2023-09-07 19:51:21','2023-09-07 19:51:21'),(84,'expense','012-Lizy',-103783,'2023-05-20 00:00:00','2023-09-07 19:51:46','2023-09-07 19:51:46'),(85,'expense','017-repas-travel',-3157,'2023-04-24 00:00:00','2023-09-07 19:52:15','2023-09-07 19:52:15'),(86,'expense','018-repas-skaleet',-1200,'2023-04-25 00:00:00','2023-09-07 19:52:43','2023-09-07 19:52:43'),(87,'expense','019-repas-skaleet',-1200,'2023-04-26 00:00:00','2023-09-07 19:52:43','2023-09-07 19:52:43'),(88,'expense','020-repas-skaleet',-1200,'2023-04-24 00:00:00','2023-09-07 19:53:58','2023-09-07 19:53:58'),(89,'expense','021-repas-skaleet',-2105,'2023-04-25 00:00:00','2023-09-07 19:54:27','2023-09-07 19:54:27'),(90,'expense','022-wavebox',-1295,'2023-05-22 00:00:00','2023-09-07 19:54:54','2023-09-07 19:54:54'),(91,'expense','023-parking',-5310,'2023-04-26 00:00:00','2023-09-07 19:55:18','2023-09-07 19:55:18'),(92,'expense','024-hotel',-42192,'2023-04-26 00:00:00','2023-09-07 19:55:53','2023-09-07 19:55:53'),(93,'expense','025-peage',-1260,'2023-04-23 00:00:00','2023-09-07 19:56:17','2023-09-07 19:56:17'),(94,'expense','026-peage',-1540,'2023-04-26 00:00:00','2023-09-07 19:56:44','2023-09-07 19:56:44'),(95,'expense','027-hotel',-54000,'2023-05-25 00:00:00','2023-09-07 19:57:11','2023-09-07 19:57:11'),(96,'expense','028-peage',-1540,'2023-05-23 00:00:00','2023-09-07 19:57:32','2023-09-07 19:57:32'),(97,'expense','029-repas-skaleet',-1200,'2023-05-24 00:00:00','2023-09-07 19:57:58','2023-09-07 19:57:58'),(98,'expense','030-peage',-1540,'2023-05-25 00:00:00','2023-09-07 19:58:18','2023-09-07 19:58:18'),(99,'expense','031-snakc-deplacement',-875,'2023-05-23 00:00:00','2023-09-07 19:58:55','2023-09-07 19:58:55'),(100,'expense','032-repas-skaleet',-3611,'2023-05-24 00:00:00','2023-09-07 19:59:30','2023-09-07 19:59:30'),(101,'expense','033-cartouche',-4577,'2023-03-30 00:00:00','2023-09-07 20:00:31','2023-09-07 20:00:31'),(102,'expense','034-ovh',-2097,'2023-06-01 00:00:00','2023-09-07 20:01:19','2023-09-07 20:01:19'),(103,'expense','035-Fiduwin',-13988,'2023-06-01 00:00:00','2023-09-07 20:02:00','2023-09-07 20:02:00'),(104,'expense','036-Dropbox',-11988,'2023-06-06 00:00:00','2023-09-07 20:02:36','2023-09-07 20:02:36'),(105,'expense','037-Wavebox',-1295,'2023-06-22 00:00:00','2023-09-07 20:03:05','2023-09-07 20:03:05'),(106,'expense','038-deplacement',-1860,'2023-06-23 00:00:00','2023-09-07 20:03:45','2023-09-07 20:03:45'),(107,'expense','039-Parking',-2900,'2023-06-23 00:00:00','2023-09-07 20:04:08','2023-09-07 20:04:08'),(108,'expense','040-luminus',-8430,'2023-06-15 00:00:00','2023-09-07 20:04:35','2023-09-07 20:04:35'),(109,'expense','042-ING',-2700,'2023-07-01 00:00:00','2023-09-07 20:05:38','2023-09-07 20:05:38'),(110,'expense','043-Fiduwin',-13989,'2023-07-01 00:00:00','2023-09-07 20:06:00','2023-09-07 20:06:00'),(111,'expense','044-Ovh',-699,'2023-07-12 00:00:00','2023-09-07 20:06:27','2023-09-07 20:06:27'),(112,'expense','045-46-47-Envato',-6500,'2023-07-12 00:00:00','2023-09-07 20:07:01','2023-09-07 20:07:01'),(113,'expense','048-Ulys(peage)',-3080,'2023-07-01 00:00:00','2023-09-07 20:07:58','2023-09-07 20:07:58'),(114,'expense','050-Lizy',-106510,'2023-07-13 00:00:00','2023-09-07 20:08:31','2023-09-07 20:08:31'),(115,'expense','051-Amazon-livre',-4499,'2023-07-13 00:00:00','2023-09-07 20:09:06','2023-09-07 20:09:06'),(116,'expense','052-Luminus',-42874,'2023-07-15 00:00:00','2023-09-07 20:09:37','2023-09-07 20:09:37'),(117,'expense','053-Luminus',-8460,'2023-07-15 00:00:00','2023-09-07 20:10:01','2023-09-07 20:10:01'),(118,'expense','054-Luminus',-1892,'2023-07-15 00:00:00','2023-09-07 20:10:34','2023-09-07 20:10:34'),(119,'expense','055-Lizy',-106510,'2023-07-20 00:00:00','2023-09-07 20:11:04','2023-09-07 20:11:04'),(120,'expense','056-Fiduwin',-13989,'2023-08-01 00:00:00','2023-09-07 20:11:41','2023-09-07 20:11:41'),(121,'expense','057-deplacement-repas',-2233,'2023-08-09 00:00:00','2023-09-07 20:12:09','2023-09-07 20:12:09'),(122,'expense','058-repas-skaleet',-1580,'2023-08-09 00:00:00','2023-09-07 20:12:42','2023-09-07 20:12:42'),(123,'expense','059-hotel',-20256,'2023-08-08 00:00:00','2023-09-07 20:13:17','2023-09-07 20:13:17'),(124,'expense','060-Lizy',-106510,'2023-08-20 00:00:00','2023-09-07 20:13:38','2023-09-07 20:13:38'),(125,'expense','061-skaleet-repas',-1650,'2023-08-10 00:00:00','2023-09-07 20:14:04','2023-09-07 20:14:04'),(126,'expense','062-Ionity',-2498,'2023-08-24 00:00:00','2023-09-07 20:14:31','2023-09-07 20:14:31'),(127,'expense','063-Ionity',-1403,'2023-08-24 00:00:00','2023-09-07 20:14:55','2023-09-07 20:14:55'),(128,'expense','064-Ionity',-1438,'2023-08-27 00:00:00','2023-09-07 20:15:17','2023-09-07 20:15:17'),(129,'expense','065-ionity',-2064,'2023-08-27 00:00:00','2023-09-07 20:15:41','2023-09-07 20:15:41'),(130,'expense','066-ovh',-699,'2023-09-01 00:00:00','2023-09-07 20:16:13','2023-09-07 20:16:13'),(131,'expense','067-Ionity',-425,'2023-09-01 00:00:00','2023-09-07 20:16:41','2023-09-07 20:16:41'),(132,'expense','068-Fiduwin',-13989,'2023-09-01 00:00:00','2023-09-07 20:17:02','2023-09-07 20:17:02');
/*!40000 ALTER TABLE `balance_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bill` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` bigint unsigned NOT NULL,
  `tax_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_datetime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bill_reference_unique` (`reference`),
  KEY `bill_client_index` (`client`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill`
--

LOCK TABLES `bill` WRITE;
/*!40000 ALTER TABLE `bill` DISABLE KEYS */;
INSERT INTO `bill` VALUES (3,'2023-001','Famousgrey',6000,'0','2023-04-20 00:00:00','2023-09-07 10:19:14','2023-09-07 10:19:14'),(4,'2023-002','The refurb company',30000,'0','2023-04-21 00:00:00','2023-09-07 10:19:37','2023-09-07 10:19:37'),(5,'2023-004','Skaleet',306823,'0','2023-05-03 00:00:00','2023-09-07 10:20:12','2023-09-07 10:20:12'),(6,'2023-005','Skaleet',964167,'0','2023-06-01 00:00:00','2023-09-07 10:21:16','2023-09-07 10:21:16'),(7,'2023-006','Skaleet',925529,'0','2023-07-01 00:00:00','2023-09-07 10:21:51','2023-09-07 10:21:51'),(8,'2023-008','Skaleet',787500,'0','2023-08-01 00:00:00','2023-09-07 10:22:22','2023-09-07 10:22:22'),(9,'2023-007','Chez bobet',250000,'0','2023-06-30 00:00:00','2023-09-07 10:22:48','2023-09-07 10:22:48'),(10,'2023-009','Famousgrey',12000,'21','2023-08-11 00:00:00','2023-09-07 10:23:25','2023-09-07 10:23:25'),(11,'2023-010','Skaleet',777566,'0','2023-09-01 00:00:00','2023-09-07 10:23:52','2023-09-07 10:23:52');
/*!40000 ALTER TABLE `bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` bigint unsigned NOT NULL,
  `tax_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `expense_reference_unique` (`reference`),
  KEY `expense_category_index` (`category`),
  KEY `expense_provider_index` (`provider`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense`
--

LOCK TABLES `expense` WRITE;
/*!40000 ALTER TABLE `expense` DISABLE KEYS */;
INSERT INTO `expense` VALUES (64,'001-ovh','OTHERS','OVH',25795,'included-not-refundable','BE','2023-09-07 19:44:06','2023-09-07 19:44:06'),(65,'002-vistaprint','OTHERS','Vistaprint',3053,'exempt','BE','2023-09-07 19:45:23','2023-09-07 19:45:23'),(66,'003-Lizy','CAR','Lizy',805860,'exempt','BE','2023-09-07 19:45:47','2023-09-07 19:45:47'),(67,'004-Ag-Rc_pro','INSURANCE','AG',23991,'exempt','BE','2023-09-07 19:46:26','2023-09-07 19:46:26'),(68,'005-Fiduwin','ACCOUNTANT','Fiduwin',13988,'exempt','BE','2023-09-07 19:46:57','2023-09-07 19:46:57'),(69,'006-Amazon','CAR','Amazon',22655,'reverse-charge','BE','2023-09-07 19:47:29','2023-09-07 19:47:29'),(70,'007-Lizy','CAR','Lizy',145295,'exempt','BE','2023-09-07 19:48:10','2023-09-07 19:48:10'),(71,'008-Fiduwin','ACCOUNTANT','Fiduwin',13988,'exempt','BE','2023-09-07 19:48:34','2023-09-07 19:48:34'),(72,'009-Skoda','CAR','Skoda',1240,'reverse-charge','OTHER_EU','2023-09-07 19:49:20','2023-09-07 19:49:20'),(73,'010-luminus-charge','CAR','Luminus',265,'exempt','BE','2023-09-07 19:50:55','2023-09-07 19:50:55'),(74,'011-luminus-charge','CAR','Luminus',7825,'exempt','FR','2023-09-07 19:51:21','2023-09-07 19:51:21'),(75,'012-Lizy','CAR','Lizy',103783,'exempt','BE','2023-09-07 19:51:46','2023-09-07 19:51:46'),(76,'017-repas-travel','TRAVEL','Uber',3157,'exempt','FR','2023-09-07 19:52:15','2023-09-07 19:52:15'),(77,'018-repas-skaleet','TRAVEL','Gourmet club',1200,'exempt','FR','2023-09-07 19:52:43','2023-09-07 19:52:43'),(78,'019-repas-skaleet','TRAVEL','Gourmet club',1200,'exempt','FR','2023-09-07 19:52:43','2023-09-07 19:52:43'),(79,'020-repas-skaleet','TRAVEL','Gourmet club',1200,'exempt','FR','2023-09-07 19:53:58','2023-09-07 19:53:58'),(80,'021-repas-skaleet','TRAVEL','Pokawa',2105,'exempt','FR','2023-09-07 19:54:27','2023-09-07 19:54:27'),(81,'022-wavebox','SOFTWARE','Wavebox',1295,'exempt','OUTSIDE_EU','2023-09-07 19:54:54','2023-09-07 19:54:54'),(82,'023-parking','TRAVEL','Indigo',5310,'exempt','FR','2023-09-07 19:55:18','2023-09-07 19:55:18'),(83,'024-hotel','TRAVEL','Greet Hotel',42192,'exempt','FR','2023-09-07 19:55:53','2023-09-07 19:55:53'),(84,'025-peage','TRAVEL','Sanef',1260,'exempt','FR','2023-09-07 19:56:17','2023-09-07 19:56:17'),(85,'026-peage','TRAVEL','Sanef',1540,'exempt','FR','2023-09-07 19:56:44','2023-09-07 19:56:44'),(86,'027-hotel','TRAVEL','Boulogne Residence Hotel',54000,'exempt','FR','2023-09-07 19:57:11','2023-09-07 19:57:11'),(87,'028-peage','TRAVEL','Sanef',1540,'exempt','FR','2023-09-07 19:57:32','2023-09-07 19:57:32'),(88,'029-repas-skaleet','TRAVEL','Gourmet club',1200,'exempt','FR','2023-09-07 19:57:58','2023-09-07 19:57:58'),(89,'030-peage','TRAVEL','Sanef',1540,'exempt','FR','2023-09-07 19:58:18','2023-09-07 19:58:18'),(90,'031-snakc-deplacement','TRAVEL','ROC France SAS',875,'exempt','FR','2023-09-07 19:58:55','2023-09-07 19:58:55'),(91,'032-repas-skaleet','TRAVEL','Uber',3611,'exempt','FR','2023-09-07 19:59:30','2023-09-07 19:59:30'),(92,'033-cartouche','HARDWARE','Amazon',4577,'exempt','BE','2023-09-07 20:00:31','2023-09-07 20:00:31'),(93,'034-ovh','SOFTWARE','OVH',2097,'exempt','FR','2023-09-07 20:01:19','2023-09-07 20:01:19'),(94,'035-Fiduwin','ACCOUNTANT','Fiduwin',13988,'exempt','BE','2023-09-07 20:02:00','2023-09-07 20:02:00'),(95,'036-Dropbox','SOFTWARE','Dropbox',11988,'exempt','OTHER_EU','2023-09-07 20:02:36','2023-09-07 20:02:36'),(96,'037-Wavebox','SOFTWARE','Wavebox',1295,'exempt','OUTSIDE_EU','2023-09-07 20:03:05','2023-09-07 20:03:05'),(97,'038-deplacement','TRAVEL','McDo',1860,'exempt','FR','2023-09-07 20:03:45','2023-09-07 20:03:45'),(98,'039-Parking','TRAVEL','Indigo',2900,'exempt','FR','2023-09-07 20:04:08','2023-09-07 20:04:08'),(99,'040-luminus','CAR','Luminus',8430,'exempt','FR','2023-09-07 20:04:35','2023-09-07 20:04:35'),(100,'042-ING','OTHERS','ING',2700,'exempt','BE','2023-09-07 20:05:38','2023-09-07 20:05:38'),(101,'043-Fiduwin','ACCOUNTANT','Fiduwin',11561,'21','BE','2023-09-07 20:06:00','2023-09-07 20:06:00'),(102,'044-Ovh','SOFTWARE','OVH',699,'exempt','FR','2023-09-07 20:06:27','2023-09-07 20:06:27'),(103,'045-46-47-Envato','SOFTWARE','Envato',6500,'exempt','OUTSIDE_EU','2023-09-07 20:07:01','2023-09-07 20:07:01'),(104,'048-Ulys(peage)','TRAVEL','Ulys',2567,'20','FR','2023-09-07 20:07:58','2023-09-07 20:07:58'),(105,'050-Lizy','CAR','Lizy',88025,'21','BE','2023-09-07 20:08:31','2023-09-07 20:08:31'),(106,'051-Amazon-livre','OTHERS','Amazon',4244,'6','BE','2023-09-07 20:09:06','2023-09-07 20:09:06'),(107,'052-Luminus','CAR','Luminus',35433,'21','BE','2023-09-07 20:09:37','2023-09-07 20:09:37'),(108,'053-Luminus','CAR','Luminus',7050,'20','FR','2023-09-07 20:10:01','2023-09-07 20:10:01'),(109,'054-Luminus','CAR','Luminus',1564,'21','NL','2023-09-07 20:10:34','2023-09-07 20:10:34'),(110,'055-Lizy','CAR','Lizy',88025,'21','BE','2023-09-07 20:11:04','2023-09-07 20:11:04'),(111,'056-Fiduwin','ACCOUNTANT','Fiduwin',11561,'21','BE','2023-09-07 20:11:41','2023-09-07 20:11:41'),(112,'057-deplacement-repas','TRAVEL','Uber',2233,'exempt','FR','2023-09-07 20:12:09','2023-09-07 20:12:09'),(113,'058-repas-skaleet','TRAVEL','Bangcook',1580,'exempt','FR','2023-09-07 20:12:42','2023-09-07 20:12:42'),(114,'059-hotel','TRAVEL','Ibis',20256,'exempt','FR','2023-09-07 20:13:17','2023-09-07 20:13:17'),(115,'060-Lizy','CAR','Lizy',88025,'21','BE','2023-09-07 20:13:38','2023-09-07 20:13:38'),(116,'061-skaleet-repas','TRAVEL','McDo',1650,'exempt','FR','2023-09-07 20:14:04','2023-09-07 20:14:04'),(117,'062-Ionity','CAR','Ionity',2082,'20','FR','2023-09-07 20:14:31','2023-09-07 20:14:31'),(118,'063-Ionity','CAR','Ionity',1169,'20','FR','2023-09-07 20:14:55','2023-09-07 20:14:55'),(119,'064-Ionity','CAR','Ionity',1198,'20','FR','2023-09-07 20:15:17','2023-09-07 20:15:17'),(120,'065-ionity','CAR','Ionity',1720,'20','FR','2023-09-07 20:15:41','2023-09-07 20:15:41'),(121,'066-ovh','SOFTWARE','OVH',699,'exempt','FR','2023-09-07 20:16:13','2023-09-07 20:16:13'),(122,'067-Ionity','CAR','Ionity',351,'21','BE','2023-09-07 20:16:41','2023-09-07 20:16:41'),(123,'068-Fiduwin','ACCOUNTANT','Fiduwin',11561,'21','BE','2023-09-07 20:17:02','2023-09-07 20:17:02');
/*!40000 ALTER TABLE `expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `forecast`
--

DROP TABLE IF EXISTS `forecast`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forecast` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` bigint unsigned NOT NULL,
  `vat_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forecasted_on` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forecast`
--

LOCK TABLES `forecast` WRITE;
/*!40000 ALTER TABLE `forecast` DISABLE KEYS */;
INSERT INTO `forecast` VALUES (1,'INCOME',NULL,1000000,'intracom','2023-10-01 00:00:00','2023-09-07 20:18:25','2023-09-07 20:18:25',NULL),(2,'INCOME',NULL,1000000,'intracom','2023-11-01 00:00:00','2023-09-07 20:18:47','2023-09-07 20:18:47',NULL),(3,'EXPENSE','CAR',88025,'21','2023-09-20 00:00:00','2023-09-07 20:20:12','2023-09-07 20:20:12','BE'),(4,'EXPENSE','CAR',88025,'21','2023-10-20 00:00:00','2023-09-07 20:20:27','2023-09-07 20:20:27','BE'),(5,'EXPENSE','CAR',88025,'21','2023-11-20 00:00:00','2023-09-07 20:20:40','2023-09-07 20:20:40','BE'),(6,'EXPENSE','CAR',88025,'21','2023-12-20 00:00:00','2023-09-07 20:20:55','2023-09-07 20:20:55','BE'),(7,'EXPENSE','ACCOUNTANT',11561,'21','2023-10-01 00:00:00','2023-09-07 20:21:12','2023-09-07 20:21:12','BE'),(8,'EXPENSE','ACCOUNTANT',11561,'21','2023-11-01 00:00:00','2023-09-07 20:21:24','2023-09-07 20:21:24','BE'),(9,'EXPENSE','ACCOUNTANT',11561,'21','2023-12-01 00:00:00','2023-09-07 20:21:41','2023-09-07 20:21:41','BE'),(10,'EXPENSE','PLCI',19950,'exempt','2023-10-01 00:00:00','2023-09-07 20:26:18','2023-09-07 20:26:18','BE'),(11,'EXPENSE','PLCI',19950,'exempt','2023-11-01 00:00:00','2023-09-07 20:26:18','2023-09-07 20:26:18','BE'),(12,'EXPENSE','PLCI',19950,'exempt','2023-12-01 00:00:00','2023-09-07 20:26:18','2023-09-07 20:26:18','BE'),(13,'EXPENSE','CAR',88025,'21','2024-01-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(14,'EXPENSE','CAR',88025,'21','2024-02-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(15,'EXPENSE','CAR',88025,'21','2024-03-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(16,'EXPENSE','CAR',88025,'21','2024-04-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(17,'EXPENSE','CAR',88025,'21','2024-05-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(18,'EXPENSE','CAR',88025,'21','2024-06-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(19,'EXPENSE','CAR',88025,'21','2024-07-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(20,'EXPENSE','CAR',88025,'21','2024-08-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(21,'EXPENSE','CAR',88025,'21','2024-09-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(22,'EXPENSE','CAR',88025,'21','2024-10-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(23,'EXPENSE','CAR',88025,'21','2024-11-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(24,'EXPENSE','CAR',88025,'21','2024-12-20 20:32:18','2023-09-07 20:32:22','2023-09-07 20:32:22','BE'),(25,'EXPENSE','ACCOUNTANT',11561,'21','2024-01-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(26,'EXPENSE','ACCOUNTANT',11561,'21','2024-02-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(27,'EXPENSE','ACCOUNTANT',11561,'21','2024-03-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(28,'EXPENSE','ACCOUNTANT',11561,'21','2024-04-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(29,'EXPENSE','ACCOUNTANT',11561,'21','2024-05-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(30,'EXPENSE','ACCOUNTANT',11561,'21','2024-06-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(31,'EXPENSE','ACCOUNTANT',11561,'21','2024-07-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(32,'EXPENSE','ACCOUNTANT',11561,'21','2024-08-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(33,'EXPENSE','ACCOUNTANT',11561,'21','2024-09-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(34,'EXPENSE','ACCOUNTANT',11561,'21','2024-10-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(35,'EXPENSE','ACCOUNTANT',11561,'21','2024-11-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(36,'EXPENSE','ACCOUNTANT',11561,'21','2024-12-01 20:33:09','2023-09-07 20:33:12','2023-09-07 20:33:12','BE'),(37,'INCOME',NULL,854500,'intracom','2024-01-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(38,'INCOME',NULL,854500,'intracom','2024-02-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(39,'INCOME',NULL,854500,'intracom','2024-03-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(40,'INCOME',NULL,854500,'intracom','2024-04-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(41,'INCOME',NULL,854500,'intracom','2024-05-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(42,'INCOME',NULL,854500,'intracom','2024-06-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(43,'INCOME',NULL,854500,'intracom','2024-07-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(44,'INCOME',NULL,854500,'intracom','2024-08-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(45,'INCOME',NULL,854500,'intracom','2024-09-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(46,'INCOME',NULL,854500,'intracom','2024-10-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(47,'INCOME',NULL,854500,'intracom','2024-11-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(48,'INCOME',NULL,854500,'intracom','2024-12-01 20:34:04','2023-09-07 20:34:04','2023-09-07 20:34:04',NULL),(49,'EXPENSE','PLCI',19950,'exempt','2024-01-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(50,'EXPENSE','PLCI',19950,'exempt','2024-02-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(51,'EXPENSE','PLCI',19950,'exempt','2024-03-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(52,'EXPENSE','PLCI',19950,'exempt','2024-04-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(53,'EXPENSE','PLCI',19950,'exempt','2024-05-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(54,'EXPENSE','PLCI',19950,'exempt','2024-06-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(55,'EXPENSE','PLCI',19950,'exempt','2024-07-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(56,'EXPENSE','PLCI',19950,'exempt','2024-08-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(57,'EXPENSE','PLCI',19950,'exempt','2024-09-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(58,'EXPENSE','PLCI',19950,'exempt','2024-10-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(59,'EXPENSE','PLCI',19950,'exempt','2024-11-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE'),(60,'EXPENSE','PLCI',19950,'exempt','2024-12-01 20:38:36','2023-09-07 20:38:38','2023-09-07 20:38:38','BE');
/*!40000 ALTER TABLE `forecast` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_09_01_074312_create_expense_table',1),(6,'2023_09_01_100844_create_balance_transaction_table',2),(7,'2023_09_01_142111_create_bill_table',2),(8,'2023_09_06_132611_create_forecast_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2023-09-08  8:27:42

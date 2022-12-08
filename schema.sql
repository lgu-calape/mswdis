-- MariaDB dump 10.19  Distrib 10.5.15-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: mswdo
-- ------------------------------------------------------
-- Server version	10.5.15-MariaDB-0+deb11u1

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
-- Current Database: `mswdo`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `mswdo` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mswdo`;

--
-- Table structure for table `households`
--

DROP TABLE IF EXISTS `households`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `households` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `psa_ref` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `households`
--

LOCK TABLES `households` WRITE;
/*!40000 ALTER TABLE `households` DISABLE KEYS */;
/*!40000 ALTER TABLE `households` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lname` varchar(45) NOT NULL,
  `mname` varchar(45) DEFAULT NULL,
  `fname` varchar(45) NOT NULL,
  `suffix` varchar(6) DEFAULT NULL,
  `dob` date NOT NULL,
  `pob` varchar(45) DEFAULT NULL,
  `purok` varchar(45) NOT NULL,
  `barangay` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'tan','yu','irme',NULL,'2022-01-31','calape, bohol','purok 0','liboron','2022-12-06 03:39:24',NULL),(2,'tan','yu','irme',NULL,'2022-01-31','calape, bohol','purok 0','liboron','2022-12-06 03:40:00',NULL),(3,'tan','yu','irme',NULL,'2022-01-31','calape, bohol','purok 0','liboron','2022-12-06 03:40:19',NULL),(4,'tan','yu','irme',NULL,'2022-01-31','calape, bohol','purok 0','liboron','2022-12-06 03:41:39',NULL),(5,'tan','yu','irme',NULL,'2022-01-31','calape, bohol','purok 0','liboron','2022-12-06 05:08:48',NULL),(6,'tan','yu','irme',NULL,'2022-01-31','calape, bohol','purok 0','liboron','2022-12-06 05:09:18',NULL),(7,'tan','yu','irme',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 05:09:56',NULL),(8,'tan','yu','irme',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 05:11:34',NULL),(9,'tan','yu','irme',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 05:11:57',NULL),(10,'tan','yu','123',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 07:00:59',NULL),(11,'tan','yu','ermi',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 07:01:24',NULL),(12,'tan','yu','ermi',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 09:47:00',NULL),(13,'tan','yu','ermi',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 09:50:43',NULL),(14,'tan','yu','ermi',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 10:03:46',NULL),(15,'tan','yu','ermi',NULL,'2022-12-31','calape, bohol','purok 0','liboron','2022-12-06 10:05:52',NULL);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `class` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programs`
--

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;
INSERT INTO `programs` VALUES (1,'SSS','insurance','Social Security System'),(2,'GSIS','insurance','Government Service Insurance System '),(3,'PhilHealth','insurance','Philippine Health Insurance');
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rel_members_programs`
--

DROP TABLE IF EXISTS `rel_members_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rel_members_programs` (
  `member_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rel_members_programs`
--

LOCK TABLES `rel_members_programs` WRITE;
/*!40000 ALTER TABLE `rel_members_programs` DISABLE KEYS */;
/*!40000 ALTER TABLE `rel_members_programs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-08 14:28:35


CREATE DATABASE /*!32312 IF NOT EXISTS*/ `mswdo` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mswdo`;
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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_aff` (
  `member_id` int(11) DEFAULT NULL,
  `aff_value` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  KEY `members_aff_FK` (`member_id`),
  CONSTRAINT `members_aff_FK` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='members affiliation';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_attr` (
  `member_id` int(11) DEFAULT NULL,
  `attrib_value` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  KEY `members_attr_FK` (`member_id`),
  CONSTRAINT `members_attr_FK` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='members attribution';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_contact_info` (
  `member_id` int(11) DEFAULT NULL,
  `contact_id` varchar(100) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `class` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `programs_UN` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rel_members_programs` (
  `member_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: localhost    Database: examreg_backend
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `role` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,'$2y$10$Q1qLdSAVBHM0vnOP/IfCp.ok/b7Ym.fpdyGklzkBEtPEj9uvw5KhG',1,1,'admin'),(9,'$2y$10$DYwLU2DuSPtuiMUEmb10yeI8lUvjmdQl4BEMZs17w2k6.meiM/7yK',2,108,'18020812');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_classes_1` (`course_id`),
  CONSTRAINT `fk_classes_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (12,'CA-CLC1',12),(14,'CA-CLC3',12),(28,'CA-CLC1',14);
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `year_start` year(4) DEFAULT NULL,
  `year_end` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (12,'K60',2012,2016),(14,'K63',2019,2023);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examrooms`
--

DROP TABLE IF EXISTS `examrooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `examrooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `amount_computer` int(11) NOT NULL,
  `examtime_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_examrooms_1` (`examtime_id`),
  CONSTRAINT `fk_examrooms_1` FOREIGN KEY (`examtime_id`) REFERENCES `examtimes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examrooms`
--

LOCK TABLES `examrooms` WRITE;
/*!40000 ALTER TABLE `examrooms` DISABLE KEYS */;
INSERT INTO `examrooms` VALUES (4,'abc',10,12);
/*!40000 ALTER TABLE `examrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examtimes`
--

DROP TABLE IF EXISTS `examtimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `examtimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examtimes`
--

LOCK TABLES `examtimes` WRITE;
/*!40000 ALTER TABLE `examtimes` DISABLE KEYS */;
INSERT INTO `examtimes` VALUES (12,'2019-12-10','10:10:10','11:10:10');
/*!40000 ALTER TABLE `examtimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examtimes_subjectclasses`
--

DROP TABLE IF EXISTS `examtimes_subjectclasses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `examtimes_subjectclasses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subjectclass_id` int(11) NOT NULL,
  `examtime_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_1` (`subjectclass_id`),
  KEY `fk_2` (`examtime_id`),
  CONSTRAINT `fk_1` FOREIGN KEY (`subjectclass_id`) REFERENCES `subjectclasses` (`id`),
  CONSTRAINT `fk_2` FOREIGN KEY (`examtime_id`) REFERENCES `examtimes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examtimes_subjectclasses`
--

LOCK TABLES `examtimes_subjectclasses` WRITE;
/*!40000 ALTER TABLE `examtimes_subjectclasses` DISABLE KEYS */;
/*!40000 ALTER TABLE `examtimes_subjectclasses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semesters`
--

DROP TABLE IF EXISTS `semesters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `semesters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semesters`
--

LOCK TABLES `semesters` WRITE;
/*!40000 ALTER TABLE `semesters` DISABLE KEYS */;
INSERT INTO `semesters` VALUES (1,2019,'Kì 2'),(2,2001,'Kì 1'),(9,2000,'Kì 1');
/*!40000 ALTER TABLE `semesters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_students_1` (`class_id`),
  CONSTRAINT `fk_students_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (42,18021234,'abc','18021234@vnu.edu.vn','2000-06-08',NULL),(58,18020972,'Nguyễn Thị Minh Nguyệt','18020972@vnu.edu.vn','2000-05-21',12),(63,18020852,'Lê Kim Long','18020852@vnu.edu.vn','2000-02-06',12),(66,18020921,'Nguyễn Thị Minh Nguyệt','18020921@vnu.edu.vn','2000-05-21',28),(69,18020906,'Nguyễn Đức Minh','18020906@vnu.edu.vn','2000-10-07',28),(70,18020909,'Trần Công Minh','18020909@vnu.edu.vn','2000-06-30',28),(71,18020949,'Tần Lê Nghĩa','18020949@vnu.edu.vn','2000-03-06',28),(72,18020950,'Lê Huy Ngọ','18020950@vnu.edu.vn','2000-02-14',28),(73,18020963,'Nguyễn Đình Ngọc','18020963@vnu.edu.vn','2000-06-24',28),(74,18020975,'Lê Quang Nhật','18020975@vnu.edu.vn','2000-12-06',28),(75,18020991,'Nguyễn Đình Phan','18020991@vnu.edu.vn','2000-03-28',28),(76,18021052,'Nguyễn Văn Quang','18021052@vnu.edu.vn','2000-02-20',28),(77,18021048,'Trần Vinh Quang','18021048@vnu.edu.vn','2000-11-23',28),(78,18021033,'Lê Anh Quân','18021033@vnu.edu.vn','2000-05-23',28),(79,18021058,'Nguyễn Kiến Quốc','18021058@vnu.edu.vn','2000-11-22',28),(80,18021174,'Trần Trung Thành','18021174@vnu.edu.vn','2000-09-18',28),(81,18021139,'Phạm Hải Thắng','18021139@vnu.edu.vn','2000-07-02',28),(82,18021309,'Vũ Khánh Trình','18021309@vnu.edu.vn','2000-11-30',28),(83,18021319,'Đinh Thành Trung','18021319@vnu.edu.vn','2000-01-10',28),(84,18021338,'Nguyễn Xuân Trường','18021338@vnu.edu.vn','2000-12-14',28),(85,18021361,'Nguyễn Anh Tuấn','18021361@vnu.edu.vn','2000-03-30',28),(86,18021424,'Nguyễn Quốc Việt','18021424@vnu.edu.vn','2000-04-30',28),(87,18021433,'Phạm Dương Vũ','18021433@vnu.edu.vn','2000-07-03',28),(89,NULL,'Kì 1',NULL,NULL,NULL),(90,18020763,'Phùng Thị Khánh Linh','18020763@vnu.edu.vn','1999-06-08',12),(102,12345677,'Nguyễn Thị Minh Nguyệt','12345677@vnu.edu.vn','2000-05-21',12),(105,18020831,'Nguyễn Thăng Long','18020831@vnu.edu.vn','2000-02-09',28),(108,18020812,'Nông Hồng Long','18020812@vnu.edu.vn','2000-12-07',28);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_examtimes`
--

DROP TABLE IF EXISTS `students_examtimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students_examtimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `examtime_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_students_examtimes_1` (`student_id`),
  KEY `fk_students_examtimes_2` (`examtime_id`),
  CONSTRAINT `fk_students_examtimes_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_students_examtimes_2` FOREIGN KEY (`examtime_id`) REFERENCES `examtimes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_examtimes`
--

LOCK TABLES `students_examtimes` WRITE;
/*!40000 ALTER TABLE `students_examtimes` DISABLE KEYS */;
/*!40000 ALTER TABLE `students_examtimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjectclasses`
--

DROP TABLE IF EXISTS `subjectclasses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjectclasses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subjectClasses_1` (`subject_id`),
  CONSTRAINT `fk_subjectClasses_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjectclasses`
--

LOCK TABLES `subjectclasses` WRITE;
/*!40000 ALTER TABLE `subjectclasses` DISABLE KEYS */;
/*!40000 ALTER TABLE `subjectclasses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjectclasses_students`
--

DROP TABLE IF EXISTS `subjectclasses_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjectclasses_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `subjectclass_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subjectClasses_students_1` (`student_id`),
  KEY `fk_subjectClasses_students_2` (`subjectclass_id`),
  CONSTRAINT `fk_subjectClasses_students_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_subjectClasses_students_2` FOREIGN KEY (`subjectclass_id`) REFERENCES `subjectclasses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjectclasses_students`
--

LOCK TABLES `subjectclasses_students` WRITE;
/*!40000 ALTER TABLE `subjectclasses_students` DISABLE KEYS */;
/*!40000 ALTER TABLE `subjectclasses_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_bin NOT NULL,
  `semester_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subjects_1` (`semester_id`),
  CONSTRAINT `fk_subjects_1` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (10,'asfafs','safasf',NULL),(13,'','123',NULL),(16,'abc','123',1);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-23 11:03:41

-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: localhost    Database: examreg
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
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,12,'abc');
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
  `name` varchar(255) DEFAULT NULL,
  `amount_computer` int(11) DEFAULT NULL,
  `id_examtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_examrooms_1` (`id_examtime`),
  CONSTRAINT `fk_examrooms_1` FOREIGN KEY (`id_examtime`) REFERENCES `examtimes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examrooms`
--

LOCK TABLES `examrooms` WRITE;
/*!40000 ALTER TABLE `examrooms` DISABLE KEYS */;
INSERT INTO `examrooms` VALUES (1,'110',45,1);
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
  `id_semester` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_examtimes_1` (`id_semester`),
  CONSTRAINT `fk_examtimes_1` FOREIGN KEY (`id_semester`) REFERENCES `semesters` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examtimes`
--

LOCK TABLES `examtimes` WRITE;
/*!40000 ALTER TABLE `examtimes` DISABLE KEYS */;
INSERT INTO `examtimes` VALUES (1,1,'2019-10-10','08:00:00','09:00:00');
/*!40000 ALTER TABLE `examtimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semesters`
--

DROP TABLE IF EXISTS `semesters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `semesters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semesters`
--

LOCK TABLES `semesters` WRITE;
/*!40000 ALTER TABLE `semesters` DISABLE KEYS */;
INSERT INTO `semesters` VALUES (1,'kì 1 - 2019');
/*!40000 ALTER TABLE `semesters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_examtime`
--

DROP TABLE IF EXISTS `student_examtime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_examtime` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `examtime_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_student_examroom_1` (`student_id`),
  KEY `fk_student_examtime_2` (`examtime_id`),
  CONSTRAINT `fk_student_examroom_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  CONSTRAINT `fk_student_examtime_2` FOREIGN KEY (`examtime_id`) REFERENCES `examtimes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_examtime`
--

LOCK TABLES `student_examtime` WRITE;
/*!40000 ALTER TABLE `student_examtime` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_examtime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_subject`
--

DROP TABLE IF EXISTS `student_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_student` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_student_subject_1` (`id_student`),
  KEY `fk_student_subject_2` (`id_subject`),
  CONSTRAINT `fk_student_subject_1` FOREIGN KEY (`id_student`) REFERENCES `students` (`id`),
  CONSTRAINT `fk_student_subject_2` FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_subject`
--

LOCK TABLES `student_subject` WRITE;
/*!40000 ALTER TABLE `student_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `dob` date NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `class_course` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (186,'18020763','Phùng Thị Khánh Linh','18020763@vnu.edu.vn','1999-06-08',NULL,'QH-2018-I/CQ-C-A-CLC1'),(187,'18020852','Lê Kim Long','18020852@vnu.edu.vn','2000-02-06',NULL,'QH-2018-I/CQ-C-A-CLC1'),(188,'18020831','Nguyễn Thăng Long','18020831@vnu.edu.vn','2000-02-09',NULL,'QH-2018-I/CQ-C-A-CLC1'),(189,'18020812','Nông Hồng Long','18020812@vnu.edu.vn','2000-12-07',NULL,'QH-2018-I/CQ-C-A-CLC1'),(190,'18020906','Nguyễn Đức Minh','18020906@vnu.edu.vn','2000-10-07',NULL,'QH-2018-I/CQ-C-A-CLC1'),(191,'18020909','Trần Công Minh','18020909@vnu.edu.vn','2000-06-30',NULL,'QH-2018-I/CQ-C-A-CLC1'),(192,'18020949','Tần Lê Nghĩa','18020949@vnu.edu.vn','2000-03-06',NULL,'QH-2018-I/CQ-C-A-CLC1'),(193,'18020950','Lê Huy Ngọ','18020950@vnu.edu.vn','2000-02-14',NULL,'QH-2018-I/CQ-C-A-CLC1'),(194,'18020963','Nguyễn Đình Ngọc','18020963@vnu.edu.vn','2000-06-24',NULL,'QH-2018-I/CQ-C-A-CLC1'),(195,'18020975','Lê Quang Nhật','18020975@vnu.edu.vn','2000-12-06',NULL,'QH-2018-I/CQ-C-A-CLC1'),(196,'18020991','Nguyễn Đình Phan','18020991@vnu.edu.vn','2000-03-28',NULL,'QH-2018-I/CQ-C-A-CLC1'),(197,'18021052','Nguyễn Văn Quang','18021052@vnu.edu.vn','2000-02-20',NULL,'QH-2018-I/CQ-C-A-CLC1'),(198,'18021048','Trần Vinh Quang','18021048@vnu.edu.vn','2000-11-23',NULL,'QH-2018-I/CQ-C-A-CLC1'),(199,'18021033','Lê Anh Quân','18021033@vnu.edu.vn','2000-05-23',NULL,'QH-2018-I/CQ-C-A-CLC1'),(200,'18021058','Nguyễn Kiến Quốc','18021058@vnu.edu.vn','2000-11-22',NULL,'QH-2018-I/CQ-C-A-CLC1'),(201,'18021174','Trần Trung Thành','18021174@vnu.edu.vn','2000-09-18',NULL,'QH-2018-I/CQ-C-A-CLC1'),(202,'18021139','Phạm Hải Thắng','18021139@vnu.edu.vn','2000-07-02',NULL,'QH-2018-I/CQ-C-A-CLC1'),(203,'18021309','Vũ Khánh Trình','18021309@vnu.edu.vn','2000-11-30',NULL,'QH-2018-I/CQ-C-A-CLC1'),(204,'18021319','Đinh Thành Trung','18021319@vnu.edu.vn','2000-01-10',NULL,'QH-2018-I/CQ-C-A-CLC1'),(205,'18021338','Nguyễn Xuân Trường','18021338@vnu.edu.vn','2000-12-14',NULL,'QH-2018-I/CQ-C-A-CLC1'),(206,'18021361','Nguyễn Anh Tuấn','18021361@vnu.edu.vn','2000-03-30',NULL,'QH-2018-I/CQ-C-A-CLC1'),(207,'18021424','Nguyễn Quốc Việt','18021424@vnu.edu.vn','2000-04-30',NULL,'QH-2018-I/CQ-C-A-CLC1'),(208,'18021433','Phạm Dương Vũ','18021433@vnu.edu.vn','2000-07-03',NULL,'QH-2018-I/CQ-C-A-CLC1');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_course` int(11) NOT NULL,
  `id_examtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subjects_1` (`id_course`),
  KEY `fk_subjects_2` (`id_examtime`),
  CONSTRAINT `fk_subjects_1` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id`),
  CONSTRAINT `fk_subjects_2` FOREIGN KEY (`id_examtime`) REFERENCES `examtimes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
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

-- Dump completed on 2019-10-24 22:56:26

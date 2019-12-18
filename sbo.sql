-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: sbo
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `am_in_start` varchar(15) DEFAULT NULL,
  `am_in_end` varchar(15) DEFAULT NULL,
  `am_out_start` varchar(15) DEFAULT NULL,
  `am_out_end` varchar(15) DEFAULT NULL,
  `pm_instart` varchar(15) DEFAULT NULL,
  `pm_inend` varchar(15) DEFAULT NULL,
  `pm_outstart` varchar(15) DEFAULT NULL,
  `pm_outend` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`attendance_id`,`event_id`),
  KEY `attendance_event_id_FK_idx` (`event_id`),
  CONSTRAINT `attendance_event_id_FK` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (34,3,'2019-12-19','03:30','04:30','05:30','06:30','12:00','12:30','16:00','17:00');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (2,'Overnight','2019-11-24','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed rhoncus auctor dui, nec scelerisque dui aliquam eu. Aenean elementum porta sem, luctus dictum ligula blandit viverra. Quisque et ipsum fermentum, venenatis ex et, fermentum erat. Cras sit amet dignissim tellus, sit amet mattis mauris. In hac habitasse platea dictumst. Sed dui purus, pharetra eu tristique id, egestas eu lorem. Nam enim leo, malesuada et tincidunt posuere, tincidunt ut libero. Vivamus leo libero, blandit a imperdiet sed, ultricies sed mauris. Sed ut rutrum massa. Aenean porta, enim sed interdum auctor, nisi nulla finibus mi, in molestie est elit eleifend leo. Duis lacinia ullamcorper leo, vulputate semper velit sollicitudin non. Proin rutrum ex et mi pellentesque auctor. Donec sem augue, fringilla sed tristique vel, vestibulum sed tellus. Etiam eget vestibulum sapien. Aenean dictum rhoncus metus vitae fermentum. ','2019-12-18','2019-12-19'),(3,'CIT Night','2019-11-24','SBO Organized Event','2019-01-01','2019-01-02'),(4,'CIT Night','2019-11-24','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed rhoncus auctor dui, nec scelerisque dui aliquam eu. Aenean elementum porta sem, luctus dictum ligula blandit viverra. Quisque et ipsum fermentum, venenatis ex et, fermentum erat. Cras sit amet dignissim tellus, sit amet mattis mauris. In hac habitasse platea dictumst. Sed dui purus, pharetra eu tristique id, egestas eu lorem. Nam enim leo, malesuada et tincidunt posuere, tincidunt ut libero. Vivamus leo libero, blandit a imperdiet sed, ultricies sed mauris. Sed ut rutrum massa. Aenean porta, enim sed interdum auctor, nisi nulla finibus mi, in molestie est elit eleifend leo. Duis lacinia ullamcorper leo, vulputate semper velit sollicitudin non. Proin rutrum ex et mi pellentesque auctor. Donec sem augue, fringilla sed tristique vel, vestibulum sed tellus. Etiam eget vestibulum sapien. Aenean dictum rhoncus metus vitae fermentum. ','2019-01-01','2019-01-02'),(5,'Hotline Blingggg',NULL,'','2019-12-19','2019-12-19'),(6,'Hotline Blinggggggggggg',NULL,'No description.','2019-12-20','2019-12-20'),(7,'lalala',NULL,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed rhoncus auctor dui, nec scelerisque dui aliquam eu. Aenean elementum porta sem, luctus dictum ligula blandit viverra. Quisque et ipsum fermentum, venenatis ex et, fermentum erat. Cras sit amet dignissim tellus, sit amet mattis mauris. In hac habitasse platea dictumst. Sed dui purus, pharetra eu tristique id, egestas eu lorem. Nam enim leo, malesuada et tincidunt posuere, tincidunt ut libero. Vivamus leo libero, blandit a imperdiet sed, ultricies sed mauris. Sed ut rutrum massa. Aenean porta, enim sed interdum auctor, nisi nulla finibus mi, in molestie est elit eleifend leo. Duis lacinia ullamcorper leo, vulputate semper velit sollicitudin non. Proin rutrum ex et mi pellentesque auctor. Donec sem augue, fringilla sed tristique vel, vestibulum sed tellus. Etiam eget vestibulum sapien. Aenean dictum rhoncus metus vitae fermentum. ','2019-01-01','2019-01-02');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `section` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(1) DEFAULT NULL,
  `section` varchar(15) DEFAULT NULL,
  `sy` tinytext,
  `term` tinytext,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
INSERT INTO `section` VALUES (1,'','No Section',NULL,NULL),(2,'2','A','2019-2020','First Semester'),(3,'3','A','2019-2020','First Semester');
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `student_id` varchar(10) NOT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `contact_num` varchar(45) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  KEY `st_section_id_fk_idx` (`section_id`),
  CONSTRAINT `st_sect_id_FK` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('131-4578-1','Khan','Gengis','Mongol','Mongol','9081239874',3),('142-1324-1','Ruiz','Ameerah','Garcia','87 Bonifcio Drive, Victoria Village ','63-2-9847589',2),('151-1547-4','de la Cruz','Juan','Garcia','San Fernando, La Union','09123941234',2),('171-0115-2','Francisco','Rica','Oafericua','San Fernando City','09121117780',1),('171-0135-2','dabatos','christian','balahay','san francisco','09957695761',1),('171-0192-2','Rosario','Mivien','Alvar','400 Cantingan, Quinavite, Bauang, La Union','09219698035',2),('171-0203-2','Eugenio','Eucelha','Bulay','Luna','09219698035',3);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_attendance` (
  `att_id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `am_in` time DEFAULT NULL,
  `am_out` time DEFAULT NULL,
  `pm_in` time DEFAULT NULL,
  `pm_out` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`att_id`,`student_id`),
  KEY `sa_stud_id_FK_idx` (`student_id`),
  CONSTRAINT `sa_att_id_FK` FOREIGN KEY (`att_id`) REFERENCES `attendance` (`attendance_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sa_stud_id_FK` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_attendance`
--

LOCK TABLES `student_attendance` WRITE;
/*!40000 ALTER TABLE `student_attendance` DISABLE KEYS */;
INSERT INTO `student_attendance` VALUES (34,'131-4578-1',NULL,NULL,NULL,NULL),(34,'142-1324-1','03:53:00',NULL,NULL,NULL),(34,'151-1547-4',NULL,NULL,NULL,NULL),(34,'171-0115-2',NULL,NULL,NULL,NULL),(34,'171-0135-2',NULL,NULL,NULL,NULL),(34,'171-0192-2',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `student_attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey`
--

DROP TABLE IF EXISTS `survey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey` (
  `surveyid` int(11) NOT NULL AUTO_INCREMENT,
  `surveytitle` varchar(100) DEFAULT NULL,
  `eventid` int(11) DEFAULT NULL,
  PRIMARY KEY (`surveyid`),
  KEY `event_survey_id_FK_idx` (`eventid`),
  CONSTRAINT `event_survey_id_FK` FOREIGN KEY (`eventid`) REFERENCES `events` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey`
--

LOCK TABLES `survey` WRITE;
/*!40000 ALTER TABLE `survey` DISABLE KEYS */;
INSERT INTO `survey` VALUES (1,'CIT Night Survey',3);
/*!40000 ALTER TABLE `survey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_answer`
--

DROP TABLE IF EXISTS `survey_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey_answer` (
  `optionid` int(11) DEFAULT NULL,
  `studentid` varchar(10) DEFAULT NULL,
  `answertime` datetime DEFAULT NULL,
  KEY `answer_option_id_FK_idx` (`optionid`),
  KEY `answer_student_id_FK_idx` (`studentid`),
  CONSTRAINT `answer_option_id_FK` FOREIGN KEY (`optionid`) REFERENCES `survey_option` (`optionid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `answer_student_id_FK` FOREIGN KEY (`studentid`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_answer`
--

LOCK TABLES `survey_answer` WRITE;
/*!40000 ALTER TABLE `survey_answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `survey_answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_option`
--

DROP TABLE IF EXISTS `survey_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey_option` (
  `optionid` int(11) NOT NULL,
  `optiontext` varchar(45) DEFAULT NULL,
  `questionid` int(11) DEFAULT NULL,
  PRIMARY KEY (`optionid`),
  KEY `question_option_id_FK_idx` (`questionid`),
  CONSTRAINT `question_option_id_FK` FOREIGN KEY (`questionid`) REFERENCES `survey_question` (`questionid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_option`
--

LOCK TABLES `survey_option` WRITE;
/*!40000 ALTER TABLE `survey_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `survey_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_question`
--

DROP TABLE IF EXISTS `survey_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey_question` (
  `questionid` int(11) NOT NULL AUTO_INCREMENT,
  `questiontext` varchar(150) DEFAULT NULL,
  `surveyid` int(11) DEFAULT NULL,
  PRIMARY KEY (`questionid`),
  KEY `survey_event_id_FK_idx` (`surveyid`),
  CONSTRAINT `survey_event_id_FK` FOREIGN KEY (`surveyid`) REFERENCES `survey` (`surveyid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_question`
--

LOCK TABLES `survey_question` WRITE;
/*!40000 ALTER TABLE `survey_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `survey_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `password` text,
  `stud_id` varchar(10) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  PRIMARY KEY (`stud_id`,`username`),
  KEY `stud_id_idx` (`stud_id`),
  KEY `type_id_idx` (`type_id`),
  CONSTRAINT `stud_id` FOREIGN KEY (`stud_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `user_type` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('$2y$10$hJCluTgNBk2nfjVwUQ/aj.oLS8GlBlFm1AHG1UdYEuKcrmmKSrBui','131-4578-1',4,'student'),('$2y$10$PqwqG3BsNXxCFA24znE9f.DeyTXkO/dqemO7l/aS3EndWjTj/q/TC','171-0135-2',3,'officer'),('$2y$10$xcW9/INnFuYsXgOXOaGWvOWBy7jPfgSYF8BFR4dKeQuvkEtbUYJn.','171-0192-2',1,'admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL,
  `type_desc` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_type`
--

LOCK TABLES `user_type` WRITE;
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` VALUES (1,'root'),(2,'attendance officer'),(3,'officer'),(4,'student');
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-19  5:35:20

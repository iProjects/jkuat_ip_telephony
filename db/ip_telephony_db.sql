-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ip_telephony_db
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

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
-- Table structure for table tbl_campuses
--

-- -- DROP TABLE IF EXISTS tbl_campuses;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS tbl_campuses (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  campus_name varchar(200) NOT NULL COMMENT 'Campus Name',
  status varchar(200) NULL COMMENT 'Status',
  created_date varchar(200) NULL COMMENT 'Created Date',
  addedby varchar(200) NULL COMMENT 'Added By',
  PRIMARY KEY (id),
  UNIQUE KEY campus_name (campus_name)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES tbl_campuses WRITE;
/*!40000 ALTER TABLE tbl_campuses DISABLE KEYS */;
INSERT INTO tbl_campuses VALUES 
(1,'Main Campus','active','21-06-2023 08:46:43 AM','admin'),
(2,'Nairobi CBD','active','21-06-2023 08:46:43 AM','admin'),
(3,'Westlands','active','21-06-2023 08:46:43 AM','admin'),
(4,'Karen','active','21-06-2023 08:46:43 AM','admin'),
(5,'Nakuru','active','21-06-2023 08:46:43 AM','admin'),
(6,'Mombasa','active','21-06-2023 08:46:43 AM','admin'),
(7,'Kisii','active','21-06-2023 08:46:43 AM','admin'),
(8,'Kitale','active','21-06-2023 08:46:43 AM','admin'),
(9,'Kakamega','active','21-06-2023 08:46:43 AM','admin');
/*!40000 ALTER TABLE tbl_campuses ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table tbl_departments
--

-- -- DROP TABLE IF EXISTS tbl_departments;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS tbl_departments (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  campus_id int(11) NOT NULL COMMENT 'Campus Foreign Key',
  department_name varchar(200) NOT NULL COMMENT 'Department Name',
  status varchar(200) NULL COMMENT 'Status',
  created_date varchar(200) NULL COMMENT 'Created Date',
  addedby varchar(200) NULL COMMENT 'Added By',
  PRIMARY KEY (id),
  UNIQUE KEY unique_department (department_name, campus_id),
  CONSTRAINT campus_foreign_key FOREIGN KEY (campus_id) REFERENCES tbl_campuses (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



LOCK TABLES tbl_departments WRITE;
/*!40000 ALTER TABLE tbl_departments DISABLE KEYS */; 
INSERT INTO tbl_departments VALUES   
 
   (1,1,'Swicthboard','active','21-06-2023 08:46:43 AM','admin'),
   (2,1,'Chancellor','active','21-06-2023 08:46:43 AM','admin'),
   (3,1,'VC','active','21-06-2023 08:46:43 AM','admin'), 
   (4,1,'Council','active','21-06-2023 08:46:43 AM','admin'), 
   (5,1,'Asst CCO','active','21-06-2023 08:46:43 AM','admin'),
   (6,1,'Industrial Park','active','21-06-2023 08:46:43 AM','admin'),  
   (7,1,'Ombudsman','active','21-06-2023 08:46:43 AM','admin'), 
   (8,1,'Security','active','21-06-2023 08:46:43 AM','admin'), 
   (9,1,'DIPCA','active','21-06-2023 08:46:43 AM','admin'), 
   (10,1,'Corporate','active','21-06-2023 08:46:43 AM','admin'), 
   (11,1,'Adhere','active','21-06-2023 08:46:43 AM','admin'),
   (12,1,'PR','active','21-06-2023 08:46:43 AM','admin'),
   (13,1,'AUDIT','active','21-06-2023 08:46:43 AM','admin'),    
   (14,1,'DLEMA','active','21-06-2023 08:46:43 AM','admin'),
   (15,1,'CUST','active','21-06-2023 08:46:43 AM','admin'),  
   (16,1,'University Project','active','21-06-2023 08:46:43 AM','admin'),
   (17,1,'UIL','active','21-06-2023 08:46:43 AM','admin'),
   (18,1,'ICT','active','21-06-2023 08:46:43 AM','admin'),   
   (19,1,'DVC APD','active','21-06-2023 08:46:43 AM','admin'), 
   (20,1,'Legal','active','21-06-2023 08:46:43 AM','admin'),
   (21,1,'Registrar APD','active','21-06-2023 08:46:43 AM','admin'), 
   (22,1,'Transport','active','21-06-2023 08:46:43 AM','admin'), 
   (23,1,'Human Resourses','active','21-06-2023 08:46:43 AM','admin'), 
   (24,1,'Registry','active','21-06-2023 08:46:43 AM','admin'),
   (25,1,'Planning','active','21-06-2023 08:46:43 AM','admin'),
   (26,1,'Central Services','active','21-06-2023 08:46:43 AM','admin'),
   (27,1,'catering','active','21-06-2023 08:46:43 AM','admin'),
   (28,1,'Estates','active','21-06-2023 08:46:43 AM','admin'),
   (29,1,'Finance','active','21-06-2023 08:46:43 AM','admin'),  
   (30,1,'SODEL','active','21-06-2023 08:46:43 AM','admin'), 
   (31,1,'Hospital','active','21-06-2023 08:46:43 AM','admin'), 
   (32,1,'Procurement','active','21-06-2023 08:46:43 AM','admin'),
   (33,1,'Stores','active','21-06-2023 08:46:43 AM','admin'),
   (34,1,'Tailoring','active','21-06-2023 08:46:43 AM','admin'),
   (35,1,'DVC AA','active','21-06-2023 08:46:43 AM','admin'),
   (36,1,'Registrar AA','active','21-06-2023 08:46:43 AM','admin'),
   (37,1,'Programmes','active','21-06-2023 08:46:43 AM','admin'),
   (38,1,'DAQA','active','21-06-2023 08:46:43 AM','admin'),
   (39,1,'BPS','active','21-06-2023 08:46:43 AM','admin'),
   (40,1,'Gender','active','21-06-2023 08:46:43 AM','admin'),
   (41,1,'Welfare','active','21-06-2023 08:46:43 AM','admin'),
   (42,1,'Mail Registry','active','21-06-2023 08:46:43 AM','admin'),
   (43,1,'Dean','active','21-06-2023 08:46:43 AM','admin'),
   (44,1,'Chaplain','active','21-06-2023 08:46:43 AM','admin'),
   (45,1,'Sports','active','21-06-2023 08:46:43 AM','admin'),
   (46,1,'Library','active','21-06-2023 08:46:43 AM','admin'),
   (47,1,'COHRED','active','21-06-2023 08:46:43 AM','admin'),
   (48,1,'Development Study','active','21-06-2023 08:46:43 AM','admin'),
   (49,1,'MTAC','active','21-06-2023 08:46:43 AM','admin'),
   (50,1,'Business','active','21-06-2023 08:46:43 AM','admin'),
   (51,1,'CLB Lab','active','21-06-2023 08:46:43 AM','admin'),
   (52,1,'Economics','active','21-06-2023 08:46:43 AM','admin'), 
   (53,1,'SEPM','active','21-06-2023 08:46:43 AM','admin'),
   (54,1,'Lead','active','21-06-2023 08:46:43 AM','admin'),
   (55,1,'Prof','active','21-06-2023 08:46:43 AM','admin'),
   (57,1,'Agriculture','active','21-06-2023 08:46:43 AM','admin'),
   (58,1,'Food science','active','21-06-2023 08:46:43 AM','admin'),
   (59,1,'Land Resources','active','21-06-2023 08:46:43 AM','admin'),
   (60,1,'DR','active','21-06-2023 08:46:43 AM','admin'),
   (61,1,'Horticulture','active','21-06-2023 08:46:43 AM','admin'),
   (62,1,'COETEC','active','21-06-2023 08:46:43 AM','admin'),
   (63,1,'Workshop','active','21-06-2023 08:46:43 AM','admin'),
   (64,1,'SEEIE','active','21-06-2023 08:46:43 AM','admin'),
   (65,1,'Electrical','active','21-06-2023 08:46:43 AM','admin'),
   (66,1,'TIE','active','21-06-2023 08:46:43 AM','admin'),
   (67,1,'SCEGE','active','21-06-2023 08:46:43 AM','admin'),
   (68,1,'GEGIS','active','21-06-2023 08:46:43 AM','admin'),
   (69,1,'SOMME','active','21-06-2023 08:46:43 AM','admin'),
   (70,1,'Mechanical','active','21-06-2023 08:46:43 AM','admin'),
   (71,1,'Mechatronic','active','21-06-2023 08:46:43 AM','admin'),
   (72,1,'BEED','active','21-06-2023 08:46:43 AM','admin'),
   (73,1,'WARREC','active','21-06-2023 08:46:43 AM','admin'),
   (74,1,'SABS','active','21-06-2023 08:46:43 AM','admin'),
   (75,1,'Constrution Management','active','21-06-2023 08:46:43 AM','admin'), 
   (76,1,'COPAS','active','21-06-2023 08:46:43 AM','admin'),
   (77,1,'Biological','active','21-06-2023 08:46:43 AM','admin'),
   (78,1,'Botany','active','21-06-2023 08:46:43 AM','admin'),
   (79,1,'Zoology','active','21-06-2023 08:46:43 AM','admin'),
   (80,1,'Chemistry','active','21-06-2023 08:46:43 AM','admin'),
   (81,1,'Physics','active','21-06-2023 08:46:43 AM','admin'),
   (82,1,'Mathematics','active','21-06-2023 08:46:43 AM','admin'),
   (83,1,'Statistics','active','21-06-2023 08:46:43 AM','admin'),
   (84,1,'Computing','active','21-06-2023 08:46:43 AM','admin'),
   (85,1,'IT','active','21-06-2023 08:46:43 AM','admin'),
   (86,1,'COHES','active','21-06-2023 08:46:43 AM','admin'),
   (87,1,'Biochemistry','active','21-06-2023 08:46:43 AM','admin'),
   (88,1,'RPE','active','21-06-2023 08:46:43 AM','admin'),
   (89,1,'MLS','active','21-06-2023 08:46:43 AM','admin'),
   (90,1,'Haematology','active','21-06-2023 08:46:43 AM','admin'),
   (91,1,'Nursing','active','21-06-2023 08:46:43 AM','admin'),
   (92,1,'Pharmacy','active','21-06-2023 08:46:43 AM','admin'),
   (93,1,'Microbiology','active','21-06-2023 08:46:43 AM','admin'),
   (94,1,'Public Health','active','21-06-2023 08:46:43 AM','admin'),
   (95,1,'Medicine','active','21-06-2023 08:46:43 AM','admin'), 
   (96,1,'JICA','active','21-06-2023 08:46:43 AM','admin'),
   (97,1,'Production','active','21-06-2023 08:46:43 AM','admin'),
   (98,1,'Research','active','21-06-2023 08:46:43 AM','admin'),
   (99,1,'Extension','active','21-06-2023 08:46:43 AM','admin'),
   (100,1,'Linkages','active','21-06-2023 08:46:43 AM','admin'),
   (101,1,'FOTEC','active','21-06-2023 08:46:43 AM','admin'),
   (102,1,'CPC','active','21-06-2023 08:46:43 AM','admin'),
   (103,1,'UCCD','active','21-06-2023 08:46:43 AM','admin'), 
   (104,1,'IBR','active','21-06-2023 08:46:43 AM','admin'),
   (105,1,'Lab','active','21-06-2023 08:46:43 AM','admin'),
   (106,1,'Organic Farming','active','21-06-2023 08:46:43 AM','admin'), 
   (107,1,'IEET','active','21-06-2023 08:46:43 AM','admin'),
   (108,1,'SAJOREC','active','21-06-2023 08:46:43 AM','admin'),
   (109,1,'JAST','active','21-06-2023 08:46:43 AM','admin'),
   (110,1,'Farm','active','21-06-2023 08:46:43 AM','admin'),
   (111,1,'Halls','active','21-06-2023 08:46:43 AM','admin'),
   (112,1,'Bookshop','active','21-06-2023 08:46:43 AM','admin'),
   (113,1,'Avaya Support','active','21-06-2023 08:46:43 AM','admin'),
   (114,1,'Boardroom','active','21-06-2023 08:46:43 AM','admin'),
   (115,1,'JKUATES','active','21-06-2023 08:46:43 AM','admin'), 
   
   
   
    
   (250,1,'Planning and Budget','active','21-06-2023 08:46:43 AM','admin'), 
   (251,1,'Dep Registrar Exams','active','21-06-2023 08:46:43 AM','admin'),
   (252,1,'Exams','active','21-06-2023 08:46:43 AM','admin'), 
   (253,1,'Dep Registrar Senate','active','21-06-2023 08:46:43 AM','admin'),
   (254,1,'Senate','active','21-06-2023 08:46:43 AM','admin'),  
   (255,1,'Printery','active','21-06-2023 08:46:43 AM','admin'), 
   (256,1,'Civil','active','21-06-2023 08:46:43 AM','admin'), 
   (257,1,'Academic','active','21-06-2023 08:46:43 AM','admin'), 
   (258,1,'Aliso','active','21-06-2023 08:46:43 AM','admin'), 
   (259,1,'DVC Finance','active','21-06-2023 08:46:43 AM','admin'), 
   (260,1,'Project','active','21-06-2023 08:46:43 AM','admin'), 
   (261,1,'ICEOD','active','21-06-2023 08:46:43 AM','admin'),     
   (262,1,'Mining','active','21-06-2023 08:46:43 AM','admin'),
   
   
   
   
   (116,2,'Director','active','21-06-2023 08:46:43 AM','admin'),
   (117,2,'Dep Director','active','21-06-2023 08:46:43 AM','admin'),
   (118,2,'CES','active','21-06-2023 08:46:43 AM','admin'),
   (119,2,'EPD','active','21-06-2023 08:46:43 AM','admin'),
   (120,2,'Acoounts','active','21-06-2023 08:46:43 AM','admin'),
   (121,2,'Admin','active','21-06-2023 08:46:43 AM','admin'),
   (122,2,'Lab','active','21-06-2023 08:46:43 AM','admin'),
   (123,2,'Exams','active','21-06-2023 08:46:43 AM','admin'),
   (124,2,'library','active','21-06-2023 08:46:43 AM','admin'),
   (125,2,'Caretaker','active','21-06-2023 08:46:43 AM','admin'),
   
   
   
   (126,3,'Principal westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (127,3,'Director westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (128,3,'Finance Westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (129,3,'HOD westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (130,3,'Registrar Westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (131,3,'Customer Care Westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (132,3,'Dean westlands','active','21-06-2023 08:46:43 AM','admin'),
   (133,3,'hospital westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (134,3,'Procurement westlands','active','21-06-2023 08:46:43 AM','admin'),
   (135,3,'server room westlands','active','21-06-2023 08:46:43 AM','admin'),
   (136,3,'Technical weslands','active','21-06-2023 08:46:43 AM','admin'),
   (137,3,'cafeteria westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (138,3,'Exams Westlands','active','21-06-2023 08:46:43 AM','admin'),
   (139,3,'academic westlands','active','21-06-2023 08:46:43 AM','admin'), 
   (140,3,'ICT','active','21-06-2023 08:46:43 AM','admin'), 
   (141,3,'library','active','21-06-2023 08:46:43 AM','admin'), 
   (142,3,'security','active','21-06-2023 08:46:43 AM','admin'), 
   (143,3,'HRD','active','21-06-2023 08:46:43 AM','admin'),
   (144,3,'Estates','active','21-06-2023 08:46:43 AM','admin'),     
   
   
   
   (145,4,'ICT','active','21-06-2023 08:46:43 AM','admin'), 
   (146,4,'academic','active','21-06-2023 08:46:43 AM','admin'), 
   (147,4,'Director','active','21-06-2023 08:46:43 AM','admin'),
   (148,4,'Principal','active','21-06-2023 08:46:43 AM','admin'), 
   (149,4,'Registrar','active','21-06-2023 08:46:43 AM','admin'), 
   (150,4,'central services','active','21-06-2023 08:46:43 AM','admin'),
   (151,4,'security','active','21-06-2023 08:46:43 AM','admin'), 
   (152,4,'cafeteria','active','21-06-2023 08:46:43 AM','admin'),
   (153,4,'Bookshop','active','21-06-2023 08:46:43 AM','admin'),
   (154,4,'finance','active','21-06-2023 08:46:43 AM','admin'), 
   (155,4,'library','active','21-06-2023 08:46:43 AM','admin'), 
   (156,4,'Law','active','21-06-2023 08:46:43 AM','admin'), 
   (157,4,'Lecturer','active','21-06-2023 08:46:43 AM','admin'), 
   (158,4,'Hospital','active','21-06-2023 08:46:43 AM','admin'), 
   (159,4,'IT','active','21-06-2023 08:46:43 AM','admin'), 
   (160,4,'Condinators','active','21-06-2023 08:46:43 AM','admin'), 
   (161,4,'BSS','active','21-06-2023 08:46:43 AM','admin'), 
   (162,4,'sports','active','21-06-2023 08:46:43 AM','admin'),
   (163,4,'Applied science','active','21-06-2023 08:46:43 AM','admin'), 
   (164,4,'Estates','active','21-06-2023 08:46:43 AM','admin'), 
   (165,4,'Chaplains','active','21-06-2023 08:46:43 AM','admin'),
   (166,4,'Dean','active','21-06-2023 08:46:43 AM','admin'), 
   (167,4,'Student councils','active','21-06-2023 08:46:43 AM','admin'),    
   (168,4,'Karen Lab','active','21-06-2023 08:46:43 AM','admin'),
   (169,4,'Biochem lab','active','21-06-2023 08:46:43 AM','admin'),  
   (170,4,'Conference','active','21-06-2023 08:46:43 AM','admin'),  
   
   
   
   (171,5,'Avaya support','active','21-06-2023 08:46:43 AM','admin'),
   (172,5,'Director','active','21-06-2023 08:46:43 AM','admin'),
   (173,5,'Dep Director','active','21-06-2023 08:46:43 AM','admin'),
   (174,5,'Sec Director','active','21-06-2023 08:46:43 AM','admin'),
   (175,5,'Board room','active','21-06-2023 08:46:43 AM','admin'),
   (176,5,'Reception','active','21-06-2023 08:46:43 AM','admin'), 
   (177,5,'lab','active','21-06-2023 08:46:43 AM','admin'),
   (178,5,'Bookshop','active','21-06-2023 08:46:43 AM','admin'),
   (179,5,'Registry','active','21-06-2023 08:46:43 AM','admin'),
   (180,5,'Admin','active','21-06-2023 08:46:43 AM','admin'),
   (181,5,'Accounts','active','21-06-2023 08:46:43 AM','admin'), 
   (182,5,'Security','active','21-06-2023 08:46:43 AM','admin'), 
   (183,5,'library','active','21-06-2023 08:46:43 AM','admin'),
   (184,5,'Exams','active','21-06-2023 08:46:43 AM','admin'),
   (185,5,'sports','active','21-06-2023 08:46:43 AM','admin'),
   (186,5,'Condinators','active','21-06-2023 08:46:43 AM','admin'), 
   (187,5,'server room Nakuru','active','21-06-2023 08:46:43 AM','admin'),
   
   
   
   (188,6,'Director','active','21-06-2023 08:46:43 AM','admin'),
   (189,6,'Dep-Director','active','21-06-2023 08:46:43 AM','admin'),
   (190,6,'Procurement','active','21-06-2023 08:46:43 AM','admin'),
   (191,6,'Administration','active','21-06-2023 08:46:43 AM','admin'),
   (192,6,'Finance','active','21-06-2023 08:46:43 AM','admin'), 
   (193,6,'COD','active','21-06-2023 08:46:43 AM','admin'), 
   (194,6,'Exams','active','21-06-2023 08:46:43 AM','admin'), 
   (195,6,'Registry','active','21-06-2023 08:46:43 AM','admin'), 
   (196,6,'Lab','active','21-06-2023 08:46:43 AM','admin'),
   (197,6,'Library','active','21-06-2023 08:46:43 AM','admin'),
   
   
   
   (198,7,'Avaya support','active','21-06-2023 08:46:43 AM','admin'),
   (199,7,'Director','active','21-06-2023 08:46:43 AM','admin'),
   (200,7,'Dep Director','active','21-06-2023 08:46:43 AM','admin'),
   (201,7,'Sec Director','active','21-06-2023 08:46:43 AM','admin'),
   (202,7,'COD IT','active','21-06-2023 08:46:43 AM','admin'),
   (203,7,'COD HRD','active','21-06-2023 08:46:43 AM','admin'),
   (204,7,'COD Health Sci','active','21-06-2023 08:46:43 AM','admin'),
   (205,7,'Admin','active','21-06-2023 08:46:43 AM','admin'),
   (206,7,'Registry','active','21-06-2023 08:46:43 AM','admin'),
   (207,7,'Accounts','active','21-06-2023 08:46:43 AM','admin'),
   (208,7,'Server room','active','21-06-2023 08:46:43 AM','admin'), 
   (209,7,'Board room','active','21-06-2023 08:46:43 AM','admin'), 
   (210,7,'library','active','21-06-2023 08:46:43 AM','admin'),
   (211,7,'secretary','active','21-06-2023 08:46:43 AM','admin'),
   (212,7,'JKUSO','active','21-06-2023 08:46:43 AM','admin'), 
   (213,7,'Cleaner','active','21-06-2023 08:46:43 AM','admin'),
   (214,7,'Director Kisii','active','21-06-2023 08:46:43 AM','admin'), 
   (215,7,'COD IT and Maths','active','21-06-2023 08:46:43 AM','admin'),
   (216,7,'COD Social sci','active','21-06-2023 08:46:43 AM','admin'),  
   (217,7,'Sec','active','21-06-2023 08:46:43 AM','admin'), 
   (219,7,'Exams','active','21-06-2023 08:46:43 AM','admin'), 
   (220,7,'Lab','active','21-06-2023 08:46:43 AM','admin'),
   (221,7,'security','active','21-06-2023 08:46:43 AM','admin'),
   (222,7,'Estates','active','21-06-2023 08:46:43 AM','admin'),
   (223,7,'Kitchen','active','21-06-2023 08:46:43 AM','admin'),
   (224,7,'Stores','active','21-06-2023 08:46:43 AM','admin'),
   
   
   
   (225,8,'Director','active','21-06-2023 08:46:43 AM','admin'),
   (226,8,'Dep-Director','active','21-06-2023 08:46:43 AM','admin'),
   (227,8,'Secretary','active','21-06-2023 08:46:43 AM','admin'),
   (228,8,'Administrator','active','21-06-2023 08:46:43 AM','admin'),
   (229,8,'Finance','active','21-06-2023 08:46:43 AM','admin'),
   (230,8,'Procurement','active','21-06-2023 08:46:43 AM','admin'),
   (231,8,'Registry','active','21-06-2023 08:46:43 AM','admin'),
   (232,8,'Lab','active','21-06-2023 08:46:43 AM','admin'),
   (233,8,'Library','active','21-06-2023 08:46:43 AM','admin'),
   (234,8,'Administration','active','21-06-2023 08:46:43 AM','admin'),
   (235,8,'Security','active','21-06-2023 08:46:43 AM','admin'),
   (236,8,'Exams','active','21-06-2023 08:46:43 AM','admin'), 
   (237,8,'Server room','active','21-06-2023 08:46:43 AM','admin'),
   
   
   
   (238,9,'Reception','active','21-06-2023 08:46:43 AM','admin'),
   (239,9,'Director','active','21-06-2023 08:46:43 AM','admin'),
   (240,9,'Dep-Director','active','21-06-2023 08:46:43 AM','admin'),
   (241,9,'Secretary','active','21-06-2023 08:46:43 AM','admin'),
   (242,9,'Administrator','active','21-06-2023 08:46:43 AM','admin'),
   (243,9,'Finance','active','21-06-2023 08:46:43 AM','admin'), 
   (244,9,'Clerk','active','21-06-2023 08:46:43 AM','admin'),
   (245,9,'Library','active','21-06-2023 08:46:43 AM','admin'),
   (246,9,'Estates','active','21-06-2023 08:46:43 AM','admin'), 
   (247,9,'Exams','active','21-06-2023 08:46:43 AM','admin'),
   (248,9,'Registry','active','21-06-2023 08:46:43 AM','admin'),
   (249,9,'Security','active','21-06-2023 08:46:43 AM','admin');
   
   
   
/*!40000 ALTER TABLE tbl_departments ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table tbl_extensions
--

-- DROP TABLE IF EXISTS tbl_extensions;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS tbl_extensions (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  campus_id int(11) NOT NULL COMMENT 'Campus Foreign Key',
  extension_number varchar(200) NOT NULL COMMENT 'Extension Number',
  owner_assigned varchar(200) NOT NULL COMMENT 'Owner Assigned',
  department_id int(11) NOT NULL COMMENT 'Department Foreign Key',
  status varchar(200) NULL COMMENT 'Status',
  created_date varchar(200) NULL COMMENT 'Created Date',
  addedby varchar(200) NULL COMMENT 'Added By',
  PRIMARY KEY (id),
  UNIQUE KEY extension_number (extension_number),
  CONSTRAINT campus_extensions_foreign_key FOREIGN KEY (campus_id) REFERENCES tbl_campuses (id),
  CONSTRAINT department_foreign_key FOREIGN KEY (department_id) REFERENCES tbl_departments (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table tbl_users
--

-- DROP TABLE IF EXISTS tbl_users;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS tbl_users (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  email varchar(200) NOT NULL COMMENT 'Email',
  full_names varchar(200) NOT NULL COMMENT 'Full Names',
  password varchar(200) NOT NULL COMMENT 'Password',
  secretWord varchar(200) NOT NULL COMMENT 'Secret Word', 
  status varchar(200) NULL COMMENT 'Status',
  created_date varchar(200) NULL COMMENT 'Created Date',
  addedby varchar(200) NULL COMMENT 'Added By',
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES tbl_users WRITE;
/*!40000 ALTER TABLE tbl_users DISABLE KEYS */;
INSERT INTO tbl_users VALUES 
(1,'admin@gmail.com','admin admin','admin','admin','active','21-06-2023 08:46:43 AM','admin'),
(2,'fanikiwa254@gmail.com','fanikiwa fanikiwa','fanikiwa','fanikiwa','active','21-06-2023 08:46:43 AM','admin');
/*!40000 ALTER TABLE tbl_users ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table tbl_roles
--

-- DROP TABLE IF EXISTS tbl_roles;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS tbl_roles (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  role_name varchar(200) NOT NULL COMMENT 'Role Name',
  status varchar(200) NULL COMMENT 'Status',
  created_date varchar(200) NULL COMMENT 'Created Date',
  addedby varchar(200) NULL COMMENT 'Added By',
  PRIMARY KEY (id),
  UNIQUE KEY role_name (role_name)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES tbl_roles WRITE;
/*!40000 ALTER TABLE tbl_roles DISABLE KEYS */;
INSERT INTO tbl_roles VALUES 
(1,'superadmin','active','21-06-2023 08:46:43 AM','admin'),
(2,'admin','active','21-06-2023 08:46:43 AM','admin');
/*!40000 ALTER TABLE tbl_roles ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table tbl_rights
--

-- DROP TABLE IF EXISTS tbl_rights;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS tbl_rights (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  right_code varchar(200) NOT NULL COMMENT 'Right Code', 
  right_name varchar(200) NOT NULL COMMENT 'Right Name', 
  status varchar(200) NULL COMMENT 'Status',
  created_date varchar(200) NULL COMMENT 'Created Date',
  addedby varchar(200) NULL COMMENT 'Added By',
  PRIMARY KEY (id),
  UNIQUE KEY right_name (right_name)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES tbl_rights WRITE;
/*!40000 ALTER TABLE tbl_rights DISABLE KEYS */;
INSERT INTO tbl_rights VALUES 
(1,'view_extensions','View Extensions','active','21-06-2023 08:46:43 AM','admin'),
(2,'view_campuses','View Campuses','active','21-06-2023 08:46:43 AM','admin'),
(3,'view_departments',' View Departments','active','21-06-2023 08:46:43 AM','admin'),
(4,'view_users','View Users','active','21-06-2023 08:46:43 AM','admin'),
(5,'view_roles','View Roles','active','21-06-2023 08:46:43 AM','admin'),
(6,'view_rights','View Rights','active','21-06-2023 08:46:43 AM','admin'),
(7,'view_users_roles','View Users Roles','active','21-06-2023 08:46:43 AM','admin'),
(8,'view_roles_rights','View Roles Rights','active','21-06-2023 08:46:43 AM','admin'),

(9,'btncreate_extension_view','Create Extension','active','21-06-2023 08:46:43 AM','admin'),
(10,'btncreate_campus_view','Create Campus','active','21-06-2023 08:46:43 AM','admin'),
(11,'btncreate_department_view',' Create Department','active','21-06-2023 08:46:43 AM','admin'),
(12,'btncreate_user_view','Create User','active','21-06-2023 08:46:43 AM','admin'),
(13,'btncreate_role_view','Create Role','active','21-06-2023 08:46:43 AM','admin'),
(14,'btncreate_right_view','Create Right','inactive','21-06-2023 08:46:43 AM','admin'),
(15,'btncreate_user_role_view','Create User Role','active','21-06-2023 08:46:43 AM','admin'),
(16,'btncreate_role_right_view','Create Role Right','active','21-06-2023 08:46:43 AM','admin'),

(17,'btn_edit_extension','Edit Extension','active','21-06-2023 08:46:43 AM','admin'),
(18,'btn_edit_campus',' Edit Campus','active','21-06-2023 08:46:43 AM','admin'),
(19,'btn_edit_department','Edit Department','active','21-06-2023 08:46:43 AM','admin'),
(20,'btn_edit_user','Edit User','active','21-06-2023 08:46:43 AM','admin'),
(21,'btn_edit_role','Edit Role','active','21-06-2023 08:46:43 AM','admin'),
(22,'btn_edit_right','Edit Right','inactive','21-06-2023 08:46:43 AM','admin'),
(23,'btn_edit_user_role','Edit User Role','active','21-06-2023 08:46:43 AM','admin'),
(24,'btn_edit_role_right','Edit Role Right','active','21-06-2023 08:46:43 AM','admin'),

(25,'btn_delete_extension','Delete Extension','active','21-06-2023 08:46:43 AM','admin'),
(26,'btn_delete_campus','Delete Campus','active','21-06-2023 08:46:43 AM','admin'),
(27,'btn_delete_department','Delete Department','active','21-06-2023 08:46:43 AM','admin'),
(28,'btn_delete_user','Delete User','active','21-06-2023 08:46:43 AM','admin'),
(29,'btn_delete_role','Delete Role','active','21-06-2023 08:46:43 AM','admin'),
(30,'btn_delete_right','Delete Right','inactive','21-06-2023 08:46:43 AM','admin'),
(31,'btn_delete_user_role','Delete User Role','active','21-06-2023 08:46:43 AM','admin'),
(32,'btn_delete_role_right','Delete Role Right','active','21-06-2023 08:46:43 AM','admin');
/*!40000 ALTER TABLE tbl_rights ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table tbl_users_roles
--

-- DROP TABLE IF EXISTS tbl_users_roles;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS tbl_users_roles (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  user_id int(11) NOT NULL COMMENT 'User Foregn Key',
  role_id int(11) NOT NULL COMMENT 'Role Foreign Key',
  status varchar(200) NULL COMMENT 'Status',
  created_date varchar(200) NULL COMMENT 'Created Date',
  addedby varchar(200) NULL COMMENT 'Added By',
  PRIMARY KEY (id),
  UNIQUE KEY unique_user_role (user_id, role_id),
  CONSTRAINT user_foreign_key FOREIGN KEY (user_id) REFERENCES tbl_users (id),
  CONSTRAINT user_role_foreign_key FOREIGN KEY (role_id) REFERENCES tbl_roles (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES tbl_users_roles WRITE;
/*!40000 ALTER TABLE tbl_users_roles DISABLE KEYS */;
INSERT INTO tbl_users_roles VALUES 
(1,1,1,'active','21-06-2023 08:46:43 AM','admin'),
(2,2,1,'active','21-06-2023 08:46:43 AM','admin');
/*!40000 ALTER TABLE tbl_users_roles ENABLE KEYS */;
UNLOCK TABLES;



--
-- Table structure for table tbl_roles_rights
--

-- DROP TABLE IF EXISTS tbl_roles_rights;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS tbl_roles_rights (
  id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  role_id int(11) NOT NULL COMMENT 'Role Foreign Key',
  right_id int(11) NOT NULL COMMENT 'Right Foregn Key',
  allowed bit NULL COMMENT 'Allowed',
  status varchar(200) NULL COMMENT 'Status',
  created_date varchar(200) NULL COMMENT 'Created Date',
  addedby varchar(200) NULL COMMENT 'Added By',
  PRIMARY KEY (id),
  UNIQUE KEY unique_role_right (role_id, right_id),
  CONSTRAINT role_foreign_key FOREIGN KEY (role_id) REFERENCES tbl_roles (id),
  CONSTRAINT rights_foreign_key FOREIGN KEY (right_id) REFERENCES tbl_rights (id)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES tbl_roles_rights WRITE;
/*!40000 ALTER TABLE tbl_roles_rights DISABLE KEYS */;
INSERT INTO tbl_roles_rights VALUES 
(1,1,1,1,'active','21-06-2023 08:46:43 AM','admin'),
(2,1,2,1,'active','21-06-2023 08:46:43 AM','admin'),
(3,1,3,1,'active','21-06-2023 08:46:43 AM','admin'),
(4,1,4,1,'active','21-06-2023 08:46:43 AM','admin'),
(5,1,5,1,'active','21-06-2023 08:46:43 AM','admin'),
(6,1,6,1,'active','21-06-2023 08:46:43 AM','admin'),
(7,1,7,1,'active','21-06-2023 08:46:43 AM','admin'),
(8,1,8,1,'active','21-06-2023 08:46:43 AM','admin'),
(9,1,9,1,'active','21-06-2023 08:46:43 AM','admin'),
(10,1,10,1,'active','21-06-2023 08:46:43 AM','admin'),
(11,1,11,1,'active','21-06-2023 08:46:43 AM','admin'),
(12,1,12,1,'active','21-06-2023 08:46:43 AM','admin'),
(13,1,13,1,'active','21-06-2023 08:46:43 AM','admin'),
(14,1,14,0,'active','21-06-2023 08:46:43 AM','admin'),
(15,1,15,1,'active','21-06-2023 08:46:43 AM','admin'),
(16,1,16,1,'active','21-06-2023 08:46:43 AM','admin'),
(17,1,17,1,'active','21-06-2023 08:46:43 AM','admin'),
(18,1,18,1,'active','21-06-2023 08:46:43 AM','admin'),
(19,1,19,1,'active','21-06-2023 08:46:43 AM','admin'),
(20,1,20,1,'active','21-06-2023 08:46:43 AM','admin'),
(21,1,21,1,'active','21-06-2023 08:46:43 AM','admin'),
(22,1,22,0,'active','21-06-2023 08:46:43 AM','admin'),
(23,1,23,1,'active','21-06-2023 08:46:43 AM','admin'),
(24,1,24,1,'active','21-06-2023 08:46:43 AM','admin'),
(25,1,25,1,'active','21-06-2023 08:46:43 AM','admin'),
(26,1,26,1,'active','21-06-2023 08:46:43 AM','admin'),
(27,1,27,1,'active','21-06-2023 08:46:43 AM','admin'),
(28,1,28,1,'active','21-06-2023 08:46:43 AM','admin'),
(29,1,29,1,'active','21-06-2023 08:46:43 AM','admin'),
(30,1,30,0,'active','21-06-2023 08:46:43 AM','admin'),
(31,1,31,1,'active','21-06-2023 08:46:43 AM','admin'),
(32,1,32,1,'active','21-06-2023 08:46:43 AM','admin');

/*!40000 ALTER TABLE tbl_roles_rights ENABLE KEYS */;
UNLOCK TABLES;










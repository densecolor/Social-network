-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: 
-- ------------------------------------------------------
-- Server version	5.6.10

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
-- Table structure for table `COMMENTAIRE`
--

DROP TABLE IF EXISTS `COMMENTAIRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COMMENTAIRE` (
  `CODECOM` int(11) NOT NULL AUTO_INCREMENT,
  `CODECOM_APPARTENIR` int(11) NULL,
  `IDM` INTEGER(2) NOT NULL,
  `CONTENU` CHAR(140) NULL  ,
  `DATECOM` CHAR(32) NULL  , 
  `NBAPP` INT(11) NULL  DEFAULT 0, 
  PRIMARY KEY (`CODECOM`),
  KEY `I_FK_COMMENTAIRE_COMMENTAIRE1` (`CODECOM_APPARTENIR`),
  KEY `I_FK_COMMENTAIRE_MEMBRES` (`IDM`),
  CONSTRAINT `COMMENTAIRE_ibfk_1` FOREIGN KEY (`CODECOM_APPARTENIR`) REFERENCES `COMMENTAIRE` (`CODECOM`),
  CONSTRAINT `COMMENTAIRE_ibfk_2` FOREIGN KEY (`IDM`) REFERENCES `MEMBRES` (`IDM`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COMMENTAIRE`
--

LOCK TABLES `COMMENTAIRE` WRITE;
/*!40000 ALTER TABLE `COMMENTAIRE` DISABLE KEYS */;
INSERT INTO `COMMENTAIRE` values(null,null,"3","communication applis JAVA et Oracle. Compliqué?","15/04/2017",0),
(null,'1','1','Très compliqué, manuel Oracle obligatoire.','16/04/2017',0),
(null,null,'1','Pourquoi Oracle est -il si courant dans les applis bancaires','16/04/2017',0);
/*!40000 ALTER TABLE `COMMENTAIRE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEMBRES`
--

DROP TABLE IF EXISTS `MEMBRES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MEMBRES` (
  `IDM`INTEGER(2) NOT NULL AUTO_INCREMENT ,
  `NOMM` CHAR(32) NOT NULL  ,
  `PRENOMM`CHAR(32) NOT NULL  ,
  `PSEUDOM` CHAR(32) NOT NULL  ,
  `EMAILM` CHAR(255) NOT NULL,
  `PASSWORD`  CHAR(6) NOT NULL
   ,
  PRIMARY KEY (`IDM`)
  

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table `MEMBRES`
--

LOCK TABLES `MEMBRES` WRITE;
/*!40000 ALTER TABLE `MEMBRES` DISABLE KEYS */;
INSERT INTO `MEMBRES`VALUES
(NULL,'ZOZO','Zoé','Zooo','zoe@gmail.com','111111'),
(NULL,'ODIDI','Odile','Oddd','Odile@gmail.com','222222'),
(NULL,'DANI','Dan','Danda','Dan@gmail.com','333333'),
 (NULL,'BONNET','Charlotte','Cha','BONNET_@gmail.com','333333'),
(NULL,'HACHE','Cloé','Clo','HACHE_@gmail.com','444444'),
 (NULL,'FABRE','Margaux','Mar','FABRE_@gmail.com','555555'),
(NULL,'WATTEL','Marie','Mar','WATTEL_@gmail.com','666666'),
(NULL,'MARTIN','Anouchka','Ano','MARTIN_@gmail.com','777777'),
 (NULL,'HAAG','Lauriane','Lau','HAAG_@gmail.com','888888'),
 (NULL,'KOINDREDI','Vochimié','Voc','KOINDREDI_@gmail.com','999999'),
 (NULL,'POULET','Laure','Lau','POULET_@gmail.com','000000'),
(NULL,'LETANG','Maria-Eléna','Mar','LETANG_@gmail.com','aaaaaa'),
(NULL,'TOUATI','Assia','Ass','TOUATI_@gmail.com','bbbbbb'),
 (NULL,'BLANC','Ludivine','Lud','BLANC_@gmail.com','cccccc'),
(NULL,'PETIT','Cassandra','Cas','PETIT_@gmail.com','dddddd'),
(NULL,'JACOLIN','Aurore','Aur','JACOLIN_@gmail.com','eeeeee'),
(NULL,'PLANTEAU-DE-MAROUSSEM','MarieOlivia','Mar','PLANTEAU-DE-MAROUSSEM_@gmail.com','ffffff'),
(NULL,'DESBORDES','Joana','Joa','DESBORDES_@gmail.com','gggggg'),
(NULL,'QUARD','Lisa','Lis','QUARD_@gmail.com','hhhhhh'),
(NULL,'COSTE','Julie','Jul','COSTE_@gmail.com','iiiiii'),
(NULL,'BLOSSIER','Claire','Cla','BLOSSIER_@gmail.com','jjjjjj');
/*!40000 ALTER TABLE `MEMBRES` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `COMPETENCE`
--

DROP TABLE IF EXISTS `COMPETENCE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COMPETENCE` (
	`CODEC` INTEGER(2) NOT NULL  AUTO_INCREMENT ,
  `NOMC` CHAR(32) NULL  ,
  PRIMARY KEY (`CODEC`)
 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COMPETENCE`
--

LOCK TABLES `COMPETENCE` WRITE;
/*!40000 ALTER TABLE `COMPETENCE` DISABLE KEYS */;
INSERT INTO `COMPETENCE`values(null,'Pilotage projet'),(null,'Java'),(null,'Oracle'),(null,'Banque-Assurance'),(null,'ETL');
/*!40000 ALTER TABLE `COMPETENCE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `NIVEAU`
--

DROP TABLE IF EXISTS `NIVEAU`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NIVEAU` (
  `IDN` INTEGER(2) NOT NULL  AUTO_INCREMENT ,
   `LIBELLEN` CHAR(32) NOT NULL  
   ,
  PRIMARY KEY (`IDN`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `NIVEAU`
--

LOCK TABLES `NIVEAU` WRITE;
/*!40000 ALTER TABLE `NIVEAU` DISABLE KEYS */;
INSERT INTO `NIVEAU`  values(null,'debutant'),(null,'junior'),(null,'expert'),(null,'confirme');
/*!40000 ALTER TABLE `NIVEAU` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RECOMMANDER`
--

DROP TABLE IF EXISTS `RECOMMANDER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RECOMMANDER` (
  `IDM` INTEGER(2) NOT NULL,  
 
   `CODEC` INTEGER(2) NOT NULL ,
   `IDM_1` INTEGER(2) NOT NULL,  
   PRIMARY KEY (`IDM`,`CODEC`,`IDM_1`) ,
  KEY `I_FK_RECOMMANDER_MEMBRES` (`IDM`),
  KEY `I_FK_RECOMMANDER_COMPETENCE` (`CODEC`),
  KEY `I_FK_RECOMMANDER_MEMBRES1` (`IDM_1`),
  CONSTRAINT `RECOMMANDER_ibfk_1` FOREIGN KEY (`IDM`) REFERENCES `MEMBRES` (`IDM`),
  CONSTRAINT `RECOMMANDER_ibfk_2` FOREIGN KEY (`CODEC`) REFERENCES `COMPETENCE` (`CODEC`),
  CONSTRAINT `RECOMMANDER_ibfk_3` FOREIGN KEY (`IDM_1`) REFERENCES `MEMBRES` (`IDM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RECOMMANDER`
--

LOCK TABLES `RECOMMANDER` WRITE;
/*!40000 ALTER TABLE `RECOMMANDER` DISABLE KEYS */;
INSERT INTO `RECOMMANDER` values('2','4','3'),('5','2','7'),('4','3','14'),('4','1','15'),('6','1','13'),('7','1','8'),('8','1','13');
/*!40000 ALTER TABLE `RECOMMANDER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `APPRECIER`
--

DROP TABLE IF EXISTS `APPRECIER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `APPRECIER` (
  `IDM` INTEGER(2) NOT NULL  ,
   `CODECOM` int(11) NOT NULL  ,
  PRIMARY KEY (`IDM`,`CODECOM`) ,
  KEY `I_FK_APPRECIER_MEMBRES` (`IDM`),
  KEY `I_FK_APPRECIER_COMMENTAIRE` (`CODECOM`),
  CONSTRAINT `APPRECIER_ibfk_1` FOREIGN KEY (`IDM`) REFERENCES `MEMBRES` (`IDM`),
  CONSTRAINT `APPRECIER_ibfk_2` FOREIGN KEY (`CODECOM`) REFERENCES `COMMENTAIRE` (`CODECOM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `APPRECIER`
--

LOCK TABLES `APPRECIER` WRITE;
/*!40000 ALTER TABLE `APPRECIER` DISABLE KEYS */;

/*!40000 ALTER TABLE `APPRECIER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AVOIR`
--

DROP TABLE IF EXISTS `AVOIR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AVOIR` (
	`IDM` INTEGER(2) NOT NULL  ,
   `CODEC`INTEGER(2) NOT NULL  ,
   `IDN` INTEGER(2) NOT NULL  
   , PRIMARY KEY (`IDM`,`CODEC`,`IDN`),
  KEY `I_FK_AVOIR_MEMBRES` (`IDM`),
  KEY `I_FK_AVOIR_COMPETENCE` (`CODEC`),
   KEY `I_FK_AVOIR_NIVEAU` (`IDN`),
  CONSTRAINT `AVOIR_ibfk_1` FOREIGN KEY (`IDM`) REFERENCES `MEMBRES` (`IDM`),
  CONSTRAINT `AVOIR_ibfk_2` FOREIGN KEY (`CODEC`) REFERENCES `COMPETENCE` (`CODEC`),
   CONSTRAINT `AVOIR_ibfk_3` FOREIGN KEY (`IDN`) REFERENCES `NIVEAU` (`IDN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AVOIR`
--

LOCK TABLES `AVOIR` WRITE;
/*!40000 ALTER TABLE `AVOIR` DISABLE KEYS */;
INSERT INTO `AVOIR` values('1','2','3'),('2','1','3'),('3','2','1'),('4','4','1'),('6','3','1'),('7','4','1'),('8','2','1');
/*!40000 ALTER TABLE `AVOIR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suivre`
--


DROP TABLE IF EXISTS `SUIVRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SUIVRE` (
  `IDM` INTEGER(2) NOT NULL  ,
   `IDM_1` INTEGER(2) NOT NULL  ,
 
   PRIMARY KEY (`IDM`,`IDM_1`) ,
    KEY `I_FK_SUIVRE_MEMBRES` (`IDM`),
   KEY `I_FK_SUIVRE_MEMBRES1` (`IDM_1`),
  CONSTRAINT `SUIVRE_ibfk_1` FOREIGN KEY (`IDM`) REFERENCES `MEMBRES` (`IDM`),
  CONSTRAINT `SUIVRE_ibfk_2` FOREIGN KEY (`IDM_1`) REFERENCES `MEMBRES` (`IDM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SUIVRE`
--

LOCK TABLES `SUIVRE` WRITE;
/*!40000 ALTER TABLE `SUIVRE` DISABLE KEYS */;
INSERT INTO `SUIVRE`  values('4','13'),('4','14'),('4','15'),('4','5'),('5','7'),('6','13'),('7','8'),('9','15'),('6','15'),('8','13');
/*!40000 ALTER TABLE `SUIVRE` ENABLE KEYS */;
UNLOCK TABLES;



/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-12 12:41:21

-- MySQL dump 10.13  Distrib 5.7.41, for Linux (x86_64)
--
-- Host: localhost    Database: football
-- ------------------------------------------------------
-- Server version	5.7.41

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
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20230530103358','2023-05-30 12:34:12',55);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_98197A65296CD8AE` (`team_id`),
  CONSTRAINT `FK_98197A65296CD8AE` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player`
--

LOCK TABLES `player` WRITE;
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` VALUES (1,1,'Stone','Kris',6540),(2,1,'Katrina','Feeney',789),(3,1,'Adaline','Zemlak',NULL),(4,1,'Hadley','Walker',NULL),(5,1,'Theresia','McCullough',NULL),(6,1,'Rylan','Parker',2787),(7,1,'Hipolito','Bahringer',NULL),(8,1,'Reta','Bahringer',NULL),(9,1,'Darwin','Robel',NULL),(10,1,'Tiara','Stroman',NULL),(11,2,'Jacklyn','Schneider',NULL),(12,2,'Deion','Thompson',NULL),(13,2,'Raymond','Olson',NULL),(14,2,'Alexandre','Pfeffer',NULL),(15,2,'Patsy','Hickle',NULL),(16,2,'Howard','Olson',NULL),(17,2,'Dianna','Kassulke',NULL),(18,2,'Jany','Mitchell',NULL),(19,2,'Boris','Spinka',NULL),(20,2,'Sabrina','Lowe',NULL),(21,3,'Octavia','Steuber',NULL),(22,3,'Ilene','Ankunding',NULL),(23,3,'Vena','Robel',NULL),(24,3,'Adrianna','Bartoletti',NULL),(25,3,'Zetta','Runolfsdottir',NULL),(26,3,'Angelita','Buckridge',NULL),(27,3,'Carissa','Watsica',NULL),(28,3,'Vivienne','Ruecker',NULL),(29,3,'Jordan','Kulas',NULL),(30,3,'Lonzo','Friesen',NULL),(31,4,'Dannie','Ledner',NULL),(32,4,'Deontae','Jacobs',NULL),(33,4,'Schuyler','Lueilwitz',NULL),(34,4,'Pink','Zulauf',NULL),(35,4,'Marielle','Greenfelder',NULL),(36,4,'Monroe','Dach',NULL),(37,4,'Holden','Bergnaum',NULL),(38,4,'Delpha','Mosciski',NULL),(39,4,'Clinton','Stanton',NULL),(40,4,'Nella','Stamm',NULL),(41,5,'Johanna','Kreiger',NULL),(42,5,'Maegan','Renner',NULL),(43,5,'Rosina','Conn',NULL),(44,5,'Jerrell','Lind',NULL),(45,5,'Jayson','Dooley',NULL),(46,5,'Luigi','Pfannerstill',NULL),(47,5,'Eunice','Hoppe',NULL),(48,5,'Ricardo','Roberts',NULL),(49,5,'Jonas','Wilderman',NULL),(50,5,'Alva','Ledner',NULL),(51,6,'Terrance','Okuneva',NULL),(52,6,'Larue','Wiza',NULL),(53,6,'Jakob','Wiegand',NULL),(54,6,'Lambert','Schuppe',NULL),(55,6,'Elise','Little',NULL),(56,6,'Ernest','Murazik',NULL),(57,6,'Eileen','Schneider',NULL),(58,6,'Francisco','Senger',NULL),(59,6,'Zoey','Mohr',NULL),(60,6,'Ofelia','Buckridge',NULL),(61,6,'Pierre','Kris',NULL),(62,6,'Lewis','Heaney',NULL),(63,6,'Kristy','Adams',NULL),(64,6,'Vinnie','Wiza',NULL),(65,6,'Broderick','Yundt',NULL),(66,6,'Edyth','Dooley',NULL),(67,6,'Reggie','Gulgowski',NULL),(68,6,'Naomie','Gibson',NULL),(69,6,'Madelynn','Weissnat',NULL),(70,6,'Norene','Purdy',NULL),(71,7,'Rubye','Bayer',NULL),(72,7,'George','Homenick',NULL),(73,7,'Saige','Stroman',NULL),(74,7,'Mathias','Jacobs',NULL),(75,7,'Destiny','Erdman',NULL),(76,7,'Abigayle','Pagac',NULL),(77,7,'Wilburn','Pagac',NULL),(78,7,'Emmanuelle','Steuber',NULL),(79,7,'Garfield','Turner',NULL),(80,7,'Zoie','Cassin',NULL),(81,7,'Jayme','Ullrich',NULL),(82,7,'Annabel','Ratke',NULL),(83,7,'Melyssa','Metz',NULL),(84,7,'Jade','Lowe',NULL),(85,7,'Hilario','Herzog',NULL),(86,7,'Margret','Greenfelder',NULL),(87,7,'Hermina','Jacobson',NULL),(88,7,'Xander','Becker',NULL),(89,7,'Otho','Lynch',NULL),(90,7,'Mayra','Schneider',NULL),(91,8,'Dallas','Heller',NULL),(92,8,'Cydney','Moore',NULL),(93,8,'Emmy','Crooks',NULL),(94,8,'Declan','Green',NULL),(95,8,'Chesley','Hauck',NULL),(96,8,'Carmelo','Bergnaum',NULL),(97,8,'Benton','Rodriguez',NULL),(98,8,'Fleta','Torphy',NULL),(99,8,'Alisa','Mueller',NULL),(100,8,'Cristian','Okuneva',NULL),(101,8,'Cooper','Renner',NULL),(102,8,'Allison','Rutherford',NULL),(103,8,'Alec','Hahn',NULL),(104,8,'Amaya','Jacobs',NULL),(105,8,'Herta','Batz',NULL),(106,8,'Tabitha','Runolfsdottir',NULL),(107,8,'Jimmie','Hintz',NULL),(108,8,'Alicia','Swift',NULL),(109,8,'Dagmar','Friesen',NULL),(110,8,'Elva','Lebsack',NULL),(111,9,'Samanta','Rau',NULL),(112,9,'Euna','Dickens',NULL),(113,9,'Kenton','Blanda',NULL),(114,9,'Marta','Hintz',NULL),(115,9,'Destiney','Schmeler',NULL),(116,9,'Katlynn','Dooley',NULL),(117,9,'Beau','Orn',NULL),(118,9,'Tre','Flatley',NULL),(119,9,'Rupert','Heidenreich',NULL),(120,9,'April','Padberg',NULL),(121,9,'Ted','Cassin',NULL),(122,9,'Antonia','Gusikowski',NULL),(123,9,'Imelda','Yost',NULL),(124,9,'Leann','Bruen',NULL),(125,9,'Monserrat','Hoppe',NULL),(126,9,'Ressie','McLaughlin',NULL),(127,9,'Libbie','Osinski',NULL),(128,9,'Sheridan','Berge',NULL),(129,9,'Jeromy','Haley',NULL),(130,9,'Gerald','Pacocha',NULL),(131,10,'Elsie','Streich',NULL),(132,10,'Nelda','Lehner',NULL),(133,10,'Schuyler','Hoppe',NULL),(134,10,'Roman','West',NULL),(135,10,'Donald','Stroman',NULL),(136,10,'Meggie','Feil',NULL),(137,10,'Lurline','Emard',NULL),(138,10,'Shanny','Walsh',NULL),(139,10,'Domenica','Hilpert',NULL),(140,10,'Jasmin','Grant',NULL),(141,10,'Kobe','Gutmann',NULL),(142,10,'Claud','Hackett',NULL),(143,10,'Christopher','Ernser',NULL),(144,10,'Judge','Mohr',NULL),(145,10,'Deonte','Ortiz',NULL),(146,10,'Avis','Hermiston',NULL),(147,10,'Alana','Hettinger',NULL),(148,10,'Brielle','Feil',NULL),(149,10,'Roman','Bogan',NULL),(150,10,'Howard','Heathcote',NULL),(151,11,'Marcelina','Parisian',NULL),(152,11,'Gabrielle','Dach',NULL),(153,11,'Carroll','Rath',NULL),(154,11,'Darren','Hayes',NULL),(155,11,'Gudrun','Moen',NULL),(156,11,'Dejah','Wyman',NULL),(157,11,'Mavis','Windler',NULL),(158,11,'Edwina','Wisoky',NULL),(159,11,'Orlando','Hagenes',NULL),(160,11,'Eva','Abbott',NULL),(161,11,'Clinton','Gutkowski',NULL),(162,11,'Kip','Bahringer',NULL),(163,11,'Mason','Carter',NULL),(164,11,'Etha','Jaskolski',NULL),(165,11,'Myah','Hauck',NULL),(166,11,'Ivy','Schmitt',NULL),(167,11,'Sunny','Ankunding',NULL),(168,11,'Karlee','Wyman',NULL),(169,11,'Lauren','Schimmel',NULL),(170,11,'Josefina','Emmerich',NULL),(171,12,'Hulda','Ruecker',NULL),(172,12,'Leonel','Wisoky',NULL),(173,12,'Johnson','Russel',NULL),(174,12,'Omer','Krajcik',NULL),(175,12,'Alec','Williamson',NULL),(176,12,'Larissa','McKenzie',NULL),(177,12,'Muhammad','Rau',NULL),(178,12,'Hazle','Wilderman',NULL),(179,12,'Glen','Runte',NULL),(180,12,'Marge','Collins',NULL),(181,12,'Electa','Predovic',NULL),(182,12,'Wallace','Upton',NULL),(183,12,'Elnora','Cummings',NULL),(184,12,'Steve','Bruen',NULL),(185,12,'Renee','Collier',NULL),(186,12,'Maurice','Champlin',NULL),(187,12,'Elnora','O\'Kon',NULL),(188,12,'Koby','Fadel',NULL),(189,12,'Micheal','Moen',NULL),(190,12,'Omari','Wyman',NULL),(191,13,'Gunner','Heathcote',NULL),(192,13,'Leslie','McDermott',NULL),(193,13,'Dagmar','Kirlin',NULL),(194,13,'Violette','Goodwin',NULL),(195,13,'Gaylord','Kuhic',NULL),(196,13,'Curt','Corwin',NULL),(197,13,'Evans','Greenholt',NULL),(198,13,'Diamond','Reichert',NULL),(199,13,'Genoveva','Cremin',NULL),(200,13,'Augusta','Conroy',NULL),(201,13,'Rae','Upton',NULL),(202,13,'Mekhi','Murray',NULL),(203,13,'Jaquelin','Botsford',NULL),(204,13,'Emma','Batz',NULL),(205,13,'Jordane','Mraz',NULL),(206,13,'Leonor','Moen',NULL),(207,13,'Roy','DuBuque',NULL),(208,13,'Jaquan','Yost',NULL),(209,13,'Cristian','Wunsch',NULL),(210,13,'Immanuel','Quitzon',NULL),(211,14,'Titus','Wunsch',NULL),(212,14,'Julie','Treutel',NULL),(213,14,'Alta','Ankunding',NULL),(214,14,'Gaylord','Ullrich',NULL),(215,14,'Lukas','Jacobson',NULL),(216,14,'Earnestine','Leannon',NULL),(217,14,'Laurel','Kub',NULL),(218,14,'Elena','Skiles',NULL),(219,14,'Kattie','Terry',NULL),(220,14,'Adriana','Daniel',NULL),(221,14,'Mittie','Grant',NULL),(222,14,'Autumn','Kshlerin',NULL),(223,14,'Iva','Larson',NULL),(224,14,'Nathaniel','Koss',NULL),(225,14,'Verona','Haag',NULL),(226,14,'Columbus','Mayert',NULL),(227,14,'Bernita','Schmitt',NULL),(228,14,'Loyal','Mueller',NULL),(229,14,'Tracy','Armstrong',NULL),(230,14,'Danyka','Mertz',NULL),(231,15,'Christ','Cole',NULL),(232,15,'Dameon','Wunsch',NULL),(233,15,'Laila','Swift',NULL),(234,15,'Alek','Becker',NULL),(235,15,'Kane','Collins',NULL),(236,15,'Carlo','Emmerich',NULL),(237,15,'Davonte','Heidenreich',NULL),(238,15,'Hannah','Bayer',NULL),(239,15,'Damion','Okuneva',NULL),(240,15,'Bailee','Langworth',NULL),(241,15,'Leslie','Turner',NULL),(242,15,'Amparo','Zboncak',NULL),(243,15,'Jerod','Senger',NULL),(244,15,'Shanie','Walker',NULL),(245,15,'Mose','Veum',NULL),(246,15,'Chanelle','Ortiz',NULL),(247,15,'Brant','Moen',NULL),(248,15,'Nora','Gislason',NULL),(249,15,'Price','Bayer',NULL),(250,15,'Monique','Lesch',NULL);
/*!40000 ALTER TABLE `player` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `money_balance` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (1,'Nader PLC','Costa Rica',287626),(2,'Crona Ltd','Greenland',253288),(3,'Kuhlman, Medhurst and Kuhic','Reunion',51044),(4,'Schuppe LLC','Montenegro',921688),(5,'Thompson, Kshlerin and Sauer','Oman',686470),(6,'O\'Kon-Turcotte','Niue',939186),(7,'Satterfield-Kohler','United Kingdom',590131),(8,'Brown LLC','Maldives',913771),(9,'Runolfsdottir, Lowe and Bednar','Swaziland',118864),(10,'Smitham, Jakubowski and McCullough','Congo',945848),(11,'Swift Group','Djibouti',170884),(12,'Crona, Will and Daugherty','Burundi',890180),(13,'Renner Inc','Micronesia',243226),(14,'Kilback-Schaefer','Barbados',434657),(15,'Lowe-Muller','Madagascar',50327);
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-31 16:53:37

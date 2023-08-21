CREATE DATABASE  IF NOT EXISTS `happypaws` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `happypaws`;
-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: happypaws
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `asignacioncitas`
--

DROP TABLE IF EXISTS `asignacioncitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignacioncitas` (
  `idasignacionCita` int NOT NULL AUTO_INCREMENT,
  `idcita` int NOT NULL,
  `idColaborador` int NOT NULL,
  PRIMARY KEY (`idasignacionCita`),
  KEY `fk_Asignacion_Cita` (`idcita`),
  KEY `fk_Asignacion_Colaborador` (`idColaborador`),
  CONSTRAINT `fk_Asignacion_Cita` FOREIGN KEY (`idcita`) REFERENCES `citas` (`idCita`),
  CONSTRAINT `fk_Asignacion_Colaborador` FOREIGN KEY (`idColaborador`) REFERENCES `colaborador` (`idColaborador`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignacioncitas`
--

LOCK TABLES `asignacioncitas` WRITE;
/*!40000 ALTER TABLE `asignacioncitas` DISABLE KEYS */;
/*!40000 ALTER TABLE `asignacioncitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `canton`
--

DROP TABLE IF EXISTS `canton`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `canton` (
  `idCanton` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `idProvincia` int NOT NULL,
  PRIMARY KEY (`idCanton`),
  KEY `fk_canton_Provincia` (`idProvincia`),
  CONSTRAINT `fk_canton_Provincia` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`idProvincia`)
) ENGINE=InnoDB AUTO_INCREMENT=707 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canton`
--

LOCK TABLES `canton` WRITE;
/*!40000 ALTER TABLE `canton` DISABLE KEYS */;
INSERT INTO `canton` VALUES (101,'San José',1),(102,'Alajuelita',1),(103,'Vázquez de Coronado',1),(104,'Acosta',1),(105,'Tibás',1),(106,'Moravia',1),(107,'Montes de Oca',1),(108,'Turrubares',1),(109,'Dota',1),(110,'Curridabat',1),(111,'Pérez Zeledón',1),(112,'Escazú',1),(113,'León Cortés',1),(114,'Desamparados',1),(115,'Puriscal',1),(116,'Tarrazú',1),(117,'Aserrí',1),(118,'Mora',1),(119,'Goicoechea',1),(120,'Santa Ana',1),(201,'Alajuela',2),(202,'San Carlos',2),(203,'Zarcero',2),(204,'Sarchí',2),(205,'Upala',2),(206,'Los Chiles',2),(207,'Guatuso',2),(208,'Río Cuarto',2),(209,'San Ramón',2),(210,'Grecia',2),(211,'San Mateo',2),(212,'Atenas',2),(213,'Naranjo',2),(214,'Palmares',2),(215,'Poás',2),(216,'Orotina',2),(301,'Cartago',3),(302,'Paraíso',3),(303,'La Unión',3),(304,'Jiménez',3),(305,'Turrialba',3),(306,'Alvarado',3),(307,'Oreamuno',3),(308,'El Guarco',3),(401,'Heredia',4),(402,'SARAPIQUI',4),(403,'Barva',4),(404,'Santo Domingo',4),(405,'Santa Bárbara',4),(406,'San Rafael',4),(407,'San Isidro',4),(408,'Belén',4),(409,'Flores',4),(410,'San Pablo',4),(501,'Liberia',5),(502,'La Cruz',5),(503,'Hojancha',5),(504,'Nicoya',5),(505,'Santa Cruz',5),(506,'Bagaces',5),(507,'Carrillo',5),(508,'Cañas',5),(509,'Abangares',5),(510,'Tilarán',5),(511,'Nandayure',5),(601,'Puntarenas',6),(602,'Esparza',6),(603,'Buenos Aires',6),(604,'Osa',6),(605,'Quepos',6),(606,'Golfito',6),(607,'Coto Brus',6),(608,'Parrita',6),(609,'Corredores',6),(610,'Garabito',6),(611,'Monteverde',6),(612,'Puerto Jiménez',6),(701,'Limón',7),(702,'Pococí',7),(703,'Siquirres',7),(704,'Talamanca',7),(705,'Matina',7),(706,'Guácimo',7);
/*!40000 ALTER TABLE `canton` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `idCargo` int NOT NULL AUTO_INCREMENT,
  `cargo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idCargo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'Administrador'),(2,'Recepcionista'),(3,'Médico');
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citas`
--

DROP TABLE IF EXISTS `citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citas` (
  `idCita` int NOT NULL AUTO_INCREMENT,
  `idCliente` int NOT NULL,
  `idMascota` int NOT NULL,
  `idServicio` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `idHorario` int NOT NULL,
  `idestado` int NOT NULL,
  PRIMARY KEY (`idCita`),
  KEY `fk_Citas_Horario` (`idHorario`),
  KEY `fk_Citas_Mascota` (`idMascota`),
  KEY `fk_Citas_Servicio` (`idServicio`),
  KEY `fk_Citas_Cliente` (`idCliente`),
  KEY `fk_Citas_Estado` (`idestado`),
  CONSTRAINT `fk_Citas_Cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  CONSTRAINT `fk_Citas_Estado` FOREIGN KEY (`idestado`) REFERENCES `estado` (`idestado`),
  CONSTRAINT `fk_Citas_Horario` FOREIGN KEY (`idHorario`) REFERENCES `horariocitas` (`idHorario`),
  CONSTRAINT `fk_Citas_Servicio` FOREIGN KEY (`idServicio`) REFERENCES `servicios` (`idServicio`),
  CONSTRAINT `fk_Citas_Mascota` FOREIGN KEY (`idMascota`) REFERENCES `mascota` (`idMascota`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
INSERT INTO `citas` VALUES (1,1,1,1,'2023-08-20',1,1);
/*!40000 ALTER TABLE `citas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `idCliente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `apellido1` varchar(30) DEFAULT NULL,
  `apellido2` varchar(30) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `imagen` varchar(400) DEFAULT 'NULL',
  `domicilio` varchar(250) DEFAULT NULL,
  `idProvincia` int DEFAULT NULL,
  `idCanton` int DEFAULT NULL,
  `idDistrito` int DEFAULT NULL,
  `idRol` int NOT NULL DEFAULT '3',
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(200) NOT NULL,
  PRIMARY KEY (`idCliente`),
  KEY `fk_Cliente_Provincia` (`idProvincia`),
  KEY `fk_Cliente_Canton` (`idCanton`),
  KEY `fk_Cliente_Distrito` (`idDistrito`),
  KEY `fk_Cliente_Rol` (`idRol`),
  CONSTRAINT `fk_Cliente_Canton` FOREIGN KEY (`idCanton`) REFERENCES `canton` (`idCanton`),
  CONSTRAINT `fk_Cliente_Distrito` FOREIGN KEY (`idDistrito`) REFERENCES `distrito` (`idDistrito`),
  CONSTRAINT `fk_Cliente_Provincia` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`idProvincia`),
  CONSTRAINT `fk_Cliente_Rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Jorge','Hernández','Araya','60245117','7c62b90e2e77a68562e301db48ccbc76.jpg','200 metros sur del hotel Villas de la Colina',1,101,10101,3,'jorge@email.com','$2y$10$EeR5YV6qbqeCwr6KyhPhs.9OE7iJU8AJSwWlx1PYmJWjxCibIZm5O');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colaborador`
--

DROP TABLE IF EXISTS `colaborador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colaborador` (
  `idColaborador` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `apellido1` varchar(30) DEFAULT NULL,
  `apellido2` varchar(30) DEFAULT NULL,
  `idCargo` int NOT NULL,
  `idEspecialidad` int NOT NULL,
  `imagen` varchar(400) DEFAULT 'no_disponible.webp',
  `idRol` int NOT NULL DEFAULT '1',
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(200) NOT NULL,
  PRIMARY KEY (`idColaborador`),
  KEY `fk_Colaborador_Cargo` (`idCargo`),
  KEY `fk_Colaborador_Especialidad` (`idEspecialidad`),
  KEY `fk_Colaborador_Rol` (`idRol`),
  CONSTRAINT `fk_Colaborador_Cargo` FOREIGN KEY (`idCargo`) REFERENCES `cargo` (`idCargo`),
  CONSTRAINT `fk_Colaborador_Especialidad` FOREIGN KEY (`idEspecialidad`) REFERENCES `especialidad` (`idEspecialidad`),
  CONSTRAINT `fk_Colaborador_Rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaborador`
--

LOCK TABLES `colaborador` WRITE;
/*!40000 ALTER TABLE `colaborador` DISABLE KEYS */;
INSERT INTO `colaborador` VALUES (1,'admin','admin','admin',1,5,'2bec2643a2e49f487d6262bcf2bbb14a.jpg',1,'admin@happypaws.com','$2y$10$SorXZ98r6A1KtoxMQjjkTOBjr2EEOEELJKbxgBdFP8rJjclBmYht2'),(2,'Luis Carlos','Morales','Mena',3,1,'4512cd38ce4ed7fbf944f817a9e28b68.jpg',2,'juan.moreles@happypaws.com','$2y$10$TuO6Dyr3qF0tQtH0J0r/he6l40.wUOiea7bWXkK8cESCcPotlS7AS'),(3,'Ana','Rodríguez','Moya',3,2,'814bf8304eb6011bbf97fd94350b44fe.jpg',2,'ana.rodriges@happypaws.com','$2y$10$AiN6qE07lOjAOYWfrF.us.y19Rl72k7i3ekA9K5rz/s2LrGzJzKjS'),(4,'Elizabeth','Gómez','Roldan',1,4,'296728b02f2db0822d8658b214172f01.jpg',2,'elizabeth.gomez@happypaws.com','$2y$10$YK0opKbIEHSVEfKZ8FVCS.i3NzKVejkm27yATzyCiZ20FWOq25gd2'),(5,'Sofia','Rojas','Quesada',3,3,'fee34ecf2b12c6259162670efd678cd9.jpg',2,'sofia.rojas@happypaws.com','$2y$10$Nm70ne8cNIbaOpkCx19Eju/8e.dxqQazxbRWH1JJMgzAoLSPOoQ1W');
/*!40000 ALTER TABLE `colaborador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colaboradorservicio`
--

DROP TABLE IF EXISTS `colaboradorservicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colaboradorservicio` (
  `idServicio` int NOT NULL,
  `idColaborador` int NOT NULL,
  PRIMARY KEY (`idServicio`,`idColaborador`),
  KEY `fk_ServicioColaborador` (`idColaborador`),
  CONSTRAINT `fk_Colaborador_Servicio` FOREIGN KEY (`idServicio`) REFERENCES `servicios` (`idServicio`),
  CONSTRAINT `fk_ServicioColaborador` FOREIGN KEY (`idColaborador`) REFERENCES `colaborador` (`idColaborador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaboradorservicio`
--

LOCK TABLES `colaboradorservicio` WRITE;
/*!40000 ALTER TABLE `colaboradorservicio` DISABLE KEYS */;
INSERT INTO `colaboradorservicio` VALUES (1,2),(2,3),(3,4),(4,5);
/*!40000 ALTER TABLE `colaboradorservicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distrito`
--

DROP TABLE IF EXISTS `distrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distrito` (
  `idDistrito` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `idCanton` int NOT NULL,
  PRIMARY KEY (`idDistrito`),
  KEY `fk_Distrito_Canton` (`idCanton`),
  CONSTRAINT `fk_Distrito_Canton` FOREIGN KEY (`idCanton`) REFERENCES `canton` (`idCanton`)
) ENGINE=InnoDB AUTO_INCREMENT=70606 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distrito`
--

LOCK TABLES `distrito` WRITE;
/*!40000 ALTER TABLE `distrito` DISABLE KEYS */;
INSERT INTO `distrito` VALUES (10101,'Carmen',101),(10102,'Merced',101),(10103,'Hospital',101),(10104,'Catedral',101),(10105,'Zapote',101),(10106,'San Francisco de Dos Ríos',101),(10107,'Uruca',101),(10108,'Mata Redonda',101),(10109,'Pavas',101),(10110,'Hatillo',101),(10111,'San Sebastián',101),(10201,'Escazú',102),(10202,'San Antonio',102),(10203,'San Rafael',102),(10301,'Desamparados',103),(10302,'San Miguel',103),(10303,'San Juan de Dios',103),(10304,'San Rafael Arriba',103),(10305,'San Antonio',103),(10306,'Frailes',103),(10307,'Patarrá',103),(10308,'San Cristóbal',103),(10309,'Rosario',103),(10310,'Damas',103),(10311,'San Rafael Abajo',103),(10312,'Gravilias',103),(10313,'Los Guido',103),(10401,'Santiago',104),(10402,'Mercedes Sur',104),(10403,'Barbacoas',104),(10404,'Grifo Alto',104),(10405,'San Rafael',104),(10406,'Candelarita',104),(10407,'Desamparaditos',104),(10408,'San Antonio',104),(10409,'Chires',104),(10501,'San Marcos',105),(10502,'San Lorenzo',105),(10503,'San Carlos',105),(10601,'Aserrí',106),(10602,'Tarbaca',106),(10603,'Vuelta de Jorco',106),(10604,'San Gabriel',106),(10605,'Legua',106),(10606,'Monterrey',106),(10607,'Salitrillos',106),(10701,'Colón',107),(10702,'Guayabo',107),(10703,'Tabarcia',107),(10704,'Piedras Negras',107),(10705,'Picagres',107),(10706,'Jaris',107),(10707,'Quitirrisí',107),(10801,'Guadalupe',108),(10802,'San Francisco',108),(10803,'Calle Blancos',108),(10804,'Mata de Plátano',108),(10805,'Ipís',108),(10806,'Rancho Redondo',108),(10807,'Purral',108),(10901,'Santa Ana',109),(10902,'Salitral',109),(10903,'Pozos',109),(10904,'Uruca',109),(10905,'Piedades',109),(10906,'Brasil',109),(11001,'Alajuelita',110),(11002,'San Josecito',110),(11003,'San Antonio',110),(11004,'Concepción',110),(11005,'San Felipe',110),(11101,'San Isidro',111),(11102,'San Rafael',111),(11103,'Dulce Nombre de Jesús',111),(11104,'Patalillo',111),(11105,'Cascajal',111),(11201,'San Ignacio',112),(11202,'Guaitil',112),(11203,'Palmichal',112),(11204,'Cangrejal',112),(11205,'Sabanillas',112),(11301,'San Juan',113),(11302,'Cinco Esquinas',113),(11303,'Anselmo Llorente',113),(11304,'León XIII',113),(11305,'Colima',113),(11401,'San Vicente',114),(11402,'San Jerónimo',114),(11403,'La Trinidad',114),(11501,'San Pedro',115),(11502,'Sabanilla',115),(11503,'Mercedes',115),(11504,'San Rafael',115),(11601,'San Pablo',116),(11602,'San Pedro',116),(11603,'San Juan de Mata',116),(11604,'San Luis',116),(11605,'Carara',116),(11701,'Santa María',117),(11702,'Jardín',117),(11703,'Copey',117),(11801,'Curridabat',118),(11802,'Granadilla',118),(11803,'Sánchez',118),(11804,'Tirrases',118),(11901,'San Isidro de El General',119),(11902,'El General',119),(11903,'Daniel Flores',119),(11904,'Rivas',119),(11905,'San Pedro',119),(11906,'Platanares',119),(11907,'Pejibaye',119),(11908,'Cajón',119),(11909,'Barú',119),(11910,'Río Nuevo',119),(11911,'Páramo',119),(11912,'La Amistad',119),(12001,'San Pablo',120),(12002,'San Andrés',120),(12003,'Llano Bonito',120),(12004,'San Isidro',120),(12005,'Santa Cruz',120),(12006,'San Antonio',120),(20101,'Alajuela',201),(20102,'San José',201),(20103,'Carrizal',201),(20104,'San Antonio',201),(20105,'Guácima',201),(20106,'San Isidro',201),(20107,'Sabanilla',201),(20108,'San Rafael',201),(20109,'Río Segundo',201),(20110,'Desamparados',201),(20111,'Turrúcares',201),(20112,'Tambor',201),(20113,'Garita',201),(20114,'Sarapiquí',201),(20201,'San Ramón',202),(20202,'Santiago',202),(20203,'San Juan',202),(20204,'Piedades Norte',202),(20205,'Piedades Sur',202),(20206,'San Rafael',202),(20207,'San Isidro',202),(20208,'Ángeles',202),(20209,'Alfaro',202),(20210,'Volio',202),(20211,'Concepción',202),(20212,'Zapotal',202),(20213,'Peñas Blancas',202),(20214,'San Lorenzo',202),(20301,'Grecia',203),(20302,'San Isidro',203),(20303,'San José',203),(20304,'San Roque',203),(20305,'Tacares',203),(20307,'Puente de Piedra',203),(20308,'Bolívar',203),(20401,'San Mateo',204),(20402,'Desmonte',204),(20403,'Jesús María',204),(20404,'Labrador',204),(20501,'Atenas',205),(20502,'Jesús',205),(20503,'Mercedes',205),(20504,'San Isidro',205),(20505,'Concepción',205),(20506,'San José',205),(20507,'Santa Eulalia',205),(20508,'Escobal',205),(20601,'Naranjo',206),(20602,'San Miguel',206),(20603,'San José',206),(20604,'Cirrí Sur',206),(20605,'San Jerónimo',206),(20606,'San Juan',206),(20607,'El Rosario',206),(20608,'Palmitos',206),(20701,'Palmares',207),(20702,'Zaragoza',207),(20703,'Buenos Aires',207),(20704,'Santiago',207),(20705,'Candelaria',207),(20706,'Esquipulas',207),(20707,'La Granja',207),(20801,'San Pedro',208),(20802,'San Juan',208),(20803,'San Rafael',208),(20804,'Carrillos',208),(20805,'Sabana Redonda',208),(20901,'Orotina',209),(20902,'El Mastate',209),(20903,'Hacienda Vieja',209),(20904,'Coyolar',209),(20905,'La Ceiba',209),(21001,'Quesada',210),(21002,'Florencia',210),(21003,'Buenavista',210),(21004,'Aguas Zarcas',210),(21005,'Venecia',210),(21006,'Pital',210),(21007,'La Fortuna',210),(21008,'La Tigra',210),(21009,'La Palmera',210),(21010,'Venado',210),(21011,'Cutris',210),(21012,'Monterrey',210),(21013,'Pocosol',210),(21101,'Zarcero',211),(21102,'Laguna',211),(21103,'Tapesco',211),(21104,'Guadalupe',211),(21105,'Palmira',211),(21106,'Zapote',211),(21107,'Brisas',211),(21201,'Sarchí Norte',212),(21202,'Sarchí Sur',212),(21203,'Toro Amarillo',212),(21204,'San Pedro',212),(21205,'Rodríguez',212),(21301,'Upala',213),(21302,'Aguas Claras',213),(21303,'San José',213),(21304,'Bijagua',213),(21305,'Delicias',213),(21306,'Dos Ríos',213),(21307,'Yolillal',213),(21308,'Canalete',213),(21401,'Los Chiles',214),(21402,'Caño Negro',214),(21403,'El Amparo',214),(21404,'San Jorge',214),(21501,'San Rafael',215),(21502,'Buenavista',215),(21503,'Cote',215),(21504,'Katira',215),(21601,'Río Cuarto',216),(21602,'Santa Rita',216),(21603,'Santa Isabel',216),(30101,'Oriental',301),(30102,'Occidental',301),(30103,'Carmen',301),(30104,'San Nicolás',301),(30105,'Aguacaliente',301),(30106,'Guadalupe',301),(30107,'Corralillo',301),(30108,'Tierra Blanca',301),(30109,'Dulce Nombre',301),(30110,'Llano Grande',301),(30111,'Quebradilla',301),(30201,'Paraíso',302),(30202,'Santiago',302),(30203,'Orosi',302),(30204,'Cachí',302),(30205,'Llanos de Santa Lucía',302),(30206,'Birrisito',302),(30301,'Tres Ríos',303),(30302,'San Diego',303),(30303,'San Juan',303),(30304,'San Rafael',303),(30305,'Concepción',303),(30306,'Dulce Nombre',303),(30307,'San Ramón',303),(30308,'Río Azul',303),(30401,'Juan Viñas',304),(30402,'Tucurrique',304),(30403,'Pejibaye',304),(30404,'La Victoria',304),(30501,'Turrialba',305),(30502,'La Suiza',305),(30503,'Peralta',305),(30504,'Santa Cruz',305),(30505,'Santa Teresita',305),(30506,'Pavones',305),(30507,'Tuis',305),(30508,'Tayutic',305),(30509,'Santa Rosa',305),(30510,'Tres Equis',305),(30511,'La Isabel',305),(30512,'Chirripó',305),(30601,'Pacayas',306),(30602,'Cervantes',306),(30603,'Capellades',306),(30701,'San Rafael',307),(30702,'Cot',307),(30703,'Potrero Cerrado',307),(30704,'Cipreses',307),(30705,'Santa Rosa',307),(30801,'El Tejar',308),(30802,'San Isidro',308),(30803,'Tobosi',308),(30804,'Patio de Agua',308),(40101,'Heredia',401),(40102,'Mercedes',401),(40103,'San Francisco',401),(40104,'Ulloa',401),(40105,'Varablanca',401),(40201,'Barva',402),(40202,'San Pedro',402),(40203,'San Pablo',402),(40204,'San Roque',402),(40205,'Santa Lucía',402),(40206,'San José de la Montaña',402),(40301,'Santo Domingo',403),(40302,'San Vicente',403),(40303,'San Miguel',403),(40304,'Paracito',403),(40305,'Santo Tomás',403),(40306,'Santa Rosa',403),(40307,'Tures',403),(40308,'Pará',403),(40401,'Santa Bárbara',404),(40402,'San Pedro',404),(40403,'San Juan',404),(40404,'Jesús',404),(40405,'Santo Domingo',404),(40406,'Purabá',404),(40501,'San Rafael',405),(40502,'San Josecito',405),(40503,'Santiago',405),(40504,'Ángeles',405),(40505,'Concepción',405),(40601,'San Isidro',406),(40602,'San José',406),(40603,'Concepción',406),(40604,'San Francisco',406),(40701,'San Antonio',407),(40702,'La Ribera',407),(40703,'La Asunción',407),(40801,'San Joaquín',408),(40802,'Barrantes',408),(40803,'Llorente',408),(40901,'San Pablo',409),(40902,'Rincón de Sabanilla',409),(41001,'Puerto Viejo',410),(41002,'La Virgen',410),(41003,'Las Horquetas',410),(41004,'Llanuras del Gaspar',410),(41005,'Cureña',410),(50101,'Liberia',501),(50102,'Cañas Dulces',501),(50103,'Mayorga',501),(50104,'Nacascolo',501),(50105,'Curubandé',501),(50201,'Nicoya',502),(50202,'Mansión',502),(50203,'San Antonio',502),(50204,'Quebrada Honda',502),(50205,'Sámara',502),(50206,'Nosara',502),(50207,'Belén de Nosarita',502),(50301,'Santa Cruz',503),(50302,'Bolsón',503),(50303,'Veintisiete de Abril',503),(50304,'Tempate',503),(50305,'Cartagena',503),(50306,'Cuajiniquil',503),(50307,'Diriá',503),(50308,'Cabo Velas',503),(50309,'Tamarindo',503),(50401,'Bagaces',504),(50402,'La Fortuna',504),(50403,'Mogote',504),(50404,'Río Naranjo',504),(50501,'Filadelfia',505),(50502,'Palmira',505),(50503,'Sardinal',505),(50504,'Belén',505),(50601,'Cañas',506),(50602,'Palmira',506),(50603,'San Miguel',506),(50604,'Bebedero',506),(50605,'Porozal',506),(50701,'Las Juntas',507),(50702,'Sierra',507),(50703,'San Juan',507),(50704,'Colorado',507),(50801,'Tilarán',508),(50802,'Quebrada Grande',508),(50803,'Tronadora',508),(50804,'Santa Rosa',508),(50805,'Líbano',508),(50806,'Tierras Morenas',508),(50807,'Arenal',508),(50808,'Cabeceras',508),(50901,'Carmona',509),(50902,'Santa Rita',509),(50903,'Zapotal',509),(50904,'San Pablo',509),(50905,'Porvenir',509),(50906,'Bejuco',509),(51001,'La Cruz',510),(51002,'Santa Cecilia',510),(51003,'La Garita',510),(51004,'Santa Elena',510),(51101,'Hojancha',511),(51102,'Monte Romo',511),(51103,'Puerto Carrillo',511),(51104,'Huacas',511),(51105,'Matambú',511),(60101,'Puntarenas',601),(60102,'Pitahaya',601),(60103,'Chomes',601),(60104,'Lepanto',601),(60105,'Paquera',601),(60106,'Manzanillo',601),(60107,'Guacimal',601),(60108,'Barranca',601),(60109,'Monte Verde',601),(60110,'Isla del Coco',601),(60111,'Cóbano',601),(60112,'Chacarita',601),(60113,'Chira',601),(60114,'Acapulco',601),(60115,'El Roble',601),(60116,'Arancibia',601),(60201,'Espíritu Santo',602),(60202,'San Juan Grande',602),(60203,'Macacona',602),(60204,'San Rafael',602),(60205,'San Jerónimo',602),(60206,'Caldera',602),(60301,'Buenos Aires',603),(60302,'Volcán',603),(60303,'Potrero Grande',603),(60304,'Boruca',603),(60305,'Pilas',603),(60306,'Colinas',603),(60307,'Chánguena',603),(60308,'Biolley',603),(60309,'Brunka',603),(60401,'Miramar',604),(60402,'La Unión',604),(60403,'San Isidro',604),(60501,'Puerto Cortés',605),(60502,'Palmar',605),(60503,'Sierpe',605),(60504,'Bahía Ballena',605),(60505,'Piedras Blancas',605),(60506,'Bahía Drake',605),(60601,'Quepos',606),(60602,'Savegre',606),(60603,'Naranjito',606),(60701,'Golfito',607),(60702,'Puerto Jiménez',607),(60703,'Guaycará',607),(60704,'Pavón',607),(60801,'San Vito',608),(60802,'Sabalito',608),(60803,'Aguabuena',608),(60804,'Limoncito',608),(60805,'Pittier',608),(60806,'Gutiérrez Braun',608),(60901,'Parrita',609),(61001,'Corredor',610),(61002,'La Cuesta',610),(61003,'Canoas',610),(61004,'Laurel',610),(61101,'Jacó',611),(61102,'Tárcoles',611),(61103,'Lagunillas',611),(70101,'Limón',701),(70102,'Valle La Estrella',701),(70103,'Río Blanco',701),(70104,'Matama',701),(70201,'Guápiles',702),(70202,'Jiménez',702),(70203,'Rita',702),(70204,'Roxana',702),(70205,'Cariari',702),(70206,'Colorado',702),(70207,'La Colonia',702),(70301,'Siquirres',703),(70302,'Pacuarito',703),(70303,'Florida',703),(70304,'Germania',703),(70305,'El Cairo',703),(70306,'Alegría',703),(70307,'Reventazón',703),(70401,'Bratsi',704),(70402,'Sixaola',704),(70403,'Cahuita',704),(70404,'Telire',704),(70501,'Matina',705),(70502,'Batán',705),(70503,'Carrandi',705),(70601,'Guácimo',706),(70602,'Mercedes',706),(70603,'Pocora',706),(70604,'Río Jiménez',706),(70605,'Duacarí',706);
/*!40000 ALTER TABLE `distrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidad`
--

DROP TABLE IF EXISTS `especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidad` (
  `idEspecialidad` int NOT NULL AUTO_INCREMENT,
  `especialidad` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idEspecialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
INSERT INTO `especialidad` VALUES (1,'Medicina General','Atención y cuidado general de la salud de los animales, incluyendo diagnóstico y tratamiento de enfermedades comunes.'),(2,'Cirugía','Realización de procedimientos quirúrgicos en animales para tratar diversas condiciones médicas.'),(3,'Castración','Procedimiento quirúrgico para esterilizar animales, evitando su reproducción y controlando la población.'),(4,'Aseo','Servicios de limpieza y cuidado de higiene para mantener a los animales limpios y saludables.'),(5,'Administrador','Administrador de la plataforma web.'),(6,'Recepcionista','Brindar atención a visitantes externos y canalizarlos al área correspondiente.'),(7,'N/A','N/A');
/*!40000 ALTER TABLE `especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado` (
  `idestado` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`idestado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'Asignada'),(2,'Atendida'),(3,'Cancelada');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `idEvento` int NOT NULL AUTO_INCREMENT,
  `Lugar` varchar(200) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `descripcion` varchar(400) DEFAULT NULL,
  `imagen` varchar(400) DEFAULT NULL,
  `idProvincia` int NOT NULL,
  `idCanton` int NOT NULL,
  `idDistrito` int NOT NULL,
  `nombreEvento` varchar(100) NOT NULL,
  PRIMARY KEY (`idEvento`),
  KEY `fk_Eventos_Provincia` (`idProvincia`),
  KEY `fk_Eventos_Canton` (`idCanton`),
  KEY `fk_Eventos_Distrito` (`idDistrito`),
  CONSTRAINT `fk_Eventos_Canton` FOREIGN KEY (`idCanton`) REFERENCES `canton` (`idCanton`),
  CONSTRAINT `fk_Eventos_Distrito` FOREIGN KEY (`idDistrito`) REFERENCES `distrito` (`idDistrito`),
  CONSTRAINT `fk_Eventos_Provincia` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`idProvincia`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,'Coronado','2023-10-21','09:00:00','16:00:00','Campaña de Castración Felina y Canina','510eba026a7c41146da608f893168338.jpg',1,101,10101,'Campaña de Castración Felina y Canina'),(2,'San José','2023-08-27','10:00:00','14:00:00','Día de Adopción Responsable','fca9f567b40e6266fee2be3a288cd70b.jpg',1,101,10101,'Día de Adopción Responsable'),(3,'Heredia','2023-09-30','08:30:00','16:30:00','Charla sobre Nutrición y Salud Animal','c44d16f414c9f8b0be7a74417cea9254.jpg',1,101,10101,'Charla sobre Nutrición y Salud Animal'),(4,'Mata Platano','2023-09-15','11:00:00','04:00:00','Exposición de Razas Caninas','453952d44dc3c0a018eae36a22f78833.jpg',1,101,10101,'Exposición de Razas Caninas'),(5,'Pedregal','2023-08-13','09:00:00','13:00:00','Vacunación Gratuita','95f06f81d2dea3f9c5807f3b7658b3fe.jpg',1,101,10101,'Vacunación Gratuita'),(6,'Pérez Zeledon','2023-11-19','10:00:00','14:00:00','Taller de Adiestramiento Canino','aa3a47b08ab10594c53e4f2914f92a45.jpg',1,101,10101,'Taller de Adiestramiento Canino');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historialmedico`
--

DROP TABLE IF EXISTS `historialmedico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historialmedico` (
  `idHMedico` int NOT NULL AUTO_INCREMENT,
  `detalleCita` varchar(200) NOT NULL,
  `costo` int DEFAULT NULL,
  `idMascota` int NOT NULL,
  `idColaborador` int NOT NULL,
  `idCita` int NOT NULL,
  PRIMARY KEY (`idHMedico`),
  KEY `fk_HistorialMedico_Mascota` (`idMascota`),
  KEY `fk_HistorialMedico_Colaborador` (`idColaborador`),
  KEY `fk_HistorialMedico_Cita` (`idCita`),
  CONSTRAINT `fk_HistorialMedico_Cita` FOREIGN KEY (`idCita`) REFERENCES `citas` (`idCita`),
  CONSTRAINT `fk_HistorialMedico_Colaborador` FOREIGN KEY (`idColaborador`) REFERENCES `colaborador` (`idColaborador`),
  CONSTRAINT `fk_HistorialMedico_Mascota` FOREIGN KEY (`idMascota`) REFERENCES `mascota` (`idMascota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historialmedico`
--

LOCK TABLES `historialmedico` WRITE;
/*!40000 ALTER TABLE `historialmedico` DISABLE KEYS */;
/*!40000 ALTER TABLE `historialmedico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horariocitas`
--

DROP TABLE IF EXISTS `horariocitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horariocitas` (
  `idHorario` int NOT NULL AUTO_INCREMENT,
  `horaInicio` time DEFAULT NULL,
  `horaFin` time DEFAULT NULL,
  PRIMARY KEY (`idHorario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horariocitas`
--

LOCK TABLES `horariocitas` WRITE;
/*!40000 ALTER TABLE `horariocitas` DISABLE KEYS */;
INSERT INTO `horariocitas` VALUES (1,'08:00:00','09:00:00'),(2,'09:00:00','10:00:00'),(3,'10:00:00','11:00:00'),(4,'11:00:00','12:00:00'),(5,'13:00:00','14:00:00'),(6,'14:00:00','15:00:00'),(7,'15:00:00','16:00:00');
/*!40000 ALTER TABLE `horariocitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mascota`
--

DROP TABLE IF EXISTS `mascota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mascota` (
  `idMascota` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `imagen` varchar(400) DEFAULT NULL,
  `idTipoMascota` int NOT NULL,
  `idCliente` int NOT NULL,
  PRIMARY KEY (`idMascota`),
  KEY `fk_Mascota_TipoMascota` (`idTipoMascota`),
  KEY `fk_Mascota_Cliente` (`idCliente`),
  CONSTRAINT `fk_Mascota_Cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  CONSTRAINT `fk_Mascota_TipoMascota` FOREIGN KEY (`idTipoMascota`) REFERENCES `tipomascota` (`idTipoMascota`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mascota`
--

LOCK TABLES `mascota` WRITE;
/*!40000 ALTER TABLE `mascota` DISABLE KEYS */;
INSERT INTO `mascota` VALUES (1,'Buddy','Es un doberman de 80kg, pelo negro y muy amigable','bfe5dbd863e85065d8430e23bf8b74a4.jpg',1,1),(2,'Max','Es un gato muy especial, pero un poco arizco','c8fd00e7c02997095899aa70046c793e.jpg',2,1),(3,'Luna','Es mi mejor amiga, tiene 2 anios','5036650d388ff7d2b00798c43034b964.jpg',2,1);
/*!40000 ALTER TABLE `mascota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provincia` (
  `idProvincia` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idProvincia`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincia`
--

LOCK TABLES `provincia` WRITE;
/*!40000 ALTER TABLE `provincia` DISABLE KEYS */;
INSERT INTO `provincia` VALUES (1,'San José'),(2,'Alajuela'),(3,'Cartago'),(4,'Heredia'),(5,'Guanacaste'),(6,'Puntarenas'),(7,'Limón');
/*!40000 ALTER TABLE `provincia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `idRol` int NOT NULL AUTO_INCREMENT,
  `nombreRol` varchar(50) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Admin'),(2,'Medico'),(3,'User');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `idServicio` int NOT NULL AUTO_INCREMENT,
  `servicio` varchar(50) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idServicio`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES (1,'Medicina General','Consulta médica general para mascotas.'),(2,'Cirugía','Procedimientos quirúrgicos para mascotas.'),(3,'Castración','Servicios de castración para mascotas.'),(4,'Aseo de Mascotas','Servicios profesionales de aseo para mascotas.');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipomascota`
--

DROP TABLE IF EXISTS `tipomascota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipomascota` (
  `idTipoMascota` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idTipoMascota`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipomascota`
--

LOCK TABLES `tipomascota` WRITE;
/*!40000 ALTER TABLE `tipomascota` DISABLE KEYS */;
INSERT INTO `tipomascota` VALUES (1,'Perro'),(2,'Gato');
/*!40000 ALTER TABLE `tipomascota` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-20 16:03:04

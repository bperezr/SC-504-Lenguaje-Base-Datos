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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canton`
--

LOCK TABLES `canton` WRITE;
/*!40000 ALTER TABLE `canton` DISABLE KEYS */;
INSERT INTO `canton` VALUES (1,'Goicoechea',1),(2,'Vasquez de Coronado',1),(3,'San José',1),(4,'Alajuelita',1),(5,'Acosta',1),(6,'Tibás',1),(7,'Moravia',1),(8,'Montes de Oca',1),(9,'Turrubares',1),(10,'Dota',1),(11,'Curridabat',1),(12,'Pérez Zeledón',1),(13,'Escazú',1),(14,'León Cortés',1),(15,'Desamparados',1),(16,'Puriscal',1),(17,'Tarrazú',1),(18,'Aserrí',1),(19,'Mora',1),(20,'Goicoechea',1),(21,'Santa Ana',1),(22,'Alajuela',4),(23,'San Carlos',4),(24,'Zarcero',4),(25,'Sarchí',4),(26,'Upala',4),(27,'Los Chiles',4),(28,'Guatuso',4),(29,'Río Cuarto',4),(30,'San Ramón',4),(31,'Grecia',4),(32,'San Mateo',4),(33,'Atenas',4),(34,'Naranjo',4),(35,'Palmares',4),(36,'Poás',4),(37,'Orotina',4),(38,'Cartago',3),(39,'Paraíso',3),(40,'La Unión',3),(41,'Jiménez',3),(42,'Turrialba',3),(43,'Alvarado',3),(44,'Oreamuno',3),(45,'El Guarco',3),(46,'Heredia',2),(47,'SARAPIQUI',2),(48,'Barva',2),(49,'Santo Domingo',2),(50,'Santa Bárbara',2),(51,'San Rafael',2),(52,'San Isidro',2),(53,'Belén',2),(54,'Flores',2),(55,'San Pablo',2);
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
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `idHorario` int NOT NULL,
  `idMascota` int NOT NULL,
  `idServicio` int NOT NULL,
  `idCliente` int NOT NULL,
  PRIMARY KEY (`idCita`),
  KEY `fk_Citas_Horario` (`idHorario`),
  KEY `fk_Citas_Mascota` (`idMascota`),
  KEY `fk_Citas_Servicio` (`idServicio`),
  KEY `fk_Citas_Cliente` (`idCliente`),
  CONSTRAINT `fk_Citas_Cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  CONSTRAINT `fk_Citas_Horario` FOREIGN KEY (`idHorario`) REFERENCES `horariocitas` (`idHorario`),
  CONSTRAINT `fk_Citas_Servicio` FOREIGN KEY (`idServicio`) REFERENCES `servicios` (`idServicio`),
  CONSTRAINT `fk_Citas_TipoMascota` FOREIGN KEY (`idMascota`) REFERENCES `tipomascota` (`idTipoMascota`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
INSERT INTO `citas` VALUES (1,'John Doe','john.doe@example.com','2023-07-30',1,1,1,1),(2,'Jane Smith','jane.smith@example.com','2023-07-30',2,2,2,2),(3,'Tony','tony@email.es','2023-08-02',2,1,3,1),(4,'Jorge','jorge09ha@email.test','2023-08-09',3,2,5,2),(5,'TEST2','test2@gmail.com','2023-08-31',1,2,5,2),(6,'Andres','ant@test.cr','2023-08-24',5,2,4,2),(7,'Marco','marco.antonio@test.com','2023-08-16',4,2,6,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Juan','Perez','Gomez','123456789','Calle 1, Ciudad',1,1,1,3,'juan.p@email.com','admin01'),(2,'Maria','Gonzalez','Lopez','987654321','Avenida 2, Pueblo',2,2,4,3,'maria.g@email.com','admin01');
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaborador`
--

LOCK TABLES `colaborador` WRITE;
/*!40000 ALTER TABLE `colaborador` DISABLE KEYS */;
INSERT INTO `colaborador` VALUES (28,'Jorge','Hernández','Hernandez',3,1,'3ddc7d8b94d61ef33e39e1b84b06bac5.jpg',2,'jorge.h@happypaws.test','admin01'),(29,'Ana','Lima','Perez',3,2,'eaeb66b9ceddd99b9f28626dcb0a1140.jpg',2,'ana.l@happypaws.test','admin01'),(30,'Andres','Lopez','Rios',2,1,'9eff7369e81bd1676ebf2cd373609702.jpg',1,'andresl@happypaws.com','$2y$10$szkvnnS39qxATAramczxLuFBpjuHqtVk0flakyl6AWouaHs5FKRDS'),(31,'Andres','Lopez','Rios',3,2,'bf4b493efb6b70152fa1b3afeca34ab8.jpg',1,'andresl2@happypaws.com','admin');
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
/*!40000 ALTER TABLE `colaboradorservicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacto` (
  `idContacto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mensaje` varchar(250) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distrito`
--

LOCK TABLES `distrito` WRITE;
/*!40000 ALTER TABLE `distrito` DISABLE KEYS */;
INSERT INTO `distrito` VALUES (1,'Cascajal',2),(2,'San Pedro',2),(3,'San Rafael',2),(4,'San Francisco',2),(5,'San Francisco de Dos Ríos',1),(6,'Uruca',1),(7,'Mata Redonda',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
INSERT INTO `especialidad` VALUES (1,'Medicina General','Atención y cuidado general de la salud de los animales, incluyendo diagnóstico y tratamiento de enfermedades comunes.'),(2,'Cirugía','Realización de procedimientos quirúrgicos en animales para tratar diversas condiciones médicas.'),(3,'Castración','Procedimiento quirúrgico para esterilizar animales, evitando su reproducción y controlando la población.'),(4,'Aseo','Servicios de limpieza y cuidado de higiene para mantener a los animales limpios y saludables.');
/*!40000 ALTER TABLE `especialidad` ENABLE KEYS */;
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
INSERT INTO `eventos` VALUES (14,'Coronado','2023-10-21','09:00:00','16:00:00','Campaña de Castración Felina y Canina','f980d313262c9e939186bcecdeb8a083.jpg',1,2,2,'Campaña de Castración Felina y Canina'),(15,'San José','2023-08-27','10:00:00','14:00:00','Día de Adopción Responsable','fca9f567b40e6266fee2be3a288cd70b.jpg',1,3,6,'Día de Adopción Responsable'),(16,'Heredia','2023-09-30','08:30:00','16:30:00','Charla sobre Nutrición y Salud Animal','cc3e82020d07451ccbe59f4cc57ef565.jpg',2,51,3,'Charla sobre Nutrición y Salud Animal'),(17,'Mata Platano','2023-09-15','11:00:00','04:00:00','Exposición de Razas Caninas','453952d44dc3c0a018eae36a22f78833.jpg',1,1,7,'Exposición de Razas Caninas'),(18,'Pedregal','2023-08-13','09:00:00','13:00:00','Vacunación Gratuita','4fdf54a7f4d79fd5d03abe16bc9a1011.jpg',2,53,7,'Vacunación Gratuita'),(19,'Pérez Zeledon','2023-11-19','10:00:00','14:00:00','Taller de Adiestramiento Canino','aa3a47b08ab10594c53e4f2914f92a45.jpg',1,12,7,'Taller de Adiestramiento Canino'),(20,'Club Peppers','2023-08-27','10:00:00','14:00:00','Test','1122054eb2f23bf03971d88ef129efe5.jpg',2,4,2,'Test'),(21,'Test2','2023-08-08','16:00:00','19:00:00','TEST','d47c98156806ef3ac4ec6ca6b077c93f.jpg',1,1,1,'Test2');
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
-- Table structure for table `horariocolaborador`
--

DROP TABLE IF EXISTS `horariocolaborador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horariocolaborador` (
  `idHorario` int NOT NULL,
  `idColaborador` int NOT NULL,
  PRIMARY KEY (`idHorario`,`idColaborador`),
  KEY `fk_ColaboradorHorario` (`idColaborador`),
  CONSTRAINT `fk_ColaboradorHorario` FOREIGN KEY (`idColaborador`) REFERENCES `colaborador` (`idColaborador`),
  CONSTRAINT `fk_horario_Colaborador` FOREIGN KEY (`idHorario`) REFERENCES `horariocitas` (`idHorario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horariocolaborador`
--

LOCK TABLES `horariocolaborador` WRITE;
/*!40000 ALTER TABLE `horariocolaborador` DISABLE KEYS */;
/*!40000 ALTER TABLE `horariocolaborador` ENABLE KEYS */;
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
INSERT INTO `mascota` VALUES (1,'Buddy','Es un doberman de 80kg, pelo negro y muy amigable',1,1),(2,'Max','Es un gato muy especial, pero un poco arizco',1,2),(3,'Luna','Es mi mejor amiga, tiene 2 anios',2,1);
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
INSERT INTO `provincia` VALUES (1,'San José'),(2,'Heredia'),(3,'Cartago'),(4,'Alajuela'),(5,'Puntarenas'),(6,'Limón'),(7,'Guanacaste');
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
INSERT INTO `servicios` VALUES (3,'Medicina General','Consulta médica general para mascotas.'),(4,'Cirugía','Procedimientos quirúrgicos para mascotas.'),(5,'Castración','Servicios de castración para mascotas.'),(6,'Aseo de Mascotas','Servicios profesionales de aseo para mascotas.');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
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

-- Dump completed on 2023-08-10  6:00:12

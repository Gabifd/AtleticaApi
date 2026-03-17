CREATE DATABASE  IF NOT EXISTS `atletica` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `atletica`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: atletica
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `atribucao`
--

DROP TABLE IF EXISTS `atribucao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atribucao` (
  `idAtribucao` int NOT NULL,
  `nmCargo` varchar(200) NOT NULL,
  `nrHoras` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idAtribucao`),
  UNIQUE KEY `nmCargo_UNIQUE` (`nmCargo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atribucao`
--

LOCK TABLES `atribucao` WRITE;
/*!40000 ALTER TABLE `atribucao` DISABLE KEYS */;
/*!40000 ALTER TABLE `atribucao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membro`
--

DROP TABLE IF EXISTS `membro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membro` (
  `idMembro` varchar(200) NOT NULL,
  `nmNome` varchar(45) NOT NULL,
  `nrCPF` varchar(45) NOT NULL,
  `nrEntrada` date NOT NULL,
  `flAtivo` char(1) NOT NULL,
  `Atribucao_idAtribucao` int NOT NULL,
  PRIMARY KEY (`idMembro`),
  UNIQUE KEY `nrCPF_UNIQUE` (`nrCPF`),
  KEY `fk_Membro_Atribucao_idx` (`Atribucao_idAtribucao`),
  CONSTRAINT `fk_Membro_Atribucao` FOREIGN KEY (`Atribucao_idAtribucao`) REFERENCES `atribucao` (`idAtribucao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membro`
--

LOCK TABLES `membro` WRITE;
/*!40000 ALTER TABLE `membro` DISABLE KEYS */;
/*!40000 ALTER TABLE `membro` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-17  8:55:16

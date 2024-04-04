-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 04, 2024 at 08:00 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pastelaria`
--

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nome_user` varchar(50) NOT NULL,
  `email_user` varchar(50) NOT NULL,
  `senha_user` varchar(50) NOT NULL,
  `tipo_user` char(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nome_user`, `email_user`, `senha_user`, `tipo_user`) VALUES
(1, 'Henrique Ailer', 'ailer@email.com', 'senha-padrao', 'a'),
(2, 'Caio Paulena', 'caio@email.com', 'senha-padrao', 'a'),
(3, 'João Silva', 'joao@email.com', 'senha-padrao', 'f'),
(4, 'Arthur Souza', 'arthur@email.com', 'senha-padrao', 'f'),
(5, 'Admnistrador', 'adm', 'adm', 'a');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

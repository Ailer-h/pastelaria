-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 09, 2024 at 08:08 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `estoque`
--

DROP TABLE IF EXISTS `estoque`;
CREATE TABLE IF NOT EXISTS `estoque` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `nome_item` varchar(50) NOT NULL,
  `data_vencimento` date NOT NULL,
  `valor_custo` decimal(10,2) NOT NULL,
  `unidade_medida` varchar(2) NOT NULL,
  `qtd` int(11) NOT NULL,
  `qtd_padrao` int(11) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `estoque`
--

INSERT INTO `estoque` (`id_item`, `nome_item`, `data_vencimento`, `valor_custo`, `unidade_medida`, `qtd`, `qtd_padrao`) VALUES
(2, 'PROD1', '1111-11-11', '25.00', 'g', 100, 100),
(3, 'PROD2', '1111-11-11', '35.00', 'g', 78, 100),
(4, 'PROD3', '1111-11-11', '245.00', 'g', 45, 100),
(5, 'PROD4', '1111-11-11', '12.00', 'g', 0, 100),
(6, 'PROD5', '1111-11-11', '12.00', 'g', 88, 99),
(7, 'PROD6', '1111-11-11', '15.00', 'g', 10, 100);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nome_user` varchar(50) NOT NULL,
  `email_user` varchar(50) NOT NULL,
  `senha_user` varchar(50) NOT NULL,
  `cpf_user` varchar(14) NOT NULL,
  `cargo_user` varchar(50) NOT NULL,
  `tipo_user` char(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nome_user`, `email_user`, `senha_user`, `cpf_user`, `cargo_user`, `tipo_user`) VALUES
(1, 'Henrique Ailer', 'ailer@email.com', 'senha-padrao', '123.123.123-12', 'Admnistrador', 'a'),
(2, 'Caio Paulena', 'caio@email.com', 'senha-padrao', '123.123.123-12', 'Admnistrador', 'a'),
(3, 'João Silva', 'joao@email.com', 'senha-padrao', '123.123.123-12', 'Atendente', 'f'),
(4, 'Arthur Souza', 'arthur@email.com', 'senha-padrao', '123.123.123-12', 'Atendente', 'f'),
(5, 'Admnistrador', 'adm', 'adm', '456.456.456.78', 'Diretor', 'd');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

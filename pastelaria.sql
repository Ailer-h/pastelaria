-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 03:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `estoque`
--

CREATE TABLE `estoque` (
  `id_item` int(11) NOT NULL,
  `nome_item` varchar(50) NOT NULL,
  `data_vencimento` date NOT NULL,
  `valor_custo` decimal(10,2) NOT NULL,
  `unidade_medida` varchar(2) NOT NULL,
  `qtd` int(11) NOT NULL,
  `qtd_padrao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estoque`
--

INSERT INTO `estoque` (`id_item`, `nome_item`, `data_vencimento`, `valor_custo`, `unidade_medida`, `qtd`, `qtd_padrao`) VALUES
(2, 'PROD1', '1111-11-11', 25.00, 'g', 100, 100),
(3, 'PROD2', '1111-11-11', 35.00, 'g', 78, 100),
(4, 'PROD3', '1111-11-11', 245.00, 'g', 45, 100),
(5, 'PROD4', '1111-11-11', 12.00, 'g', 0, 100),
(6, 'PROD5', '1111-11-11', 12.00, 'g', 88, 99),
(7, 'PROD6', '1111-11-11', 15.00, 'ml', 10, 100);

-- --------------------------------------------------------

--
-- Table structure for table `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `celular1` varchar(14) NOT NULL,
  `celular2` varchar(14) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ramo_atividade` varchar(100) NOT NULL,
  `produto_oferecido` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id_prod` int(11) NOT NULL,
  `nome_prod` varchar(50) NOT NULL,
  `img_prod` longblob NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `preco_custo` decimal(10,2) NOT NULL,
  `qtd_ingrediente` int(11) NOT NULL,
  `valor_venda` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `nome_user` varchar(50) NOT NULL,
  `email_user` varchar(50) NOT NULL,
  `senha_user` varchar(50) NOT NULL,
  `cpf_user` varchar(14) NOT NULL,
  `cargo_user` varchar(50) NOT NULL,
  `tipo_user` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nome_user`, `email_user`, `senha_user`, `cpf_user`, `cargo_user`, `tipo_user`) VALUES
(1, 'Henrique Ailer', 'ailer@email.com', 'senha-padrao', '123.123.123-12', 'Admnistrador', 'a'),
(2, 'Caio Paulena', 'caio@email.com', 'senha-padrao', '123.123.123-12', 'Admnistrador', 'a'),
(3, 'João Silva', 'joao@email.com', 'senha-padrao', '123.123.123-12', 'Atendente', 'f'),
(4, 'Arthur Souza', 'arthur@email.com', 'senha-padrao', '123.123.123-12', 'Atendente', 'f'),
(5, 'Admnistrador', 'adm', 'adm', '456.456.456.78', 'Diretor', 'd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_prod`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

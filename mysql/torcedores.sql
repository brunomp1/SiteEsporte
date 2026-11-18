-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/11/2026 às 00:49
-- Versão do servidor: 10.11.16-MariaDB
-- Versão do PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cartao_amarelo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `torcedores`
--

CREATE TABLE `torcedores` (
  `id` int(11) NOT NULL,
  `nome` varchar(190) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(40) NOT NULL,
  `time_clube` varchar(90) NOT NULL,
  `cidade` varchar(180) NOT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `torcedores`
--

INSERT INTO `torcedores` (`id`, `nome`, `email`, `senha`, `telefone`, `time_clube`, `cidade`, `criado_em`) VALUES
(1, 'pedro', 'pedro@hj', '123', '189999923', 'Corinthians', 'Presidente', '2026-11-08 12:39:17'),
(2, 'Bruno', 'bruno@123', '123', '18676767', 'Corinthians', 'Prudente', '2026-11-10 01:36:34'),
(3, 'Pedro', 'pjbrito@gmail', '123', '189676767', 'Corinthians', 'Presidente Prudente', '2026-11-11 17:54:21'),
(4, 'Anardo', 'anar@gmail', '123', '1899', 'Sporting CP', 'A', '2026-11-11 22:35:35'),
(5, 'ana', 'ana@gmail', '1234', '00000000000', 'Mirassol', 'SP', '2026-11-11 23:34:46');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `torcedores`
--
ALTER TABLE `torcedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `torcedores`
--
ALTER TABLE `torcedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Nov-2020 às 12:32
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `monogerador`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `banco_horas`
--

CREATE TABLE `banco_horas` (
  `id` int(10) NOT NULL,
  `id_gerador` varchar(100) NOT NULL,
  `last_count_horas` time NOT NULL,
  `update_ut` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `email_server`
--

CREATE TABLE `email_server` (
  `id` int(11) NOT NULL,
  `host` varchar(100) NOT NULL,
  `smtp_auth` tinyint(1) NOT NULL,
  `smtp_security` varchar(30) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `port` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `email_server`
--

INSERT INTO `email_server` (`id`, `host`, `smtp_auth`, `smtp_security`, `username`, `password`, `port`, `ativo`) VALUES
(110, 'smtp.gmail.com', 1, 'tls', 'geradorcaixa@gmail.com', 'geradorcaixa20.', 587, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerador`
--

CREATE TABLE `gerador` (
  `id` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `fabricante` text NOT NULL,
  `modelo` text NOT NULL,
  `potencia` text NOT NULL,
  `hora_trabalho` text NOT NULL,
  `foto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`foto`)),
  `ip` text DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_manutencao` date DEFAULT NULL,
  `n_imobilizado` int(10) NOT NULL,
  `balcao` int(10) NOT NULL,
  `id_grupo` int(10) DEFAULT NULL,
  `create_ut` datetime DEFAULT NULL,
  `update_ut` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delete_ut` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `gerador`
--

INSERT INTO `gerador` (`id`, `descricao`, `fabricante`, `modelo`, `potencia`, `hora_trabalho`, `foto`, `ip`, `telefone`, `data_manutencao`, `n_imobilizado`, `balcao`, `id_grupo`, `create_ut`, `update_ut`, `delete_ut`, `estado`) VALUES
('708f889e0903d276d96588e40ff03fd5', 'Gerador Ag Asa Ucla', 'Volvo', 'P450', '450', '23', NULL, NULL, NULL, '2020-09-16', 0, 0, 8, '2020-11-20 03:01:53', '2020-11-20 16:01:53', NULL, 1),
('8775cd8327a0535694395dd35fcc4009', 'Gerador Ag ASA I', 'Volvo', 'VP450', '450', '23', NULL, NULL, NULL, '2020-09-07', 0, 0, 9, '2022-11-20 03:36:35', '2020-11-22 04:36:35', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerador_config`
--

CREATE TABLE `gerador_config` (
  `id` int(11) NOT NULL,
  `gerador_id` varchar(100) NOT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `key_auth` varchar(300) NOT NULL,
  `gerador_status` tinyint(1) DEFAULT NULL,
  `avariado` tinyint(1) DEFAULT NULL,
  `rede_publica` tinyint(1) DEFAULT NULL,
  `update_ut` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `gerador_config`
--

INSERT INTO `gerador_config` (`id`, `gerador_id`, `ip`, `key_auth`, `gerador_status`, `avariado`, `rede_publica`, `update_ut`) VALUES
(3, '708f889e0903d276d96588e40ff03fd5', NULL, '5eb9929eed1116d707d229d60e699eda2ab96ca2e55e9013e4d9a2b1c46b9203', 1, 0, 0, '2020-11-22 02:36:31'),
(5, '8775cd8327a0535694395dd35fcc4009', '192.168.1.100', '754a5be052011cdbf15210b37ade6263acf5466ce513ade897c7af6ce0c854de', 0, 0, 0, '2020-11-23 22:28:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerador_historico`
--

CREATE TABLE `gerador_historico` (
  `id` int(10) NOT NULL,
  `gerador_id` varchar(100) NOT NULL,
  `gerador_status` tinyint(1) NOT NULL,
  `avariado` tinyint(1) NOT NULL,
  `rede_publica` tinyint(1) NOT NULL,
  `create_ut` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `gerador_historico`
--

INSERT INTO `gerador_historico` (`id`, `gerador_id`, `gerador_status`, `avariado`, `rede_publica`, `create_ut`) VALUES
(1, '708f889e0903d276d96588e40ff03fd5', 0, 0, 0, '2020-11-21 00:23:06'),
(2, '708f889e0903d276d96588e40ff03fd5', 1, 0, 1, '2020-11-21 00:32:17'),
(3, '708f889e0903d276d96588e40ff03fd5', 1, 1, 1, '2020-11-21 00:32:22'),
(4, '708f889e0903d276d96588e40ff03fd5', 0, 1, 1, '2020-11-21 00:32:29'),
(5, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-21 00:32:34'),
(6, '708f889e0903d276d96588e40ff03fd5', 0, 0, 0, '2020-11-21 00:32:38'),
(7, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-21 00:32:47'),
(8, '708f889e0903d276d96588e40ff03fd5', 1, 1, 1, '2020-11-21 00:32:53'),
(9, '708f889e0903d276d96588e40ff03fd5', 0, 1, 1, '2020-11-21 00:32:56'),
(10, '708f889e0903d276d96588e40ff03fd5', 0, 0, 1, '2020-11-21 00:33:01'),
(11, '708f889e0903d276d96588e40ff03fd5', 0, 0, 0, '2020-11-21 00:33:05'),
(12, '708f889e0903d276d96588e40ff03fd5', 0, 0, 0, '2020-11-22 00:04:39'),
(13, '708f889e0903d276d96588e40ff03fd5', 0, 0, 0, '2020-11-22 00:05:07'),
(14, '708f889e0903d276d96588e40ff03fd5', 0, 0, 0, '2020-11-22 00:06:40'),
(15, '708f889e0903d276d96588e40ff03fd5', 0, 0, 0, '2020-11-22 00:07:22'),
(16, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:11:51'),
(17, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:18:48'),
(18, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:25:17'),
(19, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:25:22'),
(20, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:42:27'),
(21, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:43:31'),
(22, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:43:33'),
(23, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:45:14'),
(24, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:46:45'),
(25, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:47:44'),
(26, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:47:46'),
(27, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:52:43'),
(28, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:53:42'),
(29, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:53:56'),
(30, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:53:58'),
(31, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:55:39'),
(32, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 00:58:06'),
(33, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:00:05'),
(34, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:01:02'),
(35, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:05:30'),
(36, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:06:20'),
(37, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:07:34'),
(38, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:09:22'),
(39, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:09:40'),
(40, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:13:36'),
(41, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:15:06'),
(42, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:16:45'),
(43, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:19:30'),
(44, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:22:19'),
(45, '708f889e0903d276d96588e40ff03fd5', 0, 1, 0, '2020-11-22 01:23:01'),
(46, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-22 01:25:23'),
(47, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-22 01:49:33'),
(48, '708f889e0903d276d96588e40ff03fd5', 1, 0, 0, '2020-11-22 02:01:52'),
(49, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-22 02:02:49'),
(50, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-22 02:06:30'),
(51, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-22 02:11:29'),
(52, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-22 02:14:34'),
(53, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-22 02:15:23'),
(54, '708f889e0903d276d96588e40ff03fd5', 1, 0, 0, '2020-11-22 02:15:39'),
(55, '708f889e0903d276d96588e40ff03fd5', 1, 0, 0, '2020-11-22 02:24:39'),
(56, '708f889e0903d276d96588e40ff03fd5', 1, 1, 0, '2020-11-22 02:26:37'),
(57, '708f889e0903d276d96588e40ff03fd5', 1, 0, 0, '2020-11-22 02:36:31'),
(58, '8775cd8327a0535694395dd35fcc4009', 1, 1, 0, '2020-11-22 03:43:23'),
(59, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:43:59'),
(60, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:45:06'),
(61, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:46:11'),
(62, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:46:45'),
(63, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:47:33'),
(64, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:51:23'),
(65, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:51:25'),
(66, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:51:27'),
(67, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:52:14'),
(68, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:52:36'),
(69, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:52:38'),
(70, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:52:57'),
(71, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:56:00'),
(72, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:57:00'),
(73, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:57:02'),
(74, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 03:59:01'),
(75, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-22 04:00:29'),
(76, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:41:23'),
(77, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:42:36'),
(78, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:45:12'),
(79, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:46:08'),
(80, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:46:15'),
(81, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:46:41'),
(82, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:50:28'),
(83, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:50:34'),
(84, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:51:01'),
(85, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:51:07'),
(86, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:53:44'),
(87, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 16:57:29'),
(88, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:00:39'),
(89, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:00:43'),
(90, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:01:33'),
(91, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:01:37'),
(92, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:10:35'),
(93, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:10:41'),
(94, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:11:16'),
(95, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:12:00'),
(96, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:12:41'),
(97, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:12:47'),
(98, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:12:54'),
(99, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:02'),
(100, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:09'),
(101, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:16'),
(102, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:23'),
(103, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:30'),
(104, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:37'),
(105, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:44'),
(106, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:51'),
(107, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:13:58'),
(108, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:14:05'),
(109, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:14:12'),
(110, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:14:19'),
(111, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:14:26'),
(112, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 17:14:33'),
(113, '8775cd8327a0535694395dd35fcc4009', 1, 1, 0, '2020-11-23 17:38:49'),
(114, '8775cd8327a0535694395dd35fcc4009', 1, 1, 0, '2020-11-23 17:38:58'),
(115, '8775cd8327a0535694395dd35fcc4009', 1, 1, 0, '2020-11-23 17:39:22'),
(116, '8775cd8327a0535694395dd35fcc4009', 1, 1, 0, '2020-11-23 17:41:01'),
(117, '8775cd8327a0535694395dd35fcc4009', 1, 1, 0, '2020-11-23 17:43:06'),
(118, '8775cd8327a0535694395dd35fcc4009', 1, 1, 0, '2020-11-23 17:44:05'),
(119, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 19:19:25'),
(120, '8775cd8327a0535694395dd35fcc4009', 0, 1, 0, '2020-11-23 21:57:48'),
(121, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 21:58:01'),
(122, '8775cd8327a0535694395dd35fcc4009', 0, 1, 0, '2020-11-23 21:59:09'),
(123, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 21:59:21'),
(124, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 21:59:34'),
(125, '8775cd8327a0535694395dd35fcc4009', 0, 1, 0, '2020-11-23 22:01:51'),
(126, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:02:06'),
(127, '8775cd8327a0535694395dd35fcc4009', 0, 0, 1, '2020-11-23 22:02:17'),
(128, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:02:29'),
(129, '8775cd8327a0535694395dd35fcc4009', 1, 0, 1, '2020-11-23 22:03:06'),
(130, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:03:19'),
(131, '8775cd8327a0535694395dd35fcc4009', 0, 0, 1, '2020-11-23 22:19:05'),
(132, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:19:17'),
(133, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 22:19:31'),
(134, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:19:43'),
(135, '8775cd8327a0535694395dd35fcc4009', 0, 0, 1, '2020-11-23 22:19:48'),
(136, '8775cd8327a0535694395dd35fcc4009', 1, 1, 1, '2020-11-23 22:20:01'),
(137, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:20:12'),
(138, '8775cd8327a0535694395dd35fcc4009', 0, 0, 1, '2020-11-23 22:20:30'),
(139, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:20:41'),
(140, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 22:24:41'),
(141, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:24:52'),
(142, '8775cd8327a0535694395dd35fcc4009', 1, 0, 0, '2020-11-23 22:27:27'),
(143, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:27:38'),
(144, '8775cd8327a0535694395dd35fcc4009', 0, 1, 0, '2020-11-23 22:27:56'),
(145, '8775cd8327a0535694395dd35fcc4009', 0, 0, 0, '2020-11-23 22:28:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerador_tempo_vida`
--

CREATE TABLE `gerador_tempo_vida` (
  `id` int(10) NOT NULL,
  `id_gerador` varchar(100) NOT NULL,
  `datatempo_inicial` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datatempo_final` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tempo_vida` float DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `descrever` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE `grupo` (
  `id` int(10) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `local` varchar(30) NOT NULL,
  `descricao` text NOT NULL,
  `create_ut` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_ut` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delete_ut` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`id`, `nome`, `local`, `descricao`, `create_ut`, `update_ut`, `delete_ut`, `estado`) VALUES
(3, 'Sede', '', 'dgfgshbrrvaesatv', '2020-11-01 13:08:59', '2020-11-01 14:08:59', '2001-11-20 01:08:59', 0),
(4, 'Fazenda', 'Fazenda', 'Gerentes da Agência da Fazenda', '2020-11-01 13:12:58', '2020-11-01 14:12:58', '2020-11-01 13:12:58', 1),
(5, 'Sede1', '', 'sss1', '2020-11-01 13:08:56', '2020-11-01 14:08:56', '2001-11-20 01:08:56', 0),
(6, 'tuca', 'tuca', 'Tuca', '2020-10-03 00:17:02', '2020-10-03 01:17:02', '2003-10-20 12:17:02', 0),
(7, 'DARH - Técnico', 'Sede', 'Gestão de todos os geradores - com apenas a visualização dos geradores', '2020-11-01 13:12:15', '2020-11-01 14:12:15', '2020-11-01 13:12:15', 1),
(8, 'ASA II', 'Praia - ASA UCLA', 'Gerentes da Agência', '2001-11-20 01:14:28', '2020-11-01 14:14:28', '2020-11-01 13:14:28', 1),
(9, 'ASA I', 'Praia - ASA trás Assembleia', 'Gerentes da Agência', '2001-11-20 01:15:16', '2020-11-01 14:15:16', '2020-11-01 13:15:16', 1),
(10, 'GIAI', 'Praia - Sede', 'Gabinete responsavel por todos os geradores da Caixa', '2001-11-20 01:16:26', '2020-11-01 14:16:26', '2020-11-01 13:16:26', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_acesso`
--

CREATE TABLE `grupo_acesso` (
  `id` int(10) NOT NULL,
  `id_utilizador` int(10) NOT NULL,
  `id_grupo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `grupo_acesso`
--

INSERT INTO `grupo_acesso` (`id`, `id_utilizador`, `id_grupo`) VALUES
(3, 1, 7),
(4, 26, 7),
(9, 1, 4),
(10, 26, 4),
(12, 26, 8),
(15, 26, 9),
(16, 1, 8),
(17, 1, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `justificativa`
--

CREATE TABLE `justificativa` (
  `id` int(10) NOT NULL,
  `id_temp_vida` int(10) NOT NULL,
  `estado` text NOT NULL,
  `evento` text NOT NULL,
  `causa` text NOT NULL,
  `solucao` text NOT NULL,
  `data_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_utilizador` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mqtt_server`
--

CREATE TABLE `mqtt_server` (
  `id` int(11) NOT NULL,
  `server_mqtt` varchar(30) NOT NULL,
  `port_ws` int(11) NOT NULL,
  `port_mqtt` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `ativo_ws` tinyint(1) NOT NULL,
  `ativo_mqtt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `mqtt_server`
--

INSERT INTO `mqtt_server` (`id`, `server_mqtt`, `port_ws`, `port_mqtt`, `username`, `password`, `ativo_ws`, `ativo_mqtt`) VALUES
(8, '192.168.1.250', 1991, 1883, 'mqtt', 'Mqtt2020.', 0, 127);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfilutilizador`
--

CREATE TABLE `perfilutilizador` (
  `id` int(10) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `create_ut` datetime DEFAULT NULL,
  `update_ut` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delete_ut` datetime DEFAULT NULL,
  `estado` smallint(5) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `perfilutilizador`
--

INSERT INTO `perfilutilizador` (`id`, `nome`, `descricao`, `create_ut`, `update_ut`, `delete_ut`, `estado`) VALUES
(10, 'Adminstrador - Programador', 'Adminsitrador com todas as permissões do sistema', '2020-08-28 19:48:47', '2020-11-01 14:02:57', '2020-08-28 19:48:47', 1),
(12, 'Gerentes', 'Permisão de gestor de acordo com os equipamentos associados', '2020-08-27 14:19:25', '2020-11-01 14:05:36', '2020-08-27 14:19:25', 1),
(14, 'Operador', 'Operador permissão visualização para monitorização', '2020-08-28 19:45:18', '2020-11-01 14:04:11', '2020-08-28 19:45:18', 1),
(18, 'teste 1', 'teste 1', '2020-08-28 22:24:41', '2020-08-29 01:16:15', '2029-08-20 12:16:15', 0),
(20, 'osvaldo', 'balão', '2020-08-28 22:27:05', '2020-08-29 01:16:19', '2029-08-20 12:16:19', 0),
(21, 'joão', 'belo', NULL, '2020-08-29 01:16:22', '2029-08-20 12:16:22', 0),
(22, 'Administrador', 'Admin', NULL, '2020-09-29 00:04:00', '2028-09-20 11:04:00', 0),
(23, 'Normal', 'Normal', '2020-08-28 19:45:18', '2020-10-03 22:54:44', '2003-10-20 09:54:44', 0),
(24, 'teste', 'aaaa', '2020-08-28 19:45:18', '2020-08-29 01:31:02', '2029-08-20 12:31:02', 0),
(25, 'eew', 'ewewe', '2020-08-28 19:45:18', '2020-08-29 01:31:05', '2029-08-20 12:31:05', 0),
(26, 'dd', 'dd', '0000-00-00 00:00:00', '2020-08-29 01:33:32', '2029-08-20 12:33:32', 0),
(27, 'f', 'f', '0000-00-00 00:00:00', '2020-08-29 01:33:38', '2029-08-20 12:33:38', 0),
(28, 'fff', 'ffff', '2029-08-20 02:35:56', '2020-08-29 01:33:41', '2029-08-20 12:33:41', 0),
(29, 'r', 'r', '2029-08-20 02:38:26', '2020-08-29 01:33:44', '2029-08-20 12:33:44', 0),
(30, 'falou', 'td', '2029-08-20 02:44:31', '2020-08-29 01:33:47', '2029-08-20 12:33:47', 0),
(31, 'ff', 'ff', '2029-08-20 02:49:48', '2020-08-29 01:33:50', '2029-08-20 12:33:50', 0),
(32, 'xxx', NULL, '0000-00-00 00:00:00', '2020-08-29 01:33:53', '2029-08-20 12:33:53', 0),
(33, 'xx', 'xxxx', '2020-08-28 23:53:49', '2020-08-29 01:30:19', '2029-08-20 12:30:19', 0),
(34, 'fuuuta', 'paooo', '2029-08-20 03:03:59', '2020-08-29 01:16:32', '2029-08-20 12:16:32', 0),
(37, 'Desenvolvedor', 'Adminstração completa do site', '2002-10-20 09:55:44', '2020-11-01 14:04:30', '2001-11-20 01:04:30', 0),
(38, 'Adminstração', 'Responsaveis pelos geradores', '2001-11-20 01:06:35', '2020-11-01 14:06:35', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_permissao`
--

CREATE TABLE `perfil_permissao` (
  `id` int(10) NOT NULL,
  `id_perf_util` int(10) NOT NULL,
  `id_per` int(10) NOT NULL,
  `create_ut` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_ut` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delete_ut` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `perfil_permissao`
--

INSERT INTO `perfil_permissao` (`id`, `id_perf_util`, `id_per`, `create_ut`, `update_ut`, `delete_ut`) VALUES
(48, 23, 4, '2020-10-01 09:57:29', '2020-10-01 10:57:29', '2020-10-01 09:57:29'),
(49, 23, 6, '2020-10-01 09:57:29', '2020-10-01 10:57:29', '2020-10-01 09:57:29'),
(51, 14, 7, '2020-10-31 20:31:35', '2020-10-31 21:31:35', '2020-10-31 20:31:35'),
(52, 14, 8, '2020-10-31 20:31:35', '2020-10-31 21:31:35', '2020-10-31 20:31:35'),
(130, 37, 19, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(131, 37, 20, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(132, 37, 21, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(133, 37, 22, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(134, 37, 11, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(135, 37, 14, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(136, 37, 15, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(137, 37, 12, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(138, 37, 13, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(139, 37, 16, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(140, 37, 17, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(141, 37, 4, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(142, 37, 5, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(143, 37, 7, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(144, 37, 8, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(145, 37, 9, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(146, 37, 6, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(147, 37, 10, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(148, 37, 23, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(149, 37, 24, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(150, 37, 25, '2020-11-01 12:56:28', '2020-11-01 13:56:28', '2020-11-01 12:56:28'),
(379, 38, 18, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(380, 38, 19, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(381, 38, 20, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(382, 38, 29, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(383, 38, 26, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(384, 38, 21, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(385, 38, 22, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(386, 38, 11, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(387, 38, 14, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(388, 38, 15, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(389, 38, 12, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(390, 38, 13, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(391, 38, 16, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(392, 38, 17, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(393, 38, 4, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(394, 38, 5, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(395, 38, 7, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(396, 38, 8, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(397, 38, 9, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(398, 38, 6, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(399, 38, 10, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(400, 38, 23, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(401, 38, 24, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48'),
(402, 38, 25, '2020-11-19 17:20:48', '2020-11-19 18:20:48', '2020-11-19 17:20:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

CREATE TABLE `permissoes` (
  `id` int(10) NOT NULL,
  `nome` varchar(250) DEFAULT NULL,
  `descrisao` text NOT NULL,
  `create_ut` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_ut` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delete_ut` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`id`, `nome`, `descrisao`, `create_ut`, `update_ut`, `delete_ut`) VALUES
(4, 'utilizadores', 'Modulo Utilizadores', '2020-09-03 16:30:49', '2020-09-03 17:30:49', '2020-09-03 16:30:49'),
(5, 'utilizadores_perfil', 'Acesso a perfil de utilizador', '2020-09-03 16:32:10', '2020-09-03 17:32:10', '2020-09-03 16:32:10'),
(6, 'utilizadores_perfil_registar', 'Registar perfil de utilizador', '2020-09-03 16:32:39', '2020-09-03 17:32:39', '2020-09-03 16:32:39'),
(7, 'utilizadores_perfil_editar', 'Editar perfil de utilizador', '2020-09-03 16:32:55', '2020-09-03 17:32:55', '2020-09-03 16:32:55'),
(8, 'utilizadores_perfil_eliminar', 'Eliminar perfil de utilizador', '2020-09-03 16:33:16', '2020-09-03 17:33:16', '2020-09-03 16:33:16'),
(9, 'utilizadores_perfil_permissoes', 'Adicionar permissões a perfil de utilizador', '2020-09-03 16:33:58', '2020-09-03 17:33:58', '2020-09-03 16:33:58'),
(10, 'utilizadores_utilizador', 'Acesso a utilizador', '2020-10-31 21:15:38', '2020-10-31 22:15:38', '2020-10-31 21:15:38'),
(11, 'grupo', 'Modulo Grupo', '2020-11-04 22:08:24', '2020-11-04 23:08:24', '2020-11-04 22:08:24'),
(12, 'grupo_eliminar', 'Permissão para eliminar grupo', '2020-10-31 23:38:24', '2020-11-01 00:38:24', '2020-10-31 23:38:24'),
(13, 'grupo_ver_utilizador', 'Permissão para ver utilizadores associados a um grupo', '2020-11-04 19:58:39', '2020-11-04 20:58:39', '2020-11-04 19:58:39'),
(14, 'grupo_adicionar', 'Permissão para adicionar novos grupos', '2020-10-31 23:40:25', '2020-11-01 00:40:25', '2020-10-31 23:40:25'),
(15, 'grupo_editar', 'Permissão editar grupo', '2020-10-31 23:58:27', '2020-11-01 00:58:27', '2020-10-31 23:58:27'),
(16, 'grupo_ver_utilizador_adicionar', 'Permissão adicionar utilizadores a um grupo', '2020-10-31 23:59:34', '2020-11-01 00:59:34', '2020-10-31 23:59:34'),
(17, 'grupo_ver_utilizador_eliminar', 'Permissão eliminar utilizador de um grupo', '2020-11-01 00:00:23', '2020-11-01 01:00:23', '2020-11-01 00:00:23'),
(18, 'equipamentos', 'Modulo equipamentos', '2020-11-01 00:06:24', '2020-11-01 01:06:24', '2020-11-01 00:06:24'),
(19, 'equipamentos_gerador', 'Permissão de acesso aos geradores', '2020-11-01 00:07:29', '2020-11-01 01:07:29', '2020-11-01 00:07:29'),
(20, 'equipamentos_gerador_adicionar', 'Permissão de adicionar novos gerador', '2020-11-01 00:08:43', '2020-11-01 01:08:43', '2020-11-01 00:08:43'),
(21, 'equipamentos_gerador_editar', 'Permissão de editar um gerador', '2020-11-01 00:09:22', '2020-11-01 01:09:22', '2020-11-01 00:09:22'),
(22, 'equipamentos_gerador_eliminar', 'Permissão de eliminar um gerador', '2020-11-01 00:10:02', '2020-11-01 01:10:02', '2020-11-01 00:10:02'),
(23, 'utilizadores_utilizador_adicionar', 'Permissão adicionar utilizador', '2020-11-01 00:50:56', '2020-11-01 01:50:56', '2020-11-01 00:50:56'),
(24, 'utilizadores_utilizador_editar', 'Permissão de editar utilizador', '2020-11-01 00:51:36', '2020-11-01 01:51:36', '2020-11-01 00:51:36'),
(25, 'utilizadores_utilizador_eliminar', 'Permissão de eliminar utilizador', '2020-11-01 00:52:10', '2020-11-01 01:52:10', '2020-11-01 00:52:10'),
(26, 'equipamentos_gerador_detalhes', 'Permissão de visualizar os detalhes de um gerador ', '2020-11-04 22:31:18', '2020-11-04 23:31:18', '2020-11-04 22:31:18'),
(27, 'utilizadores_utilizador_editar', 'Permissão de editar um utilizador', '2020-11-04 22:47:19', '2020-11-04 23:47:19', '2020-11-04 22:47:19'),
(28, 'utilizadores_utilizador_eliminar', 'Permissão de eliminar um utilizador', '2020-11-04 22:47:50', '2020-11-04 23:47:50', '2020-11-04 22:47:50'),
(29, 'equipamentos_gerador_config', 'Permissão de visualizar a configuração de um gerador', '2020-11-19 17:20:19', '2020-11-19 18:20:19', '2020-11-19 17:20:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sms_server`
--

CREATE TABLE `sms_server` (
  `id` int(10) NOT NULL,
  `accountsid` varchar(100) NOT NULL,
  `authtoken` varchar(100) NOT NULL,
  `numberfrom` varchar(100) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `provedor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sms_server`
--

INSERT INTO `sms_server` (`id`, `accountsid`, `authtoken`, `numberfrom`, `ativo`, `provedor`) VALUES
(14, 'ACfe798a5ee2067bc2b8c928505118f58b', '6918f17cac3bf4055098bed1928f93cf', '+16626707353', 1, 'Twilio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `departamento` char(30) NOT NULL,
  `id` int(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `foto` longtext DEFAULT NULL,
  `telefone` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `create_ut` datetime NOT NULL DEFAULT current_timestamp(),
  `updade_ut` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delete_ut` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_perfil_permission` int(10) NOT NULL,
  `funcao` char(30) NOT NULL,
  `numero_funcionario` int(10) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `utilizador`
--

INSERT INTO `utilizador` (`departamento`, `id`, `username`, `password`, `nome`, `foto`, `telefone`, `email`, `create_ut`, `updade_ut`, `delete_ut`, `id_perfil_permission`, `funcao`, `numero_funcionario`, `estado`) VALUES
('IT', 1, 'isilva', '12345', 'Ivanildo Silva', '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', '+2389573218', 'ivanildoee@gmail.com', '2020-09-30 14:51:56', '2020-11-22 12:57:43', '2020-11-22 11:57:43', 10, 'Admin', 3232343, 1),
('IT', 26, 'afortes', '62ee3d08675e5a4f4a98ee6950b4ab5638fa502d33c86fecece2028b093e4aeb', 'Anilton Fortes', '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', '+2389899252', 'aniltonafortes@gmail.com', '2002-10-20 09:55:08', '2020-11-22 12:57:30', '2020-11-22 11:57:30', 10, 'Admin', 1234, 1),
('DICS', 29, 'teste01', '62ee3d08675e5a4f4a98ee6950b4ab5638fa502d33c86fecece2028b093e4aeb', 'Abel Cardoso', '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', '899876775', 'abel.caixa.cv', '2029-10-20 03:52:32', '2020-11-01 14:20:56', '2020-11-01 13:20:56', 38, 'Director', 99, 1),
('DICS', 33, 'Aniltonf', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'Anilton Fortes', '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', '9899252', 'anilton.fortes@caixa.cv', '2001-11-20 01:19:52', '2020-11-01 14:19:52', '2020-11-01 13:19:52', 10, 'Técnico Superior', 4235, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `banco_horas`
--
ALTER TABLE `banco_horas`
  ADD KEY `fk_bancohoras_gerador` (`id_gerador`);

--
-- Índices para tabela `email_server`
--
ALTER TABLE `email_server`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `gerador`
--
ALTER TABLE `gerador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gerador_grupo` (`id_grupo`);

--
-- Índices para tabela `gerador_config`
--
ALTER TABLE `gerador_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gerador_id` (`gerador_id`);

--
-- Índices para tabela `gerador_historico`
--
ALTER TABLE `gerador_historico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_historico_gerador` (`gerador_id`);

--
-- Índices para tabela `gerador_tempo_vida`
--
ALTER TABLE `gerador_tempo_vida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tempovida_gerador` (`id_gerador`);

--
-- Índices para tabela `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `grupo_acesso`
--
ALTER TABLE `grupo_acesso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_grupo_utilizador` (`id_grupo`),
  ADD KEY `fk_utilizador_grupo` (`id_utilizador`);

--
-- Índices para tabela `justificativa`
--
ALTER TABLE `justificativa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_justificativa_tempovida` (`id_temp_vida`),
  ADD KEY `fk_justitificativa_utilizador` (`id_utilizador`);

--
-- Índices para tabela `mqtt_server`
--
ALTER TABLE `mqtt_server`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `perfilutilizador`
--
ALTER TABLE `perfilutilizador`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `perfil_permissao`
--
ALTER TABLE `perfil_permissao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_perfilutilizador_permissoes` (`id_perf_util`),
  ADD KEY `fk_permissoes_perfilutilizador` (`id_per`);

--
-- Índices para tabela `permissoes`
--
ALTER TABLE `permissoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `sms_server`
--
ALTER TABLE `sms_server`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `numero_funcionario` (`numero_funcionario`),
  ADD KEY `fk_utilizador_perfilutilizador` (`id_perfil_permission`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `email_server`
--
ALTER TABLE `email_server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de tabela `gerador_config`
--
ALTER TABLE `gerador_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `gerador_historico`
--
ALTER TABLE `gerador_historico`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT de tabela `gerador_tempo_vida`
--
ALTER TABLE `gerador_tempo_vida`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `grupo_acesso`
--
ALTER TABLE `grupo_acesso`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `justificativa`
--
ALTER TABLE `justificativa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mqtt_server`
--
ALTER TABLE `mqtt_server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `perfilutilizador`
--
ALTER TABLE `perfilutilizador`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `perfil_permissao`
--
ALTER TABLE `perfil_permissao`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=403;

--
-- AUTO_INCREMENT de tabela `permissoes`
--
ALTER TABLE `permissoes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `sms_server`
--
ALTER TABLE `sms_server`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `banco_horas`
--
ALTER TABLE `banco_horas`
  ADD CONSTRAINT `fk_bancohoras_gerador` FOREIGN KEY (`id_gerador`) REFERENCES `gerador` (`id`);

--
-- Limitadores para a tabela `gerador`
--
ALTER TABLE `gerador`
  ADD CONSTRAINT `fk_gerador_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`);

--
-- Limitadores para a tabela `gerador_config`
--
ALTER TABLE `gerador_config`
  ADD CONSTRAINT `config_gerador_id` FOREIGN KEY (`gerador_id`) REFERENCES `gerador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `gerador_historico`
--
ALTER TABLE `gerador_historico`
  ADD CONSTRAINT `historico_gerador_id` FOREIGN KEY (`gerador_id`) REFERENCES `gerador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `gerador_tempo_vida`
--
ALTER TABLE `gerador_tempo_vida`
  ADD CONSTRAINT `tempo_vida_gerador_id` FOREIGN KEY (`id_gerador`) REFERENCES `gerador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `grupo_acesso`
--
ALTER TABLE `grupo_acesso`
  ADD CONSTRAINT `fk_grupo_utilizador` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `fk_utilizador_grupo` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id`);

--
-- Limitadores para a tabela `justificativa`
--
ALTER TABLE `justificativa`
  ADD CONSTRAINT `fk_justificativa_tempovida` FOREIGN KEY (`id_temp_vida`) REFERENCES `gerador_tempo_vida` (`id`),
  ADD CONSTRAINT `fk_justitificativa_utilizador` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id`);

--
-- Limitadores para a tabela `perfil_permissao`
--
ALTER TABLE `perfil_permissao`
  ADD CONSTRAINT `fk_perfilutilizador_permissoes` FOREIGN KEY (`id_perf_util`) REFERENCES `perfilutilizador` (`id`),
  ADD CONSTRAINT `fk_permissoes_perfilutilizador` FOREIGN KEY (`id_per`) REFERENCES `permissoes` (`id`);

--
-- Limitadores para a tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD CONSTRAINT `fk_utilizador_perfilutilizador` FOREIGN KEY (`id_perfil_permission`) REFERENCES `perfilutilizador` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

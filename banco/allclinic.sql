-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 07-Dez-2018 às 17:39
-- Versão do servidor: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `allclinic`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

CREATE TABLE `agenda` (
  `CODAGTO` int(3) NOT NULL,
  `DESCRICAO` varchar(150) NOT NULL,
  `INICIO` time NOT NULL,
  `FIM` time NOT NULL,
  `SEGUNDA` tinyint(1) NOT NULL,
  `TERCA` tinyint(1) NOT NULL,
  `QUARTA` tinyint(1) NOT NULL,
  `QUINTA` tinyint(1) NOT NULL,
  `SEXTA` tinyint(1) NOT NULL,
  `SABADO` tinyint(1) NOT NULL,
  `DOMINGO` tinyint(1) NOT NULL,
  `CODINST` int(11) NOT NULL,
  `INTERVALO` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `agenda`
--

INSERT INTO `agenda` (`CODAGTO`, `DESCRICAO`, `INICIO`, `FIM`, `SEGUNDA`, `TERCA`, `QUARTA`, `QUINTA`, `SEXTA`, `SABADO`, `DOMINGO`, `CODINST`, `INTERVALO`) VALUES
(1, 'CADASTRO 41 9:50', '09:50:00', '18:00:00', 0, 1, 1, 0, 1, 0, 0, 1, 5),
(2, 'CADASTRO 41 213123', '08:00:00', '18:00:00', 0, 1, 1, 0, 0, 0, 0, 1, 5),
(3, 'AGENDA 4 AGORA', '08:30:00', '18:30:00', 1, 1, 1, 1, 0, 0, 0, 1, 15),
(4, 'AGENDA RADIOLOGIA', '08:30:00', '18:30:00', 1, 1, 1, 1, 1, 0, 0, 1, 15);

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `CODAGTO` int(7) NOT NULL,
  `PRONTUARIO` int(11) NOT NULL,
  `HORA` time NOT NULL,
  `DATA` date NOT NULL,
  `CODINST` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `agendamento`
--

INSERT INTO `agendamento` (`CODAGTO`, `PRONTUARIO`, `HORA`, `DATA`, `CODINST`) VALUES
(1, 3, '16:50:00', '2018-10-09', 0),
(2, 3, '16:50:00', '2018-10-09', 0),
(3, 3, '16:50:00', '2018-10-09', 0),
(4, 3, '16:50:00', '2018-10-09', 0),
(5, 3, '16:50:00', '2018-10-09', 0),
(6, 3, '16:50:00', '2018-10-09', 0),
(7, 7, '09:30:00', '2018-10-18', 0),
(8, 3, '08:00:00', '2018-11-12', 0),
(9, 3, '08:30:00', '2018-11-07', 1),
(11, 7, '03:50:00', '2018-11-06', 1),
(12, 6, '08:50:00', '2014-11-18', 1),
(13, 6, '05:09:00', '2018-11-14', 1),
(15, 8, '20:22:00', '2018-11-14', 1),
(16, 6, '16:12:00', '2018-11-16', 1),
(17, 3, '18:04:00', '2018-11-20', 1),
(18, 3, '18:17:00', '2018-11-23', 1),
(19, 3, '13:23:00', '2018-11-26', 1),
(20, 7, '13:26:00', '2018-11-26', 1),
(21, 8, '13:30:00', '2018-11-26', 1),
(22, 9, '13:33:00', '2018-11-26', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `agtoexame`
--

CREATE TABLE `agtoexame` (
  `CODAGTOEXA` int(8) NOT NULL,
  `CODPROCEDIMENTO` int(7) NOT NULL,
  `CODAGTO` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `agtoexame`
--

INSERT INTO `agtoexame` (`CODAGTOEXA`, `CODPROCEDIMENTO`, `CODAGTO`) VALUES
(1, 10, 6),
(2, 9, 7),
(3, 9, 8),
(4, 8, 9),
(6, 9, 11),
(7, 8, 12),
(8, 7, 13),
(10, 9, 15),
(11, 8, 16),
(12, 9, 17),
(13, 9, 18),
(14, 9, 19),
(15, 10, 20),
(16, 9, 21),
(17, 7, 22);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ci_session`
--

CREATE TABLE `ci_session` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ci_session`
--

INSERT INTO `ci_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('5r0tgk8qg3o6f3vgglsr94odbrii533s', '::1', 1544200645, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534343230303633373b6c6f6761646f7c623a313b434f44494e53547c733a313a2231223b4e4f4d457c733a31353a2252454e41544f20524f4553534c4552223b4150454c555345527c733a363a2252454e41544f223b494e53545f46414e54415349417c733a383a2244454c4c4155444f223b4d53477c4e3b),
('9haihfinc03jse28gidfchpdkrhh5kel', '::1', 1544199997, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534343139393939373b6c6f6761646f7c623a313b434f44494e53547c733a313a2231223b4e4f4d457c733a31353a2252454e41544f20524f4553534c4552223b4150454c555345527c733a363a2252454e41544f223b494e53545f46414e54415349417c733a383a2244454c4c4155444f223b),
('cj0j35je74n5nd1rrg8sbluksff6mk4p', '::1', 1544198965, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534343139383936353b6c6f6761646f7c623a313b434f44494e53547c733a313a2231223b4e4f4d457c733a31353a2252454e41544f20524f4553534c4552223b4150454c555345527c733a363a2252454e41544f223b494e53545f46414e54415349417c733a383a2244454c4c4155444f223b),
('do4659crru2tbq0crj0sieskt66s0kf8', '::1', 1544200637, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534343230303633373b6c6f6761646f7c623a313b434f44494e53547c733a313a2231223b4e4f4d457c733a31353a2252454e41544f20524f4553534c4552223b4150454c555345527c733a363a2252454e41544f223b494e53545f46414e54415349417c733a383a2244454c4c4155444f223b4d53477c4e3b),
('gecrqih3rpl4u8ul1c3gohkghdpqthfd', '::1', 1544199671, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534343139393637313b6c6f6761646f7c623a313b434f44494e53547c733a313a2231223b4e4f4d457c733a31353a2252454e41544f20524f4553534c4552223b4150454c555345527c733a363a2252454e41544f223b494e53545f46414e54415349417c733a383a2244454c4c4155444f223b),
('k3n4h5u5jsprgge1fmfmdgp3lom6jhcm', '::1', 1544200335, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534343230303333353b6c6f6761646f7c623a313b434f44494e53547c733a313a2231223b4e4f4d457c733a31353a2252454e41544f20524f4553534c4552223b4150454c555345527c733a363a2252454e41544f223b494e53545f46414e54415349417c733a383a2244454c4c4155444f223b);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eluicao`
--

CREATE TABLE `eluicao` (
  `CODELUICAO` int(11) NOT NULL,
  `LOTE` varchar(11) NOT NULL,
  `DATA` date NOT NULL,
  `HORA` time NOT NULL,
  `VOLUME` float(9,4) NOT NULL,
  `ATIVIDADE_MCI` float(9,4) NOT NULL,
  `ATIVO` char(1) NOT NULL,
  `CQ` char(1) NOT NULL,
  `EFI_ATV_TEORICA` int(11) NOT NULL,
  `EFI_ATV_MEDIDA` int(11) NOT NULL,
  `EFI_RESULTADO` float(9,4) NOT NULL,
  `EFI_VOLUME` int(11) NOT NULL,
  `PUREZA_RADIONUCLIDICA` float(9,4) NOT NULL,
  `PUREZA_QUIMICA` char(1) NOT NULL,
  `LIMPIDA` char(1) NOT NULL,
  `CODGERADOR` int(7) NOT NULL,
  `PH` float(7,4) NOT NULL,
  `DATAINATIVO` datetime NOT NULL,
  `DATAHORA` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `eluicao`
--

INSERT INTO `eluicao` (`CODELUICAO`, `LOTE`, `DATA`, `HORA`, `VOLUME`, `ATIVIDADE_MCI`, `ATIVO`, `CQ`, `EFI_ATV_TEORICA`, `EFI_ATV_MEDIDA`, `EFI_RESULTADO`, `EFI_VOLUME`, `PUREZA_RADIONUCLIDICA`, `PUREZA_QUIMICA`, `LIMPIDA`, `CODGERADOR`, `PH`, `DATAINATIVO`, `DATAHORA`) VALUES
(5, '123', '2018-10-17', '03:06:00', 1254.0000, 100000.0000, 'S', 'S', 12, 23, 231.0000, 0, 123.0000, 'S', 'S', 13, 0.0000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '1524', '2018-11-12', '17:05:00', 135.5800, 1254.0000, 'S', 'S', 1, 2, 3.0000, 0, 4.0000, 'N', 'S', 15, 0.0000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '124', '2018-11-12', '14:24:00', 7777.0000, 77777.0000, 'N', 'S', 1, 2, 3.0000, 0, 4.0000, 'N', 'N', 13, 0.0000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '21A', '2018-11-16', '20:36:00', 12.0000, 21.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 13, 0.0000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '123', '2018-11-20', '18:12:00', 123.0000, 231.0000, 'S', 'S', 0, 0, 0.0000, 0, 0.0000, 'S', 'S', 21, 0.0000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, '123', '2018-11-20', '18:46:00', 123.0000, 213.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '2018-11-20 00:00:00', '0000-00-00 00:00:00'),
(11, '124', '2018-11-21', '20:09:00', 125.0000, 222.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(12, '325221', '2018-11-21', '20:11:00', 124.0000, 14541.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '1970-01-01 01:00:00', '0000-00-00 00:00:00'),
(13, '124', '2018-11-21', '20:13:00', 124.0000, 3254.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '2018-11-21 00:00:00', '0000-00-00 00:00:00'),
(14, '123', '2018-11-21', '20:14:00', 213.0000, 23.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, '225', '2018-11-21', '20:34:00', 1545.0000, 22.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '2018-11-21 20:34:00', '0000-00-00 00:00:00'),
(16, '123', '2018-11-21', '20:46:00', 213.0000, 213.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '2018-11-21 20:46:00', '0000-00-00 00:00:00'),
(17, '123', '2018-11-21', '20:55:00', 23.0000, 23123.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '2018-11-22 00:55:00', '2018-11-21 20:55:00'),
(18, '1', '2018-11-21', '21:37:00', 123.0000, 213.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '2018-11-22 01:37:00', '2018-11-21 21:37:00'),
(19, '123', '2018-11-23', '19:03:00', 1233.0000, 213.2000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '2018-11-23 23:03:00', '2018-11-23 19:03:00'),
(20, 'E1', '2018-11-26', '12:46:00', 6.0000, 970.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 20, 0.0000, '2018-11-26 16:46:00', '2018-11-26 12:46:00'),
(21, '123', '2018-12-03', '19:24:00', 123.0000, 123.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 23, 0.0000, '2018-12-03 23:24:00', '2018-12-03 19:24:00'),
(22, 'E12', '2018-12-04', '18:48:00', 123.0000, 123.0000, 'S', 'S', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 21, 0.0000, '2018-12-04 22:48:00', '2018-12-04 18:48:00'),
(23, 'E2', '2018-12-06', '16:54:00', 123.0000, 213.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 23, 0.0000, '2018-12-06 20:54:00', '2018-12-06 16:54:00'),
(24, 'E1', '2018-12-06', '21:21:00', 123.0000, 4123.0000, 'S', 'N', 0, 0, 0.0000, 0, 0.0000, 'N', 'N', 24, 0.0000, '2018-12-07 01:21:00', '2018-12-06 21:21:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fabricante`
--

CREATE TABLE `fabricante` (
  `CODFABRICANTE` int(11) NOT NULL,
  `DESCRICAO` varchar(45) NOT NULL,
  `ESPECIFICACAO` varchar(45) NOT NULL,
  `TIPO` char(1) NOT NULL,
  `CODINST` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fabricante`
--

INSERT INTO `fabricante` (`CODFABRICANTE`, `DESCRICAO`, `ESPECIFICACAO`, `TIPO`, `CODINST`) VALUES
(1, 'TEST1', 'TEST2', '2', 0),
(4, 'CADASTRO 22', 'CADASTRO 2', '1', 0),
(5, 'CADASTRO 3', 'CADASTRO 3', '2', 0),
(6, 'CADASTRO 41', 'CADASTRO 4', '2', 0),
(7, 'teste agora', 'teste 2111', '1', 0),
(15, 'TESTE CODINST', 'TESTE CODINST', '1', 19),
(16, 'GERADOR TEC', 'GERADOR TEC', '1', 1),
(17, 'TESTE RADIOFARMACO', 'TESTE RADIOFARMACO', '2', 1),
(18, 'cadastro teste3', 'teste 3', '2', 1),
(19, 'ipen11', 'ipen11', '1', 1),
(20, 'teste 2', 'teste2', '1', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fabricantefarmaco`
--

CREATE TABLE `fabricantefarmaco` (
  `CODFABRICANTE` int(11) NOT NULL,
  `CODFARMACO` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fabricantefarmaco`
--

INSERT INTO `fabricantefarmaco` (`CODFABRICANTE`, `CODFARMACO`) VALUES
(18, 1),
(18, 1),
(18, 3),
(18, 7),
(18, 3),
(18, 7),
(16, 1),
(16, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fabricante_farmaco`
--

CREATE TABLE `fabricante_farmaco` (
  `CODFABRICANTE` int(11) NOT NULL,
  `CODFARMACO` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fabricante_farmaco`
--

INSERT INTO `fabricante_farmaco` (`CODFABRICANTE`, `CODFARMACO`) VALUES
(18, 1),
(18, 3),
(18, 7),
(16, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `farmaco`
--

CREATE TABLE `farmaco` (
  `CODFARMACO` int(7) NOT NULL,
  `DESCRICAO` varchar(70) NOT NULL,
  `PH` float(7,3) NOT NULL,
  `SOLV_ORGANICO` float(7,3) NOT NULL,
  `SOLV_INORGANICO` float(7,3) NOT NULL,
  `CODINST` int(11) NOT NULL,
  `ATIVO` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `farmaco`
--

INSERT INTO `farmaco` (`CODFARMACO`, `DESCRICAO`, `PH`, `SOLV_ORGANICO`, `SOLV_INORGANICO`, `CODINST`, `ATIVO`) VALUES
(1, 'ABC1', 4.000, 5.000, 6.000, 1, 'S'),
(2, 'ABCAAA', 12.000, 13.000, 123.000, 1, 'S'),
(3, 'ABC3', 12.500, 13.000, 123.000, 1, 'S'),
(4, 'ABC4', 12.000, 12.300, 123.000, 1, 'S'),
(5, 'ABC5', 12.500, 13.000, 123.000, 1, 'N'),
(6, 'ABC6', 12.500, 13.000, 123.000, 1, 'S'),
(7, 'ABC7', 11.000, 1547.000, 123.000, 1, 'S'),
(8, 'ABC8', 8.000, 8.000, 8.000, 1, 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fracionamento`
--

CREATE TABLE `fracionamento` (
  `CODFRACIONAMENTO` int(7) NOT NULL,
  `CODMARCACAO` int(7) NOT NULL,
  `CODINST` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fracionamento`
--

INSERT INTO `fracionamento` (`CODFRACIONAMENTO`, `CODMARCACAO`, `CODINST`) VALUES
(58, 3, 1),
(59, 3, 1),
(60, 3, 1),
(61, 3, 1),
(62, 3, 1),
(63, 3, 1),
(64, 3, 1),
(65, 3, 1),
(66, 3, 1),
(67, 3, 1),
(68, 3, 1),
(69, 3, 1),
(70, 3, 1),
(71, 3, 1),
(72, 5, 1),
(73, 5, 1),
(74, 6, 1),
(77, 8, 1),
(78, 8, 1),
(79, 7, 1),
(80, 9, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerador`
--

CREATE TABLE `gerador` (
  `CODGERADOR` int(11) NOT NULL,
  `LOTE` varchar(11) NOT NULL,
  `DATA` date NOT NULL,
  `HORA` time NOT NULL,
  `NRO_ELUICAO` int(11) NOT NULL,
  `ATIVO` char(1) NOT NULL,
  `DATA_CALIBRACAO` date NOT NULL,
  `ATIVIDADE_CALIBRACAO` int(11) NOT NULL,
  `CODINST` int(11) NOT NULL,
  `APELUSER` varchar(10) NOT NULL,
  `CODFABRICANTE` int(11) NOT NULL,
  `DATAINATIVO` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `gerador`
--

INSERT INTO `gerador` (`CODGERADOR`, `LOTE`, `DATA`, `HORA`, `NRO_ELUICAO`, `ATIVO`, `DATA_CALIBRACAO`, `ATIVIDADE_CALIBRACAO`, `CODINST`, `APELUSER`, `CODFABRICANTE`, `DATAINATIVO`) VALUES
(13, '1234', '2018-10-24', '12:05:00', 123, 'S', '2018-10-16', 4514, 1, 'RENATO', 5, '2018-11-18'),
(15, '5555', '2018-11-12', '17:04:00', 1, 'S', '2018-11-12', 5555, 1, 'RENATO', 17, '2018-11-18'),
(19, '123', '2018-11-19', '18:08:00', 231, 'S', '2018-11-20', 123, 1, 'RENATO', 16, '2018-11-18'),
(20, '2133213', '2018-11-19', '18:09:00', 123, 'S', '2018-11-20', 123, 1, 'RENATO', 16, '2018-12-04'),
(21, '123', '2018-11-20', '17:59:00', 1244, '', '2018-11-06', 13, 1, 'RENATO', 16, '2018-12-05'),
(22, '12451', '2018-11-23', '18:04:00', 123, '', '2018-11-15', 123, 1, 'RENATO', 16, '2018-12-08'),
(23, '1233', '2018-11-26', '12:44:00', 1, '', '2018-11-26', 1200, 1, 'FERNANDO', 18, '2018-12-11'),
(24, '123asdf123', '2018-11-27', '18:52:00', 0, '', '2018-11-06', 123, 1, 'RENATO', 16, '2018-12-12'),
(25, 'G123', '2018-12-06', '16:57:00', 0, '', '2018-12-06', 123, 1, 'RENATO', 18, '2018-12-21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituicao`
--

CREATE TABLE `instituicao` (
  `CODINST` int(11) NOT NULL,
  `RAZAO` varchar(70) NOT NULL,
  `FANTASIA` varchar(30) NOT NULL,
  `CNPJ` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `instituicao`
--

INSERT INTO `instituicao` (`CODINST`, `RAZAO`, `FANTASIA`, `CNPJ`) VALUES
(1, 'Clinica de diagnostico por imagem vero dellaudo', 'DELLAUDO', '69.544.575/0001'),
(19, 'ADSF', 'CADASTRO TESTE', 'dd'),
(22, 'ASDFASDF', 'ADSFASDF', 'asdfasdf'),
(23, 'TYEST2', 'TESTE1', '12312312'),
(24, 'TESTETSETSET 4', 'REANATDOSFNEEED', '02514417474');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itemfracionamento`
--

CREATE TABLE `itemfracionamento` (
  `CODITFRACIONAMENTO` int(7) NOT NULL,
  `CODFRACIONAMENTO` int(7) NOT NULL,
  `PRONTUARIO` int(7) NOT NULL,
  `ATIVIDADE` float(7,3) NOT NULL,
  `HORAINICIO` time NOT NULL,
  `ATV_ADMINISTRADA` float(7,3) NOT NULL,
  `HORA_ADMINISTRADA` time NOT NULL,
  `CODAGTOEXA` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `itemfracionamento`
--

INSERT INTO `itemfracionamento` (`CODITFRACIONAMENTO`, `CODFRACIONAMENTO`, `PRONTUARIO`, `ATIVIDADE`, `HORAINICIO`, `ATV_ADMINISTRADA`, `HORA_ADMINISTRADA`, `CODAGTOEXA`) VALUES
(61, 58, 6, 0.000, '00:00:00', 0.000, '00:00:00', 0),
(62, 59, 6, 1.000, '00:00:00', 0.000, '00:00:00', 0),
(63, 71, 3, 0.000, '00:00:00', 0.000, '00:00:00', 0),
(64, 71, 6, 0.000, '00:00:00', 0.000, '00:00:00', 0),
(65, 70, 8, 12.000, '17:06:00', 1.240, '17:10:00', 0),
(66, 72, 3, 9.541, '08:50:00', 9.800, '09:00:00', 0),
(67, 72, 8, 1.500, '08:50:00', 124.480, '09:00:00', 0),
(68, 72, 6, 0.000, '00:00:00', 0.000, '00:00:00', 0),
(69, 72, 7, 0.000, '00:00:00', 0.000, '00:00:00', 0),
(70, 73, 0, 7.541, '05:59:00', 5.218, '05:54:00', 11),
(71, 73, 0, 0.000, '00:00:00', 0.000, '00:00:00', 10),
(72, 74, 0, 9999.999, '12:32:00', 125.650, '12:23:00', 13),
(76, 77, 0, 29.000, '09:23:00', 28.000, '10:49:00', 16),
(78, 77, 0, 12.222, '09:12:00', 12.330, '09:23:00', 15),
(79, 78, 0, 0.000, '00:00:00', 0.000, '00:00:00', 14),
(80, 79, 0, 0.000, '00:00:00', 0.000, '00:00:00', 17),
(81, 80, 0, 0.000, '00:00:00', 0.000, '00:00:00', 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcacao`
--

CREATE TABLE `marcacao` (
  `CODMARCACAO` int(7) NOT NULL,
  `CODELUICAO` int(7) NOT NULL,
  `DATA` date NOT NULL,
  `HORA` time NOT NULL,
  `LOTE` varchar(9) NOT NULL,
  `KIT_CODFABRICANTE` int(7) NOT NULL,
  `KIT_LOTE` varchar(11) NOT NULL,
  `CQ` char(1) NOT NULL,
  `ORGANICO` double(7,4) NOT NULL,
  `QUIMICO` double(7,4) NOT NULL,
  `APELUSER` varchar(11) NOT NULL,
  `CODFARMACO` int(7) NOT NULL,
  `PH` double(7,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `marcacao`
--

INSERT INTO `marcacao` (`CODMARCACAO`, `CODELUICAO`, `DATA`, `HORA`, `LOTE`, `KIT_CODFABRICANTE`, `KIT_LOTE`, `CQ`, `ORGANICO`, `QUIMICO`, `APELUSER`, `CODFARMACO`, `PH`) VALUES
(3, 5, '2018-10-18', '05:59:00', '', 4, '213', 'S', 12.0000, 231.0000, 'RENATO', 0, 0.0000),
(4, 6, '2018-11-12', '17:06:00', '', 16, '7777', 'S', 1.0000, 2.0000, 'RENATO', 0, 0.0000),
(5, 6, '2018-11-12', '08:05:00', '', 16, '42148', 'S', 123.0000, 231.0000, 'RENATO', 0, 0.0000),
(6, 19, '2018-11-23', '16:25:00', '', 16, '123', 'N', 0.0000, 0.0000, 'RENATO', 0, 0.0000),
(7, 20, '2018-11-26', '10:20:00', '', 16, '123', 'N', 0.0000, 0.0000, 'FERNANDO', 0, 0.0000),
(8, 20, '2018-11-26', '10:30:00', '', 16, '7777', 'N', 0.0000, 0.0000, 'FERNANDO', 0, 0.0000),
(9, 21, '2018-12-03', '05:05:00', '', 16, '123', 'N', 0.0000, 0.0000, 'RENATO', 0, 0.0000),
(10, 24, '2018-12-06', '21:27:00', 'E1', 16, '213A', 'N', 0.0000, 0.0000, 'RENATO', 1, 12.0000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `paciente`
--

CREATE TABLE `paciente` (
  `PRONTUARIO` int(11) NOT NULL,
  `NOME` varchar(70) NOT NULL,
  `TELEFONE` varchar(15) NOT NULL,
  `PESO` decimal(7,4) NOT NULL,
  `CPF` varchar(15) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `DTNASCIMENTO` date NOT NULL,
  `CODINST` int(7) NOT NULL,
  `ALTURA` float(7,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `paciente`
--

INSERT INTO `paciente` (`PRONTUARIO`, `NOME`, `TELEFONE`, `PESO`, `CPF`, `EMAIL`, `DTNASCIMENTO`, `CODINST`, `ALTURA`) VALUES
(3, 'RENATO ROESSLER', '(54)99638-4949', '100.7500', '020.516.970-86', '', '2018-08-07', 1, 0.0000),
(6, 'MAURO LODI', '(54)69414-1414', '105.0000', '151.414.211-41', 'mauroroberto@gmail.com', '1990-06-03', 1, 1.9500),
(7, 'RICARDO BORDIM', '(54)99999-9999', '65.0000', '000.000.000-00', 'ricardo@bordim.com', '2009-02-04', 1, 1.6500),
(8, 'DANIELE FERREIRA', '(54)98245-2411', '60.0000', '000.000.000-00', 'dani@gmail.com', '2018-10-10', 1, 160.0000),
(9, 'RODRIGO SILVA', '(54)99934-5961', '1.9500', '151.114.521-54', 'RODRIGO@GMAIL.COM', '2009-01-07', 1, 1.5900);

-- --------------------------------------------------------

--
-- Estrutura da tabela `procedimentos`
--

CREATE TABLE `procedimentos` (
  `CODPROCEDIMENTO` int(7) NOT NULL,
  `DESCRICAO` varchar(70) NOT NULL,
  `ATIVO` char(1) NOT NULL,
  `CODINST` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `procedimentos`
--

INSERT INTO `procedimentos` (`CODPROCEDIMENTO`, `DESCRICAO`, `ATIVO`, `CODINST`) VALUES
(7, 'ECO MAMARIA', 'S', 1),
(8, 'AMPLIACAO OU MAGNIFICACAO DE LESAO MAMARIA', 'S', 1),
(9, 'ANGIO-RM VENOSA DE CRANIO', 'S', 1),
(10, 'DENSITOMETRIA OSSEA (CORPO INTEIRO - ACADEMIA)', 'S', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `APELUSER` varchar(10) NOT NULL,
  `NOME` varchar(45) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `CODINST` int(11) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`APELUSER`, `NOME`, `EMAIL`, `CODINST`, `senha`) VALUES
('DANI', 'DANIELE FERREIRA', 'daniele@gmail.com', 22, '202cb962ac59075b964b07152d234b70'),
('FERNANDO', 'FERNANDO MENEZES', 'fernando@gmail.com', 1, '81dc9bdb52d04dc20036dbd8313ed055'),
('MAURO', 'MAURO ROBERTO LODI2', 'mauroroberto@gmail.com', 19, '81dc9bdb52d04dc20036dbd8313ed055'),
('RENATO', 'RENATO ROESSLER', 'renatoroessler@gmailc.com', 1, '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`CODAGTO`);

--
-- Indexes for table `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`CODAGTO`);

--
-- Indexes for table `agtoexame`
--
ALTER TABLE `agtoexame`
  ADD PRIMARY KEY (`CODAGTOEXA`);

--
-- Indexes for table `ci_session`
--
ALTER TABLE `ci_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `eluicao`
--
ALTER TABLE `eluicao`
  ADD PRIMARY KEY (`CODELUICAO`);

--
-- Indexes for table `fabricante`
--
ALTER TABLE `fabricante`
  ADD PRIMARY KEY (`CODFABRICANTE`);

--
-- Indexes for table `farmaco`
--
ALTER TABLE `farmaco`
  ADD PRIMARY KEY (`CODFARMACO`);

--
-- Indexes for table `fracionamento`
--
ALTER TABLE `fracionamento`
  ADD PRIMARY KEY (`CODFRACIONAMENTO`);

--
-- Indexes for table `gerador`
--
ALTER TABLE `gerador`
  ADD PRIMARY KEY (`CODGERADOR`);

--
-- Indexes for table `instituicao`
--
ALTER TABLE `instituicao`
  ADD PRIMARY KEY (`CODINST`);

--
-- Indexes for table `itemfracionamento`
--
ALTER TABLE `itemfracionamento`
  ADD PRIMARY KEY (`CODITFRACIONAMENTO`);

--
-- Indexes for table `marcacao`
--
ALTER TABLE `marcacao`
  ADD PRIMARY KEY (`CODMARCACAO`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`PRONTUARIO`);

--
-- Indexes for table `procedimentos`
--
ALTER TABLE `procedimentos`
  ADD PRIMARY KEY (`CODPROCEDIMENTO`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`APELUSER`),
  ADD UNIQUE KEY `APELUSER` (`APELUSER`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `CODAGTO` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `CODAGTO` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `agtoexame`
--
ALTER TABLE `agtoexame`
  MODIFY `CODAGTOEXA` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `eluicao`
--
ALTER TABLE `eluicao`
  MODIFY `CODELUICAO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `fabricante`
--
ALTER TABLE `fabricante`
  MODIFY `CODFABRICANTE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `farmaco`
--
ALTER TABLE `farmaco`
  MODIFY `CODFARMACO` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fracionamento`
--
ALTER TABLE `fracionamento`
  MODIFY `CODFRACIONAMENTO` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `gerador`
--
ALTER TABLE `gerador`
  MODIFY `CODGERADOR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `instituicao`
--
ALTER TABLE `instituicao`
  MODIFY `CODINST` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `itemfracionamento`
--
ALTER TABLE `itemfracionamento`
  MODIFY `CODITFRACIONAMENTO` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `marcacao`
--
ALTER TABLE `marcacao`
  MODIFY `CODMARCACAO` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `PRONTUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `procedimentos`
--
ALTER TABLE `procedimentos`
  MODIFY `CODPROCEDIMENTO` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/10/2024 às 19:11
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbutopia`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_hora`
--

CREATE TABLE `tbl_hora` (
  `idHora` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_hora`
--

INSERT INTO `tbl_hora` (`idHora`, `descricao`) VALUES
(1, '16:00 horas'),
(2, '17:00 horas'),
(3, '18:00 horas'),
(4, '19:00 horas');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_mesa`
--

CREATE TABLE `tbl_mesa` (
  `idMesa` int(2) NOT NULL,
  `numeroMesa` int(2) NOT NULL,
  `capacidade` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_mesa`
--

INSERT INTO `tbl_mesa` (`idMesa`, `numeroMesa`, `capacidade`) VALUES
(1, 1, '2 Pessoas'),
(2, 2, '3 Pessoas'),
(3, 3, '4  Pessoas'),
(4, 4, '6 Pessoas'),
(5, 5, '8 Pessoas'),
(6, 6, '10 Pessoas'),
(7, 7, 'Acima de 10 Pessoas');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_reserva`
--

CREATE TABLE `tbl_reserva` (
  `idReserva` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `whatsapp` varchar(45) NOT NULL,
  `dataReserva` date NOT NULL,
  `FK_idMesa` int(2) NOT NULL,
  `FK_idStatusReserva` int(11) NOT NULL,
  `FK_idHoraReserva` int(11) NOT NULL,
  `FK_idTipoReserva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_reserva`
--

INSERT INTO `tbl_reserva` (`idReserva`, `nome`, `whatsapp`, `dataReserva`, `FK_idMesa`, `FK_idStatusReserva`, `FK_idHoraReserva`, `FK_idTipoReserva`) VALUES
(1, 'Ronaldo', '444444', '2024-10-29', 3, 1, 3, 1),
(2, 'Ronaldo', '444444', '2024-10-29', 3, 1, 3, 1),
(3, 'Tuka', '222222', '2024-10-23', 3, 1, 3, 2),
(4, 'Pedro', '666666666', '2024-10-29', 5, 1, 4, 2),
(5, 'Amanda', '1234567654', '2024-10-30', 7, 1, 4, 3),
(6, 'Aline', '484938483', '2024-10-30', 1, 1, 1, 1),
(7, 'Luiz', '54433333', '2024-10-30', 4, 1, 2, 2),
(8, 'Ronaldo', '5466765', '2024-10-30', 7, 1, 4, 3),
(9, 'Ana', '65444543321', '2024-10-31', 1, 1, 3, 1),
(10, 'Ana', '65444543321', '2024-10-31', 1, 1, 3, 1),
(11, 'teste', '555555', '2024-10-29', 3, 1, 2, 2),
(12, 'testee', '55555', '2024-10-23', 1, 1, 3, 1),
(13, 'testee', '55555', '2024-10-23', 1, 1, 3, 1),
(14, 'testee', '55555', '2024-10-23', 1, 1, 3, 1),
(15, 'teste3', '1111', '2024-10-28', 5, 1, 3, 2),
(16, 'teste4', '1111', '2024-10-28', 5, 1, 3, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_statusreserva`
--

CREATE TABLE `tbl_statusreserva` (
  `idStatusReserva` int(1) NOT NULL,
  `descricao` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_statusreserva`
--

INSERT INTO `tbl_statusreserva` (`idStatusReserva`, `descricao`) VALUES
(1, 'Confirmada'),
(2, 'Cancelada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_tiporeserva`
--

CREATE TABLE `tbl_tiporeserva` (
  `idTipoReserva` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_tiporeserva`
--

INSERT INTO `tbl_tiporeserva` (`idTipoReserva`, `descricao`) VALUES
(1, 'Salão Principal'),
(2, 'Area Externa (Churrasqueira)'),
(3, 'Evento (mais de 30 pessoas)');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbl_hora`
--
ALTER TABLE `tbl_hora`
  ADD PRIMARY KEY (`idHora`);

--
-- Índices de tabela `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  ADD PRIMARY KEY (`idMesa`);

--
-- Índices de tabela `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `fk_tbl_reserva_tbl_mesa1_idx` (`FK_idMesa`),
  ADD KEY `fk_tbl_reserva_tbl_statusReserva1_idx` (`FK_idStatusReserva`),
  ADD KEY `fk_hora_idx` (`FK_idHoraReserva`),
  ADD KEY `fk_tipoReserva_idx` (`FK_idTipoReserva`);

--
-- Índices de tabela `tbl_statusreserva`
--
ALTER TABLE `tbl_statusreserva`
  ADD PRIMARY KEY (`idStatusReserva`);

--
-- Índices de tabela `tbl_tiporeserva`
--
ALTER TABLE `tbl_tiporeserva`
  ADD PRIMARY KEY (`idTipoReserva`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_hora`
--
ALTER TABLE `tbl_hora`
  MODIFY `idHora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  MODIFY `idMesa` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `tbl_statusreserva`
--
ALTER TABLE `tbl_statusreserva`
  MODIFY `idStatusReserva` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbl_tiporeserva`
--
ALTER TABLE `tbl_tiporeserva`
  MODIFY `idTipoReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  ADD CONSTRAINT `fk_hora` FOREIGN KEY (`FK_idHoraReserva`) REFERENCES `tbl_hora` (`idHora`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_reserva_tbl_mesa1` FOREIGN KEY (`FK_idMesa`) REFERENCES `tbl_mesa` (`idMesa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_reserva_tbl_statusReserva1` FOREIGN KEY (`FK_idStatusReserva`) REFERENCES `tbl_statusreserva` (`idStatusReserva`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tipoReserva` FOREIGN KEY (`FK_idTipoReserva`) REFERENCES `tbl_tiporeserva` (`idTipoReserva`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

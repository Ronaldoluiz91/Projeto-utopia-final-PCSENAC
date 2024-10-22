-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/10/2024 às 22:03
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
-- Estrutura para tabela `tbl_assunto`
--

CREATE TABLE `tbl_assunto` (
  `idAssunto` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_assunto`
--

INSERT INTO `tbl_assunto` (`idAssunto`, `descricao`) VALUES
(1, 'Elogios'),
(2, 'Reclamações'),
(3, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_capacidade`
--

CREATE TABLE `tbl_capacidade` (
  `idCapacidade` int(2) NOT NULL,
  `capacidade` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_capacidade`
--

INSERT INTO `tbl_capacidade` (`idCapacidade`, `capacidade`) VALUES
(2, 2),
(4, 4),
(6, 6),
(8, 8),
(10, 10),
(20, 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_contato`
--

CREATE TABLE `tbl_contato` (
  `idContato` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `mensagem` varchar(500) NOT NULL,
  `Fk_Assunto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_contato`
--

INSERT INTO `tbl_contato` (`idContato`, `nome`, `celular`, `mensagem`, `Fk_Assunto`) VALUES
(17, 'Ronaldo', '123456', 'Parabéns pelo atendimento', 1);

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
-- Estrutura para tabela `tbl_reserva`
--

CREATE TABLE `tbl_reserva` (
  `idReserva` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `whatsapp` varchar(45) NOT NULL,
  `dataReserva` date NOT NULL,
  `FK_idCapacidade` int(2) NOT NULL,
  `FK_idStatusReserva` int(11) NOT NULL,
  `FK_idHoraReserva` int(11) NOT NULL,
  `FK_idTipoReserva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tbl_reserva`
--

INSERT INTO `tbl_reserva` (`idReserva`, `nome`, `whatsapp`, `dataReserva`, `FK_idCapacidade`, `FK_idStatusReserva`, `FK_idHoraReserva`, `FK_idTipoReserva`) VALUES
(171, 'Daniele', '123456778', '2024-10-22', 6, 1, 2, 1),
(172, 'Kenedy', '123456778', '2024-10-23', 20, 1, 3, 3);

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
-- Índices de tabela `tbl_assunto`
--
ALTER TABLE `tbl_assunto`
  ADD PRIMARY KEY (`idAssunto`);

--
-- Índices de tabela `tbl_capacidade`
--
ALTER TABLE `tbl_capacidade`
  ADD PRIMARY KEY (`idCapacidade`);

--
-- Índices de tabela `tbl_contato`
--
ALTER TABLE `tbl_contato`
  ADD PRIMARY KEY (`idContato`),
  ADD KEY `fk_assunto_idx` (`Fk_Assunto`);

--
-- Índices de tabela `tbl_hora`
--
ALTER TABLE `tbl_hora`
  ADD PRIMARY KEY (`idHora`);

--
-- Índices de tabela `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `fk_tbl_reserva_tbl_mesa1_idx` (`FK_idCapacidade`),
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
-- AUTO_INCREMENT de tabela `tbl_assunto`
--
ALTER TABLE `tbl_assunto`
  MODIFY `idAssunto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_contato`
--
ALTER TABLE `tbl_contato`
  MODIFY `idContato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `tbl_hora`
--
ALTER TABLE `tbl_hora`
  MODIFY `idHora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

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
-- Restrições para tabelas `tbl_contato`
--
ALTER TABLE `tbl_contato`
  ADD CONSTRAINT `fk_assunto` FOREIGN KEY (`Fk_Assunto`) REFERENCES `tbl_assunto` (`idAssunto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbl_reserva`
--
ALTER TABLE `tbl_reserva`
  ADD CONSTRAINT `fk_hora` FOREIGN KEY (`FK_idHoraReserva`) REFERENCES `tbl_hora` (`idHora`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_reserva_tbl_mesa1` FOREIGN KEY (`FK_idCapacidade`) REFERENCES `tbl_capacidade` (`idCapacidade`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_reserva_tbl_statusReserva1` FOREIGN KEY (`FK_idStatusReserva`) REFERENCES `tbl_statusreserva` (`idStatusReserva`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tipoReserva` FOREIGN KEY (`FK_idTipoReserva`) REFERENCES `tbl_tiporeserva` (`idTipoReserva`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/11/2025 às 04:19
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
-- Banco de dados: `transjourney`
--
CREATE DATABASE IF NOT EXISTS transjourney CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE transjourney;

-- --------------------------------------------------------

--
-- Estrutura para tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo` enum('Presencial','Online') DEFAULT 'Presencial',
  `data_consulta` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `turno` varchar(20) DEFAULT NULL,
  `profissional` varchar(100) DEFAULT NULL,
  `especialidade` varchar(100) DEFAULT NULL,
  `local_endereco` varchar(255) DEFAULT NULL,
  `status` enum('Agendado','Concluído','Cancelado') DEFAULT 'Agendado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `consultas`
--

INSERT INTO `consultas` (`id`, `usuario_id`, `tipo`, `data_consulta`, `horario`, `turno`, `profissional`, `especialidade`, `local_endereco`, `status`) VALUES
(1, 4, 'Presencial', '2025-11-27', '07:00:00', 'Manhã', 'Dra. Júlia', NULL, NULL, 'Agendado'),
(2, 4, 'Presencial', '2025-11-11', '14:00:00', 'Tarde', 'Dra. Alice', NULL, NULL, 'Agendado'),
(5, 4, 'Presencial', '2025-11-03', NULL, NULL, NULL, NULL, NULL, 'Agendado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `diario`
--

CREATE TABLE `diario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_registro` date NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `texto` text NOT NULL,
  `reflexao` text DEFAULT NULL,
  `emoji` varchar(10) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `diario`
--

INSERT INTO `diario` (`id`, `usuario_id`, `data_registro`, `titulo`, `texto`, `reflexao`, `emoji`, `criado_em`) VALUES
(1, 4, '2025-11-26', NULL, 'Ótimo!!', 'A noite sempre é mais escura antes de amanhecer. ', '😀', '2025-11-28 19:02:36'),
(2, 4, '2025-11-30', NULL, 'Bom', 'Semestre ta acabando', '😀', '2025-11-30 01:58:14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `doses`
--

CREATE TABLE `doses` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `medicamento_id` int(11) NOT NULL,
  `data_hora` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `doses`
--

INSERT INTO `doses` (`id`, `usuario_id`, `medicamento_id`, `data_hora`) VALUES
(12, 4, 1, '2025-11-29 23:13:58'),
(13, 4, 1, '2025-11-29 23:22:00'),
(14, 4, 1, '2025-11-27 03:52:01'),
(15, 4, 6, '2025-12-15 04:01:09'),
(16, 4, 7, '2025-11-03 04:04:24');

-- --------------------------------------------------------

--
-- Estrutura para tabela `exames`
--

CREATE TABLE `exames` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nome_exame` varchar(100) NOT NULL,
  `data_realizacao` date NOT NULL,
  `caminho_arquivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `exames`
--

INSERT INTO `exames` (`id`, `usuario_id`, `nome_exame`, `data_realizacao`, `caminho_arquivo`) VALUES
(1, 4, 'Hemograma', '2024-11-19', '../uploads/exames/exame_4_1764353532.pdf'),
(2, 4, 'Raio X', '2025-09-30', '../uploads/exames/exame_4_1764353609.pdf'),
(3, 4, 'teste', '2025-10-20', '../uploads/exames/exame_4_1764467957.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fotos`
--

CREATE TABLE `fotos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_foto` date NOT NULL,
  `caminho_arquivo` varchar(255) NOT NULL,
  `legenda` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `fotos`
--

INSERT INTO `fotos` (`id`, `usuario_id`, `data_foto`, `caminho_arquivo`, `legenda`) VALUES
(1, 4, '2024-06-28', '../uploads/galeria/4_1764351760_6929df10df6ed.jpeg', NULL),
(4, 4, '2025-09-30', '../uploads/galeria/4_1764357712_6929f65026571.jpeg', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dose` varchar(50) DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `frequencia` enum('Diário','Alternado','Semanal') DEFAULT 'Diário',
  `notificar` tinyint(1) DEFAULT 0,
  `data_inicio` date DEFAULT curdate(),
  `data_fim` date DEFAULT NULL,
  `uso_continuo` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `medicamentos`
--

INSERT INTO `medicamentos` (`id`, `usuario_id`, `nome`, `dose`, `horario`, `frequencia`, `notificar`, `data_inicio`, `data_fim`, `uso_continuo`) VALUES
(1, 4, 'Venvanse', '30mg', '00:00:00', 'Diário', 1, '2025-11-27', '2025-12-09', 0),
(2, 4, 'Pristiq', '100mg', '00:00:00', 'Alternado', 1, '2025-11-27', '2025-12-05', 0),
(6, 4, 'teste futuro', 't', '00:00:00', 'Alternado', 0, '2025-12-15', '2025-12-19', 0),
(7, 4, 'teste passado', 't', '00:00:00', 'Diário', 1, '2025-11-03', '2025-11-06', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `humor` varchar(50) DEFAULT '?',
  `transicao_social` int(11) DEFAULT 0,
  `transicao_hormonal` int(11) DEFAULT 0,
  `altura` decimal(3,2) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT 'default.jpg',
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `perfil`
--

INSERT INTO `perfil` (`id`, `usuario_id`, `genero`, `humor`, `transicao_social`, `transicao_hormonal`, `altura`, `peso`, `foto_perfil`, `descricao`) VALUES
(1, 4, 'Homem', '😊', 18, 25, 1.68, 71.00, '../uploads/perfil/perfil_4_1764358338.png', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome_social` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_social`, `email`, `senha`, `nascimento`) VALUES
(3, 'Pedro', 'adm@adm', '$2y$10$ybHeI77JtjSTkSeoTRrSVu.qMUohY72UPpGrCPJ8tpgeFCRG8n4GS', '2025-11-23'),
(4, 'Teste', 'teste@teste', '$2y$10$SlT4b98MJvQ775OSeUyFvulMcWS4WdifgzP1bsxVFAKnRMbXZx8AW', '1990-01-01');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `diario`
--
ALTER TABLE `diario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `doses`
--
ALTER TABLE `doses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `medicamento_id` (`medicamento_id`);

--
-- Índices de tabela `exames`
--
ALTER TABLE `exames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `diario`
--
ALTER TABLE `diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `doses`
--
ALTER TABLE `doses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `exames`
--
ALTER TABLE `exames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `diario`
--
ALTER TABLE `diario`
  ADD CONSTRAINT `diario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `doses`
--
ALTER TABLE `doses`
  ADD CONSTRAINT `doses_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doses_ibfk_2` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamentos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `exames`
--
ALTER TABLE `exames`
  ADD CONSTRAINT `exames_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD CONSTRAINT `medicamentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `perfil_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

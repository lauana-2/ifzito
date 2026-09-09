-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/09/2026 às 18:45
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
-- Banco de dados: `ifzito`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anotacoes_tarefa`
--

CREATE TABLE `anotacoes_tarefa` (
  `id_anotacao` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `conteudo` text NOT NULL,
  `id_tarefa` int(11) NOT NULL,
  `id_estudante` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `anotacoes_tarefa`
--

INSERT INTO `anotacoes_tarefa` (`id_anotacao`, `titulo`, `conteudo`, `id_tarefa`, `id_estudante`, `criado_em`, `atualizado_em`) VALUES
(5, 'nao sei fazer aquilo lá', 'aaaaaaaaaaaaaaaaaaaaaa', 1, 5, '2026-09-02 16:38:51', '2026-09-02 16:38:51'),
(6, 'nao sei fazer aquilo lá', 'a', 1, 5, '2026-09-02 17:15:48', '2026-09-02 17:15:48'),
(7, 'a tarefa dificil', 'nao sei faze', 1, 10, '2026-09-02 17:21:26', '2026-09-02 17:21:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso`
--

CREATE TABLE `curso` (
  `id_curso` bigint(20) NOT NULL,
  `sigla` varchar(20) NOT NULL,
  `nome_curso` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `curso`
--

INSERT INTO `curso` (`id_curso`, `sigla`, `nome_curso`) VALUES
(1, 'TECINF', 'Técnico em Informática'),
(7, 'TECJOG', 'Técnico em Programação de Jogos Digitais'),
(8, 'TECMEC', 'Técnico em Mecânica'),
(9, 'TECAUT', 'Técnico em Automação Industrial'),
(10, 'TECELE', 'Técnico em Eletrotécnica');

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso_disciplina`
--

CREATE TABLE `curso_disciplina` (
  `id_curso_disciplina` bigint(20) NOT NULL,
  `id_curso` bigint(20) NOT NULL,
  `id_disciplina` bigint(20) NOT NULL,
  `ano` smallint(6) NOT NULL,
  `carga_horaria` int(11) NOT NULL DEFAULT 80,
  `obrigatoria` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `curso_disciplina`
--

INSERT INTO `curso_disciplina` (`id_curso_disciplina`, `id_curso`, `id_disciplina`, `ano`, `carga_horaria`, `obrigatoria`) VALUES
(1, 1, 1, 1, 80, 1),
(2, 1, 2, 1, 80, 1),
(3, 1, 3, 1, 80, 1),
(4, 1, 4, 1, 80, 1),
(5, 1, 5, 1, 80, 1),
(6, 1, 6, 1, 80, 1),
(7, 1, 7, 1, 80, 1),
(8, 1, 8, 1, 80, 1),
(9, 1, 9, 1, 80, 1),
(10, 1, 10, 1, 80, 1),
(11, 1, 11, 2, 80, 1),
(12, 1, 12, 2, 80, 1),
(13, 1, 13, 2, 80, 1),
(14, 1, 14, 2, 80, 1),
(15, 1, 15, 2, 80, 1),
(16, 1, 16, 2, 80, 1),
(17, 1, 17, 2, 80, 1),
(18, 1, 18, 2, 80, 1),
(19, 1, 19, 2, 80, 1),
(20, 1, 20, 2, 80, 1),
(21, 1, 21, 3, 80, 1),
(22, 1, 22, 3, 80, 1),
(23, 1, 23, 3, 80, 1),
(24, 1, 24, 3, 80, 1),
(25, 1, 25, 3, 80, 1),
(26, 1, 26, 3, 80, 1),
(27, 1, 27, 3, 80, 1),
(28, 1, 28, 3, 80, 1),
(29, 1, 29, 3, 80, 1),
(30, 1, 30, 3, 80, 1),
(31, 1, 31, 4, 80, 1),
(32, 1, 32, 4, 80, 1),
(33, 1, 33, 4, 80, 1),
(34, 1, 34, 4, 80, 1),
(35, 1, 35, 4, 80, 1),
(36, 1, 36, 4, 80, 1),
(37, 1, 37, 4, 80, 1),
(38, 1, 38, 4, 80, 1),
(39, 1, 39, 4, 80, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `id_disciplina` bigint(20) NOT NULL,
  `nome_disciplina` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `disciplina`
--

INSERT INTO `disciplina` (`id_disciplina`, `nome_disciplina`) VALUES
(18, 'Algoritmos e Programação'),
(4, 'Artes'),
(28, 'Banco de Dados'),
(26, 'Biologia I'),
(34, 'Biologia II'),
(2, 'Educação Física I'),
(12, 'Educação Física II'),
(37, 'Empreendedorismo e Inovação'),
(19, 'Engenharia de Software'),
(22, 'Espanhol I'),
(31, 'Espanhol II'),
(7, 'Filosofia I'),
(15, 'Filosofia II'),
(36, 'Física Aplicada'),
(16, 'Física I'),
(25, 'Física II'),
(8, 'Fundamentos de Computação'),
(9, 'Fundamentos de Design Gráfico para Computação'),
(5, 'Fundamentos Matemáticos'),
(14, 'Geografia I'),
(24, 'Geografia II'),
(17, 'Gestão de Web Sites'),
(6, 'História I'),
(32, 'História II'),
(20, 'Infraestrutura de TI'),
(29, 'Inteligência Artificial'),
(3, 'Língua Inglesa I'),
(1, 'Língua Portuguesa I'),
(11, 'Língua Portuguesa II'),
(21, 'Língua Portuguesa III'),
(13, 'Matemática II'),
(23, 'Matemática III'),
(30, 'Programação WEB I'),
(38, 'Programação WEB II'),
(27, 'Química I'),
(35, 'Química II'),
(33, 'Sociologia'),
(10, 'Tecnologias WEB'),
(39, 'Tópicos Avançados em Desenvolvimento de Sistemas');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estudantes`
--

CREATE TABLE `estudantes` (
  `id_estudante` int(11) NOT NULL,
  `fotoEstudante` varchar(200) NOT NULL,
  `nomeEstudante` varchar(100) NOT NULL,
  `dataNascimentoEstudante` date NOT NULL,
  `cursoEstudante` varchar(10) NOT NULL,
  `ano_estudante` smallint(6) NOT NULL,
  `emailEstudante` varchar(150) NOT NULL,
  `senhaEstudante` varchar(100) NOT NULL,
  `pronome` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `estudantes`
--

INSERT INTO `estudantes` (`id_estudante`, `fotoEstudante`, `nomeEstudante`, `dataNascimentoEstudante`, `cursoEstudante`, `ano_estudante`, `emailEstudante`, `senhaEstudante`, `pronome`) VALUES
(1, 'img/37f24020d9dd8ba1bec78a95aea974da.jpg', 'Teste', '2026-08-04', 'TECINF', 2, 'teste@gmail.com', '202cb962ac59075b964b07152d234b70', NULL),
(2, 'img/pv-2.webp', 'laurinha', '2026-08-11', 'TECINF', 3, 'lau@gmail.com', '202cb962ac59075b964b07152d234b70', NULL),
(3, 'img/uall.png', 'ana', '3999-09-12', 'TECINF', 3, 'ana@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(5, 'img/Captura de tela 2026-07-05 011322.png', 'lauAdmin', '2009-03-12', 'TECINF', 3, 'adminLau@gmail.com', '202cb962ac59075b964b07152d234b70', 'Ela'),
(7, 'img/Captura de tela 2026-07-08 000034.png', 'testee', '2026-08-05', 'TECINF', 1, 't@gmail.com', '202cb962ac59075b964b07152d234b70', 'Nulo'),
(8, 'img/Captura de tela 2026-07-08 000034.png', 'testee', '2026-08-05', 'TECINF', 1, 't@gmail.com', '202cb962ac59075b964b07152d234b70', 'Nulo'),
(9, 'img/Captura de tela 2026-07-08 000034.png', 'testee', '2026-08-05', 'TECINF', 1, 't@gmail.com', '202cb962ac59075b964b07152d234b70', 'Nulo'),
(10, 'img/fotodeperfil.png', 'Aluno Feliz', '2026-07-15', 'TECINF', 1, 'aluno@gmail.com', '202cb962ac59075b964b07152d234b70', 'Ele'),
(11, 'img/fotodeperfil.png', 'Aluno Feliz', '2026-02-04', 'TECINF', 3, 'alunoo@gmail.com', '202cb962ac59075b964b07152d234b70', 'Ele');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `idTarefa` int(11) NOT NULL,
  `nomeTarefa` varchar(30) NOT NULL,
  `descricaoTarefa` varchar(200) NOT NULL,
  `Disciplinas_id_disciplina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tarefas`
--

INSERT INTO `tarefas` (`idTarefa`, `nomeTarefa`, `descricaoTarefa`, `Disciplinas_id_disciplina`) VALUES
(1, '', 'pipipipopopo', 18);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anotacoes_tarefa`
--
ALTER TABLE `anotacoes_tarefa`
  ADD PRIMARY KEY (`id_anotacao`),
  ADD KEY `idx_anotacoes_tarefa_tarefa` (`id_tarefa`),
  ADD KEY `idx_anotacoes_tarefa_estudante` (`id_estudante`);

--
-- Índices de tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `sigla` (`sigla`);

--
-- Índices de tabela `curso_disciplina`
--
ALTER TABLE `curso_disciplina`
  ADD PRIMARY KEY (`id_curso_disciplina`),
  ADD UNIQUE KEY `uk_curso_disciplina` (`id_curso`,`id_disciplina`,`ano`),
  ADD KEY `fk_curso_disciplina_disciplina` (`id_disciplina`);

--
-- Índices de tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`id_disciplina`),
  ADD UNIQUE KEY `nome_disciplina` (`nome_disciplina`);

--
-- Índices de tabela `estudantes`
--
ALTER TABLE `estudantes`
  ADD PRIMARY KEY (`id_estudante`);

--
-- Índices de tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`idTarefa`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anotacoes_tarefa`
--
ALTER TABLE `anotacoes_tarefa`
  MODIFY `id_anotacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `curso_disciplina`
--
ALTER TABLE `curso_disciplina`
  MODIFY `id_curso_disciplina` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `id_disciplina` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `estudantes`
--
ALTER TABLE `estudantes`
  MODIFY `id_estudante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `idTarefa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `anotacoes_tarefa`
--
ALTER TABLE `anotacoes_tarefa`
  ADD CONSTRAINT `fk_anotacoes_tarefa_estudante` FOREIGN KEY (`id_estudante`) REFERENCES `estudantes` (`id_estudante`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_anotacoes_tarefa_tarefa` FOREIGN KEY (`id_tarefa`) REFERENCES `tarefas` (`idTarefa`) ON DELETE CASCADE;

--
-- Restrições para tabelas `curso_disciplina`
--
ALTER TABLE `curso_disciplina`
  ADD CONSTRAINT `fk_curso_disciplina_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_curso_disciplina_disciplina` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplina` (`id_disciplina`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

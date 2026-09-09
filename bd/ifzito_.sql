-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Ago-2026 às 22:41
-- Versão do servidor: 8.0.29
-- versão do PHP: 8.1.6

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
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `id_curso` bigint NOT NULL,
  `sigla` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_curso` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id_curso`, `sigla`, `nome_curso`) VALUES
(1, 'TECINF', 'Técnico em Informática'),
(7, 'TECJOG', 'Técnico em Programação de Jogos Digitais'),
(8, 'TECMEC', 'Técnico em Mecânica'),
(9, 'TECAUT', 'Técnico em Automação Industrial'),
(10, 'TECELE', 'Técnico em Eletrotécnica');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso_disciplina`
--

CREATE TABLE `curso_disciplina` (
  `id_curso_disciplina` bigint NOT NULL,
  `id_curso` bigint NOT NULL,
  `id_disciplina` bigint NOT NULL,
  `ano` smallint NOT NULL,
  `carga_horaria` int NOT NULL DEFAULT '80',
  `obrigatoria` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `curso_disciplina`
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
-- Estrutura da tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `id_disciplina` bigint NOT NULL,
  `nome_disciplina` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `disciplina`
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
-- Estrutura da tabela `estudantes`
--

CREATE TABLE `estudantes` (
  `id_estudante` int NOT NULL,
  `fotoEstudante` varchar(200) NOT NULL,
  `nomeEstudante` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dataNascimentoEstudante` date NOT NULL,
  `cursoEstudante` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ano_estudante` smallint NOT NULL,
  `emailEstudante` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senhaEstudante` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pronome` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `estudantes`
--

INSERT INTO `estudantes` (`id_estudante`, `fotoEstudante`, `nomeEstudante`, `dataNascimentoEstudante`, `cursoEstudante`, `ano_estudante`, `emailEstudante`, `senhaEstudante`, `pronome`) VALUES
(1, 'img/37f24020d9dd8ba1bec78a95aea974da.jpg', 'Teste', '2026-08-04', 'TECINF', 2, 'teste@gmail.com', '202cb962ac59075b964b07152d234b70', NULL),
(2, 'img/pv-2.webp', 'laurinha', '2026-08-11', 'TECINF', 3, 'lau@gmail.com', '202cb962ac59075b964b07152d234b70', NULL),
(3, 'img/uall.png', 'ana', '3999-09-12', 'TECINF', 3, 'ana@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `idTarefa` int NOT NULL,
  `nomeTarefa` varchar(30) NOT NULL,
  `descricaoTarefa` varchar(200) NOT NULL,
  `Disciplinas_id_disciplina` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `sigla` (`sigla`);

--
-- Índices para tabela `curso_disciplina`
--
ALTER TABLE `curso_disciplina`
  ADD PRIMARY KEY (`id_curso_disciplina`),
  ADD UNIQUE KEY `uk_curso_disciplina` (`id_curso`,`id_disciplina`,`ano`),
  ADD KEY `fk_curso_disciplina_disciplina` (`id_disciplina`);

--
-- Índices para tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`id_disciplina`),
  ADD UNIQUE KEY `nome_disciplina` (`nome_disciplina`);

--
-- Índices para tabela `estudantes`
--
ALTER TABLE `estudantes`
  ADD PRIMARY KEY (`id_estudante`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `curso_disciplina`
--
ALTER TABLE `curso_disciplina`
  MODIFY `id_curso_disciplina` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `id_disciplina` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `estudantes`
--
ALTER TABLE `estudantes`
  MODIFY `id_estudante` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `curso_disciplina`
--
ALTER TABLE `curso_disciplina`
  ADD CONSTRAINT `fk_curso_disciplina_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_curso_disciplina_disciplina` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplina` (`id_disciplina`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

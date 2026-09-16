-- Execute este arquivo UMA VEZ no banco `ifzito` já existente.
-- Ele cria a tabela usada pelo calendário individual de cada estudante.

CREATE TABLE IF NOT EXISTS `eventos` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudante` int(11) NOT NULL,
  `data_evento` date NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_evento`),
  KEY `idx_eventos_estudante_data` (`id_estudante`, `data_evento`),
  CONSTRAINT `fk_eventos_estudante`
    FOREIGN KEY (`id_estudante`) REFERENCES `estudantes` (`id_estudante`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

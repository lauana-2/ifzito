-- Execute este arquivo no banco `ifzito` caso você já tenha o banco criado.

CREATE TABLE IF NOT EXISTS anotacoes_tarefa (
    id_anotacao INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL,
    conteudo TEXT NOT NULL,
    id_tarefa INT NOT NULL,
    id_estudante INT NOT NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_anotacao),
    KEY idx_anotacoes_tarefa_tarefa (id_tarefa),
    KEY idx_anotacoes_tarefa_estudante (id_estudante),
    CONSTRAINT fk_anotacoes_tarefa_tarefa
        FOREIGN KEY (id_tarefa) REFERENCES tarefas (idTarefa) ON DELETE CASCADE,
    CONSTRAINT fk_anotacoes_tarefa_estudante
        FOREIGN KEY (id_estudante) REFERENCES estudantes (id_estudante) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

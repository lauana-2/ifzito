-- Execute este arquivo apenas se o banco ifzito já estiver criado
-- e a tabela tarefas já existir com a estrutura antiga.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;

ALTER TABLE tarefas
    CHANGE COLUMN nomeTarefa tituloTarefa VARCHAR(100) NOT NULL,
    MODIFY COLUMN descricaoTarefa VARCHAR(200) DEFAULT NULL,
    MODIFY COLUMN Disciplinas_id_disciplina BIGINT NOT NULL;

ALTER TABLE tarefas
    MODIFY COLUMN idTarefa INT NOT NULL AUTO_INCREMENT;

ALTER TABLE tarefas
    ADD PRIMARY KEY (idTarefa);

ALTER TABLE tarefas
    ADD INDEX fk_tarefas_disciplina (Disciplinas_id_disciplina);

ALTER TABLE tarefas
    ADD CONSTRAINT fk_tarefas_disciplina
    FOREIGN KEY (Disciplinas_id_disciplina)
    REFERENCES disciplina (id_disciplina)
    ON DELETE RESTRICT;

<?php
include "header.php";
include "conexaoBD.php";

$disciplinas = mysqli_query($conn, "SELECT id_disciplina, nome_disciplina FROM disciplina ORDER BY nome_disciplina");
?>

<div class="container-fluid">
    <div class="d-flex justify-content-center mb-4">
        <h2>Adicione uma nova tarefa</h2>
    </div>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-warning text-center">
            <?php echo htmlspecialchars($_GET['erro'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center">
        <form action="actionTarefa.php" method="POST" class="w-100" style="max-width: 600px;">
            <div class="form-floating mt-3 mb-3">
                <select name="id_disciplina" id="id_disciplina" class="form-select" required>
                    <option value="" selected disabled>Selecione uma disciplina</option>
                    <?php while ($disciplina = mysqli_fetch_assoc($disciplinas)): ?>
                        <option value="<?php echo (int) $disciplina['id_disciplina']; ?>">
                            <?php echo htmlspecialchars($disciplina['nome_disciplina'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <label for="id_disciplina">Disciplina da tarefa</label>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="tituloTarefa" id="tituloTarefa" class="form-control" maxlength="100" required>
                <label for="tituloTarefa">Título da tarefa</label>
            </div>

            <div class="form-floating mt-3 mb-3">
                <textarea name="descricaoTarefa" id="descricaoTarefa" class="form-control" maxlength="200" style="height: 140px;"></textarea>
                <label for="descricaoTarefa">Descrição da atividade</label>
            </div>

            <div class="d-flex gap-2">
                <a href="tarefas.php" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Criar tarefa</button>
            </div>
        </form>
    </div>
</div>

<?php include "footer.php" ?>

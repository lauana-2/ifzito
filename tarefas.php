<?php
include "conexaoBD.php";

$buscarTarefas = "
    SELECT
        t.idTarefa,
        t.nomeTarefa,
        t.descricaoTarefa,
        d.nome_disciplina
    FROM tarefas t
    INNER JOIN disciplina d
        ON d.id_disciplina = t.Disciplinas_id_disciplina
    ORDER BY t.idTarefa DESC
";

$tarefas = mysqli_query($conn, $buscarTarefas);

include "header.php";
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Tarefas Gerais</h1>
            <p class="text-muted mb-0">Crie suas tarefas e configure-as do seu jeito!</p>
        </div>
        <a href="novaTarefa.php" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nova tarefa
        </a>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Tarefa cadastrada!</strong> A tarefa foi salva no banco de dados e já está disponível nesta página.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if ($tarefas && mysqli_num_rows($tarefas) > 0): ?>
            <?php while ($tarefa = mysqli_fetch_assoc($tarefas)): ?>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-start">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <?php echo htmlspecialchars($tarefa['nome_disciplina'], ENT_QUOTES, 'UTF-8'); ?>
                                    </div>

                                    <div class="h5 mb-2 font-weight-bold text-gray-800">
                                        <?php echo htmlspecialchars($tarefa['nomeTarefa'], ENT_QUOTES, 'UTF-8'); ?>
                                    </div>

                                    <?php if ($tarefa['descricaoTarefa'] !== ''): ?>
                                        <p class="mb-0 text-gray-600">
                                            <?php echo nl2br(htmlspecialchars($tarefa['descricaoTarefa'], ENT_QUOTES, 'UTF-8')); ?>
                                        </p>
                                    <?php else: ?>
                                        <p class="mb-0 text-muted">Sem descrição.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="tarefa.php?id=<?php echo (int) $tarefa['idTarefa']; ?>" class="btn btn-outline-success btn-sm">
                                    Ver tarefa <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-tasks fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-800">Nenhuma tarefa cadastrada</h5>
                        <p class="text-muted">Cadastre a primeira tarefa para ela aparecer aqui.</p>
                        <a href="novaTarefa.php" class="btn btn-success">Cadastrar tarefa</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "footer.php" ?>

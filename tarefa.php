<?php
session_start();
include "conexaoBD.php";

// Recebe o ID diretamente da URL. Ex.: tarefa.php?id=3
$idTarefa = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($idTarefa <= 0) {
    header("Location: tarefas.php?erro=" . urlencode("Tarefa não encontrada."));
    exit();
}

// Busca a tarefa pelo ID.
$buscarTarefa = mysqli_prepare(
    $conn,
    "SELECT t.idTarefa, t.nomeTarefa, t.descricaoTarefa, t.Disciplinas_id_disciplina,
            d.nome_disciplina
     FROM tarefas t
     LEFT JOIN disciplina d ON d.id_disciplina = t.Disciplinas_id_disciplina
     WHERE t.idTarefa = ?
     LIMIT 1"
);

if (!$buscarTarefa) {
    header("Location: tarefas.php?erro=" . urlencode("Não foi possível consultar a tarefa."));
    exit();
}

mysqli_stmt_bind_param($buscarTarefa, "i", $idTarefa);
mysqli_stmt_execute($buscarTarefa);

// Usa bind_result em vez de get_result para funcionar mesmo quando o PHP
// do XAMPP não possui o driver mysqlnd habilitado.
mysqli_stmt_bind_result(
    $buscarTarefa,
    $idTarefaBanco,
    $nomeTarefaBanco,
    $descricaoTarefaBanco,
    $idDisciplinaBanco,
    $nomeDisciplinaBanco
);

if (mysqli_stmt_fetch($buscarTarefa)) {
    $tarefa = [
        'idTarefa' => $idTarefaBanco,
        'nomeTarefa' => $nomeTarefaBanco,
        'descricaoTarefa' => $descricaoTarefaBanco,
        'Disciplinas_id_disciplina' => $idDisciplinaBanco,
        'nome_disciplina' => $nomeDisciplinaBanco ?: 'Disciplina não encontrada'
    ];
} else {
    $tarefa = null;
}

mysqli_stmt_close($buscarTarefa);

if (!$tarefa) {
    header("Location: tarefas.php?erro=" . urlencode("Tarefa não encontrada."));
    exit();
}

$anotacoes = [];
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true && isset($_SESSION['id_estudante'])) {
    $idEstudante = (int) $_SESSION['id_estudante'];

    $buscarAnotacoes = mysqli_prepare(
        $conn,
        "SELECT id_anotacao, titulo, conteudo, criado_em, atualizado_em
         FROM anotacoes_tarefa
         WHERE id_tarefa = ? AND id_estudante = ?
         ORDER BY atualizado_em DESC, id_anotacao DESC"
    );
    mysqli_stmt_bind_param($buscarAnotacoes, "ii", $idTarefa, $idEstudante);
    mysqli_stmt_execute($buscarAnotacoes);
    $resultadoAnotacoes = mysqli_stmt_get_result($buscarAnotacoes);

    while ($anotacao = mysqli_fetch_assoc($resultadoAnotacoes)) {
        $anotacoes[] = $anotacao;
    }
    mysqli_stmt_close($buscarAnotacoes);
}

include "header.php";
?>

<div class="container-fluid">
    <div class="mb-4">
        <a href="tarefas.php" class="text-success text-decoration-none">
            <i class="fas fa-arrow-left mr-1"></i> Voltar para tarefas
        </a>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pronto!</strong> A anotação foi salva.
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['erro'], ENT_QUOTES, 'UTF-8'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['excluido'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Anotação excluída!</strong> A anotação foi removida da tarefa.
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-body p-4">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                        <?php echo htmlspecialchars($tarefa['nome_disciplina'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>

                    <h1 class="h3 font-weight-bold text-gray-800 mb-3">
                        <?php echo htmlspecialchars($tarefa['nomeTarefa'], ENT_QUOTES, 'UTF-8'); ?>
                    </h1>

                    <hr>

                    <h6 class="font-weight-bold text-gray-800 mt-4">
                        <i class="fas fa-align-left mr-2 text-success"></i>Descrição da atividade
                    </h6>

                    <?php if (!empty($tarefa['descricaoTarefa'])): ?>
                        <p class="text-gray-700 mb-0" style="white-space: pre-line;">
                            <?php echo htmlspecialchars($tarefa['descricaoTarefa'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    <?php else: ?>
                        <p class="text-muted mb-0">Esta tarefa não possui uma descrição.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100 border-left-success">
                <div class="card-body p-4">
                    <h6 class="font-weight-bold text-gray-800 mb-3">
                        <i class="fas fa-info-circle mr-2 text-success"></i>Sobre a tarefa
                    </h6>

                    <div class="mb-3">
                        <small class="text-muted d-block">Disciplina</small>
                        <span class="font-weight-bold text-gray-800">
                            <?php echo htmlspecialchars($tarefa['nome_disciplina'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </div>

                    <div>
                        <small class="text-muted d-block">Data de entrega:</small>
                        <span class="text-gray-800">#<?php echo (int) $tarefa['idTarefa']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fas fa-sticky-note mr-2"></i>Minhas anotações
            </h6>
            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
               <button
                    type="button"
                    class="btn btn-success btn-sm"
                    id="btnNovaAnotacao"
                    onclick="abrirNovaAnotacao()">
                    <i class="fas fa-plus mr-1"></i>
                    Nova anotação
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body">
            <?php if (!(isset($_SESSION['logado']) && $_SESSION['logado'] === true)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-lock fa-2x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-800">Entre na sua conta para fazer anotações</h5>
                    <p class="text-muted mb-3">Suas anotações ficam vinculadas ao seu perfil e a esta tarefa.</p>
                    <a href="formLogin.php" class="btn btn-success">Fazer login</a>
                </div>
            <?php else: ?>
                <div class="mb-4" id="novaAnotacao" style="display: none;">
                    <div class="card border-left-success bg-light">
                        <div class="card-body">
                            <form action="actionAnotacaoTarefa.php" method="POST">
                                <input type="hidden" name="acao" value="nova">
                                <input type="hidden" name="id_tarefa" value="<?php echo (int) $tarefa['idTarefa']; ?>">

                                <div class="form-group">
                                    <label for="tituloAnotacao" class="font-weight-bold">Título</label>
                                    <input type="text" name="titulo" id="tituloAnotacao" class="form-control" maxlength="100" placeholder="Ex.: Dúvidas sobre a atividade" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="conteudoAnotacao" class="font-weight-bold">Anotação</label>
                                    <textarea name="conteudo" id="conteudoAnotacao" class="form-control" rows="5" maxlength="2000" placeholder="Escreva aqui suas dúvidas, ideias ou lembretes..." required></textarea>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i> Salvar anotação
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php if (count($anotacoes) === 0): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-sticky-note fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-800">Nenhuma anotação ainda</h5>
                        <p class="text-muted mb-0">Use este espaço para registrar dúvidas, ideias e lembretes sobre esta tarefa.</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($anotacoes as $anotacao): ?>
                            <div class="col-lg-6 mb-3">
                                <div class="card h-100 border-left-warning">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="font-weight-bold text-gray-800 mb-0">
                                                <?php echo htmlspecialchars($anotacao['titulo'], ENT_QUOTES, 'UTF-8'); ?>
                                            </h6>
                                            <span class="text-muted small">
                                                <?php echo date('d/m/Y H:i', strtotime($anotacao['atualizado_em'])); ?>
                                            </span>
                                        </div>

                                        <p class="text-gray-700 mb-3" style="white-space: pre-line;">
                                            <?php echo htmlspecialchars($anotacao['conteudo'], ENT_QUOTES, 'UTF-8'); ?>
                                        </p>

                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-secondary btn-sm mr-2" data-toggle="modal" data-target="#editarAnotacao<?php echo (int) $anotacao['id_anotacao']; ?>">
                                                <i class="fas fa-edit mr-1"></i> Editar
                                            </button>

                                            <form action="actionAnotacaoTarefa.php" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir esta anotação?');">
                                                <input type="hidden" name="acao" value="excluir">
                                                <input type="hidden" name="id_anotacao" value="<?php echo (int) $anotacao['id_anotacao']; ?>">
                                                <input type="hidden" name="id_tarefa" value="<?php echo (int) $tarefa['idTarefa']; ?>">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash mr-1"></i> Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="editarAnotacao<?php echo (int) $anotacao['id_anotacao']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form action="actionAnotacaoTarefa.php" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-bold text-success">Editar anotação</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span>&times;</span></button>
                                            </div>

                                            <div class="modal-body">
                                                <input type="hidden" name="acao" value="editar">
                                                <input type="hidden" name="id_anotacao" value="<?php echo (int) $anotacao['id_anotacao']; ?>">
                                                <input type="hidden" name="id_tarefa" value="<?php echo (int) $tarefa['idTarefa']; ?>">

                                                <div class="form-group">
                                                    <label class="font-weight-bold">Título</label>
                                                    <input type="text" name="titulo" class="form-control" maxlength="100" value="<?php echo htmlspecialchars($anotacao['titulo'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label class="font-weight-bold">Anotação</label>
                                                    <textarea name="conteudo" class="form-control" rows="8" maxlength="2000" required><?php echo htmlspecialchars($anotacao['conteudo'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success">Salvar alterações</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function abrirNovaAnotacao() {

    const formulario = document.getElementById('novaAnotacao');
    const botao = document.getElementById('btnNovaAnotacao');

    if (!formulario) {
        return;
    }

    if (formulario.style.display === 'none') {

        formulario.style.display = 'block';

        botao.innerHTML =
            '<i class="fas fa-times mr-1"></i> Fechar';

    } else {

        formulario.style.display = 'none';

        botao.innerHTML =
            '<i class="fas fa-plus mr-1"></i> Nova anotação';
    }
}
</script>


<?php include "footer.php"; ?>

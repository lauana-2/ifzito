<?php
session_start();
include "conexaoBD.php";

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['id_estudante'])) {
    header("Location: formLogin.php?erroLogin=loginNecessario");
    exit();
}

$idEstudante = (int) $_SESSION['id_estudante'];
$acao = $_POST['acao'] ?? '';
$idTarefa = filter_input(INPUT_POST, 'id_tarefa', FILTER_VALIDATE_INT);

function voltarTarefa($idTarefa, $mensagem = null, $sucesso = false) {
    $url = "tarefa.php?id=" . (int) $idTarefa;
    if ($mensagem !== null) {
        $url .= "&erro=" . urlencode($mensagem);
    }
    if ($sucesso) {
        $url .= "&sucesso=1";
    }
    header("Location: $url");
    exit();
}

if ($acao !== 'excluir' && !$idTarefa) {
    header("Location: tarefas.php?erro=" . urlencode("Tarefa inválida."));
    exit();
}

if ($acao === 'nova') {
    $titulo = trim($_POST['titulo'] ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');

    if ($titulo === '' || $conteudo === '') {
        voltarTarefa($idTarefa, "Preencha o título e o conteúdo da anotação.");
    }

    if (mb_strlen($titulo) > 100 || mb_strlen($conteudo) > 2000) {
        voltarTarefa($idTarefa, "O título deve ter até 100 caracteres e a anotação até 2000 caracteres.");
    }

    $verificarTarefa = mysqli_prepare($conn, "SELECT idTarefa FROM tarefas WHERE idTarefa = ?");
    mysqli_stmt_bind_param($verificarTarefa, "i", $idTarefa);
    mysqli_stmt_execute($verificarTarefa);
    $resultado = mysqli_stmt_get_result($verificarTarefa);
    $existe = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($verificarTarefa);

    if (!$existe) {
        header("Location: tarefas.php?erro=" . urlencode("Tarefa não encontrada."));
        exit();
    }

    $inserir = mysqli_prepare(
        $conn,
        "INSERT INTO anotacoes_tarefa (titulo, conteudo, id_tarefa, id_estudante) VALUES (?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($inserir, "ssii", $titulo, $conteudo, $idTarefa, $idEstudante);

    if (mysqli_stmt_execute($inserir)) {
        mysqli_stmt_close($inserir);
        voltarTarefa($idTarefa, null, true);
    }

    mysqli_stmt_close($inserir);
    voltarTarefa($idTarefa, "Não foi possível salvar a anotação.");
}

if ($acao === 'editar') {
    $idAnotacao = filter_input(INPUT_POST, 'id_anotacao', FILTER_VALIDATE_INT);
    $titulo = trim($_POST['titulo'] ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');

    if (!$idAnotacao || !$idTarefa || $titulo === '' || $conteudo === '') {
        voltarTarefa($idTarefa, "Preencha todos os campos da anotação.");
    }

    if (mb_strlen($titulo) > 100 || mb_strlen($conteudo) > 2000) {
        voltarTarefa($idTarefa, "O título deve ter até 100 caracteres e a anotação até 2000 caracteres.");
    }

    $editar = mysqli_prepare(
        $conn,
        "UPDATE anotacoes_tarefa
         SET titulo = ?, conteudo = ?, atualizado_em = CURRENT_TIMESTAMP
         WHERE id_anotacao = ? AND id_tarefa = ? AND id_estudante = ?"
    );
    mysqli_stmt_bind_param($editar, "ssiii", $titulo, $conteudo, $idAnotacao, $idTarefa, $idEstudante);

    $executou = mysqli_stmt_execute($editar);
    mysqli_stmt_close($editar);

    if ($executou) {
        voltarTarefa($idTarefa, null, true);
    }

    voltarTarefa($idTarefa, "Não foi possível editar a anotação.");
}

if ($acao === 'excluir') {
    $idAnotacao = filter_input(INPUT_POST, 'id_anotacao', FILTER_VALIDATE_INT);
    $idTarefa = filter_input(INPUT_POST, 'id_tarefa', FILTER_VALIDATE_INT);

    if (!$idAnotacao || !$idTarefa) {
        header("Location: tarefas.php");
        exit();
    }

    $excluir = mysqli_prepare(
        $conn,
        "DELETE FROM anotacoes_tarefa WHERE id_anotacao = ? AND id_tarefa = ? AND id_estudante = ?"
    );
    mysqli_stmt_bind_param($excluir, "iii", $idAnotacao, $idTarefa, $idEstudante);
    $executou = mysqli_stmt_execute($excluir);
    mysqli_stmt_close($excluir);

    if ($executou) {
        header("Location: tarefas.php?id=" . (int) $idTarefa . "&excluido=1");
        exit();
    }

    voltarTarefa($idTarefa, "Não foi possível excluir a anotação.");
}

header("Location: tarefas.php");
exit();

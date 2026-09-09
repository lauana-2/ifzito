<?php

include "conexaoBD.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: tarefas.php");
    exit();
}

$acao = $_POST['acao'] ?? 'nova';

if ($acao === 'excluir') {

    $idTarefa = filter_input(
        INPUT_POST,
        'id_tarefa',
        FILTER_VALIDATE_INT
    );

    if (!$idTarefa) {

        header("Location: tarefas.php");
        exit();

    }

    $excluirAnotacoes = mysqli_prepare(

        $conn,

        "DELETE FROM anotacoes_tarefa
         WHERE id_tarefa = ?"

    );

    mysqli_stmt_bind_param(
        $excluirAnotacoes,
        "i",
        $idTarefa
    );

    mysqli_stmt_execute($excluirAnotacoes);
    mysqli_stmt_close($excluirAnotacoes);

    $excluirTarefa = mysqli_prepare(

        $conn,

        "DELETE FROM tarefas
         WHERE idTarefa = ?"

    );

    mysqli_stmt_bind_param(
        $excluirTarefa,
        "i",
        $idTarefa
    );

    $executou = mysqli_stmt_execute(
        $excluirTarefa
    );

    mysqli_stmt_close(
        $excluirTarefa
    );

    if ($executou) {

        header(
            "Location: tarefas.php?excluido=1"
        );

        exit();

    }

    header(
        "Location: tarefas.php?erro=erroExcluir"
    );

    exit();

}


$idDisciplina = filter_input(
    INPUT_POST,
    'id_disciplina',
    FILTER_VALIDATE_INT
);

$nomeTarefa = trim(
    $_POST['nomeTarefa'] ?? ''
);

$descricaoTarefa = trim(
    $_POST['descricaoTarefa'] ?? ''
);
if (!$idDisciplina || $nomeTarefa === '') {
    header("Location: novaTarefa.php?erro=" . urlencode("Preencha a disciplina e o título da tarefa."));
    exit();
}

if (mb_strlen($nomeTarefa) > 100 || mb_strlen($descricaoTarefa) > 200) {
    header("Location: novaTarefa.php?erro=" . urlencode("O título deve ter até 100 caracteres e a descrição até 200 caracteres."));
    exit();
}

// Verifica se a disciplina realmente existe.
$buscarDisciplina = mysqli_prepare($conn, "SELECT id_disciplina FROM disciplina WHERE id_disciplina = ?");
mysqli_stmt_bind_param($buscarDisciplina, "i", $idDisciplina);
mysqli_stmt_execute($buscarDisciplina);
$resultadoDisciplina = mysqli_stmt_get_result($buscarDisciplina);

if (!mysqli_fetch_assoc($resultadoDisciplina)) {
    mysqli_stmt_close($buscarDisciplina);
    header("Location: novaTarefa.php?erro=" . urlencode("A disciplina selecionada não existe."));
    exit();
}
mysqli_stmt_close($buscarDisciplina);

// Insere a tarefa usando prepared statement para evitar SQL Injection.
$inserirTarefa = mysqli_prepare(
    $conn,
    "INSERT INTO tarefas (nomeTarefa, descricaoTarefa, Disciplinas_id_disciplina) VALUES (?, ?, ?)"
);

mysqli_stmt_bind_param($inserirTarefa, "ssi", $nomeTarefa, $descricaoTarefa, $idDisciplina);

if (mysqli_stmt_execute($inserirTarefa)) {
    mysqli_stmt_close($inserirTarefa);
    header("Location: tarefas.php?sucesso=1");
    exit();
}

mysqli_stmt_close($inserirTarefa);
header("Location: novaTarefa.php?erro=" . urlencode("Não foi possível cadastrar a tarefa no banco de dados."));
exit();

<?php
session_start();

if (!isset($_SESSION['id_estudante'])) {
    header("Location: formLogin.php");
    exit;
}

$id_estudante = (int) $_SESSION['id_estudante'];

include "conexaoBD.php";

/*
|--------------------------------------------------------------------------
| DISCIPLINAS DO ESTUDANTE
|--------------------------------------------------------------------------
| A Home mostra apenas as disciplinas correspondentes ao curso e ao ano
| do estudante logado.
|--------------------------------------------------------------------------
*/
$listarDisciplinas = "
    SELECT
        e.nomeEstudante,
        e.cursoEstudante,
        e.ano_estudante,
        d.id_disciplina,
        d.nome_disciplina
    FROM estudantes AS e
    INNER JOIN curso AS c
        ON c.sigla = e.cursoEstudante
    INNER JOIN curso_disciplina AS cd
        ON cd.id_curso = c.id_curso
        AND cd.ano = e.ano_estudante
    INNER JOIN disciplina AS d
        ON d.id_disciplina = cd.id_disciplina
    WHERE e.id_estudante = $id_estudante
    ORDER BY d.nome_disciplina
";

$res = mysqli_query($conn, $listarDisciplinas);

$disciplinas = [];
$curso = '';
$ano = '';

if ($res) {
    while ($disciplina = mysqli_fetch_assoc($res)) {
        $disciplinas[] = $disciplina;
        $curso = $disciplina['cursoEstudante'];
        $ano = $disciplina['ano_estudante'];
    }
}

$totalDisciplinas = count($disciplinas);

if ($totalDisciplinas === 0) {
    $buscarEstudante = mysqli_query(
        $conn,
        "SELECT cursoEstudante, ano_estudante FROM estudantes WHERE id_estudante = $id_estudante LIMIT 1"
    );

    if ($buscarEstudante && $dadosEstudante = mysqli_fetch_assoc($buscarEstudante)) {
        $curso = $dadosEstudante['cursoEstudante'];
        $ano = $dadosEstudante['ano_estudante'];
    }
}

function iconeDisciplina($nome)
{
    $nome = mb_strtolower($nome, 'UTF-8');

    if (strpos($nome, 'matem') !== false || strpos($nome, 'física') !== false || strpos($nome, 'fisica') !== false) {
        return 'fa-square-root-alt';
    }

    if (strpos($nome, 'program') !== false || strpos($nome, 'algorit') !== false || strpos($nome, 'comput') !== false) {
        return 'fa-code';
    }

    if (strpos($nome, 'banco') !== false) {
        return 'fa-database';
    }

    if (strpos($nome, 'web') !== false || strpos($nome, 'site') !== false) {
        return 'fa-globe';
    }

    if (strpos($nome, 'design') !== false || strpos($nome, 'artes') !== false) {
        return 'fa-palette';
    }

    if (strpos($nome, 'portugues') !== false || strpos($nome, 'língua') !== false || strpos($nome, 'lingua') !== false ||
        strpos($nome, 'ingl') !== false || strpos($nome, 'espanhol') !== false) {
        return 'fa-book-open';
    }

    if (strpos($nome, 'hist') !== false || strpos($nome, 'geografia') !== false || strpos($nome, 'filosofia') !== false ||
        strpos($nome, 'sociologia') !== false) {
        return 'fa-landmark';
    }

    if (strpos($nome, 'biologia') !== false || strpos($nome, 'química') !== false || strpos($nome, 'quimica') !== false) {
        return 'fa-flask';
    }

    if (strpos($nome, 'educação física') !== false || strpos($nome, 'educacao fisica') !== false) {
        return 'fa-running';
    }

    if (strpos($nome, 'empreendedorismo') !== false || strpos($nome, 'inovação') !== false || strpos($nome, 'inovacao') !== false) {
        return 'fa-lightbulb';
    }

    return 'fa-book';
}

include "header.php";
?>

<div class="container-fluid home-disciplinas">

    <!-- CABEÇALHO -->
    <div class="home-hero text-center mb-4">
        <span class="home-kicker">
            <i class="fas fa-graduation-cap mr-2"></i>Área do estudante
        </span>

        <h1 class="h3 mb-2">Suas disciplinas</h1>

        <p class="mb-0 text-muted">
            Acompanhe as disciplinas vinculadas ao seu curso e organize sua rotina de estudos.
        </p>
    </div>

    <!-- RESUMO -->
    <div class="row justify-content-center home-summary-row mb-4">

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="home-summary-card text-center">
                <div class="summary-icon summary-icon-green mx-auto">
                    <i class="fas fa-book"></i>
                </div>
                <div class="summary-label">Disciplinas</div>
                <div class="summary-number"><?php echo $totalDisciplinas; ?></div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="home-summary-card text-center summary-card-red">
                <div class="summary-icon summary-icon-red mx-auto">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="summary-label">Ano atual</div>
                <div class="summary-number">
                    <?php echo $ano !== '' ? htmlspecialchars($ano) . 'º' : '—'; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="home-summary-card text-center">
                <div class="summary-icon summary-icon-green mx-auto">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="summary-label">Curso</div>
                <div class="summary-course">
                    <?php echo $curso !== '' ? htmlspecialchars($curso) : 'Não informado'; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- CABEÇALHO DA LISTA -->
    <div class="home-section-header text-center mb-4">
        <h2 class="h4 mb-2">Disciplinas do seu curso</h2>
        <p class="text-muted mb-0">
            Selecione uma área do IFzito para continuar organizando seus estudos.
        </p>

        <div class="home-quick-links mt-3">
            <a href="tarefas.php" class="btn btn-outline-success btn-sm mr-2">
                <i class="fas fa-tasks mr-1"></i>Tarefas
            </a>
        </div>
    </div>

    <!-- DISCIPLINAS -->
    <?php if ($totalDisciplinas > 0): ?>

        <div class="row">

            <?php foreach ($disciplinas as $indice => $disciplina): ?>

                <?php
                    $nomeDisciplina = $disciplina['nome_disciplina'];
                    $icone = iconeDisciplina($nomeDisciplina);
                ?>

                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="disciplina-card h-100">

                        <div class="disciplina-card-top">
                            <div class="disciplina-icon">
                                <i class="fas <?php echo $icone; ?>"></i>
                            </div>

                            <span class="disciplina-number">
                                <?php echo str_pad($indice + 1, 2, '0', STR_PAD_LEFT); ?>
                            </span>
                        </div>

                        <div class="disciplina-content">
                            <h3>
                                <?php echo htmlspecialchars($nomeDisciplina, ENT_QUOTES, 'UTF-8'); ?>
                            </h3>

                            <p class="mb-0">
                                Disciplina vinculada ao seu curso.
                            </p>
                        </div>

                        <div class="disciplina-card-footer">
                            <span>
                                <i class="far fa-bookmark mr-1"></i>
                                <?php echo $ano !== '' ? htmlspecialchars($ano) . 'º ano' : 'Seu curso'; ?>
                            </span>

                            <span class="disciplina-course">
                                <i class="fas fa-graduation-cap mr-1"></i>
                                <?php echo $curso !== '' ? htmlspecialchars($curso) : 'IFPR'; ?>
                            </span>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>


<?php include "footer.php"; ?>

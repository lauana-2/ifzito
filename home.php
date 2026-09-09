<?php
    session_start();

    if (!isset($_SESSION['id_estudante'])) {
        header("Location: formLogin.php");
        exit;
    }

    $id_estudante = $_SESSION['id_estudante'];

?>

<?php include "header.php" ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Disciplinas</h1>
            <p class="text-muted mb-0">Confira suas disciplinas cursadas!</p>
        </div>
    </div>
    
    <!-- Content Row -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">

                <!-- Content Row -->
                <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4 ">

                            <!-- Project Card Example -->

                            <?php

                                //1ª Parte: Prepara a QUERY e exibe o TOTAL de Registros

                                //QUERY para listar TODOS os registros da tabela Usuarios
                                $listarDisciplinas = "SELECT
                                    e.id_estudante,
                                    e.nomeEstudante,
                                    e.cursoEstudante,
                                    e.ano_estudante,
                                    c.id_curso,
                                    cd.id_curso_disciplina,
                                    cd.ano,
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
                                ORDER BY d.nome_disciplina";


                                include "conexaoBD.php"; //Inclui o arquivo de conexão com o Banco de Dados
                                //A função mysqli_query() executa a QUERY no Banco de Dados
                                //A função die() encerra o carregamento da página
                                $res = mysqli_query($conn, $listarDisciplinas);

                                $totalDisciplinas = mysqli_num_rows($res);

                                echo "<div class='alert alert-info text-center'>
                                        Você está cursando <strong>$totalDisciplinas</strong> disciplinas! <i class='bi bi-emoji-smile'></i>
                                    </div>";
                               


                                    include "conexaoBD.php"; //Inclui o arquivo de conexão com o Banco de Dados
                                    //A função mysqli_query() executa a QUERY no Banco de Dados
                                    //A função die() encerra o carregamento da página
                                    $res = mysqli_query($conn, $listarDisciplinas);

                                ?>

                                <div class="card-body">

                                <?php

                                    while ($disciplina = mysqli_fetch_assoc($res)) {

                                        $nomeDisciplina = $disciplina['nome_disciplina'];

                                        // Por enquanto, o progresso começa em 0%
                                        $progresso = 0;

                                        echo "
                                            <h4 class='small font-weight-bold'>
                                                $nomeDisciplina
                                                <span class='float-right'>$progresso%</span>
                                            </h4>

                                            <div class='progress mb-4'>
                                                <div
                                                    class='progress-bar bg-primary'
                                                    role='progressbar'
                                                    style='width: {$progresso}%'
                                                    aria-valuenow='$progresso'
                                                    aria-valuemin='0'
                                                    aria-valuemax='100'>
                                                </div>
                                            </div>
                                        ";
                                    }

                                ?>

                                </div>

                        </div>

                        <div class="col-lg-6 mb-4">

                    </div>

<?php include "footer.php" ?>
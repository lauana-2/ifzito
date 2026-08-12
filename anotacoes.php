<?php

session_start();

include "header.php";

/*
|--------------------------------------------------------------------------
| ANOTAÇÕES
|--------------------------------------------------------------------------
| Versão inicial utilizando SESSION.
| Posteriormente podemos substituir por MySQL.
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['anotacoes'])) {
    $_SESSION['anotacoes'] = [];
}


/* ==========================================================
   FUNÇÃO DE SEGURANÇA
   ========================================================== */

function limpar($valor)
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}


/* ==========================================================
   EXCLUIR ANOTAÇÃO
   ========================================================== */

if (isset($_GET['excluir'])) {

    $id = (int) $_GET['excluir'];

    foreach ($_SESSION['anotacoes'] as $chave => $anotacao) {

        if ($anotacao['id'] == $id) {

            unset($_SESSION['anotacoes'][$chave]);

            $_SESSION['anotacoes'] = array_values($_SESSION['anotacoes']);

            break;
        }
    }

    header("Location: anotacoes.php");
    exit;
}


/* ==========================================================
   SALVAR ANOTAÇÃO
   ========================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $acao = $_POST['acao'] ?? '';

    $titulo = trim($_POST['titulo'] ?? '');
    $materia = trim($_POST['materia'] ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');

    if ($titulo !== '' && $conteudo !== '') {

        /* ------------------------------
           EDITAR
        ------------------------------ */

        if ($acao === 'editar') {

            $id = (int) ($_POST['id'] ?? 0);

            foreach ($_SESSION['anotacoes'] as &$anotacao) {

                if ($anotacao['id'] == $id) {

                    $anotacao['titulo'] = $titulo;
                    $anotacao['materia'] = $materia;
                    $anotacao['conteudo'] = $conteudo;
                    $anotacao['editado_em'] = date('d/m/Y H:i');

                    break;
                }
            }

            unset($anotacao);

        }

        /* ------------------------------
           NOVA
        ------------------------------ */

        else {

            $_SESSION['anotacoes'][] = [

                'id' => time() . rand(1, 999),

                'titulo' => $titulo,

                'materia' => $materia,

                'conteudo' => $conteudo,

                'criado_em' => date('d/m/Y H:i'),

                'editado_em' => null

            ];
        }

        header("Location: anotacoes.php");
        exit;
    }
}


/* ==========================================================
   EDIÇÃO
   ========================================================== */

$anotacaoEditar = null;

if (isset($_GET['editar'])) {

    $id = (int) $_GET['editar'];

    foreach ($_SESSION['anotacoes'] as $anotacao) {

        if ($anotacao['id'] == $id) {

            $anotacaoEditar = $anotacao;

            break;
        }
    }
}


/* ==========================================================
   PESQUISA
   ========================================================== */

$busca = trim($_GET['busca'] ?? '');

$filtroMateria = trim($_GET['materia'] ?? '');


$anotacoesFiltradas = [];


foreach ($_SESSION['anotacoes'] as $anotacao) {

    $encontrouBusca = true;
    $encontrouMateria = true;


    /* Pesquisa */

    if ($busca !== '') {

        $textoPesquisa =
            strtolower(
                $anotacao['titulo'] . ' ' .
                $anotacao['conteudo'] . ' ' .
                $anotacao['materia']
            );

        if (strpos($textoPesquisa, strtolower($busca)) === false) {

            $encontrouBusca = false;
        }
    }


    /* Filtro por matéria */

    if ($filtroMateria !== '') {

        if (strtolower($anotacao['materia']) !== strtolower($filtroMateria)) {

            $encontrouMateria = false;
        }
    }


    if ($encontrouBusca && $encontrouMateria) {

        $anotacoesFiltradas[] = $anotacao;
    }
}


/* ==========================================================
   MATÉRIAS EXISTENTES NAS ANOTAÇÕES
   ========================================================== */

$materias = [];

foreach ($_SESSION['anotacoes'] as $anotacao) {

    if (!empty($anotacao['materia'])) {

        $materias[] = $anotacao['materia'];
    }
}

$materias = array_unique($materias);

sort($materias);

?>

<!-- ==========================================================
     CONTEÚDO DA PÁGINA
     ========================================================== -->

<div class="container-fluid">


    <!-- CABEÇALHO -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">

                <i class="fas fa-sticky-note text-primary mr-2"></i>

                Minhas Anotações

            </h1>

            <p class="text-muted mb-0">

                Organize seus estudos e guarde suas anotações.

            </p>

        </div>


        <button
            class="btn btn-primary shadow-sm"
            data-toggle="modal"
            data-target="#modalNovaAnotacao">

            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i>

            Nova anotação

        </button>

    </div>



    <!-- ======================================================
         BARRA DE PESQUISA
         ====================================================== -->

    <div class="card shadow mb-4">

        <div class="card-body">

            <form method="GET" action="anotacoes.php">

                <div class="row">


                    <!-- PESQUISA -->

                    <div class="col-md-7 mb-2 mb-md-0">

                        <label class="small font-weight-bold text-gray-700">

                            Pesquisar

                        </label>

                        <div class="input-group">

                            <input
                                type="text"
                                name="busca"
                                class="form-control bg-light border-0"
                                placeholder="Pesquisar nas suas anotações..."
                                value="<?= limpar($busca) ?>">

                            <div class="input-group-append">

                                <button
                                    class="btn btn-primary"
                                    type="submit">

                                    <i class="fas fa-search"></i>

                                </button>

                            </div>

                        </div>

                    </div>


                    <!-- MATÉRIA -->

                    <div class="col-md-4 mb-2 mb-md-0">

                        <label class="small font-weight-bold text-gray-700">

                            Filtrar por matéria

                        </label>

                        <select
                            name="materia"
                            class="form-control">

                            <option value="">

                                Todas as matérias

                            </option>

                            <?php foreach ($materias as $materia): ?>

                                <option
                                    value="<?= limpar($materia) ?>"
                                    <?= strtolower($filtroMateria) === strtolower($materia) ? 'selected' : '' ?>>

                                    <?= limpar($materia) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- BOTÃO -->

                    <div class="col-md-1 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary btn-block">

                            <i class="fas fa-filter"></i>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- ======================================================
         RESULTADO DA PESQUISA
         ====================================================== -->

    <?php if ($busca !== '' || $filtroMateria !== ''): ?>

        <div class="mb-3">

            <span class="text-gray-600">

                <i class="fas fa-search mr-1"></i>

                <?= count($anotacoesFiltradas) ?>

                anotação(ões) encontrada(s)

            </span>

            <a
                href="anotacoes.php"
                class="ml-2">

                Limpar filtros

            </a>

        </div>

    <?php endif; ?>



    <!-- ======================================================
         LISTA DE ANOTAÇÕES
         ====================================================== -->

    <?php if (empty($anotacoesFiltradas)): ?>


        <!-- ESTADO VAZIO -->

        <div class="card shadow">

            <div class="card-body text-center py-5">

                <div class="mb-4">

                    <i
                        class="fas fa-sticky-note fa-4x text-gray-300">
                    </i>

                </div>

                <h5 class="font-weight-bold text-gray-700">

                    <?php if ($busca !== '' || $filtroMateria !== ''): ?>

                        Nenhuma anotação encontrada.

                    <?php else: ?>

                        Você ainda não possui anotações.

                    <?php endif; ?>

                </h5>

                <p class="text-muted">

                    <?php if ($busca !== '' || $filtroMateria !== ''): ?>

                        Tente mudar os filtros ou realizar outra pesquisa.

                    <?php else: ?>

                        Crie sua primeira anotação para começar a organizar seus estudos.

                    <?php endif; ?>

                </p>


                <?php if ($busca === '' && $filtroMateria === ''): ?>

                    <button
                        class="btn btn-primary"
                        data-toggle="modal"
                        data-target="#modalNovaAnotacao">

                        <i class="fas fa-plus mr-1"></i>

                        Criar primeira anotação

                    </button>

                <?php endif; ?>

            </div>

        </div>


    <?php else: ?>


        <div class="row">


            <?php foreach ($anotacoesFiltradas as $anotacao): ?>


                <div class="col-xl-4 col-lg-6 mb-4">


                    <div class="card shadow h-100">


                        <!-- CABEÇALHO DO CARD -->

                        <div class="card-header py-3 d-flex justify-content-between align-items-center">

                            <div>

                                <?php if (!empty($anotacao['materia'])): ?>

                                    <span class="badge badge-primary">

                                        <i class="fas fa-book mr-1"></i>

                                        <?= limpar($anotacao['materia']) ?>

                                    </span>

                                <?php else: ?>

                                    <span class="badge badge-secondary">

                                        Sem matéria

                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- MENU -->

                            <div class="dropdown no-arrow">

                                <a
                                    class="dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">

                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>

                                </a>


                                <div
                                    class="dropdown-menu dropdown-menu-right shadow">

                                    <a
                                        class="dropdown-item"
                                        href="anotacoes.php?editar=<?= $anotacao['id'] ?>">

                                        <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>

                                        Editar

                                    </a>


                                    <div class="dropdown-divider"></div>


                                    <a
                                        class="dropdown-item text-danger"
                                        href="anotacoes.php?excluir=<?= $anotacao['id'] ?>"
                                        onclick="return confirm('Tem certeza que deseja excluir esta anotação?');">

                                        <i class="fas fa-trash fa-sm fa-fw mr-2"></i>

                                        Excluir

                                    </a>

                                </div>

                            </div>

                        </div>


                        <!-- CONTEÚDO -->

                        <div class="card-body">


                            <h5 class="font-weight-bold text-gray-800">

                                <?= limpar($anotacao['titulo']) ?>

                            </h5>


                            <hr>


                            <div
                                class="text-gray-700"
                                style="white-space: pre-line;">

                                <?= limpar($anotacao['conteudo']) ?>

                            </div>


                        </div>


                        <!-- RODAPÉ -->

                        <div class="card-footer bg-white">

                            <small class="text-muted">

                                <i class="far fa-clock mr-1"></i>

                                Criada em
                                <?= limpar($anotacao['criado_em']) ?>

                            </small>


                            <?php if (!empty($anotacao['editado_em'])): ?>

                                <br>

                                <small class="text-muted">

                                    <i class="fas fa-edit mr-1"></i>

                                    Editada em
                                    <?= limpar($anotacao['editado_em']) ?>

                                </small>

                            <?php endif; ?>

                        </div>


                    </div>

                </div>


            <?php endforeach; ?>


        </div>

    <?php endif; ?>


</div>



<!-- ==========================================================
     MODAL NOVA ANOTAÇÃO
     ========================================================== -->

<div
    class="modal fade"
    id="modalNovaAnotacao"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">

    <div
        class="modal-dialog modal-lg"
        role="document">

        <div class="modal-content">


            <!-- HEADER -->

            <div class="modal-header">

                <h5 class="modal-title font-weight-bold text-primary">

                    <i class="fas fa-sticky-note mr-2"></i>

                    Nova anotação

                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <!-- FORM -->

            <form method="POST">

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="acao"
                        value="nova">


                    <!-- TÍTULO -->

                    <div class="form-group">

                        <label class="font-weight-bold">

                            Título da anotação

                        </label>

                        <input
                            type="text"
                            name="titulo"
                            class="form-control"
                            placeholder="Ex.: Resumo da aula de Matemática"
                            required>

                    </div>


                    <!-- MATÉRIA -->

                    <div class="form-group">

                        <label class="font-weight-bold">

                            Matéria

                        </label>

                        <input
                            type="text"
                            name="materia"
                            class="form-control"
                            placeholder="Ex.: Matemática">

                        <small class="form-text text-muted">

                            Depois podemos substituir este campo por uma lista
                            das matérias cadastradas no seu sistema.

                        </small>

                    </div>


                    <!-- CONTEÚDO -->

                    <div class="form-group mb-0">

                        <label class="font-weight-bold">

                            Anotação

                        </label>

                        <textarea
                            name="conteudo"
                            class="form-control"
                            rows="10"
                            placeholder="Escreva sua anotação aqui..."
                            required></textarea>

                    </div>

                </div>


                <!-- FOOTER -->

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        Cancelar

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-save mr-1"></i>

                        Salvar anotação

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- ==========================================================
     MODAL DE EDIÇÃO
     ========================================================== -->

<?php if ($anotacaoEditar): ?>

    <div
        class="modal fade"
        id="modalEditarAnotacao"
        tabindex="-1"
        role="dialog"
        aria-hidden="true">

        <div
            class="modal-dialog modal-lg"
            role="document">

            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title font-weight-bold text-primary">

                        <i class="fas fa-edit mr-2"></i>

                        Editar anotação

                    </h5>

                    <a
                        href="anotacoes.php"
                        class="close">

                        <span>&times;</span>

                    </a>

                </div>


                <form method="POST">

                    <div class="modal-body">

                        <input
                            type="hidden"
                            name="acao"
                            value="editar">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= $anotacaoEditar['id'] ?>">


                        <div class="form-group">

                            <label class="font-weight-bold">

                                Título

                            </label>

                            <input
                                type="text"
                                name="titulo"
                                class="form-control"
                                value="<?= limpar($anotacaoEditar['titulo']) ?>"
                                required>

                        </div>


                        <div class="form-group">

                            <label class="font-weight-bold">

                                Matéria

                            </label>

                            <input
                                type="text"
                                name="materia"
                                class="form-control"
                                value="<?= limpar($anotacaoEditar['materia']) ?>">

                        </div>


                        <div class="form-group mb-0">

                            <label class="font-weight-bold">

                                Anotação

                            </label>

                            <textarea
                                name="conteudo"
                                class="form-control"
                                rows="10"
                                required><?= limpar($anotacaoEditar['conteudo']) ?></textarea>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <a
                            href="anotacoes.php"
                            class="btn btn-secondary">

                            Cancelar

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="fas fa-save mr-1"></i>

                            Salvar alterações

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- ABRIR MODAL AUTOMATICAMENTE -->

    <script>

        $(document).ready(function() {

            $('#modalEditarAnotacao').modal('show');

        });

    </script>

<?php endif; ?>



<?php include "footer.php"; ?>
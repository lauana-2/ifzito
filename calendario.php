<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || empty($_SESSION['id_estudante'])) {
    header('Location: formLogin.php');
    exit;
}

require_once 'conexaoBD.php';

$idEstudante = (int) $_SESSION['id_estudante'];

$mes = isset($_GET['mes']) ? (int) $_GET['mes'] : (int) date('m');
$ano = isset($_GET['ano']) ? (int) $_GET['ano'] : (int) date('Y');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_evento'])) {

    $idEvento = (int) $_POST['id_evento'];

    $sqlExcluir = 'DELETE FROM eventos WHERE id_evento = ? AND id_estudante = ?';
    $stmtExcluir = mysqli_prepare($conn, $sqlExcluir);

    if ($stmtExcluir) {
        mysqli_stmt_bind_param($stmtExcluir, 'ii', $idEvento, $idEstudante);
        mysqli_stmt_execute($stmtExcluir);
        mysqli_stmt_close($stmtExcluir);
    }

    header('Location: calendario.php?mes=' . $mes . '&ano=' . $ano . '&excluido=1');
    exit;
}

if ($mes < 1 || $mes > 12) {
    $mes = (int) date('m');
}

if ($ano < 2000 || $ano > 2100) {
    $ano = (int) date('Y');
}

$mensagemErro = '';

/* Salva o evento antes de enviar qualquer HTML. */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaData = $_POST['data'] ?? '';
    $novoTitulo = trim($_POST['titulo'] ?? '');
    $novaDescricao = trim($_POST['descricao'] ?? '');

    $dataValida = DateTime::createFromFormat('Y-m-d', $novaData);
    $dataEhValida = $dataValida && $dataValida->format('Y-m-d') === $novaData;

    if (!$dataEhValida || $novoTitulo === '') {
        $mensagemErro = 'Informe uma data válida e um título para o evento.';
    } else {
        $sqlInserir = 'INSERT INTO eventos (id_estudante, data_evento, titulo, descricao) VALUES (?, ?, ?, ?)';
        $stmt = mysqli_prepare($conn, $sqlInserir);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'isss', $idEstudante, $novaData, $novoTitulo, $novaDescricao);

            if (mysqli_stmt_execute($stmt)) {
                $mesEvento = (int) date('m', strtotime($novaData));
                $anoEvento = (int) date('Y', strtotime($novaData));
                mysqli_stmt_close($stmt);
                header('Location: calendario.php?mes=' . $mesEvento . '&ano=' . $anoEvento . '&salvo=1');
                exit;
            }

            mysqli_stmt_close($stmt);
        }

        $mensagemErro = 'Não foi possível salvar o evento. Verifique se a tabela eventos foi criada no banco de dados.';
    }
}

$inicioMes = sprintf('%04d-%02d-01', $ano, $mes);
$fimMes = date('Y-m-t', strtotime($inicioMes));

$sqlEventos = 'SELECT id_evento, data_evento, titulo, descricao
               FROM eventos
               WHERE id_estudante = ?
                 AND data_evento BETWEEN ? AND ?
               ORDER BY data_evento ASC, id_evento ASC';

$stmtEventos = mysqli_prepare($conn, $sqlEventos);
$eventosPorData = [];

if ($stmtEventos) {
    mysqli_stmt_bind_param($stmtEventos, 'iss', $idEstudante, $inicioMes, $fimMes);
    mysqli_stmt_execute($stmtEventos);
    $resultadoEventos = mysqli_stmt_get_result($stmtEventos);

    while ($evento = mysqli_fetch_assoc($resultadoEventos)) {
        $eventosPorData[$evento['data_evento']][] = $evento;
    }

    mysqli_stmt_close($stmtEventos);
}

$diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
$primeiroDia = (int) date('N', strtotime($inicioMes));

$mesAnterior = $mes - 1;
$anoAnterior = $ano;
if ($mesAnterior === 0) {
    $mesAnterior = 12;
    $anoAnterior--;
}

$proximoMes = $mes + 1;
$proximoAno = $ano;
if ($proximoMes === 13) {
    $proximoMes = 1;
    $proximoAno++;
}

$nomesMeses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];

include 'header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <a class="btn btn-success mb-2" href="calendario.php?mes=<?php echo $mesAnterior; ?>&ano=<?php echo $anoAnterior; ?>" aria-label="Mês anterior">
            <i class="fas fa-chevron-left"></i>
        </a>

        <div class="text-center mb-2">
            <h1 class="h3 mb-1 text-gray-800">Calendário</h1>
            <h2 class="h5 mb-0"><?php echo $nomesMeses[$mes]; ?> / <?php echo $ano; ?></h2>
        </div>

        <a class="btn btn-success mb-2" href="calendario.php?mes=<?php echo $proximoMes; ?>&ano=<?php echo $proximoAno; ?>" aria-label="Próximo mês">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>

    <?php if (isset($_GET['salvo'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Evento salvo com sucesso!
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['excluido'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Evento excluído com sucesso!
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

    <?php if ($mensagemErro !== ''): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($mensagemErro, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body p-2 p-md-3">
            <div class="table-responsive calendario-responsivo">
                <table class="table table-bordered bg-white mb-0 calendario-tabela">
                    <thead class="thead-dark">
                        <tr>
                            <th>Seg</th>
                            <th>Ter</th>
                            <th>Qua</th>
                            <th>Qui</th>
                            <th>Sex</th>
                            <th>Sáb</th>
                            <th>Dom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            for ($i = 1; $i < $primeiroDia; $i++) {
                                echo '<td class="dia-vazio"></td>';
                            }

                            $contador = $primeiroDia;

                            for ($dia = 1; $dia <= $diasNoMes; $dia++) {
                                $dataAtual = sprintf('%04d-%02d-%02d', $ano, $mes, $dia);
                                $classeHoje = ($dataAtual === date('Y-m-d')) ? ' hoje' : '';

                                echo '<td class="dia-calendario' . $classeHoje . '">';
                                echo '<div class="d-flex justify-content-between align-items-start">';
                                echo '<span class="font-weight-bold">' . $dia . '</span>';
                                echo '<button type="button" class="btn btn-sm btn-success botao-adicionar-evento"'
                                    . ' data-toggle="modal" data-target="#modalEvento"'
                                    . ' data-data="' . htmlspecialchars($dataAtual, ENT_QUOTES, 'UTF-8') . '"'
                                    . ' title="Adicionar evento em ' . $dia . '">+</button>';
                                echo '</div>';

                                if (!empty($eventosPorData[$dataAtual])) {
                                    foreach ($eventosPorData[$dataAtual] as $evento) {
                                        echo '<div class="evento-calendario">';
                                        echo '<div class="d-flex justify-content-between align-items-start">';
                                        echo '<strong>' . htmlspecialchars($evento['titulo'], ENT_QUOTES, 'UTF-8') . '</strong>';

                                        echo '<form method="post" action="calendario.php?mes=' . $mes . '&ano=' . $ano . '"'
                                            . ' onsubmit="return confirm(\'Tem certeza que deseja excluir este evento?\');"'
                                            . ' class="ml-2 mb-0">';

                                        echo '<input type="hidden" name="id_evento" value="' . (int) $evento['id_evento'] . '">';
                                        echo '<button type="submit" name="excluir_evento" class="btn btn-sm btn-danger" title="Excluir evento">';
                                        echo '<i class="fas fa-trash"></i>';
                                        echo '</button>';

                                        echo '</form>';
                                        echo '</div>';

                                        if (trim((string) $evento['descricao']) !== '') {
                                            echo '<div class="descricao-evento">'
                                                . nl2br(htmlspecialchars($evento['descricao'], ENT_QUOTES, 'UTF-8'))
                                                . '</div>';
                                        }

                                        echo '</div>';
                                    }
                                }

                                echo '</td>';

                                if ($contador % 7 === 0 && $dia !== $diasNoMes) {
                                    echo '</tr><tr>';
                                }

                                $contador++;
                            }

                            while (($contador - 1) % 7 !== 0) {
                                echo '<td class="dia-vazio"></td>';
                                $contador++;
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal do Bootstrap 4 -->
<div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="tituloModalEvento" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="calendario.php?mes=<?php echo $mes; ?>&ano=<?php echo $ano; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalEvento">Novo evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="dataEvento">Data</label>
                        <input type="date" name="data" id="dataEvento" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tituloEvento">Título</label>
                        <input type="text" name="titulo" id="tituloEvento" class="form-control" maxlength="150" required autocomplete="off">
                    </div>

                    <div class="form-group mb-0">
                        <label for="descricaoEvento">Descrição / anotações</label>
                        <textarea name="descricao" id="descricaoEvento" class="form-control" rows="4" maxlength="1000"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .calendario-tabela th {
        min-width: 130px;
        text-align: center;
    }

    .calendario-tabela .dia-calendario,
    .calendario-tabela .dia-vazio {
        height: 150px;
        vertical-align: top;
    }

    .calendario-tabela .hoje {
        background: #fff3cd;
    }

    .botao-adicionar-evento {
        width: 28px;
        height: 28px;
        padding: 0;
        line-height: 1;
        border-radius: 50%;
        font-size: 18px;
        font-weight: bold;
    }

    .evento-calendario {
        margin-top: 8px;
        padding: 6px;
        border-radius: 4px;
        background: #1cc88a;
        color: #fff;
        font-size: 12px;
        word-break: break-word;
    }

    .descricao-evento {
        margin-top: 3px;
        font-size: 11px;
        opacity: .95;
    }

    @media (max-width: 767.98px) {
        .calendario-tabela th {
            min-width: 115px;
        }
    }
</style>

<script>
// Bootstrap 4: o evento show.bs.modal informa qual botão abriu o modal.
$(document).ready(function () {
    $('#modalEvento').on('show.bs.modal', function (event) {
        var botao = $(event.relatedTarget);
        var data = botao.data('data');
        var modal = $(this);

        modal.find('#dataEvento').val(data);
        modal.find('#tituloEvento').val('');
        modal.find('#descricaoEvento').val('');
    });
});
</script>

<?php include 'footer.php'; ?>

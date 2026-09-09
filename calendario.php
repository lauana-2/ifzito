<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

$arquivo = "eventos.json";

if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}

$eventos = json_decode(file_get_contents($arquivo), true);
if (!is_array($eventos)) {
    $eventos = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaData = $_POST['data'] ?? '';
    $novoTitulo = trim($_POST['titulo'] ?? '');
    $novaDescricao = trim($_POST['descricao'] ?? '');

    if ($novaData !== '' && $novoTitulo !== '') {
        $eventos[] = [
            "data" => $novaData,
            "titulo" => $novoTitulo,
            "descricao" => $novaDescricao
        ];

        file_put_contents($arquivo, json_encode($eventos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        header("Location: calendario.php?mes=" . date('m', strtotime($novaData)) . "&ano=" . date('Y', strtotime($novaData)));
        exit;
    }
}

$mes = isset($_GET['mes']) ? intval($_GET['mes']) : (int) date("m");
$ano = isset($_GET['ano']) ? intval($_GET['ano']) : (int) date("Y");

if ($mes < 1 || $mes > 12) {
    $mes = (int) date('m');
}

if ($ano < 2000 || $ano > 2100) {
    $ano = (int) date('Y');
}

$diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
$primeiroDia = (int) date('N', strtotime(sprintf('%04d-%02d-01', $ano, $mes)));

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
    1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril",
    5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto",
    9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro"
];

include "header.php";
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a class="btn btn-primary" href="?mes=<?php echo $mesAnterior; ?>&ano=<?php echo $anoAnterior; ?>">◀</a>
        <h2 class="mb-0"><?php echo $nomesMeses[$mes]; ?> / <?php echo $ano; ?></h2>
        <a class="btn btn-primary" href="?mes=<?php echo $proximoMes; ?>&ano=<?php echo $proximoAno; ?>">▶</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered bg-white mb-0">
                    <thead class="table-dark">
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
                                echo '<td style="height:120px;"></td>';
                            }

                            $contador = $primeiroDia;

                            for ($dia = 1; $dia <= $diasNoMes; $dia++) {
                                $dataAtual = sprintf("%04d-%02d-%02d", $ano, $mes, $dia);
                                $classe = ($dataAtual === date("Y-m-d")) ? "hoje" : "";

                                echo '<td class="' . $classe . '" style="height:120px; vertical-align:top;">';
                                echo '<div class="font-weight-bold">' . $dia . '</div>';

                                foreach ($eventos as $evento) {
                                    if (($evento['data'] ?? '') === $dataAtual) {
                                        echo '<div class="small bg-primary text-white p-1 mt-1 rounded">';
                                        echo '<strong>' . htmlspecialchars($evento['titulo'] ?? '', ENT_QUOTES, 'UTF-8') . '</strong><br>';
                                        echo htmlspecialchars($evento['descricao'] ?? '', ENT_QUOTES, 'UTF-8');
                                        echo '</div>';
                                    }
                                }
                                ?>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-success mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEvento"
                                    data-data="<?php echo $dataAtual; ?>">
                                    +
                                </button>

                                <?php
                                echo '</td>';

                                if ($contador % 7 === 0) {
                                    echo '</tr><tr>';
                                }

                                $contador++;
                            }

                            while (($contador - 1) % 7 !== 0) {
                                echo '<td style="height:120px;"></td>';
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

<div class="modal fade" id="modalEvento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <label>Data</label>
                    <input type="date" name="data" id="dataEvento" class="form-control" required>

                    <label class="mt-3">Título</label>
                    <input type="text" name="titulo" class="form-control" required>

                    <label class="mt-3">Descrição</label>
                    <textarea name="descricao" class="form-control"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    td.hoje {
        background: #fff3cd;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-bs-target="#modalEvento"]').forEach(function (botao) {
            botao.addEventListener('click', function () {
                document.getElementById('dataEvento').value = this.getAttribute('data-data');
            });
        });
    });
</script>

<?php include "footer.php"; ?>

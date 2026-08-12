<?php include "header.php" ?>

            <?php
        $arquivo = "eventos.json";

        if (!file_exists($arquivo)) {
            file_put_contents($arquivo, json_encode([]));
        }

        $eventos = json_decode(file_get_contents($arquivo), true);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $novaData = $_POST['data'];
            $novoTitulo = $_POST['titulo'];
            $novaDescricao = $_POST['descricao'];

            $eventos[] = [
                "data" => $novaData,
                "titulo" => $novoTitulo,
                "descricao" => $novaDescricao
            ];

            file_put_contents($arquivo, json_encode($eventos, JSON_PRETTY_PRINT));

            header("Location: index.php?mes=" . date('m', strtotime($novaData)) . "&ano=" . date('Y', strtotime($novaData)));
            exit;
        }

        $mes = isset($_GET['mes']) ? intval($_GET['mes']) : date("m");
        $ano = isset($_GET['ano']) ? intval($_GET['ano']) : date("Y");

        $diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $primeiroDia = date('N', strtotime("$ano-$mes-01"));

        $mesAnterior = $mes - 1;
        $anoAnterior = $ano;

        if ($mesAnterior == 0) {
            $mesAnterior = 12;
            $anoAnterior--;
        }

        $proximoMes = $mes + 1;
        $proximoAno = $ano;

        if ($proximoMes == 13) {
            $proximoMes = 1;
            $proximoAno++;
        }

        $nomesMeses = [
        1=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho",
        "Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"
        ];
        ?>

        <!DOCTYPE html>
        <html lang="pt-br">
        <head>

        <meta charset="UTF-8">

        <title>Calendário PHP</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>

        td{
        height:120px;
        vertical-align:top;
        }

        .dia{
        font-weight:bold;
        }

        .evento{
        font-size:12px;
        background:#0d6efd;
        color:white;
        padding:3px;
        margin-top:3px;
        border-radius:5px;
        cursor:pointer;
        }

        .hoje{
        background:#fff3cd;
        }

        </style>

        </head>

        <body class="bg-light">

        <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

        <a class="btn btn-primary" href="?mes=<?=$mesAnterior?>&ano=<?=$anoAnterior?>">◀</a>

        <h2><?=$nomesMeses[$mes]?> / <?=$ano?></h2>

        <a class="btn btn-primary" href="?mes=<?=$proximoMes?>&ano=<?=$proximoAno?>">▶</a>

        </div>

        <table class="table table-bordered bg-white">

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

        for($i=1;$i<$primeiroDia;$i++){
            echo "<td></td>";
        }

        $contador = $primeiroDia;

        for($dia=1;$dia<=$diasNoMes;$dia++){

        $dataAtual = sprintf("%04d-%02d-%02d",$ano,$mes,$dia);

        $classe = "";

        if($dataAtual==date("Y-m-d")){
            $classe="hoje";
        }

        echo "<td class='$classe'>";

        echo "<div class='dia'>$dia</div>";

        foreach($eventos as $evento){

        if($evento['data']==$dataAtual){

        echo "<div class='evento'>";

        echo "<strong>".$evento['titulo']."</strong><br>";

        echo $evento['descricao'];

        echo "</div>";

        }

        }

        ?>

        <button
        class="btn btn-sm btn-success mt-2"
        data-bs-toggle="modal"
        data-bs-target="#modalEvento"
        data-data="<?=$dataAtual?>">
        +
        </button>

        <?php

        echo "</td>";

        if($contador%7==0){
        echo "</tr><tr>";
        }

        $contador++;

        }

        while(($contador-1)%7!=0){
        echo "<td></td>";
        $contador++;
        }

        ?>

        </tr>

        </tbody>

        </table>

        </div>


        <div class="modal fade" id="modalEvento">

        <div class="modal-dialog">

        <div class="modal-content">

        <form method="post">

        <div class="modal-header">

        <h5>Novo Evento</h5>

        <button class="btn-close" data-bs-dismiss="modal"></button>

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

        <button class="btn btn-primary">Salvar</button>

        </div>

        </form>

        </div>

        </div>

        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>

        var modal=document.getElementById('modalEvento');

        modal.addEventListener('show.bs.modal',function(event){

        var botao=event.relatedTarget;

        var data=botao.getAttribute('data-data');

        document.getElementById('dataEvento').value=data;

        });

        </script>
        <br>

        </body>
        </html>

<?php include "footer.php" ?>


<?php
    //Verifica se o método de envio do formEstudante é POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Cria variáveis para armazenar as informações passadas pelo $_POST[]
        $fotoEstudante = $nomeEstudante = $dataNascimentoEstudante = $cursoEstudante = $ano_estudante = $emailEstudante = $senhaEstudante = $pronome = $confirmarSenhaEstudante = " ";

        //Variável booleana para controle de erros de preenchimento
        $erroPreenchimento = false;

        //Validação do campo nomeEstudante
        //Utiliza a função empty() para verificar se o $_POST["nomeEstudante"] está vazio
        if(empty($_POST["nomeEstudante"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $nomeEstudante = filtrar_entrada($_POST["nomeEstudante"]);

            //Utiliza a função preg_match() para verificar se há apenas letras no nomeEstudante
            if(!preg_match('/^[\p{L} ]+$/u', $nomeEstudante)){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                $erroPreenchimento = true;
            }
        }

        //Validação do campo emailEstudante
        //Utiliza a função empty() para verificar se o $_POST["emailEstudante"] está vazio
        if(empty($_POST["emailEstudante"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $emailEstudante = filtrar_entrada($_POST["emailEstudante"]);
        }

        //Validação do campo dataNascimentoEstudante
        //Utiliza a função empty() para verificar se o $_POST["dataNascimentoEstudante"] está vazio
        if(empty($_POST["dataNascimentoEstudante"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DE NASCIMENTO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $dataNascimentoEstudante = filtrar_entrada($_POST["dataNascimentoEstudante"]);

            //Usa a função strlen() para verificar o comprimento da $dataNascimentoEstudante
            if(strlen($dataNascimentoEstudante) == 10){
                //Aplica a função substr() para gerar substrings de $dataNascimentoEstudante e armazenar em dia, mês e ano
                $diaNascimentoEstudante = substr($dataNascimentoEstudante, 8, 2);
                $mesNascimentoEstudante = substr($dataNascimentoEstudante, 5, 2);
                $anoNascimentoEstudante = substr($dataNascimentoEstudante, 0, 4);
            }
            else{
                echo "<div class='alert alert-warning text-center'><strong>DATA INVÁLIDA</strong></div>";
                $erroPreenchimento = true;
            }
        }

        //Validação do campo cursoEstudante
        //Utiliza a função empty() para verificar se o $_POST["cursoEstudante"] está vazio
        if(empty($_POST["cursoEstudante"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>CURSO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $cursoEstudante = filtrar_entrada($_POST["cursoEstudante"]);
        }

        //Validação do campo ano_estudante
        //Utiliza a função empty() para verificar se o $_POST["ano_estudante"] está vazio
        if(empty($_POST["ano_estudante"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>ANO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $ano_estudante = filtrar_entrada($_POST["ano_estudante"]);
        }


        //Validação do campo senhaEstudante
        //Utiliza a função empty() para verificar se o $_POST["senhaEstudante"] está vazio
        if(empty($_POST["senhaEstudante"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            //Usa a função md5() para criptografar a $senhaEstudante 
            $senhaEstudante = md5(filtrar_entrada($_POST["senhaEstudante"]));
        }

        //Validação do campo pronome
        //Utiliza a função empty() para verificar se o $_POST["pronome"] está vazio
        if (!isset($_POST["pronome"]) || trim($_POST["pronome"]) === "") {
            echo "<div class='alert alert-warning text-center'>
                    O campo <strong>PRONOME</strong> é obrigatório!
                </div>";
            $erroPreenchimento = true;
        } 
        else {
            $pronome = filtrar_entrada($_POST["pronome"]);
        }


        //Validação do campo confirmarSenhaEstudante
        //Utiliza a função empty() para verificar se o $_POST["confirmarSenhaEstudante"] está vazio
        if(empty($_POST["confirmarSenhaEstudante"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $confirmarSenhaEstudante = md5(filtrar_entrada($_POST["confirmarSenhaEstudante"]));

            //Verifica se a $senhaEstudante e $confirmarSenha usuário são diferentes
            if($senhaEstudante != $confirmarSenhaEstudante){
                echo "<div class='alert alert-warning text-center'>As <strong>SENHAS</strong> informadas são diferentes!</div>";
                $erroPreenchimento = true;
            }
        }


        //Início da validação do campo fotoEstudante
        $diretorio    = "img/"; //Define para qual diretório as imagens serão movidas
        $fotoEstudante  = $diretorio . basename($_FILES['fotoEstudante']['name']); //Montar o nome a ser salvo no BD (assets/img/nomeDoArquivo.jpg)
        $tipoDaImagem = strtolower(pathinfo($fotoEstudante, PATHINFO_EXTENSION)); //strtolower torna as letras minúsculas / pathinfo pega a extensão do arquivo
        $erroUpload   = false; //Variável para controle de erros do upload da fotoEstudante

        //Verifica se o tamanho do arquivo é diferente de ZERO
        if($_FILES['fotoEstudante']['size'] != 0){
            //Início das validações do campo fotoEstudante

            //Verifica se o tamanho da foto é maior do que 5MB (MegaBytes) [medida em bytes]
            if($_FILES['fotoEstudante']['size'] > 5000000){
                echo "<div class='alert alert-warning text-center'>O tamanho da <strong>FOTO</strong> deve ser menor do que 5MB!</div>";
                $erroUpload = true;
            }

            //Verifica se a imagem está nos formatos JPG, JPEG, PNG ou WEBP
            if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve estar nos formatos JPG, JPEG, PNG ou WEBP!</div>";
                $erroUpload = true;
            }

            //Verifica se a imagem foi movida para o diretório (assets/img), utilizando a função move_uploaded_file()
            if(!move_uploaded_file($_FILES['fotoEstudante']['tmp_name'], $fotoEstudante)){
                echo "<div class='alert alert-danger text-center'>Erro ao tentar mover a <strong>FOTO</strong> para o diretório $diretorio!</div>";
                $erroUpload = true;
            }
        }
        else{
            echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> é obrigatória!</div>";
            $erroUpload = true;
        }

        //Verifica se não há erros de preenchimento ou erros de upload da foto
        if(!$erroPreenchimento && !$erroUpload){

            //Cria uma variável para armazenar a QUERY que realiza a inserção de dados do Usuário na tabela Estudantes
            $inserirEstudante = "INSERT INTO estudantes (fotoEstudante, nomeEstudante, dataNascimentoEstudante, cursoEstudante, ano_estudante, emailEstudante, senhaEstudante, pronome)
                                            VALUES ('$fotoEstudante', '$nomeEstudante', '$dataNascimentoEstudante', '$cursoEstudante', $ano_estudante, '$emailEstudante', '$senhaEstudante' , '$pronome')";

            //Inclui o arquivo de conexão com o Banco de Dados
            include "conexaoBD.php";
            
            if(mysqli_query($conn, $inserirEstudante)){
            ?>

            <!DOCTYPE html>
            <html lang="pt-br">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <title>Cadastro realizado</title>

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>

            <body>

                <div class="container mt-5 mb-5">

                    <div class="card shadow mx-auto" style="max-width: 600px;">

                        <div class="card-body">

                            <h2 class="text-center mb-4">
                                Cadastro realizado com sucesso! 🎉
                            </h2>

                            <div class="text-center mb-4">

                                <img 
                                    src="<?php echo $fotoEstudante; ?>"
                                    alt="Foto de <?php echo $nomeEstudante; ?>"
                                    style="width:150px; height:150px; object-fit:cover;"
                                    class="img-thumbnail"
                                >

                            </div>

                            <table class="table table-bordered">

                                <tr>
                                    <th>Nome</th>
                                    <td><?php echo $nomeEstudante; ?></td>
                                </tr>

                                <tr>
                                    <th>Data de nascimento</th>
                                    <td>
                                        <?php 
                                        echo "$diaNascimentoEstudante/$mesNascimentoEstudante/$anoNascimentoEstudante";
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Curso</th>
                                    <td><?php echo $cursoEstudante; ?></td>
                                </tr>

                                <tr>
                                    <th>Série</th>
                                    <td><?php echo $ano_estudante; ?>° ano</td>
                                </tr>

                                <tr>
                                    <th>E-mail</th>
                                    <td><?php echo $emailEstudante; ?></td>
                                </tr>

                                <tr>
                                    <th>Pronome</th>
                                    <td><?php echo $pronome; ?></td>
                                </tr>

                            </table>

                            <div class="text-center mt-4">

                                <a href="formLogin.php" class="btn btn-dark">
                                    Ir para o Login
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </body>

            </html>

            <?php
            }
            else{
                echo "<div class='alert alert-danger text-center'>
                        Erro ao tentar cadastrar <strong>USUÁRIO</strong> no banco de dados.
                    </div>";
            }
        }
    }

    //Função para filtrar entrada de dados
    function filtrar_entrada($dado){
        $dado = trim($dado); //Remove espaços desnecessários
        $dado = stripslashes($dado); //Remove barras invertidas
        $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

        //Após filtrado, o dado é retornado
        return($dado);
    }
?>

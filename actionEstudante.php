<?php include "header.php" ?>

<?php
    //Verifica se o método de envio do formEstudante é POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Cria variáveis para armazenar as informações passadas pelo $_POST[]
        $fotoEstudante = $nomeEstudante = $dataNascimentoEstudante = $emailEstudante = $senhaEstudante = $confirmarSenhaEstudante = "";

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
            $inserirEstudante = "INSERT INTO estudantes (fotoEstudante, nomeEstudante, dataNascimentoEstudante, emailEstudante, senhaEstudante)
                                            VALUES ('$fotoEstudante', '$nomeEstudante', '$dataNascimentoEstudante', '$emailEstudante', '$senhaEstudante')";

            //Inclui o arquivo de conexão com o Banco de Dados
            include "conexaoBD.php";

            //A função mysqli_connect() executa a QUERY no BD
            //Se conseguir executar a QUERY, exibe alerta de sucesso e a tabela com os dados cadastrados
            if(mysqli_query($conn, $inserirEstudante)){

                echo "<div class='alert alert-success text-center'>Os dados do <strong>USUÁRIO</strong> foram cadastrados com sucesso!</div>";
                echo "
                    <div class='container mt-3 mb-3'>
                        <div class='container mt-3 mb-3 text-center'>
                            <img src='$fotoEstudante' title='Foto de $nomeEstudante' style='width:150px' class='img-thumbnail'>
                        </div>
                        <table class='table'>
                            <tr>
                                <th>NOME</th>
                                <td>$nomeEstudante</td>
                            </tr>
                            <tr>
                                <th>DATA DE NASCIMENTO</th>
                                <td>$diaNascimentoEstudante/$mesNascimentoEstudante/$anoNascimentoEstudante</td>
                            </tr>
                            <tr>
                                <th>EMAIL</th>
                                <td>$emailEstudante</td>
                            </tr>
                            <tr>
                                <th>SENHA</th>
                                <td>$senhaEstudante</td>
                            </tr>
                            <tr>
                                <th>CONFIRMAR SENHA</th>
                                <td>$confirmarSenhaEstudante</td>
                            </tr>
                        </table>
                    </div>
                ";
            }
            else{
                echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>USUÁRIO</strong> no banco de dados $database!</div>";
            }
        }


    }
    else{
        //Usa a função header() para redirecionar o usuário para o formEstudante.php
        header("location:formEstudante.php");
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

<?php include "footer.php" ?>
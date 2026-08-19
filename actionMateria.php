<?php include "header.php" ?>

<?php
    //Verifica se o método de envio do formMateria é POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Cria variáveis para armazenar as informações passadas pelo $_POST[]
        $nomeMateria = $nomeProfessor = "";

        //Variável booleana para controle de erros de preenchimento
        $erroPreenchimento = false;

        //Validação do campo nomeMateria
        //Utiliza a função empty() para verificar se o $_POST["nomeMateria"] está vazio
        if(empty($_POST["nomeMateria"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $nomeMateria = filtrar_entrada($_POST["nomeMateria"]);

            //Utiliza a função preg_match() para verificar se há apenas letras no nomeMateria
            if(!preg_match('/^[\p{L} ]+$/u', $nomeMateria)){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME DA MATÉRIA</strong> deve conter apenas letras!</div>";
                $erroPreenchimento = true;
            }
        }

        //Validação do campo nomeProfessor
        //Utiliza a função empty() para verificar se o $_POST["nomeProfessor"] está vazio
        if(empty($_POST["nomeProfessor"])){
            //Se estiver vazio, exibe alerta e altera a variável $erroPreenchimento para true
            echo "<div class='alert alert-warning text-center'>O campo <strong>NOME PROFESSOR</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Se não estiver vazio, o dado é filtrado e armazenado na variável PHP
            $nomeProfessor = filtrar_entrada($_POST["nomeProfessor"]);
        }


        //Verifica se não há erros de preenchimento ou erros de upload da foto
        if(!$erroPreenchimento && !$erroUpload){

            //Cria uma variável para armazenar a QUERY que realiza a inserção de dados do Usuário na tabela Materias
            $inserirMateria = "INSERT INTO materias (nomeMateria, nomeProfessor)
                                            VALUES ('$nomeMateria', '$nomeProfessor')";

            //Inclui o arquivo de conexão com o Banco de Dados
            include "conexaoBD.php";

            //A função mysqli_connect() executa a QUERY no BD
            //Se conseguir executar a QUERY, exibe alerta de sucesso e a tabela com os dados cadastrados
            if(mysqli_query($conn, $inserirMateria)){

                echo "<div class='alert alert-success text-center'>Os dados do <strong>USUÁRIO</strong> foram cadastrados com sucesso!</div>";
                echo "
                    <div class='container mt-3 mb-3'>
                        <table class='table'>
                            <tr>
                                <th>NOME</th>
                                <td>$nomeMateria</td>
                            </tr>
                            <tr>
                                <th>PROFESSOR</th>
                                <td>$nomeProfessor</td>
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
        //Usa a função header() para redirecionar o usuário para o novaMateria.php
        header("location:novaMateria.php");
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
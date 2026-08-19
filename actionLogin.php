<?php

    include "conexaoBD.php"; //Inclui o arquivo de conexão com o BD para consultar usuários
    session_start(); //Função para iniciar uma sessão

    $emailEstudante = mysqli_real_escape_string($conn, $_POST['emailEstudante']); //Filtra a entrada de dados
    $senhaEstudante = mysqli_real_escape_string($conn, $_POST['senhaEstudante']);

    //QUERY para buscar dados de login
    $buscarLogin = "SELECT *
                    FROM Estudantes
                    WHERE emailEstudante = '$emailEstudante'
                    AND senhaEstudante = md5('$senhaEstudante') ";

    //Executa a QUERY
    $efetuarLogin = mysqli_query($conn, $buscarLogin);

    //Verifica se a consulta encontrou algum registro associado
    if($registro = mysqli_fetch_assoc($efetuarLogin)){
        //Criar variáveis de sessão
        $_SESSION['id_estudante']   = $registro['id_estudante'];
        $_SESSION['fotoEstudante']  = $registro['fotoEstudante'];
        $_SESSION['nomeEstudante']  = $registro['nomeEstudante'];
        $_SESSION['emailEstudante'] = $registro['emailEstudante'];
        $_SESSION['logado']       = true;

        //Redireciona o usuário para a página inicial
        header("Location: home.php");
        exit();
    }
    else{
        //Redireciona o usuário para a o formLogin
        header("Location: formLogin.php?erroLogin=dadosInvalidos");
        exit();
    }


?>
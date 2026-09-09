<?php
error_reporting(0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('America/Sao_Paulo');

if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    $id_estudante   = $_SESSION['id_estudante'] ?? null;
    $fotoEstudante  = $_SESSION['fotoEstudante'] ?? '';
    $nomeEstudante  = $_SESSION['nomeEstudante'] ?? '';
    $emailEstudante = $_SESSION['emailEstudante'] ?? '';

    $nomeCompleto = explode(' ', trim($nomeEstudante));
    $primeiroNome = $nomeCompleto[0] ?? '';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IFzito</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        /* Sidebar padronizada para todas as telas */
        .sidebar .sidebar-brand {
            height: auto;
            min-height: 105px;
            padding: 1rem;
        }

        .sidebar .sidebar-brand-text {
            font-weight: 800;
            letter-spacing: 1px;
            font-size: 18px;
            text-align: center;
            color: #fff;
        }

        .sidebar .nav-link {
            display: flex !important;
            align-items: center;
        }

        .sidebar .nav-link > i:first-child {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }

        .sidebar .nav-link .menu-arrow {
            width: auto;
            margin-left: auto;
            margin-right: 0;
            font-size: 12px;
        }
    </style>
</head>

<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Logo -->
        <br>
        <br>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
            <div class="sidebar-brand-text">
                <img src="img/logo_IF_branco.png" style="width:50px;" alt="Logo IFzito">
                <br>
                IFzito
            </div>
        </a>

        <hr class="sidebar-divider">

        <!-- Navegação -->
        <div class="sidebar-heading">
            Navegue pelo site
        </div>

        <li class="nav-item">
            <a class="nav-link" href="home.php">
                <i class="fas fa-book"></i>
                <span>Disciplinas</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="tarefas.php">
                <i class="fas fa-tasks"></i>
                <span>Tarefas</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="calendario.php?mes=<?php echo date('m'); ?>&ano=<?php echo date('Y'); ?>">
                <i class="fas fa-calendar-alt"></i>
                <span>Calendário</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle" type="button"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
             

            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <div class="topbar-divider d-none d-sm-block"></div>

                <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                    <?php if (!empty($fotoEstudante)): ?>
                        <img class="img-profile rounded-circle mr-3"
                             src="<?php echo htmlspecialchars($fotoEstudante, ENT_QUOTES, 'UTF-8'); ?>"
                             style="width:30px; height:30px;"
                             alt="Foto do perfil">
                    <?php endif; ?>

                 <div class="d-flex align-items-center mr-4">
                    <span class="mr-3 font-weight-bold text-gray-800">
                        Olá,
                        <?php echo htmlspecialchars($primeiroNome, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                </div>

                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" type="button">
                    <i class="fa fa-bars"></i>
                </button>

                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"></form>
                <div style="margin: 15px;">
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        Sair
                    </a>
                </div>
                <?php else: ?>
                    <a href="formLogin.php" class="btn btn-success">Login</a>
                <?php endif; ?>

            </nav>
            <!-- End of Topbar -->


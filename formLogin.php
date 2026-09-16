<style>
.auth-page {
    min-height: calc(100vh - 140px);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 3rem 1rem;
    background: #f8f9fc;
}

.auth-card {
    width: 100%;
    max-width: 440px;
    background: #fff;
    border: 1px solid #e3e6f0;
    border-top: 5px solid #006B3F;
    border-radius: .5rem;
    padding: 2rem;
    box-shadow: 0 .35rem 1rem rgba(58,59,69,.10);
}

.auth-header {
    text-align: center;
    margin-bottom: 1.8rem;
}

.auth-logo {
    width: 58px;
    height: 58px;
    padding: 10px;
    margin-bottom: 1rem;
    background: #006B3F;
    border-radius: 50%;
}

.auth-kicker {
    display: block;
    color: #006B3F;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .05em;
    text-transform: uppercase;
    margin-bottom: .4rem;
}

.auth-header h2 {
    color: #343a40;
    font-size: 1.65rem;
    font-weight: 700;
    margin-bottom: .45rem;
}

.auth-header p {
    color: #6c757d;
    font-size: .9rem;
}

.auth-form .form-group {
    margin-bottom: 1.15rem;
}

.auth-form label {
    display: block;
    color: #343a40;
    font-size: .85rem;
    font-weight: 600;
    margin-bottom: .4rem;
}

.auth-form label i {
    color: #006B3F;
}

.auth-form .form-control {
    height: 44px;
    border: 1px solid #ced4da;
    border-radius: .35rem;
    font-size: .9rem;
}

.auth-form .form-control:focus {
    border-color: #73B799;
    box-shadow: 0 0 0 .2rem rgba(0,107,63,.12);
}

.auth-button {
    height: 45px;
    margin-top: .5rem;
    font-weight: 700;
}

.auth-footer {
    text-align: center;
    border-top: 1px solid #eef0f3;
    margin-top: 1.5rem;
    padding-top: 1.2rem;
    color: #6c757d;
    font-size: .88rem;
}

.auth-footer a {
    color: #006B3F;
    font-weight: 700;
}
</style>
<?php include "topBar.php" ?>


    <?php
        //Verifica se há alguma passagem de parâmetro via método GET chamada 'erroLogin'
        if(isset($_GET['erroLogin'])){
            $erroLogin = $_GET['erroLogin'];

            if($erroLogin == 'dadosInvalidos'){
                echo "<div class='alert alert-warning text-center'>EMAIL ou SENHA inválidos!</div>";
            }
        }
    ?>
        
    <div class="auth-page">

        <div class="auth-card">

            <div class="auth-header">
                <img src="img/logo_IF_branco.png" alt="Logo IFzito" class="auth-logo">
                <span class="auth-kicker">IFzito - Um sistema de organização estudantil IFPR</span>
                <h2>Acessar o sistema</h2>
                <p>Entre com seus dados para acessar o IFzito.</p>
            </div>

            <?php 
                if(isset($_GET['erroLogin'])){ 
                    $erroLogin = $_GET['erroLogin']; 

                    if($erroLogin == 'dadosInvalidos'){ 
                        echo "<div class='alert alert-warning text-center'>E-mail ou senha inválidos!</div>"; 
                    } 
                } 
            ?>

            <form action="actionLogin.php" method="POST" class="auth-form">

                <div class="form-group">
                    <label for="emailEstudante">
                        <i class="fas fa-envelope mr-1"></i>
                        E-mail
                    </label>

                    <input type="email"
                        name="emailEstudante"
                        id="emailEstudante"
                        placeholder="Digite seu e-mail"
                        class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label for="senhaEstudante">
                        <i class="fas fa-lock mr-1"></i>
                        Senha
                    </label>

                    <input type="password"
                        name="senhaEstudante"
                        id="senhaEstudante"
                        placeholder="Digite sua senha"
                        class="form-control"
                        minlength="3"
                        maxlength="8"
                        required>
                </div>

                <button type="submit" class="btn btn-success btn-block auth-button">
                    <i class="fas fa-sign-in-alt mr-1"></i>
                    Entrar
                </button>

            </form>

            <div class="auth-footer">
                <span>Ainda não possui uma conta?</span>
                <a href="formEstudante.php">
                    Cadastre-se
                </a>
            </div>

        </div>

    </div>

<?php include "bottomBar.php" ?>

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

<?php include "topbar.php" ?>
    
    
 <div class="auth-page">

    <div class="auth-card auth-card-cadastro">

        <div class="auth-header">
            <img src="img/logo_IF_branco.png" alt="Logo IFzito" class="auth-logo">
            <span class="auth-kicker">IFzito - Um sistema de organização estudantil IFPR</span>
            <h2>Crie sua conta</h2>
            <p>Preencha seus dados para começar a usar o IFzito.</p>
        </div>

        <form action="actionEstudante.php"
              method="POST"
              class="auth-form"
              enctype="multipart/form-data">

            <div class="form-group">
                <label for="fotoEstudante">
                    <i class="fas fa-camera mr-1"></i>
                    Foto
                </label>

                <input type="file"
                       name="fotoEstudante"
                       id="fotoEstudante"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="nomeEstudante">
                    <i class="fas fa-user mr-1"></i>
                    Nome completo
                </label>

                <input type="text"
                       name="nomeEstudante"
                       id="nomeEstudante"
                       placeholder="Digite seu nome completo"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="dataNascimentoEstudante">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Data de nascimento
                </label>

                <input type="date"
                       name="dataNascimentoEstudante"
                       id="dataNascimentoEstudante"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="cursoEstudante">
                    <i class="fas fa-graduation-cap mr-1"></i>
                    Curso
                </label>

                <select name="cursoEstudante"
                        id="cursoEstudante"
                        class="form-control">

                    <option value="TECINF" selected>
                        Técnico em Informática para Internet
                    </option>

                    <option value="TECJOG">
                        Técnico em Programação de Jogos Digitais
                    </option>

                    <option value="TECMEC">
                        Técnico em Mecânica
                    </option>

                    <option value="TECAUT">
                        Técnico em Automação Industrial
                    </option>

                    <option value="TECELE">
                        Técnico em Eletrotécnica
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label for="ano_estudante">
                    <i class="fas fa-layer-group mr-1"></i>
                    Série
                </label>

                <select name="ano_estudante"
                        id="ano_estudante"
                        class="form-control">

                    <option value="1">1° ano</option>
                    <option value="2">2° ano</option>
                    <option value="3">3° ano</option>
                    <option value="4">4° ano</option>

                </select>
            </div>

            <div class="form-group">
                <label for="emailEstudante">
                    <i class="fas fa-envelope mr-1"></i>
                    E-mail
                </label>

                <input type="email"
                       name="emailEstudante"
                       id="emailEstudante"
                       placeholder="Digite seu e-mail"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="pronome">
                    <i class="fas fa-comment mr-1"></i>
                    Pronome
                </label>

                <select name="pronome"
                        id="pronome"
                        class="form-control">

                    <option value="Ele">Ele/dele</option>
                    <option value="Ela">Ela/dela</option>
                    <option value="Elu">Elu/delu</option>
                    <option value="Nulo">Não informar</option>

                </select>
            </div>

            <div class="form-group">
                <label for="senhaEstudante">
                    <i class="fas fa-lock mr-1"></i>
                    Senha
                </label>

                <input type="password"
                       name="senhaEstudante"
                       id="senhaEstudante"
                       placeholder="Crie uma senha"
                       class="form-control"
                       minlength="3"
                       maxlength="8">
            </div>

            <div class="form-group">
                <label for="confirmarSenhaEstudante">
                    <i class="fas fa-lock mr-1"></i>
                    Confirmar senha
                </label>

                <input type="password"
                       name="confirmarSenhaEstudante"
                       id="confirmarSenhaEstudante"
                       placeholder="Digite a senha novamente"
                       class="form-control"
                       minlength="3"
                       maxlength="8">
            </div>

            <button type="submit" class="btn btn-success btn-block auth-button">
                <i class="fas fa-user-plus mr-1"></i>
                Criar minha conta
            </button>

        </form>

        <div class="auth-footer">
            <span>Já possui uma conta?</span>
            <a href="formLogin.php">
                Voltar para o login
            </a>
        </div>

    </div>

</div>
<?php include "bottomBar.php" ?>
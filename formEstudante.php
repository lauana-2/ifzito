<?php include "topbar.php" ?>
    
    
    <div class="d-flex justify-content-center">
        <h2>Cadastre-se:</h2>
    </div>

    <div class="d-flex justify-content-center">
        <form action="actionEstudante.php" method="POST" class="was-validated" enctype="multipart/form-data">
            
            <div class="form-floating mt-3 mb-3">
                <input type="file" name="fotoEstudante" id="fotoEstudante" placeholder="Foto" class="form-control">
                <label for="fotoEstudante">Foto</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="nomeEstudante" id="nomeEstudante" placeholder="Nome Completo" class="form-control">
                <label for="nomeEstudante">Nome</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="date" name="dataNascimentoEstudante" id="dataNascimentoEstudante" placeholder="Data de Nascimento" class="form-control">
                <label for="dataNascimentoEstudante">Data de Nascimento</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <select name="cursoEstudante" id="cursoEstudante" placeholder="Pronome" class="form-control">
                    <option value="TECINF" selected>Técnico em Informática para Internet</option>
                    <option value="TECJOG">Técnico em Programação de Jogos Digitais</option>
                    <option value="TECMEC">Técnico em Mecânica</option>
                    <option value="TECAUT">Técnico em Automação Industrial</option>
                    <option value="TECELE">Técnico em Eletrotécnica</option>
                </select>
                <label for="Pronome">Selecione o seu curso</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

             <div class="form-floating mt-3 mb-3">
                <select name="ano_estudante" id="ano_estudante" placeholder="Série" class="form-control">
                    <option value="PrimeiroAno">1° ano</option>
                    <option value="SegundoAno">2° ano</option>
                    <option value="TerceiroAno">3° ano</option>
                    <option value="QuartoAno">4° ano</option>
                </select>
                <label for="Série">Selecione sua série:</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>


            <div class="form-floating mt-3 mb-3">
                <input type="email" name="emailEstudante" id="emailEstudante" placeholder="Email" class="form-control">
                <label for="emailEstudante">Email</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

             <div class="form-floating mt-3 mb-3">
                <select name="pronome" id="pronome" placeholder="pronome" class="form-control">
                    <option value="Ele">Ele/dele</option>
                    <option value="Ela">Ela/dela</option>
                    <option value="Elu">Elu/delu</option>
                    <option value="Nulo">Não informar</option>
                </select>
                <label for="pronome">Pronome</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>
            

            <div class="form-floating mt-3 mb-3">
                <input type="password" name="senhaEstudante" id="senhaEstudante" placeholder="Senha" class="form-control" minlength="3" maxlength="8">
                <label for="senhaEstudante">Senha</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="password" name="confirmarSenhaEstudante" id="confirmarSenhaEstudante" placeholder="Confirmar Senha" class="form-control" minlength="3" maxlength="8">
                <label for="confirmarSenhaEstudante">Confirmar Senha</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <button type="submit" class="btn btn-outline-dark">Cadastrar</button>

        </form>
    </div>
</div>

<?php include "bottomBar.php" ?>
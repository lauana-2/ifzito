<?php include "header.php" ?>
    
    
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
                <input type="email" name="emailEstudante" id="emailEstudante" placeholder="Email" class="form-control">
                <label for="emailEstudante">Email</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

             <div class="form-floating mt-3 mb-3">
                <select name="Pronome" id="Pronome" placeholder="Pronome" class="form-control">
                    <option value="Ele">Ele/dele</option>
                    <option value="Ela">Ela/dela</option>
                    <option value="Elu">Elu/delu</option>
                    <option value="Nulo">Não informar</option>
                </select>
                <label for="Pronome">Pronome</label>
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

<?php include "footer.php" ?>
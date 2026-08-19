<?php include "header.php" ?>
'    <div class="d-flex justify-content-center">
            <h2>Adicione uma nova matéria:</h2>
        </div>

        <div class="d-flex justify-content-center">
            <form action="actionLogin.php" method="POST">
                
                 <div class="form-floating mt-3 mb-3">
                <select name="nomeMateria" id="nomeMateria" placeholder="Matéria" class="form-control">
                    <option value="TECINF" selected>Técnico em Informática para Internet</option>
                    <option value="TECJOG">Técnico em Programação de Jogos Digitais</option>
                    <option value="TECMEC">Técnico em Mecânica</option>
                    <option value="TECAUT">Técnico em Automação Industrial</option>
                    <option value="TECELE">Técnico em Eletrotécnica</option>
                </select>
                <label for="nomeMateria">Selecione a Matéria desejada</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

                <div class="form-floating mt-3 mb-3">
                    <label for="nomeProfessor">Nome do Professor(a)</label>
                    <input type="text" name="nomeProfessor" id="nomeProfessor" class="form-control" required>
                    <label for="nomeProfessor"></label>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback"></div>
                </div>

                <button type="submit" class="btn btn-outline-dark">Criar</button>

            </form>
        </div>'

<?php include "footer.php" ?>
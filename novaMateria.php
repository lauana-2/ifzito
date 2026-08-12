<?php include "header.php" ?>
'    <div class="d-flex justify-content-center">
            <h2>Adicione uma nova matéria:</h2>
        </div>

        <div class="d-flex justify-content-center">
            <form action="actionLogin.php" method="POST">
                
                <div class="form-floating mt-3 mb-3">
                    <label for="nomeMateria">Nome da matéria:</label>
                    <input type="text" name="nomeMateria" id="nomeMateria" class="form-control" required>
                    <label for="nomeMateria"></label>
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
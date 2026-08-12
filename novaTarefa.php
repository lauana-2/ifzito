<?php include "header.php" ?>
'    <div class="d-flex justify-content-center">
            <h2>Adicione uma nova Tarefa:</h2>
        </div>

        <div class="d-flex justify-content-center">
            <form action="actionLogin.php" method="POST">
                
                <div class="form-floating mt-3 mb-3">
                    <label for="nomeTarefa">Matéria da Tarefa:</label>
                    <input type="text" name="nomeTarefa" id="nomeTarefa" class="form-control" required>
                    <label for="nomeTarefa"></label>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-floating mt-3 mb-3">
                    <label for="tituloTarefa">Título da tarefa:</label>
                    <input type="text" name="tituloTarefa" id="tituloTarefa" class="form-control" required>
                    <label for="tituloTarefa"></label>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback"></div>
                </div>
                

            <div class="form-floating mt-3 mb-3">
                <label for="descricaoTarefa">Descrição da Atividade:</label>
                <textarea name="descricaoTarefa" id="descricaoTarefa" class="form-control"></textarea>
                <label for="descricaoTarefa"></label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

                <button type="submit" class="btn btn-outline-dark">Criar</button>

            </form>
        </div>'

<?php include "footer.php" ?>
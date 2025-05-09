<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- IMPORTAÇÃO BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
    <!-- IMPORTAÇÃO CSS -->
    <link rel="stylesheet" href="../styles/newUser.css">

</head>
<body>
    <div class="header">
        <span class="cabecalhocadastro">Nova Solicitação</span>
    </div>

    <form action="../methods/newRequest.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Local do problema. *</label>
            <input type="text" class="form-control" name="adress">
        </div>
        <div class="mb-3">
            <label class="form-label">Descrição breve do problema. *</label>
            <input type="text" class="form-control" name="brief-desc">
            <div id="passwordHelpBlock" class="form-text">
                (Exemplos: Lampada queimada, ou Furar parede...)
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Descrição do problema.</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" maxlength="255"></textarea>
            <div id="passwordHelpBlock" class="form-text">
                (Max. 255 caracteres.)
            </div>
        </div>

        <div>
            <label for="picture" class="form-label">Enviar foto do problema. (Opcional)</label>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
            </div>
        <div>

        <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
    </form>
</body>
</html>
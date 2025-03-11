<?php
    //INICIANDO SEÇÃO
    session_start();

    if(!isset($_SESSION['id'])){     
        echo "<script>alert('Você precisa estar logado'); window.location.href='../../index.php';</script>";
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/editPass.css">
    
    <!-- IMPORTAÇÃO BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <form action="../methods/editPass.php" method="POST" class="container-form"> 
        <div class="containerEditPass">
            <div class="mb-3">
                <label class="form-label">Senha atual</label>
                <input type="password" class="form-control" name="passNow" minlength="6" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nova senha</label>
                <input type="password" class="form-control" name="passNew" minlength="6" required>
                <p style="font-size: 10px;">(Min: 6 caracteres)</p>
            </div>

            <div class="mb-3">
                <label class="form-label">Repita a nova senha. </label>
                <input type="password" class="form-control" name="passConfirm" minlength="6" required>
            </div>

            <button type='submit' class='btn btn-success'>Salvar</button>
        </div>
    </form>
</body>
</html>
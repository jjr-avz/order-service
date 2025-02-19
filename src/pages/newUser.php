<?php
    session_start();

    if(!isset($_SESSION["id"])){
        echo "<script>alert('Você precisa estar logado'); window.location.href='../../index.php';</script>";
    }else{
        if($_SESSION['cod_position'] != 2){
            echo "<script>alert('Acesso Negado!'); window.location.href='dashboard.php';</script>";
        }
    }
?>

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
        <span class="cabecalhocadastro">Cadastro de Usuário</span>
    </div>

    <form action="../methods/signUp.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Nome Completo</label>
            <input type="text" class="form-control" name="fullname">
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" class="form-control" name="contact">
        </div>
        <div class="mb-3">
            <label class="form-label">Local de trabalho</label>
            <input type="text" class="form-control" name="localwork">
        </div>
        <div class="mb-3">
            <label class="form-label">Cargo</label>
            <input type="text" class="form-control" name="lotation">
        </div>
        
        

        <div>
            <fieldset>
                <legend>Selecione o nível de acesso</legend>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeuser" id="comumuser" value="1" checked>
                    <label class="form-check-label" for="comumuser">
                        Usuário comum
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeuser" id="manageruser" value="2">
                    <label class="form-check-label" for="manageruser">
                        Gestor
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeuser" id="manaimentuser" value="3">
                    <label class="form-check-label" for="manaimentuser">
                        Equipe de manutenção
                    </label>
                </div>
            </fieldset>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</body>
</html>
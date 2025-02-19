<?php

    //Iniciando a sessão
    session_start();

    if(isset($_SESSION['id'])){
        if(!empty($_GET['id'])){
            require_once('../methods/connection.php');
    
            $id = $_GET['id'];
    
            $sqlsel = $conn->prepare("SELECT * FROM user WHERE id = ?");
            $sqlsel->bind_param("i", $id);
            $sqlsel->execute();
            $selres = $sqlsel->get_result();
    
            if($selres->num_rows > 0){
                while($user_data = mysqli_fetch_assoc($selres)){
                    $pushname = $user_data['name'];
                    $pushemail = $user_data['email'];
                    $pushpass = $user_data['password'];
                    $pushtel = $user_data['telefone'];
                    $pushlwork = $user_data['local_work'];
                    $pushlotation = $user_data['position'];
                    $pushnivel = $user_data['cod_position'];
                    $pushativo = $user_data['ativo'];
                }
    
            }else{
                header('Location: viewUser.php');
            }
        }
    }else{
        echo "<script>alert('Você precisa estar logado'); window.location.href='../../index.php';</script>";
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
    <!-- <div class="header">
        <span class="cabecalhocadastro">Cadastro de Usuário</span>
    </div> -->

    <form action="../methods/handleEditUser.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id?>">
        <div class="mb-3">
            <label class="form-label">Nome Completo</label>
            <input type="text" class="form-control" name="fullname" value="<?php echo $pushname ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" value="<?php echo $pushemail ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" class="form-control" name="password" placeholder="********">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" class="form-control" name="contact" value="<?php echo $pushtel ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Local de trabalho</label>
            <input type="text" class="form-control" name="localwork" value="<?php echo $pushlwork ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Cargo</label>
            <input type="text" class="form-control" name="lotation" value="<?php echo $pushlotation ?>">
        </div>

        <div>
            <fieldset>
                <legend>Selecione o nível de acesso</legend>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeuser" id="comumuser" value="1" <?php echo ($pushnivel == 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="comumuser">
                        Usuário comum
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeuser" id="manageruser" value="2" <?php echo ($pushnivel == 2) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="manageruser">
                        Gestor
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeuser" id="manaimentuser" value="3" <?php echo ($pushnivel == 3) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="manaimentuser">
                        Equipe de manutenção
                    </label>
                </div>
            </fieldset>
        </div>
        <div class="area-check">
            <input class="form-check-input me-1" type="checkbox" name="ativo" value="1" id="firstCheckbox" <?php echo ($pushativo) ? 'checked' : '' ?>>
            <label class="form-check-label" for="firstCheckbox">Ativo</label>
        </div>

        <button type="submit" name="update" id="update" class="btn btn-primary">Salvar</button>
    </form>
</body>
</html>
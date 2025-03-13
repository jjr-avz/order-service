<?php

    //Iniciando a sessão
    session_start();

    if(isset($_SESSION['id'])){
        if(!empty($_GET['id'])){
            require_once('../methods/connection.php');
    
            $id = $_GET['id'];
    
            $sqlsel = $conn->prepare("SELECT * FROM services WHERE id = ?");
            $sqlsel->bind_param("i", $id);
            $sqlsel->execute();
            $selres = $sqlsel->get_result();
    
            if($selres->num_rows > 0){
                while($user_data = mysqli_fetch_assoc($selres)){
                    $local = $user_data['local_problem'];
                    $brief = $user_data['brief_desc'];
                    $desc = $user_data['description'];
                    $caminho = $user_data['caminho_img'];
                }    
            }else{
                header('Location: viewOrder.php');
            }
        }
    }else{
        echo "<script>alert('Você precisa estar logado'); window.top.location.href='../../index.php';</script>";
        exit;
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
    <form action="../methods/handleEditOrder.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id?>">
        <div class="mb-3">
            <label class="form-label">Local do problema. *</label>
            <input type="text" class="form-control" name="adress" value="<?php echo $local ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Descrição breve do problema. *</label>
            <input type="text" class="form-control" name="brief-desc" value="<?php echo $brief ?>">
            <div id="passwordHelpBlock" class="form-text">
                (Exemplos: Lampada queimada, ou Furar parede...)
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Descrição do problema.</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" maxlength="255"><?php echo $desc ?></textarea>
            <div id="passwordHelpBlock" class="form-text">
                (Max. 255 caracteres.)
            </div>
        </div>

        <div>
        <div>
            <label for="picture" class="form-label">Enviar foto do problema. (Opcional)</label>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
            </div>
        </div>

        <?php
            if(isset($caminho)){
                $image = "../../files/imgs/problems/".$caminho;
                echo '<button type="button" class="btn btn-link" style="width: 250px;" onclick="openModal(\''. $image . '\');">Ver imagem do problema.</button>';
            }
        ?>
        <div>
            <button type="submit" name="update" id="update" class="btn btn-primary">Salvar</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../scripts/modal.js"></script>
</body>
</html>
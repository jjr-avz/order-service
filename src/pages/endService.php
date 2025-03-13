<?php
    //INICIANDO A SEÇÃO
    session_start();

    if(isset($_SESSION['id'])){
        require_once('../methods/connection.php');
    
        if(isset($_GET['id'])){
            $item = $_GET['id'];
    
            /* BUSCANDO INFORMAÇÕES DO SERVIÇO */
            $stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
            $stmt->bind_param("i", $item);
            $stmt->execute();
            $resitem = $stmt->get_result();
            $item_data = mysqli_fetch_assoc($resitem);
            $data_formatada = date("d/m/Y H:i", strtotime($item_data['date_creation']));
    
            /* BUSCANDO INFORMAÇÃO DE QUEM FOI O CRIADOR DO SERVIÇO */
            $criador = $conn->prepare("SELECT * FROM user WHERE id = ?");
            $criador->bind_param("i", $item_data['id_creator']);
            $criador->execute();
            $cid = $criador->get_result();
            $criador_data = mysqli_fetch_assoc($cid);
        }else{
            echo "nenhum id encontrado";
        }
    }else{
        echo "<script>alert('Você precisa estar logado'); window.top.location.href='../../index.php';</script>";
        exit;
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- IMPORTAÇÃO BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- IMPORTAÇÃO CSS -->
     <link rel="stylesheet" href="../styles/details.css">
     
</head>
<body>
    <?php
        
        echo "<div class='area-inf'>
            <label>Criado por:</label>
            <p>".$criador_data['name']."</p>
        </div>
        <div class='area-inf'>
            <label>Data e hora</label>
             <p>".$data_formatada."</p>
        </div>
        <div class='area-inf'>
            <label>Local do Problema</label>
            <p>".$item_data['local_problem']."</p>
        </div>
        
        <div class='area-inf'>
            <label>Descrição do problema</label>
            <p class='paragrafo'>".$item_data['description']."</p>
        </div>"; 
        
        if(isset($item_data['caminho_img'])){
            $image = "../../files/imgs/problems/".$item_data['caminho_img'];
            echo '<button class="btn btn-link" style="width: 250px;" onclick="openModal(\''. $image . '\');">Ver imagem do problema.</button>';
        }
    ?>

    <form class="form-end" action="../methods/handleEndService.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $item_data['id']?>">
        <div>
            <label>Enviar foto do problema solucionado. (Opcional)</label>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Solução do problema.</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" maxlength="255"></textarea>
            <div id="passwordHelpBlock" class="form-text">
                (Max. 255 caracteres.)
            </div>
        </div>

        <div class="area-btns" style="justify-content: space-around;">
            <button type="button" class="btn btn-danger" onclick="history.back()">Voltar</button>
            <button type="submit" name="update" id="update" class="btn btn-primary">Salvar</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../scripts/modal.js"></script>
</body>
</html>
<?php

    //INICIANDO A SESSÃO
    session_start();
    
    if(isset($_SESSION['id'])){
        require_once("../methods/connection.php");

        if(isset($_GET['id'])){
            $item = $_GET['id'];
            
            //BUSCANDO O SERVIÇO
            $sc_serv = $conn->prepare("SELECT * FROM services WHERE id = ?");
            $sc_serv->bind_param("i", $item);
            $sc_serv->execute();
            $res_serv = $sc_serv->get_result();
            $data_serv = mysqli_fetch_assoc($res_serv);

            //BUSCANDO QUEM SOLICITOU O SERVIÇO
            $sc_creator = $conn->prepare("SELECT * FROM user WHERE id = ?");
            $sc_creator->bind_param("i", $data_serv['id_creator']);
            $sc_creator->execute();
            $res_creator = $sc_creator->get_result();
            $data_creator = mysqli_fetch_assoc($res_creator);
        }else{
            header("Location: ../../index.php");
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
    <div class="area-inf">
        <label>Solicitado por:</label>
        <p><?php echo $data_creator['name'] ?></p>
    </div>
    <div class="area-inf">
        <label>Data de solicitação:</label>
        <p><?php $data_criacao = date("d/m/Y H:i", strtotime($data_serv['date_creation'])); echo $data_criacao ?></p>
    </div>
    <div class="area-inf">
        <label>Serviço executado por:</label>
        <p><?php echo $data_serv['name_tech'] ?></p>
    </div>
    <div class="area-inf">
        <label>Serviço executado em:</label>
        <p><?php $data_end = date("d/m/Y H:i", strtotime($data_serv['date_end'])); echo $data_end ?></p>
    </div>
    <div class="area-inf">
        <label>Solução:</label>
        <p class="paragrafo"><?php echo $data_serv['solution'] ?></p>
    </div>

    <?php
        if(isset($data_serv['img_solved'])){
            $image = "../../files/imgs/solved/".$data_serv['img_solved'];
            echo '<button class="btn btn-link" style="width: 300px;" onclick="openModal(\''. $image . '\');">Ver foto do problema solucionado.</button>';
        }
    ?>

    <button type="button" class="btn btn-danger" style="margin-top: 30px;" onclick='history.back()'>Voltar</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../scripts/modal.js"></script>
</body>
</html>
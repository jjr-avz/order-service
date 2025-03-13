<?php
    //INICIANDO A SEÇÃO
    session_start();

    if($_SESSION['id']){
        require_once('../methods/connection.php');
    
        if(isset($_SESSION['id'])){
            $item = $_GET['id'];
            
            /* BUSCANDO INFORMAÇÕES DO SERVIÇO */
            $stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
            $stmt->bind_param("i", $item);
            $stmt->execute();
            $resitem = $stmt->get_result();
            $item_data = mysqli_fetch_assoc($resitem);
            $date_formatada = date("d/m/Y H:i", strtotime($item_data['date_creation']));
    
            /* BUSCANDO INFORMAÇÃO DE QUEM FOI O CRIADOR DO SERVIÇO */
            $criador = $conn->prepare("SELECT * FROM user WHERE id = ?");
            $criador->bind_param("i", $item_data['id_creator']);
            $criador->execute();
            $cid = $criador->get_result();
            $criador_data = mysqli_fetch_assoc($cid);
    
            /* BUSCANDO EQUIPES DE TECNICOS CADASTRADO */
            $eqp = $conn->prepare("SELECT * FROM user WHERE cod_position = 3");
            $eqp->execute();
            $membereqp = $eqp->get_result();    
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
        <div class='area-inf'>
            <label>Criado por:</label>
            <p><?php echo $criador_data['name'] ?></p>
        </div>
        <div class='area-inf'>
            <label>Data e hora</label>
             <p><?php echo $date_formatada ?></p>
        </div>
        <div class='area-inf'>
            <label>Local do Problema</label>
            <p><?php echo $item_data['local_problem'] ?></p>
        </div>
        
        <div class='area-inf'>
            <label>Descrição do problema</label>
            <p class='paragrafo'><? php echo $item_data['description'] ?></p>
        </div>
        <?php
            if(isset($item_data['caminho_img'])){
                $image = "../../files/imgs/problems/".$item_data['caminho_img'];
                echo '<button class="btn btn-link" style="width: 150px;" onclick="openModal(\''. $image . '\');">Ver imagem</button>';
            }
        ?>

        <div>
            <form class='formulario' action='../methods/design_tech.php' method='POST'>

                <input type='hidden' name='id_sv' value="<?php echo $item_data['id'] ?>">
                <div class='area-desig'>
                    <label>Designar Equipe</label>
                    <select class='form-select' name='techuser' aria-label='Default select example'>
                        <option selected>Designar equipe</option>";
                        <?php while($eqp_data = mysqli_fetch_assoc($membereqp)){
                            echo "<option name='techuser' value='".$eqp_data['id']."'>".$eqp_data['name']."</option>";
                        } ?>
                    </select>

                    <fieldset>
                        <legend>Grau de Prioridade</legend>

                        <div class="opField">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="priority" id="low" value="0" checked>
                                <label class="form-check-label s-fs" for="low" style="font-size: 16px;">
                                    Baixo
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="priority" id="medium" value="1">
                                <label class="form-check-label s-fs" for="medium" style="font-size: 16px;">
                                    Médio
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="priority" id="high" value="2">
                                <label class="form-check-label s-fs" for="high" style="font-size: 16px;">
                                    Alto
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>        

            <div class='area-btns'>
                <button type='submit' class='btn btn-success'>Salvar</button>
                <button type='button' class='btn btn-danger' onclick='history.back()'>Cancelar</button>
            </div>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../scripts/modal.js"></script>
</body>
</html>
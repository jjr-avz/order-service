<?php

    //Iniciando a seção
    session_start();

    if(isset($_SESSION['id'])){
        require_once('connection.php');
        
        if(isset($_POST['update'])){

            $id = $_POST['id'];

            $sql = $conn->prepare("SELECT caminho_img FROM services WHERE id = ?");
            $sql->bind_param("i", $id);
            $sql->execute();
            $res = $sql->get_result();
            $row = $res->fetch_assoc();
            $img_old = $row['caminho_img']; //Salva o nome atual da imagem do banco de dados

            if(!empty($_FILES['picture']['name'])){
                $diretorio = "../../files/imgs/problems/";

                $new_img = $_FILES['picture'];
                $extensao = pathinfo($new_img['name'], PATHINFO_EXTENSION);
                $new_name_img = uniqid().".".$extensao;
                $caminho_completo = $diretorio . $new_name_img;

                if(!empty($img_old) && file_exists($diretorio . $img_old)){
                    unlink($diretorio . $img_old);
                }
                
                move_uploaded_file($new_img['tmp_name'], $caminho_completo);
            }else{
                $new_name_img = $img_old;
            }


            $local = $_POST['adress'];
            $brief = $_POST['brief-desc'];
            $desc = $_POST['description'];
            date_default_timezone_set("America/Cuiaba"); // Ajuste para sua região
            $dateup = date("Y-m-d H:i:s");
        
    
            $sqlup = $conn->prepare("UPDATE services SET local_problem = ?, brief_desc = ?, description = ?, date_creation = ?, caminho_img = ? WHERE id = ? ");
            $sqlup->bind_param("sssssi", $local, $brief, $desc, $dateup, $new_name_img, $id);
            if($sqlup->execute()){
               echo "<script>alert('Ordem de serviço atualizada com sucesso!'); window.location.href='../pages/myrequest.php';</script>";
            }else{
                echo "<script>alert('Erro ao atualizar!'); window.history.back();</script>";
            }
        }
    }else{
        echo "<script>alert('Você precisa estar logado'); window.top.location.href='../../index.php';</script>";
        exit;
    }
?>
<?php

    //INICIANDO SEÇÃO
    session_start();

    if(isset($_SESSION['id'])){
        require_once('../methods/connection.php');
        $id_sv = intval($_POST['id-sv']);

        $img = $conn->prepare("SELECT caminho_img FROM services WHERE id = ?");
        $img->bind_param("i", $id_sv);
        $img->execute();
        $img->bind_result($nameimg);
        $img->fetch();
        $img->close();

        if($nameimg){
            $caminho = "../../files/imgs/problems/".$nameimg;
            if(file_exists($caminho)){
                unlink($caminho);
            }
        }
    
    
        $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
        $stmt->bind_param("i", $id_sv);
        if($stmt->execute()){
            echo "<script>alert('Serviço excluido com sucesso')</script>";
            $stmt->close();
        }
        header("Location: ../pages/myrequest.php");
    }else{
        echo "<script>alert('Você precisa estar logado'); window.location.href='../../index.php';</script>";
    }
?>
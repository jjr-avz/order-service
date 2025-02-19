<?php

    //Iniciando a seção
    session_start();

    if(isset($_SESSION['id'])){
        require_once("connection.php");
    
        if(isset($_POST['update'])){

            if(!empty($_FILES["picture"]["name"])){
                $diretorio = "../../files/imgs/solved/";
        
                if(!is_dir($diretorio)){
                    mkdir($diretorio, 0777, true);
                }
        
                $imagem = $_FILES['picture'];
                $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
                $nomeArquivo = uniqid().".".$extensao;
                $caminhoCompleto = $diretorio.$nomeArquivo;
        
                $tiposPermitidos = ["jpg", "jpeg", "png", "gif"];
                if(!in_array(strtolower($extensao), $tiposPermitidos)){
                    die("Erro: Tipo de arquivo não permitido.");
                }
        
                move_uploaded_file($imagem["tmp_name"], $caminhoCompleto);
            }else{
                $nomeArquivo = null;
            }

            $id = $_POST['id'];
            $solution = $_POST['description'];
            $tech = $_SESSION['name'];
            date_default_timezone_set("America/Cuiaba"); // Ajuste para sua região
            $data_end = date("Y-m-d H:i:s");

            $sql = ("UPDATE services SET solution = ?, name_tech = ?, date_end = ?, status = 2, img_solved = ? WHERE id = ?");
            $sqlup = $conn->prepare($sql);
            $sqlup->bind_param("ssssi", $solution, $tech, $data_end, $nomeArquivo, $id);
            $sqlup->execute();
        }
    
        header("Location: ../pages/myservices.php");
    }else{
        echo "<script>alert('Você precisa estar logado'); window.location.href='../../index.php';</script>";
    }


?>
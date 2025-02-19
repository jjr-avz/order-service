<?php

    //INICIANDO A SESSÃO
    session_start();

    if(isset($_SESSION['id'])){
        require_once('connection.php');

        if(!empty($_FILES["picture"]["name"])){
            $diretorio = "../../files/imgs/problems/";
    
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
    
        $addres_problem = $_POST['adress'];
        $brief = $_POST['brief-desc'];
        $description_problem = $_POST['description'];
        $autor_problem = $_SESSION['id'];
        date_default_timezone_set("America/Cuiaba"); // Ajuste para sua região
        $dateup = date("Y-m-d H:i:s");
    
       
        $sql = "INSERT INTO services (brief_desc, description, id_creator, status, local_problem, date_creation, caminho_img) VALUES (?, ?, ?, 0, ?, ?, ?)";
        $sqlin = $conn->prepare($sql);

        if(!$sqlin){
            die("Erro na preparação do statement: ".$conn->error);
        }

        $sqlin->bind_param("ssisss", $brief, $description_problem, $autor_problem, $addres_problem, $dateup, $nomeArquivo);

        if($sqlin->execute()){
            header("Location: ../pages/myrequest.php");
        }
       
    }else{
        echo "<script>alert('Você precisa estar logado'); window.location.href='../../index.php';</script>";
    }
?>
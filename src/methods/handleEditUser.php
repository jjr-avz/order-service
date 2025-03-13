<?php

    //Iniciando a sessão
    session_start();

    if(isset($_SESSION['id'])){
        require_once('connection.php');
    
        if(isset($_POST['update'])){

            $id = $_POST['id'];

            //PEGANDO A SENHA JÁ SALVA NO BANCO DE DADOS
            $sql = $conn->prepare("SELECT password FROM user WHERE id = ?");
            $sql->bind_param("i", $id);
            $sql->execute();
            $res = $sql->get_result();
            $row = $res->fetch_assoc();
            $oldpass = $row['password']; //Salvar senha do banco de dados

            //SE FOI PASSADO UMA NOVA SENHA, CRIPTOGRAFAR E SALVAR NO BANCO - SENÃO, MANTER A SENHA ANTIGA
            if(!empty($_POST['password'])){                
                $oldpass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $upname = $_POST['fullname'];
            $upemail = $_POST['email'];
            $uptel = $_POST['contact'];
            $uplwork = $_POST['localwork'];
            $uplotation = $_POST['lotation'];
            $uptype = $_POST['typeuser'];
            $upativo = isset($_POST['ativo']) ? 1 : 0; //Verifica se o checkbox esta marcado, envia 1 - true ou 0 - false
    
        
    
            $sqlup = $conn->prepare("UPDATE user SET name = ?, email = ?, password = ?, telefone = ?, local_work = ?, position = ?, cod_position = ?, ativo = ? WHERE id = ? ");
            $sqlup->bind_param("ssssssiii", $upname, $upemail, $oldpass, $uptel, $uplwork, $uplotation, $uptype, $upativo, $id);
            $sqlup->execute(); 
        }
        header("Location: ../pages/viewUsers.php");
    }else{
        echo "<script>alert('Você precisa estar logado'); window.top.location.href='../../index.php';</script>";
        exit;
    }

?>
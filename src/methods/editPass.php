<?php

    //INICIAR SEÇÃO
    session_start();    

    if(!isset($_SESSION['id'])){
        echo "<script>alert('Você precisa estar logado'); window.location.href='../../index.php';</script>";
    }else{

        //IMPORTANDO ARQUIVO DE CONEXÃO COM O BD
        require_once('connection.php');

        $id = $_SESSION['id'];
        $oldPass = $_SESSION['password'];
        $passNow = $_POST['passNow'];
        $passNew = $_POST['passNew'];
        $passConfirm = $_POST['passConfirm'];
       
        if(password_verify($passNow, $oldPass)){
            if($passNew == $passConfirm){
                $newpass = password_hash($passNew, PASSWORD_DEFAULT);
                
                $sqlup = $conn->prepare("UPDATE user SET password = ? WHERE id = ? ");
                $sqlup->bind_param("si", $newpass, $id);
                $sqlup->execute();

                echo "<script>alert('Senha alterada com sucesso!');</script>";
            }else{
                echo "<script>alert('As senhas devem ser iguais.');history.back();</script>";
            }            
        }else{
            echo "<script>alert('A senha atual esta incorreta!.');</script>";
        }
    }
?>
<?php

    //INICIAR SEÇÃO
    session_start();

    if(isset($_SESSION['id'])){
        require_once('connection.php');
        $newname = $_POST['fullname'];
        $newemail = $_POST['email'];
        $newpass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $newcontact = $_POST['contact'];
        $newlocalwork = $_POST['localwork'];
        $newlotation = $_POST['lotation'];
        $newstatus = $_POST['typeuser'];
        date_default_timezone_set("America/Cuiaba"); // Ajuste para sua região
        $dateup = date("Y-m-d H:i:s");

        $qr = "SELECT id from user WHERE email = ?";
        $stmt = $conn->prepare($qr);
        $stmt->bind_param("s", $newemail);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            echo "<script>alert('Email já está em uso.');history.back();</script>";
        }else{

            $sql = "INSERT INTO user (name, password, cod_position, email, telefone, local_work, position, ativo, date_insert) VALUES ( ?, ?, ?, ?, ?, ?, ?, true, ?)";
            $sqlin = $conn->prepare($sql);
            $sqlin->bind_param("ssisssss", $newname, $newpass, $newstatus, $newemail, $newcontact, $newlocalwork, $newlotation, $dateup);
    
            if($sqlin->execute()){
                echo "<script>alert('Usuario cadastrado com sucesso.'); window.location.href='../pages/viewUsers.php';</script>";
            }else{
                echo "<script>alert('Você precisa estar logado'); window.top.location.href='../../index.php';</script>";
        exit;
            }
        }
    }        
?>
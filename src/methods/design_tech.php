<?php
    //INICIANDO SEÇÃO
    session_start();

    if(isset($_SESSION['id'])){
        require_once('../methods/connection.php');
    
        $id_serv = intval($_POST['id_sv']);
        $id_tech = intval($_POST['techuser']);
        $date_desig = date("Y-m-d");
        $priority = intval($_POST['priority']);
    
        $stmt = $conn->prepare("UPDATE services SET date_design = ?, id_tech_design = ?, priority = ?, status = 1 WHERE id = ?");
        $stmt->bind_param("siii", $date_desig, $id_tech, $priority, $id_serv);
    
        if($stmt->execute()){
            echo "<script>alert('Equipe Designada com Sucesso!'); window.location.href='../pages/viewrequest.php'</script>";
        }else{
            echo "<script>alert('Erro ao atualizar!'); window.location.href='../pages/viewrequest.php'</script>";
        }
    }else{
        echo "<script>alert('Você precisa estar logado'); window.top.location.href='../../index.php';</script>";
        exit;
    }

?>
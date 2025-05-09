<?php 
    //INICIAR SEÇÃO
    session_start();

    //CASO A SEÇÃO ESTEJA INICIADA, ENCAMINHAR DIRETAMENTE PARA O DASHBOARD
    if(empty($_POST) or (empty($_POST["email"]) or empty($_POST["password"]))){
        header('location: ../../index.php');
        exit();
    };

    //IMPORTANDO ARQUIVO DE CONEXÃO COM O BD
    require_once('connection.php');

    //PEGANDO O EMAIL E SENHA DIGITADO NO FORMULARIO DE LOGIN
    $email = $_POST['email'];
    $pass = $_POST['password'];

    //QUERY SQL QUE IRA BUSCAR SE POSSUI O USUÁRIO CADASTRADO E SE A SENHA ESTÁ CORRETA
    $sql = "SELECT * FROM user WHERE email = ? AND ativo = true LIMIT 1";
    $sqlsel = $conn->prepare($sql);
    $sqlsel->bind_param("s", $email);
    $sqlsel->execute();
    $result = $sqlsel->get_result();
    
    $resuser = $result->fetch_object();
    if(password_verify($pass, $resuser->password)){
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $resuser->name;
        $_SESSION["type"] = $resuser->cod_position;
        $_SESSION["telefone"] = $resuser->telefone;
        $_SESSION["position"] = $resuser->position;
        $_SESSION["cod_position"] = $resuser->cod_position;
        $_SESSION["id"] = $resuser->id;
        $_SESSION["password"] = $resuser->password;
        
        header('location: ../pages/dashboard.php');
        exit();
    }else{
        echo "<script>alert('Falha no login! Email e/ou senha incorreto(s).'); window.location.href='../../index.php'</script>";
        exit();
    }
?>
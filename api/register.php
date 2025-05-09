<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once "connection.php";

    $database = new Database();
    $conn = $database->getConnection();

    date_default_timezone_set("America/Cuiaba"); // Ajuste para região MS
    $datenow = date("Y-m-d H:i:s");
    
    $data = json_decode(file_get_contents("php://input"));

    //CRIPTOGRAFAR O PASSWORD
    $passcript = password_hash($data->newPass, PASSWORD_DEFAULT);


    echo($data->newName);

    $query = "INSERT INTO user (name, email, password, telefone, position, cod_position, date_insert, local_work, ativo)
                VALUES (:name, :email, :password, :telefone, :position, :cod_position, :date_insert, :local_work, true)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":name", $data->newName);
    $stmt->bindParam(":email", $data->newEmail);
    $stmt->bindParam(":password", $passcript);
    $stmt->bindParam(":telefone", $data->newTel);
    $stmt->bindParam(":position", $data->newLotation);
    $stmt->bindParam(":cod_position", $data->newStatus);
    $stmt->bindParam(":date_insert", $datenow);
    $stmt->bindParam(":local_work", $data->newLocalWork);
    
    $stmt->execute();
?>
<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once 'connection.php';

    $database = new Database();
    $conn = $database->getConnection();

    // Obter os dados enviados pelo app React Native
    $data = json_decode(file_get_contents("php://input"));

    $query = "SELECT * FROM units WHERE id = :unit_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":unit_id", $data->idUnit);

    $stmt->execute();

    if($stmt->rowCount() > 0){
        $unity = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "message" => "Login realizado com sucesso!",
            "unity" => [
                "id" => $unity["id"],
                "name_unit" => $unity["name_unit"]
            ]
        ]);
    }else{
        echo json_encode(["success" => false, "message" => "Id da unidade não encontrada"]);
    }
?>
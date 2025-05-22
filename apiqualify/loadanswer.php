<?php

    include_once 'connection.php';

    $database = new Database();
    $conn = $database->getConnection();

    if(!$conn){
        http_response_code(500);
        echo json_encode(["erro" => "Erro na conexão com o banco de dados"]);
        exit;
    }

    try{

        $query = "SELECT * FROM answers";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        header("Content-Type: application/json");
        echo json_encode($data);
    } catch (PDOException $e){
        http_response_code(500);
        echo json_encode(["erro" => "Erro na comunicação: " . $e->getMessage()]);
    }

?>
<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once "connection.php";

    $database = new Database();
    $conn = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $query = "INSERT INTO answers (unit_id, answers, id_question) VALUES (:unit_id, :answers, :id_quest)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":unit_id", $data->idUnit);    
    $stmt->bindParam(":id_quest", $data->id);
    $stmt->bindParam(":answers", $data->answer);
    $stmt->execute();    

    echo json_encode(["sucesso" => true]);

?>
<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once "connection.php";

    $database = new Database();
    $conn = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $query = "INSERT INTO classification (unit_id, classification) VALUES (:unit_id, :classify)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":unit_id", $data->unit);
    $stmt->bindParam(":classify", $data->avalie);

    $stmt->execute();

    echo json_encode(["sucesso" => true]);

?>
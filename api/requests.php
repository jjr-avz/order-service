<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once "connection.php";

    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT * from services WHERE status != 2";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);    

    echo json_encode($user);
?>
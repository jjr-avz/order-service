<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once 'connection.php';

    $database = new Database();
    $conn = $database->getConnection();

    // Obter os dados enviados pelo app React Native
    $data = json_decode(file_get_contents("php://input"));

    $query = "SELECT * FROM questions WHERE id_units = :unit_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":unit_id", $data->idUnit);
    $stmt->execute(); // <-- IMPORTANTE: Executar a consulta antes de fetch ou rowCount

    if ($stmt->rowCount() > 0) {
        $quests = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $quests[] = [
                "id" => $row["id"],
                "question" => $row["quest"]
            ];
        }

        echo json_encode([
            "success" => true,
            "message" => "Perguntas carregadas com sucesso",
            "quests" => $quests
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Não há perguntas cadastradas para essa unidade"
        ]);
    }

?>

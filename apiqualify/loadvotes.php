<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");

    include_once 'connection.php';

    $database = new Database();
    $conn = $database->getConnection();

    /*BUSCAR AS UNIDADES*/
    $queryUnit = "SELECT id, name_unit FROM units";
    $stmt = $conn->prepare($queryUnit);
    $stmt->execute();
    $unitsDb = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $units = [];

    foreach($unitsDb as $un){
        $id = $un['id'];

        $vote = [0, 0, 0, 0, 0];

        $sqlvote = "SELECT answers COUNT(*) as total FROM answers WHERE unit_id = :id GROUP BY answers";
        $stmtVote = $conn->prepare($sqlvote);
        $stmtVote->execute(['id'] => $id);
        $voteDb = $stmtVote->fetchAll(PDO::FETCH_ASSOC);

        foreach($voteDb as $vt){
            $ans = (int)$vt['answers'];
            $total = (int)$vt['total'];
            $vote[$ans - 1] = $total;
        }

        $soma = 0;
        $totalVotos = 0;
        foreach($vote as $i => $qtd){
            $soma += ($i + 1) * $qtd;
            $totalVotos += $qtd;
        }
        $media = $totalVotos > 0 ? round($soma / $totalVotos, 2) : null;

        $units[] = [
            'id' => $id,
            'name' => $un['unit_name'],
            'answer' = $vote,
            'media' = $media
        ]
    }

    echo json_encode($units);

?>
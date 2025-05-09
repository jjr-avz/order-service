<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json; charset=UTF-8");

    require_once('connection.php');

    $database = new Database();
    $conn = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    if(
        isset($data->upID) && isset($data->upName) && isset($data->upEmail) &&
        isset($data->upTel) && isset($data->upLocalw) &&
        isset($data->upPosition) && isset($data->upCodPos)
    ){
        $sql = "UPDATE user SET 
                    name = :name,
                    email = :email,
                    telefone = :tel,
                    local_work = :localw,
                    position = :position,
                    cod_position = :codpos,
                    ativo = :ativo";

        if(!empty($data->upPass)){
            $sql .= ", password = :pass";
        }

        $sql .= " WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $data->upName);
        $stmt->bindParam(':email', $data->upEmail);
        $stmt->bindParam(':tel', $data->upTel);
        $stmt->bindParam(':localw', $data->upLocalw);
        $stmt->bindParam(':position', $data->upPosition);
        $stmt->bindParam(':codpos', $data->upCodPos);
        $ativo = $data->checked ? 1 : 0;
        $stmt->bindParam(':ativo', $ativo);
        $stmt->bindParam(':id', $data->upID);

        if(!empty($data->upPass)){
            $pass = password_hash($data->upPass, PASSWORD_DEFAULT);
            $stmt->bindParam(':pass', $pass);
        }

        if($stmt->execute()){
            echo json_encode([
                "status" => "Success",
                "message" => "Dados atualizados com sucesso"
            ]);
        } else {
            echo json_encode([
                "status" => "Error",
                "message" => "Erro ao atualizar usuário"
            ]);
        }

    } else {
        echo json_encode([
            "status" => "Error",
            "message" => "Dados incompletos"
        ]);
    }

?>

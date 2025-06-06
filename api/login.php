<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once 'connection.php';

    $database = new Database();
    $conn = $database->getConnection();

    // Obter os dados enviados pelo app React Native
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->email) && !empty($data->pass)) {
        $query = "SELECT id, name, password, telefone, position, cod_position, date_insert, local_work, ativo FROM user WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $data->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            
            if (password_verify($data->pass, $user['password'])) {                
                echo json_encode([
                    "success" => true,
                    "message" => "Login realizado com sucesso!",
                    "user" => [
                        "id" => $user["id"],
                        "nome" => $user["name"],
                        "email" => $data->email,
                        "telefone" => $user["telefone"],
                        "position" => $user["position"],
                        "status" => $user["cod_position"],
                        "registrationDate" => $user["date_insert"],
                        "localWork" => $user["local_work"],
                        "ativo" => $user["ativo"]
                    ]
                ]);
            } else {
                echo json_encode(["success" => false, "message" => "Senha incorreta."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Email e senha são obrigatórios."]);
    }
?>
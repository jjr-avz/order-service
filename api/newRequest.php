<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json; charset=UTF-8");

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        require_once('connection.php');

        $database = new Database();
        $conn = $database->getConnection();

        $data = json_decode(file_get_contents("php://input"));

        $localProblem = $_POST['localProblem'];
        $briefDesc = $_POST['briefDesc'];
        $description = $_POST['description'];
        $id_creator = $_POST['id_user'];
        $picture = $_FILES['picture'];
        date_default_timezone_set("America/Cuiaba"); // Ajuste para região MS
        $datenow = date("Y-m-d H:i:s");
    

        $extensao = pathinfo($picture['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid(). "." . $extensao;

        $typePermission = ["jpg", "jpeg", "png"];
        if(!in_array(strtolower($extensao), $typePermission)){
            die("Erro: Tipo de arquivo não permitido.");
        }

        $directory = "../files/imgs/problems/" . $nomeArquivo;
        move_uploaded_file($picture['tmp_name'], $directory);

        $sql = "INSERT INTO services (brief_desc, description, id_creator, status, local_problem, date_creation, caminho_img) 
            VALUES (:briefDesc, :description, :id_creator, 1, :localProblem, :dateNow, :nomeArquivo)";
        
        $stmt = $conn -> prepare($sql);
        $stmt->bindParam(":briefDesc", $briefDesc);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":id_creator", $id_creator);
        $stmt->bindParam(":localProblem", $localProblem);
        $stmt->bindParam(":dateNow", $datenow);
        $stmt->bindParam(":nomeArquivo", $nomeArquivo);

        $stmt->execute();
    }

?>
<?php
    //INICIANDO SEÇÃO
    session_start();

    if(isset($_SESSION['id'])){

        //Verificando se o cadastro pode acessar a funcionalidade
        if($_SESSION['cod_position'] != 2){
            echo "<script>alert('Acesso Negado!'); window.location.href='dashboard.php';</script>";
        }

        require_once('../methods/connection.php');
    
        $stmt = $conn->prepare("SELECT * FROM services WHERE status = 2 ORDER BY date_creation");
        $stmt->execute();
        $res = $stmt->get_result();
    }else{
        echo "<script>alert('Você precisa estar logado'); window.location.href='../../index.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

     <!-- IMPORTAÇÃO BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- IMPORTAÇÃO CSS -->
    <link rel="stylesheet" href="../styles/buttonstable.css">
</head>
<body>
    <div class="table-responsive">
        <table class="table">
            <thead class="table-light">
                <tr>
                <th scope="col">#ID</th>
                <th scope="col">Local</th>
                <th scope="col">Problema</th>
                <th scope="col">Autor</th>
                <th scope="col">Data</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($user_data = mysqli_fetch_assoc($res)){
                        echo "<tr>";
                        echo "<td>".$user_data['id']."</td>";
                        echo "<td>".$user_data['local_problem']."</td>";
                        echo "<td>".$user_data['brief_desc']."</td>";
                        
                        //    SELECIONANDO NA TABELA QUEM O NOME DO CRIADO DA OS                    
                        $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
                        $stmt->bind_param("i", $user_data['id_creator']);
                        $stmt->execute();
                        $cid = $stmt->get_result();
                        $serv_data = mysqli_fetch_assoc($cid);
                        echo "<td>".$serv_data['name']."</td>";
                        $data_formatada = date("d/m/Y H:i", strtotime($user_data['date_end']));
                        echo "<td>".$data_formatada."</td>";
                        echo "<td style='color: #b6b6b6;'><i class='bi bi-check-circle'> Finalizado</td>";
                        echo "<td><a type='button' href='viewSolution.php?id=$user_data[id]' class='btn btn-link'>Ver</a></td>";           
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
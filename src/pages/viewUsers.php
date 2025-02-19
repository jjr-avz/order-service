<?php
    //INICIANDO SEÇÃO
    session_start();

    if(isset($_SESSION['id'])){
        //Verificando se o cadastro pode acessar a funcionalidade
        if($_SESSION['cod_position'] != 2){
            echo "<script>alert('Acesso Negado!'); window.location.href='dashboard.php';</script>";
        }

        require_once('../methods/connection.php');
    
        $stmt = $conn->prepare("SELECT * FROM user ORDER BY id");
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
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Cargo</th>
                <th scope="col">Lotação</th>
                <th scope="col">Telefone</th>
                <th scope="col">Email</th>
                <th scope="col">Ativo</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($user_data = mysqli_fetch_assoc($res)){
                    echo "<tr>";
                    echo "<td>".$user_data['id']."</td>";
                    echo "<td>".$user_data['name']."</td>";
                    echo "<td>".$user_data['position']."</td>";                    
                    echo "<td>".$user_data['local_work']."</td>";
                    echo "<td>".$user_data['telefone']."</td>";
                    echo "<td>".$user_data['email']."</td>";
                    if($user_data['ativo']){
                        echo "<td style='color: #0f8d50;'><i class='bi bi-person-fill'></i> Ativo</td>";
                    }else{
                        echo "<td style='color: #b6b6b6;'><i class='bi bi-person-fill'></i> Inativo</td>";
                    }
                    echo "<td>
                         <a href='editUser.php?id=$user_data[id]' class='bt-edit'><i class='bi bi-pencil'></i></a>
                    </td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>
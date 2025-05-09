<?php
    //INICIANDO SEÇÃO
    session_start();

    if(isset($_SESSION['id'])){

        //Verificando se o cadastro pode acessar a funcionalidade
        if($_SESSION['cod_position'] != 2){
            echo "<script>alert('Acesso Negado!'); window.location.href='dashboard.php';</script>";
        }

        require_once('../methods/connection.php');
        
        //CONTANDO QUANTIDADE DE ITENS
        $page = 1;
        $limite = 14;

        if(isset($_GET['page'])){
            $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        }

        if(!$page){
            $page = 1;
        }

        $inicio = ($limite * $page) - $limite;

        $stmtEnd = $conn->prepare("SELECT COUNT(id) AS count FROM services WHERE status = 2");
        $stmtEnd->execute();
        $resEnd = $stmtEnd->get_result();
        $row = $resEnd->fetch_assoc();
        $maxRow = $row['count'];

        $end = ceil($maxRow/$limite);

        //CARREGANDO INFORMAÇÕES PARA A PAGINA
        $stmt = $conn->prepare("SELECT * FROM services WHERE status = 2 ORDER BY date_creation LIMIT $inicio, $limite");
        $stmt->execute();
        $res = $stmt->get_result();
    }else{
        echo "<script>alert('Você precisa estar logado'); window.top.location.href='../../index.php';</script>";
        exit;
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
                        echo "<td><a type='button' href='viewSolution.php?id=$user_data[id]' class='btn btn-link jj-send' style='font-size: 14px;'>Ver</a></td>";           
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example" style="margin-right: 3vw;">
        <ul class="pagination justify-content-end">
            <li class="page-item <?php if($page <= 1){
                    echo 'disabled'; }?>">
                <a class="page-link" href="?page=1" aria-label="First">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item <?php if($page <= 1){
                    echo 'disabled'; }?>">
                <a class="page-link" href="?page=<?= $page-1 ?>" aria-label="Previous">
                    <span aria-hidden="true"><</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#" style="cursor: default;"><?= $page ?></a></li>
            <li class="page-item <?php if($page >= $end){
                    echo 'disabled'; }?>">
                <a class="page-link" href="?page=<?= $page+1 ?>" aria-label="Next">
                    <span aria-hidden="true">></span>
                </a>
            </li>
            <li class="page-item <?php if($page >= $end){
                    echo 'disabled'; }?>">
                <a class="page-link" href="?page=<?= $end ?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</body>
</html>
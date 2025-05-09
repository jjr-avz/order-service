<?php
    //INICIANDO SEÇÃO
    session_start();

    if(isset($_SESSION['id'])){

        //Verificando se o cadastro pode acessar a funcionalidade
        if($_SESSION['cod_position'] != 2){
            echo "<script>alert('Acesso Negado!'); window.location.href='dashboard.php';</script>";
        }
        
        require_once('../methods/connection.php');

        $page = 1;
        $limite = 14;

        if(isset($_GET['page'])){
            $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        }

        if(!$page){
            $page = 1;
        }

        $inicio = ($limite * $page) - $limite;

        $stmtEnd = $conn->prepare("SELECT COUNT(id) AS count FROM services WHERE status != 2");
        $stmtEnd->execute();
        $resEnd = $stmtEnd->get_result();
        $row = $resEnd->fetch_assoc();
        $maxRow = $row['count'];

        $end = ceil($maxRow/$limite);

        //BUSCANDO DADOS PARA MOSTRAR NA PAGINA
        if(!empty($_GET['search'])){
            $data = "%".$_GET['search']."%";

            $stmt = $conn->prepare("SELECT * FROM services WHERE id LIKE ? or local_problem LIKE ? or brief_desc LIKE ? ORDER BY date_creation LIMIT $inicio, $limite");
            $stmt->bind_param("iss", $data, $data, $data);
        }else{
            $stmt = $conn->prepare("SELECT * FROM services WHERE status != 2 ORDER BY date_creation LIMIT $inicio, $limite");
        }
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
    <div class="sf-area">
        <input class="sf-input" id="search" data-page="viewrequest.php" placeholder="Buscar">
            <a onclick="searchData()" class="btn btn-success">
                <i class="bi bi-search sf-icon"></i>
            </a>        
    </div>
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
                        $data_formatada = date("d/m/Y H:i", strtotime($user_data['date_creation']));
                        echo "<td>".$data_formatada."</td>";
                        if($user_data['status'] == 0){
                            echo "<td style='color:#0f8d50;'><i class='bi bi-person-fill'></i> Em aberto</td>";
                        }else{
                            if($user_data['status'] == 1){
                                echo "<td style='color:#dfd54d;'><i class='bi bi-person-fill'></i> Designado</td>";
                            }else{
                                if($user_data['status'] == 2){
                                    echo "<td style='color: #b6b6b6;'><i class='bi bi-check-circle'></i> Finalizado</td>";
                                }
                            }
                        }       
                        echo "</td>";
                        echo "<td> <a href='details.php?id=".$user_data['id']."' type='button' class='btn btn-warning jj-send' target='container-dashboard'><i class='bi bi-send-arrow-up' style='font-size: 14px;'></i></a> </td>";
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

    <script src="../scripts/handleSearch.js"></script>
</body>
</html>
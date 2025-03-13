<?php
    session_start();
    if(!isset($_SESSION["id"])){
        echo "<script>alert('Você precisa estar logado'); window.top.location.href='../../index.php';</script>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area do Usuário</title>

    <link rel="shortcut icon" type="imagex/png" href="../imgs/icon_barra.ico">

    <link rel="stylesheet" href="../styles/menu.css">
    
    <!-- IMPORTAÇÃO BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
    <div class="areaDash">
        <div class="container-sidebar">
            <div class="area-user">
                <a class="img-user" style="text-decoration: none; color: #666" href="editPass.php" target='container-dashboard'>
                    <i class="bi bi-person-circle"></i>
                </a>
                <div class="info-user">
                    <span class="dashname"><?php echo $_SESSION['name']; ?></span>
                    <span class="dashposition"><?php echo $_SESSION['position']; ?></span>
                </div>
            </div>
            <nav class="sidemenu">
                <ul>
                    <?php 
                        if($_SESSION['cod_position'] == 2){
                            echo "
                            <li class='item-menu' id='newUser' onclick='redirecionar(this)'>
                                <a href='newUser.php' target='container-dashboard'><i class='bi bi-person-plus'></i> Cadastrar usuario</a>
                            </li>
                            <li class='item-menu' onclick='redirecionar(this)'>
                                <a href='viewUsers.php' target='container-dashboard'><i class='bi bi-people'></i> Usuarios</a>
                            </li>
                            <li class='item-menu' onclick='redirecionar(this)'>
                                <a href='viewrequest.php' target='container-dashboard'><i class='bi bi-tools'></i> Solicitações Pendentes</a>
                            </li>";
                        }
                    ?>
                    <li class="item-menu" onclick="redirecionar(this)">
                        <a href="newOrder.php" target="container-dashboard"><i class="bi bi-pencil-square"></i> Nova Solicitação</a>
                    </li>
                    <?php 
                        if($_SESSION['cod_position'] == 3){
                            echo "
                            <li class='item-menu' onclick='redirecionar(this)'>
                                <a href='myservices.php' target='container-dashboard'><i class='bi bi-hourglass-split'></i> Meus Serviços</a>
                            </li>";
                        }
                    ?>
                    <li class="item-menu" onclick="redirecionar(this)">
                        <a href="myrequest.php" target="container-dashboard"><i class="bi bi-wrench-adjustable-circle"></i> Minhas Solicitações</a>
                    </li>
                    <?php
                        if($_SESSION['cod_position'] == 2){
                            echo "
                        <li class='item-menu' onclick='redirecionar(this)'>
                            <a href='finishedrequest.php' target='container-dashboard'><i class='bi bi-check-circle'></i> Serviços Finalizados</a>
                        </li>";
                        }
                    ?>
                    <li onclick="redirecionar(this)">
                        <a href="../methods/signOut.php"><i class="bi bi-box-arrow-left"></i> Sair</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- SESSÃO DO MODAL -->
        <div class="modal fade" id="modalGlobal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">FOTO</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id="modalImagem" src="" class="img-fluid rounded" alt="foto do problema.">
                        </div>                
                    </div>
                </div>
            </div>
            <!-- FIM DA SESSÃO DO MODAL -->
        <iframe name="container-dashboard" class="container-dashboard"></iframe>
    </div>

    <footer>
        <img src="../imgs/logo-2025.png" alt="Logo da Prefeitura.">
        <p>Prefeitura Municipal de Deodapolis - MS © 2025 - Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../scripts/modal.js"></script>
    <script src="../scripts/effectMenu.js"></script>
    <script src="../scripts/redirecionar.js"></script>
</body>
</html>
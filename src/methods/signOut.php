<?php
    session_start();
    $_SESSION["id"] = '';
    $_SESSION["email"] = '';
    $_SESSION["name"] = '';
    $_SESSION["type"] = '';
    $_SESSION["telefone"] = '';
    $_SESSION["position"] = '';

    session_destroy();

    header('location: ../../index.php');
?>
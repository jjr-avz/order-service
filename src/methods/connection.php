<?php

    // Configurações do banco de dados
    $host = "localhost";  // Servidor do banco de dados
    $user = "root";       // Usuário do banco (padrão no XAMPP é "root")
    $pass = "";           // Senha (padrão no XAMPP é vazia)
    $dbname = "order"; // Nome do banco de dados

    // Criando a conexão com MySQLi
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Verificando erros na conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
?>
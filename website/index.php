<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

include("database.php");

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Biblioteca</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>Biblioteca</h1>

    <p>
        Olá, <?= htmlspecialchars($_SESSION["usuario_nome"]) ?>!
    </p>

    <div class="menu">

        <a href="autores.php" class="menu-btn">
            📋 Ver Autores
        </a>

        <a href="ver_livros.php" class="menu-btn">
            📋 Ver Livros
        </a>

        <a href="emprestar.php" class="menu-btn">
            📋 Alugar um livro
        </a>
        
        <a href="meus_emprestimos.php" class="menu-btn">
            📚 Meus Empréstimos
        </a>
        <a href="logout.php" class="menu-btn">
            🚪 Sair
        </a>

    </div>

</div>

</body>

</html>
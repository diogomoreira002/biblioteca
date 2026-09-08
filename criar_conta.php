<?php

include("database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    if (empty($nome) || empty($email) || empty($senha)) {
        die("Preencha todos os campos.");
    }

    // Verifica se o email já existe
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id FROM usuarios WHERE email = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        mysqli_stmt_close($stmt);

        die("Este email já está cadastrado.");
    }

    mysqli_stmt_close($stmt);

    // Cria o hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Cadastra o usuário
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO usuarios (nome, email, senha)
         VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $nome,
        $email,
        $senhaHash
    );

    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: login.php");
        exit;

    } else {

        echo "Erro ao criar conta.";

        mysqli_stmt_close($stmt);
    }
}

?>

<form method="POST">

    <input
        type="text"
        name="nome"
        placeholder="Nome"
        required
    >

    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >

    <input
        type="password"
        name="senha"
        placeholder="Senha"
        required
    >

    <button type="submit">
        Criar conta
    </button>

</form>

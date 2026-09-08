<?php

session_start();

include("database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, nome, senha FROM usuarios WHERE email = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($result);

    if ($usuario && password_verify($senha, $usuario["senha"])) {

        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_nome"] = $usuario["nome"];

        header("Location: index.php");
        exit;
    }

    $erro = "Email ou senha incorretos.";

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Biblioteca</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                radial-gradient(circle at top, #243b55, #141e30 60%);

            color: #ffffff;
        }

        .login-container {
            width: 100%;
            max-width: 420px;

            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(12px);

            border: 1px solid rgba(255, 255, 255, 0.15);

            border-radius: 18px;

            padding: 40px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .logo {
            text-align: center;

            font-size: 48px;

            margin-bottom: 10px;
        }

        h1 {
            text-align: center;

            font-size: 28px;

            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;

            color: #b8c1cc;

            margin-bottom: 30px;

            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            margin-bottom: 8px;

            font-size: 14px;

            color: #dce3ea;
        }

        input {
            width: 100%;

            padding: 13px 15px;

            border: 1px solid rgba(255, 255, 255, 0.15);

            border-radius: 10px;

            background: rgba(0, 0, 0, 0.2);

            color: white;

            font-size: 15px;

            outline: none;

            transition: 0.2s;
        }

        input::placeholder {
            color: #8995a3;
        }

        input:focus {
            border-color: #5dade2;

            box-shadow: 0 0 0 3px rgba(93, 173, 226, 0.15);
        }

        button {
            width: 100%;

            padding: 14px;

            margin-top: 5px;

            border: none;

            border-radius: 10px;

            background: #3498db;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        button:hover {
            background: #2980b9;

            transform: translateY(-1px);
        }

        .erro {
            background: rgba(231, 76, 60, 0.15);

            border: 1px solid rgba(231, 76, 60, 0.4);

            color: #ff8f85;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

            text-align: center;

            font-size: 14px;
        }

        .register {
            text-align: center;

            margin-top: 25px;

            color: #aeb8c4;

            font-size: 14px;
        }

        .register a {
            color: #5dade2;

            text-decoration: none;

            font-weight: bold;
        }

        .register a:hover {
            text-decoration: underline;
        }

        .back {
            display: block;

            text-align: center;

            margin-top: 20px;

            color: #8995a3;

            text-decoration: none;

            font-size: 13px;
        }

        .back:hover {
            color: white;
        }

    </style>

</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="logo">
            📚
        </div>

        <h1>Bem-vindo</h1>

        <p class="subtitle">
            Entre na sua conta da Biblioteca
        </p>

        <?php if (isset($erro)): ?>

            <div class="erro">
                <?= htmlspecialchars($erro) ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Digite seu email"
                    required
                >

            </div>

            <div class="form-group">

                <label for="senha">
                    Senha
                </label>

                <input
                    type="password"
                    id="senha"
                    name="senha"
                    placeholder="Digite sua senha"
                    required
                >

            </div>

            <button type="submit">
                Entrar
            </button>

        </form>

        <div class="register">

            Ainda não possui uma conta?

            <a href="criar_conta.php">
                Criar conta
            </a>

        </div>

    </div>

</div>

</body>

</html>

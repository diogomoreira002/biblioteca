<?php
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Autor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Novo Autor</h1>

    <form action="cadastrar_autor.php" method="post">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Nome do autor" required>
        </div>

        <div class="form-group">
            <label for="data">Data de Nascimento</label>
            <input type="date" id="data" name="data" required>
        </div>

        <button type="submit">Adicionar</button>
    </form>

    <a href="autores.php" class="btn-back">← Voltar</a>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $data = $_POST['data'] ?? '';

    if (!empty($nome) && !empty($data)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO autor (Nome, DataDeNascimento) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $nome, $data);

        if (mysqli_stmt_execute($stmt)) {
            echo '<div class="success">Autor adicionado com sucesso!</div>';
        } else {
            echo '<div class="error">Erro: ' . mysqli_stmt_error($stmt) . '</div>';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

</body>
</html>   
<?php

include("proteger.php");
include("database.php");

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: autores.php"); exit; }


$stmt = mysqli_prepare($conn, "SELECT * FROM autor WHERE ID = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$row) { header("Location: autores.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $data = $_POST['data'] ?? '';

    $stmt = mysqli_prepare($conn, "UPDATE autor SET Nome = ?, DataDeNascimento = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $nome, $data, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: autores.php?msg=updated");
        exit;
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Autor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Editar Autor</h1>

    <form method="post">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($row['Nome']); ?>" required>
        </div>

        <div class="form-group">
            <label for="data">Data de Nascimento</label>
            <input type="date" id="data" name="data" value="<?php echo $row['DataDeNascimento']; ?>" required>
        </div>

        <button type="submit">Salvar</button>
    </form>

    <a href="autores.php" class="btn-back">← Voltar</a>
</div>

</body>
</html>   
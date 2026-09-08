<?php

include("proteger.php");
include("database.php");

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: ver_livros.php"); exit; }

$stmt = mysqli_prepare($conn, "SELECT * FROM livro WHERE ID = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$row) { header("Location: ver_livros.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = $_POST['nome'] ?? '';
    $autor    = (int)$_POST['autor'];
    $conteudo = $_POST['conteudo'] ?? '';

    $stmt = mysqli_prepare($conn, "UPDATE livro SET Nome = ?, Id_Autor = ?, Conteudo = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "sisi", $nome, $autor, $conteudo, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ver_livros.php?msg=updated");
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
    <title>Editar Livro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Editar Livro</h1>

    <form method="post">
        <div class="form-group">
            <label for="autor">Autor</label>
            <select id="autor" name="autor" required>
                <?php
                $result = mysqli_query($conn, "SELECT ID, Nome FROM autor ORDER BY Nome");
                while ($opt = mysqli_fetch_assoc($result)) {
                    $selected = ($opt['ID'] == $row['Id_Autor']) ? 'selected' : '';
                    echo "<option value='{$opt['ID']}' {$selected}>{$opt['Nome']}</option>";
                }
                mysqli_free_result($result);
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="conteudo">Conteúdo</label>
            <textarea id="conteudo" name="conteudo" rows="5"><?php echo htmlspecialchars($row['Conteudo']); ?></textarea>
        </div>

        <button type="submit">Salvar</button>
    </form>

    <a href="ver_livros.php" class="btn-back">← Voltar</a>
    <a href="livros.php" class="btn-back">📋 Cadastrar</a>
</div>

</body>
</html> 

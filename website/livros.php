<?php

include("proteger.php");
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Livro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Novo Livro</h1>

    <form action="livros.php" method="post">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Nome do livro" required>
        </div>

        <div class="form-group">
            <label for="autor">Autor</label>
            <select id="autor" name="autor" required>
                <option value="" disabled selected>Selecione o autor</option>
                <?php
                $result = mysqli_query($conn, "SELECT ID, Nome FROM autor ORDER BY Nome");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['ID']}'>{$row['Nome']}</option>";
                }
                mysqli_free_result($result);
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="conteudo">Conteúdo</label>
            <textarea id="conteudo" name="conteudo" rows="5" placeholder="Resumo ou conteúdo do livro"></textarea>
        </div>

        <button type="submit">Adicionar</button>
    </form>

    <a href="ver_livros.php" class="btn-back">← Voltar</a>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = $_POST['nome'] ?? '';
    $autor    = $_POST['autor'] ?? '';
    $conteudo = $_POST['conteudo'] ?? '';

    if (!empty($nome) && !empty($autor)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO livro (Nome, Id_Autor, Conteudo) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sis", $nome, $autor, $conteudo);

        if (mysqli_stmt_execute($stmt)) {
            echo '<div class="success">Livro adicionado com sucesso!</div>';
        } else {
            echo '<div class="error">Erro: ' . mysqli_stmt_error($stmt) . '</div>';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

</body>
</html>   
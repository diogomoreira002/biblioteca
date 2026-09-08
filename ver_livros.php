<?php

include("proteger.php");
include("database.php");

// EXCLUIR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM livro WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ver_livros.php?msg=deleted");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Livros</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div class="success">Livro excluído!</div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Autor</th>
                <th>Conteúdo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "
                SELECT livro.*, autor.Nome AS AutorNome
                FROM livro
                JOIN autor ON livro.Id_Autor = autor.ID
                ORDER BY livro.ID
            ");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['ID']}</td>
                        <td class='no-wrap'>{$row['Nome']}</td>
                        <td class='no-wrap'>{$row['AutorNome']}</td>
                        <td class='conteudo' title='{$row['Conteudo']}'>{$row['Conteudo']}</td>
                        <td class='acoes'>
                            <a href='editar_livro.php?id={$row['ID']}' class='btn-edit'>✏️</a>
                            <form method='post' onsubmit=\"return confirm('Excluir {$row['Nome']}?')\" style='display:inline'>
                                <input type='hidden' name='action' value='delete'>
                                <input type='hidden' name='id' value='{$row['ID']}'>
                                <button type='submit' class='btn-delete'>🗑️</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='empty'>Nenhum livro encontrado.</td></tr>";
            }
            mysqli_free_result($result);
            ?>
        </tbody>
    </table>

    <div>
    <a href="index.php" class="btn-back">← Voltar</a>
    <a href="livros.php" class="menu-btn" style="display: inline-block; border-radius: 100px; margin-left: 300px;">📋 Cadastrar</a>
    </div>
</div>

</body>
</html>   
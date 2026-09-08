<?php
include("database.php");

// EXCLUIR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM autor WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: autores.php?msg=deleted");
    exit;
}

// EDITAR (salvar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id   = (int)$_POST['id'];
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
    <title>Autores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Autores</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div class="success"><?php echo $_GET['msg'] === 'deleted' ? 'Autor excluído!' : 'Autor atualizado!'; ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Nascimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM autor ORDER BY ID");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data = date('d/m/Y', strtotime($row['DataDeNascimento']));
                    echo "<tr>
                        <td>{$row['ID']}</td>
                        <td class='no-wrap'>{$row['Nome']}</td>
                        <td>{$data}</td>
                        <td class='acoes'>
                            <a href='editar_autor.php?id={$row['ID']}' class='btn-edit'>✏️</a>
                            <form method='post' onsubmit=\"return confirm('Excluir {$row['Nome']}?')\" style='display:inline'>
                                <input type='hidden' name='action' value='delete'>
                                <input type='hidden' name='id' value='{$row['ID']}'>
                                <button type='submit' class='btn-delete'>🗑️</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='empty'>Nenhum autor encontrado.</td></tr>";
            }
            mysqli_free_result($result);
            ?>
        </tbody>
    </table>

    <a href="index.php" class="btn-back">← Voltar</a>
    <a href="cadastrar_autor.php" class="menu-btn" style="display: inline-block; border-radius: 100px; margin-left: 300px;">📋 Cadastrar</a>
</div>

</body>
</html>   
<?php

include("proteger.php");
include("database.php");

$usuario_id = $_SESSION["usuario_id"];

$sql = "
    SELECT
        e.id,
        e.data_emprestimo,
        e.data_devolucao,
        e.status,
        l.ID AS livro_id,
        l.Nome AS livro_nome
    FROM emprestimos e
    INNER JOIN livro l
        ON e.livro_id = l.ID
    WHERE e.usuario_id = ?
    ORDER BY e.data_emprestimo DESC
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $usuario_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

/*
 * Devolver livro
 */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $emprestimo_id = (int)($_POST["emprestimo_id"] ?? 0);

    if ($emprestimo_id > 0) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE emprestimos
             SET status = 'devolvido',
                 data_devolucao = NOW()
             WHERE id = ?
             AND usuario_id = ?
             AND status = 'emprestado'"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $emprestimo_id,
            $usuario_id
        );

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }

    header("Location: meus_emprestimos.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meus Empréstimos</title>

    <link rel="stylesheet" href="style.css">
    

</head>

<body>

<div class="container">

    <h1>Meus Empréstimos</h1>

    <?php if (mysqli_num_rows($result) == 0): ?>

        <p>Você ainda não possui empréstimos.</p>

    <?php else: ?>

        <table>

            <thead>

                <tr>
                    <th>Livro</th>
                    <th>Data do empréstimo</th>
                    <th>Data de devolução</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

                <?php while ($emprestimo = mysqli_fetch_assoc($result)): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($emprestimo["livro_nome"]) ?>
                        </td>

                        <td>
                            <?= date(
                                "d/m/Y H:i",
                                strtotime($emprestimo["data_emprestimo"])
                            ) ?>
                        </td>

                        <td>

                            <?php if ($emprestimo["data_devolucao"] !== null): ?>

                                <?= date(
                                    "d/m/Y H:i",
                                    strtotime($emprestimo["data_devolucao"])
                                ) ?>

                            <?php else: ?>

                                Ainda não devolvido

                            <?php endif; ?>

                        </td>

                        <td> <?= htmlspecialchars($emprestimo["status"]) ?> <?php if ($emprestimo["status"] === "emprestado"): ?> <form method="POST" style="margin-top: 10px;"> <input type="hidden" name="emprestimo_id" value="<?= (int)$emprestimo["id"] ?>" > <input type="hidden" name="acao" value="devolver" > <button type="submit"> Devolver </button> </form> <?php elseif ($emprestimo["status"] === "devolvido"): ?> <form method="POST" style="margin-top: 10px;"> <input type="hidden" name="emprestimo_id" value="<?= (int)$emprestimo["id"] ?>" > <input type="hidden" name="acao" value="deletar" > <button type="submit"> Excluir </button> </form> <?php endif; ?> </td>


                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    <?php endif; ?>

    <br>

    <a href="index.php" class="btn-back">
        ← Voltar
    </a>

</div>

</body>

</html>

<?php

mysqli_stmt_close($stmt);

?>
```

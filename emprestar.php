<?php

include("proteger.php");
include("database.php");

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedir empréstimo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Pedir empréstimo</h1>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $usuario_id = $_SESSION['usuario_id'];
        $livro_id = (int)($_POST['livro'] ?? 0);

        if ($livro_id <= 0) {

            echo '<div class="error">Selecione um livro.</div>';

        } else {

            /*
             * Verifica se o livro já está emprestado.
             */
            $stmt = mysqli_prepare(
                $conn,
                "SELECT id
                 FROM emprestimos
                 WHERE livro_id = ?
                 AND status = 'emprestado'"
            );

            mysqli_stmt_bind_param($stmt, "i", $livro_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {

                echo '<div class="error">
                        Este livro já está emprestado.
                      </div>';

            } else {

                /*
                 * Cria o empréstimo.
                 */
                $stmt = mysqli_prepare(
                    $conn,
                    "INSERT INTO emprestimos
                    (usuario_id, livro_id, data_emprestimo, status)
                    VALUES (?, ?, NOW(), 'emprestado')"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "ii",
                    $usuario_id,
                    $livro_id
                );

                if (mysqli_stmt_execute($stmt)) {

                    echo '<div class="success">
                            Empréstimo solicitado com sucesso!
                          </div>';

                } else {

                    echo '<div class="error">
                            Erro ao solicitar empréstimo:
                            ' . htmlspecialchars(mysqli_stmt_error($stmt)) . '
                          </div>';
                }
            }

            mysqli_stmt_close($stmt);
        }
    }

    ?>

    <form action="emprestar.php" method="post">

        <div class="form-group">

            <label for="livro">Livro</label>

            <select id="livro" name="livro" required>

                <option value="" disabled selected>
                    Selecione o livro
                </option>

                <?php

                $result = mysqli_query(
                    $conn,
                    "SELECT l.ID, l.Nome
                    FROM livro l
                    LEFT JOIN emprestimos e
                        ON l.ID = e.livro_id
                        AND e.status = 'emprestado'
                    WHERE e.id IS NULL
                    ORDER BY l.Nome"
                );

                while ($row = mysqli_fetch_assoc($result)) {

                    echo '<option value="' .
                         (int)$row['ID'] .
                         '">' .
                         htmlspecialchars($row['Nome']) .
                         '</option>';
                }

                mysqli_free_result($result);

                ?>

            </select>

        </div>

        <button type="submit">
            Pedir empréstimo
        </button>

    </form>

    <br>

    <a href="meus_emprestimos.php" class="btn-back">
        📚 Meus empréstimos
    </a>

    <br>

    <a href="index.php" class="btn-back">
        ← Voltar
    </a>

</div>

</body>
</html>
```

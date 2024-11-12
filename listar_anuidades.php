<?php
include 'db.php';  // Inclui a conexão com o banco de dados

// Consulta todas as anuidades
$sql = "SELECT ano, valor FROM anuidades ORDER BY ano ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$anuidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Anuidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Anuidades</h1>
        <table class="table table-bordered table-striped" border="1">
            <tr class="table-dark">
                <th>Ano</th>
                <th>Valor (R$)</th>
                <th>Ação</th>
            </tr>
            <?php foreach ($anuidades as $anuidade): ?>
                <tr>
                    <td><?php echo htmlspecialchars($anuidade['ano']); ?></td>
                    <td><?php echo 'R$ ' . number_format($anuidade['valor'], 2, ',', '.'); ?></td>
                    <td class="text-center">
                        <a class="btn btn-primary" href="editar_anuidade.php?ano=<?php echo urlencode($anuidade['ano']); ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a class="btn btn-danger" href="index.php">Voltar</a>
        <a class="btn btn-success" href="cadastro_anuidade.php">Cadastrar Anuidade</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
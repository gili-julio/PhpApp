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
</head>

<body>
    <h1>Listagem de Anuidades</h1>
    <table border="1">
        <tr>
            <th>Ano</th>
            <th>Valor (R$)</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($anuidades as $anuidade): ?>
            <tr>
                <td><?php echo htmlspecialchars($anuidade['ano']); ?></td>
                <td><?php echo 'R$ ' . number_format($anuidade['valor'], 2, ',', '.'); ?></td>
                <td>
                    <a href="editar_anuidade.php?ano=<?php echo urlencode($anuidade['ano']); ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Voltar</a>
</body>

</html>

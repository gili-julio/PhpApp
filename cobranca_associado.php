<?php
include 'db.php';

// Verifica se o ID do associado foi passado como parâmetro
if (isset($_GET['associado_id'])) {
    $associado_id = $_GET['associado_id'];

    // Busca o associado
    $stmt = $pdo->prepare("SELECT * FROM associados WHERE id = :id");
    $stmt->bindParam(':id', $associado_id);
    $stmt->execute();
    $associado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$associado) {
        echo "Associado não encontrado.";
        exit;
    }

    // Busca as anuidades a partir da data de filiação
    $ano_filiacao = date('Y', strtotime($associado['data_filiacao']));

    // Busca as anuidades devidas
    $stmt = $pdo->prepare("
        SELECT a.id AS anuidade_id, a.ano, a.valor, COALESCE(p.pago, FALSE) AS pago 
        FROM anuidades a
        LEFT JOIN pagamentos p ON a.id = p.anuidade_id AND p.associado_id = :associado_id
        WHERE a.ano >= :ano_filiacao
        ORDER BY a.ano
    ");
    $stmt->bindParam(':associado_id', $associado_id);
    $stmt->bindParam(':ano_filiacao', $ano_filiacao);
    $stmt->execute();
    $anuidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcula o total devido
    $total_devido = 0;
    foreach ($anuidades as $anuidade) {
        if (!$anuidade['pago']) {
            $total_devido += $anuidade['valor'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associado <?php echo $associado['nome'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php if (isset($associado)): ?>
            <h2>Associado: <?php echo htmlspecialchars($associado['nome']); ?></h2>
            <p>E-mail: <?php echo htmlspecialchars($associado['email']); ?></p>
            <p>Data de Filiação: <?php echo htmlspecialchars($associado['data_filiacao']); ?></p>
    
            <h3>Anuidades Pendentes</h3>
            <table class="table table-bordered table-striped" border="1">
                <tr class="table-dark">
                    <th>Ano</th>
                    <th>Valor (R$)</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
                <?php foreach ($anuidades as $anuidade): ?>
                    <tr>
                        <td><?php echo $anuidade['ano']; ?></td>
                        <td><?php echo number_format($anuidade['valor'], 2, ',', '.'); ?></td>
                        <td class="<?php echo $anuidade['pago'] ? 'text-success' : 'text-danger'; ?>"><?php echo $anuidade['pago'] ? 'Paga' : 'Pendente'; ?></td>
                        <td>
                            <?php if (!$anuidade['pago']): ?>
                                <form method="POST" action="pagar_anuidade.php" style="display:inline;">
                                    <input type="hidden" name="associado_id" value="<?php echo $associado_id; ?>">
                                    <input type="hidden" name="anuidade_id" value="<?php echo $anuidade['anuidade_id']; ?>">
                                    <button class="btn btn-success" type="submit">Pagar</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
    
            <h3>Total Pendente: R$ <?php echo number_format($total_devido, 2, ',', '.'); ?></h3>
            <a class="btn btn-danger" href="index.php">Voltar</a>
        <?php else: header("Location: index.php");?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

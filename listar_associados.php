<?php
include 'db.php';

// Obtém o ano atual
$ano_atual = date('Y');

// Consulta todos os associados e verifica se eles estão em dia com a anuidade do ano atual
$sql = "
    SELECT a.id, a.nome, a.email, a.cpf, a.data_filiacao,
           CASE WHEN p.pago = TRUE THEN 'Em Dia' ELSE 'Em Atraso' END AS status_pagamento
    FROM associados a
    LEFT JOIN (
        SELECT associado_id, pago 
        FROM pagamentos p
        JOIN anuidades an ON p.anuidade_id = an.id
        WHERE an.ano = :ano_atual
    ) p ON a.id = p.associado_id
";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ano_atual', $ano_atual);
$stmt->execute();
$associados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Associados</title>
</head>
<body>
    <h1>Listagem de Associados</h1>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>CPF</th>
            <th>Data de Filiação</th>
            <th>Status de Pagamento</th>
        </tr>
        <?php foreach ($associados as $associado): ?>
            <tr>
                <td><?php echo htmlspecialchars($associado['nome']); ?></td>
                <td><?php echo htmlspecialchars($associado['email']); ?></td>
                <td><?php echo htmlspecialchars($associado['cpf']); ?></td>
                <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($associado['data_filiacao']))); ?></td>
                <td><?php echo htmlspecialchars($associado['status_pagamento']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

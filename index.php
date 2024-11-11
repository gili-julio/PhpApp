<?php
include 'db.php';  // Inclui a conexão com o banco de dados

// Obtém o ano atual
$ano_atual = date('Y');

// Consulta todos os associados e determina o status de pagamento das anuidades devidas
$sql = "
    SELECT a.id, a.nome, a.email, a.cpf, a.data_filiacao,
           CASE
               WHEN (
                   SELECT COUNT(*) 
                   FROM anuidades an 
                   LEFT JOIN pagamentos p ON an.id = p.anuidade_id AND p.associado_id = a.id 
                   WHERE an.ano >= EXTRACT(YEAR FROM a.data_filiacao) AND an.ano <= :ano_atual AND (p.pago IS NULL OR p.pago = FALSE)
               ) = 0 THEN 'Em Dia'
               ELSE 'Em Atraso'
           END AS status_pagamento
    FROM associados a
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
    <title>Ínicio</title>
</head>

<body>
    <h1>Associados</h1>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>CPF</th>
            <th>Data de Filiação</th>
            <th>Status de Pagamento</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($associados as $associado): ?>
            <tr>
                <td><?php echo htmlspecialchars($associado['nome']); ?></td>
                <td><?php echo htmlspecialchars($associado['email']); ?></td>
                <td><?php echo htmlspecialchars($associado['cpf']); ?></td>
                <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($associado['data_filiacao']))); ?></td>
                <td><?php echo htmlspecialchars($associado['status_pagamento']); ?></td>
                <td>
                    <a href="<?php echo "cobranca_associado.php?associado_id=" . $associado['id']; ?>">Ver</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="cadastro_anuidade.php">Cadastrar Anuidade</a>
    <a href="cadastro_associado.php">Cadastrar Associado</a>
</body>

</html>
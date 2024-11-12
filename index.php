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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Associados</h1>
        <table class="table table-bordered table-striped" border="1">
            <tr class="table-dark">
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
                    <td class="text-center align-middle <?php if($associado['status_pagamento'] == "Em Dia") { echo "text-success";} else { echo "text-danger";}?>">
                        <?php echo htmlspecialchars($associado['status_pagamento']); ?></td>
                    <td class="text-center">
                        <a class="btn btn-primary" href="<?php echo "cobranca_associado.php?associado_id=" . $associado['id']; ?>">Ver</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a class="btn btn-primary" href="listar_anuidades.php">Ver Anuidades</a>
        <a class="btn btn-success" href="cadastro_associado.php">Cadastrar Associado</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
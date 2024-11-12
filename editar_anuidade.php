<?php
include 'db.php';  // Inclui a conexão com o banco de dados

// Obtém o ano da anuidade a partir do parâmetro da URL
$ano = isset($_GET['ano']) ? $_GET['ano'] : null;

if ($ano) {
    // Consulta o valor atual da anuidade para o ano fornecido
    $sql = "SELECT ano, valor FROM anuidades WHERE ano = :ano";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
    $stmt->execute();
    $anuidade = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se a anuidade não for encontrada, exibe uma mensagem de erro
    if (!$anuidade) {
        echo "Anuidade não encontrada.";
        exit;
    }
}

// Atualiza o valor da anuidade quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ano = $_POST['ano'];
    $novo_valor = $_POST['valor'];

    // Atualiza o valor da anuidade no banco de dados
    $sql = "UPDATE anuidades SET valor = :valor WHERE ano = :ano";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':valor', $novo_valor);
    $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Anuidade atualizada com sucesso!";
        header("Location: listar_anuidades.php");  // Redireciona de volta para a listagem
        exit;
    } else {
        echo "Erro ao atualizar a anuidade.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Anuidade</title>
</head>

<body>
    <h1>Editando Anuidade de <?php echo $anuidade['ano'];?></h1>
    <?php if ($anuidade): ?>
        <form method="POST" action="editar_anuidade.php">
            <input type="hidden" name="ano" value="<?php echo htmlspecialchars($anuidade['ano']); ?>">
            <label for="valor">Valor (R$):</label>
            <input type="text" name="valor" id="valor" value="<?php echo htmlspecialchars($anuidade['valor']); ?>" required>
            <button type="submit">Atualizar</button>
        </form>
        <a href="listar_anuidades.php">Cancelar</a>
    <?php endif; ?>
</body>

</html>

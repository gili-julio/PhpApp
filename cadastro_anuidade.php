<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ano = $_POST['ano'];
    $valor = $_POST['valor'];

    // Verifica se o ano já existe na tabela
    $stmt = $pdo->prepare("SELECT id FROM anuidades WHERE ano = :ano");
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Se o ano já existe, atualize o valor
        $sql = "UPDATE anuidades SET valor = :valor WHERE ano = :ano";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':ano', $ano);

        if ($stmt->execute()) {
            header("Location: index.php");
            echo "Anuidade atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar a anuidade.";
        }
    } else {
        // Se o ano não existe, insira um novo registro
        $sql = "INSERT INTO anuidades (ano, valor) VALUES (:ano, :valor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':valor', $valor);

        if ($stmt->execute()) {
            header("Location: index.php");
            echo "Anuidade cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar a anuidade.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Anuidade</title>
</head>

<body>
    <h1>Cadastro de Anuidade</h1>
    <form method="POST" action="cadastro_anuidade.php">
        <label for="ano">Ano:</label><br>
        <input type="number" id="ano" name="ano" required><br><br>

        <label for="valor">Valor (R$):</label><br>
        <input type="number" id="valor" name="valor" step="0.01" required><br><br>

        <input type="submit" value="Salvar">
    </form>
    <a href="index.php">Cancelar</a>
</body>

</html>
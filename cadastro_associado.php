<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $data_filiacao = $_POST['data_filiacao'];

    // Prepara o SQL para inserção
    $sql = "INSERT INTO associados (nome, email, cpf, data_filiacao) 
            VALUES (:nome, :email, :cpf, :data_filiacao)";

    $stmt = $pdo->prepare($sql);

    // Liga os parâmetros
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':data_filiacao', $data_filiacao);

    // Executa o SQL e verifica se a inserção foi bem-sucedida
    if ($stmt->execute()) {
        // Redireciona de volta para a página inicial
        header("Location: index.php");
        echo "Associado cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o associado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Associado</title>
</head>
<body>
    <h1>Cadastro de Associado</h1>
    <form method="POST" action="cadastro_associado.php">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf" required><br><br>

        <label for="data_filiacao">Data de Filiação:</label><br>
        <input type="date" id="data_filiacao" name="data_filiacao" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>
    <a href="index.php">Cancelar</a>
</body>
</html>

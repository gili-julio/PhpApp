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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="row justify-content-center">
        <div class="col-6">
            <h1>Cadastro de Associado</h1>
            <form method="POST" action="cadastro_associado.php">
                <label class="form-label" for="nome">Nome:</label><br>
                <input class="form-control" type="text" id="nome" name="nome" required>
        
                <label class="form-label" for="email">E-mail:</label><br>
                <input class="form-control" type="email" id="email" name="email" required>
        
                <label class="form-label" for="cpf">CPF:</label><br>
                <input class="form-control" type="text" id="cpf" name="cpf" required>
        
                <label class="form-label" for="data_filiacao">Data de Filiação:</label><br>
                <input class="form-control mb-3" type="date" id="data_filiacao" name="data_filiacao" required>
        
                <a class="btn btn-danger" href="index.php">Cancelar</a>
                <input class="btn btn-success" type="submit" value="Cadastrar">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

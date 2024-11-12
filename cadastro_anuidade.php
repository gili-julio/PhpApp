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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="row justify-content-center">
        <div class="col-6">
            <h1>Cadastro de Anuidade</h1>
            <form method="POST" action="cadastro_anuidade.php">
                <label class="form-label" for="ano">Ano:</label>
                <input class="form-control" type="number" id="ano" name="ano" required>
        
                <label class="form-label" for="valor">Valor (R$):</label>
                <input class="form-control mb-3" type="number" id="valor" name="valor" step="0.01" required>
        
                <a class="btn btn-danger" href="listar_anuidades.php">Cancelar</a>
                <input class="btn btn-success" type="submit" value="Salvar">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $associado_id = $_POST['associado_id'];
    $anuidade_id = $_POST['anuidade_id'];

    // Verifica se o pagamento já existe na tabela
    $stmt = $pdo->prepare("SELECT * FROM pagamentos WHERE associado_id = :associado_id AND anuidade_id = :anuidade_id");
    $stmt->bindParam(':associado_id', $associado_id);
    $stmt->bindParam(':anuidade_id', $anuidade_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Se já existe, atualize o status para "pago"
        $sql = "UPDATE pagamentos SET pago = TRUE WHERE associado_id = :associado_id AND anuidade_id = :anuidade_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':associado_id', $associado_id);
        $stmt->bindParam(':anuidade_id', $anuidade_id);
        $stmt->execute();
    } else {
        // Insere um novo registro com a flag "pago" como TRUE
        $sql = "INSERT INTO pagamentos (associado_id, anuidade_id, pago) VALUES (:associado_id, :anuidade_id, TRUE)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':associado_id', $associado_id);
        $stmt->bindParam(':anuidade_id', $anuidade_id);
        $stmt->execute();
    }

    // Redireciona de volta para a página de cobrança
    header("Location: cobranca_associado.php?associado_id=" . $associado_id);
    exit();
}
?>

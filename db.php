<?php
$host = 'localhost';
$dbname = 'devs_do_rn';
$username = 'postgres';  // Substitua pelo seu usuário do PostgreSQL
$password = 'postgres';  // Substitua pela sua senha do PostgreSQL

try {
    // Conexão com PostgreSQL usando PDO
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    // Definir o modo de erro de PDO para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

<?php
include 'db.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    exit('Erro: Usuário não autenticado.');
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare('SELECT SUM(valor) AS saldoTotal FROM despesas WHERE usuario_id = ?');
$stmt->execute([$usuario_id]);
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado && isset($resultado['saldoTotal'])) {
    echo number_format($resultado['saldoTotal'], 2, ',', '.');
} else {
    echo '0,00';
}
?>
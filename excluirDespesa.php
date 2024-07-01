<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idDespesa = $_POST['id'];

    try {
        $stmt = $pdo->prepare('DELETE FROM despesas WHERE id = ?');
        $stmt->execute([$idDespesa]);
        header('Location: consulta.php');
        exit;
    } catch (PDOException $e) {
        echo 'Erro ao excluir despesa: ' . $e->getMessage();
    }
} else {
    echo 'ID da despesa não especificado.';
}
?>
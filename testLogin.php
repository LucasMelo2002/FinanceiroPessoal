<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['nome']) || empty($_POST['senha'])) {
        header("Location: index.php?error=emptyfields");
        exit();
    } else {
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE nome = ?');
        $stmt->execute([$nome]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            if (password_verify($senha, $usuario['senha'])) {
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                header("Location: cadastro.php");
                exit();
            } else {
                header("Location: index.php?error=wrongpwd");
                exit();
            }
        } else {
            header("Location: index.php?error=nouser");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
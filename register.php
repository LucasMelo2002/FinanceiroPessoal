<?php
include 'db.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['nome']) || empty($_POST['senha'])) {
        $mensagem = 'Por favor, preencha todos os campos.';
    } else {
        $nome = $_POST['nome'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $stmt_check = $pdo->prepare('SELECT * FROM usuarios WHERE nome = ?');
        $stmt_check->execute([$nome]);
        $usuario_existente = $stmt_check->fetch();

        if ($usuario_existente) {
            $mensagem = 'Este nome de usuário já está em uso.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO usuarios (nome, senha) VALUES (?, ?)');
            if ($stmt->execute([$nome, $senha])) {
                $mensagem = 'Cadastro realizado com sucesso.';
                header("refresh:2;url=index.php");
            } else {
                $mensagem = 'Erro ao cadastrar. Tente novamente mais tarde.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FP - Financeiro Pessoal</title>
    <link rel="shortcut icon" type="imagex/png" href="img/moeda.png">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .login-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .login-form .inputSubmit {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-form .inputSubmit:hover {
            background-color: #0056b3;
        }

        .login-form h5 {
            margin-top: 15px;
            text-align: center;
        }

        .alert {
            margin-top: 20px;
        }

        .valid-feedback,
        .invalid-feedback {
            font-size: 14px;
        }

        .valid-feedback {
            color: #28a745;
        }

        .invalid-feedback {
            color: #dc3545;
        }
    </style>
</head>

<body class="bg-info">
    <div class="container">
        <div class="login-form">
            <h1 class="text-center">Cadastro</h1>

            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-<?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'danger'; ?>"
                    role="alert">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <form id="registerForm" action="register.php" method="POST">
                <input type="text" name="nome" placeholder="Nome de usuário" required>
                <br><br>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                <div class="feedback-container">
                    <div class="feedback-item">
                        <strong><span class="invalid-feedback" id="feedbackMinLength">• 6 caracteres</span></strong>
                        <strong><span class="valid-feedback" id="feedbackMinLengthValid">• 6 caracteres</span></strong>
                    </div>
                    <div class="feedback-item">
                        <strong><span class="invalid-feedback" id="feedbackUpperCase">• Letra maiúscula</span></strong>
                        <strong><span class="valid-feedback" id="feedbackUpperCaseValid">• Letra
                                maiúscula</span></strong>
                    </div>
                </div>
                <br><br>
                <input class="inputSubmit" type="submit" name="submit" value="Cadastrar" disabled>
            </form>
            <h5 class="text-center">Já tem login? <a href="index.php">Logar</a></h5>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script>
        document.getElementById('senha').addEventListener('input', function () {
            var senha = this.value;
            var minLengthFeedback = document.getElementById('feedbackMinLength');
            var minLengthValidFeedback = document.getElementById('feedbackMinLengthValid');
            var upperCaseFeedback = document.getElementById('feedbackUpperCase');
            var upperCaseValidFeedback = document.getElementById('feedbackUpperCaseValid');
            var submitBtn = document.querySelector('.inputSubmit');

            if (senha.length >= 6) {
                minLengthFeedback.style.display = 'none';
                minLengthValidFeedback.style.display = 'block';
                minLengthValidFeedback.style.color = '#28a745';
            } else {
                minLengthFeedback.style.display = 'block';
                minLengthValidFeedback.style.display = 'none';
            }

            if (/[A-Z]/.test(senha)) {
                upperCaseFeedback.style.display = 'none';
                upperCaseValidFeedback.style.display = 'block';
                upperCaseValidFeedback.style.color = '#28a745';
            } else {
                upperCaseFeedback.style.display = 'block';
                upperCaseValidFeedback.style.display = 'none';
            }

            if (senha.length >= 6 && /[A-Z]/.test(senha)) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('disabled');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('disabled');
            }
        });
    </script>
</body>

</html>
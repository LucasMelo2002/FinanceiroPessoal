<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FP - Financeiro Pessoal</title>
    <link rel="shortcut icon" type="imagex/png" href="img/moeda.png">
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
    </style>
</head>

<body class="bg-info">
    <div class="container">
        <div class="login-form">
            <h1 class="text-center">Login</h1>

            <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error === 'emptyfields') {
                    echo '<div class="alert alert-danger" role="alert">Por favor, preencha todos os campos.</div>';
                } elseif ($error === 'nouser') {
                    echo '<div class="alert alert-danger" role="alert">Usuário não encontrado.</div>';
                } elseif ($error === 'wrongpwd') {
                    echo '<div class="alert alert-danger" role="alert">Senha incorreta.</div>';
                }
            }
            ?>

            <form action="testLogin.php" method="POST">
                <input type="text" name="nome" placeholder="Nome de usuário">
                <br><br>
                <input type="password" name="senha" placeholder="Senha">
                <br><br>
                <input class="inputSubmit" type="submit" name="submit" value="Logar">
            </form>

            <h5 class="text-center">Não tem login? <a href="register.php">Cadastre-se</a></h5>
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
</body>

</html>
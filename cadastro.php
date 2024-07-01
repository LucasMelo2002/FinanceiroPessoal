<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = '';
$mensagem = '';

$ano = $mes = $dia = $tipo = $metodo = $descricao = $valor = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $ano = $_POST['ano'];
    $mes = $_POST['mes'];
    $dia = $_POST['dia'];
    $tipo = $_POST['tipo'];
    $metodo = $_POST['metodo'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];

    if (empty($ano) || empty($mes) || empty($dia) || empty($tipo) || empty($metodo) || empty($descricao) || empty($valor)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO despesas (usuario_id, ano, mes, dia, tipo, metodo, descricao, valor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$usuario_id, $ano, $mes, $dia, $tipo, $metodo, $descricao, $valor]);
            $mensagem = 'Despesa cadastrada com sucesso!';
        } catch (PDOException $e) {
            $erro = 'Erro ao salvar a despesa: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <title>FP - Financeiro Pessoal</title>
    <link rel="shortcut icon" type="imagex/png" href="img/moeda.png">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    <style>
        @media (max-width: 576px) {
            .form-control {
                margin-bottom: 10px;
            }
        }

        .erro-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .sucesso-message {
            color: #28a745;
            font-size: 14px;
            margin-top: 5px;
        }

        .alert {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-5">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" width="50" height="35" alt="Orçamento pessoal">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="cadastro.php">Cadastro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="consulta.php">Consulta</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <strong><a class="nav-link" href="logout.php">Sair</a></strong>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col mb-5">
                <h1 class="display-5">Cadastre seus gastos e ganhos</h1>
            </div>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="cadastro.php" method="POST">
            <div class="row mb-2">
                <div class="col-md-2 col-sm-6">
                    <select class="form-control" name="ano" id="ano">
                        <option value="">Ano</option>
                        <option value="2024" <?php if ($ano == '2024')
                            echo 'selected'; ?>>2024</option>
                    </select>
                </div>

                <div class="col-md-3 col-sm-6">
                    <select class="form-control" name="mes" id="mes">
                        <option value="">Mês</option>
                        <option value="1" <?php if ($mes == '1')
                            echo 'selected'; ?>>Janeiro</option>
                        <option value="2" <?php if ($mes == '2')
                            echo 'selected'; ?>>Fevereiro</option>
                        <option value="3" <?php if ($mes == '3')
                            echo 'selected'; ?>>Março</option>
                        <option value="4" <?php if ($mes == '4')
                            echo 'selected'; ?>>Abril</option>
                        <option value="5" <?php if ($mes == '5')
                            echo 'selected'; ?>>Maio</option>
                        <option value="6" <?php if ($mes == '6')
                            echo 'selected'; ?>>Junho</option>
                        <option value="7" <?php if ($mes == '7')
                            echo 'selected'; ?>>Julho</option>
                        <option value="8" <?php if ($mes == '8')
                            echo 'selected'; ?>>Agosto</option>
                        <option value="9" <?php if ($mes == '9')
                            echo 'selected'; ?>>Setembro</option>
                        <option value="10" <?php if ($mes == '10')
                            echo 'selected'; ?>>Outubro</option>
                        <option value="11" <?php if ($mes == '11')
                            echo 'selected'; ?>>Novembro</option>
                        <option value="12" <?php if ($mes == '12')
                            echo 'selected'; ?>>Dezembro</option>
                    </select>
                </div>

                <div class="col-md-2 col-sm-6">
                    <select class="form-control" name="dia" id="dia">
                        <option value="">Dia</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php if ($dia == $i)
                                   echo 'selected'; ?>><?php echo $i; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-2 col-sm-6">
                    <select class="form-control" name="tipo" id="tipo" onchange="atualizarMetodo()">
                        <option value="">Movimentação</option>
                        <option value="entrou" <?php if ($tipo == 'entrou')
                            echo 'selected'; ?>>Depósito</option>
                        <option value="saiu" <?php if ($tipo == 'saiu')
                            echo 'selected'; ?>>Saque</option>
                    </select>
                </div>

                <div class="col-md-3 col-sm-6">
                    <select class="form-control" name="metodo" id="metodo">
                        <option value="">Escolha o método</option>
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Descrição" name="descricao" id="descricao"
                        value="<?php echo htmlspecialchars($descricao); ?>" />
                </div>

                <div class="col-md-3 col-sm-6">
                    <input type="text" class="form-control" placeholder="Valor (R$)" name="valor" id="valor"
                        pattern="[0-9]+([,\.][0-9]+)?" value="<?php echo htmlspecialchars($valor); ?>" />
                </div>

                <div class="col-md-3 col-sm-6">
                    <button type="submit" class="btn bg-info btn-block">
                        <strong>+</strong>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modalRegistraDespesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="modal_titulo_div">
                    <h5 class="modal-title" id="modal_titulo"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_conteudo"></div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" id="modal_btn">Voltar</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const inputValor = document.querySelector('#valor');

            inputValor.addEventListener('input', function (event) {
                const valor = event.target.value;
                if (!isNumeric(valor)) {
                    event.target.value = '';
                }
            });

            function isNumeric(value) {
                return /^\d*\.?\d*$/.test(value);
            }
        });

        function atualizarMetodo() {
            const tipo = document.getElementById('tipo').value;
            const metodo = document.getElementById('metodo');

            // Limpa as opções do método
            metodo.innerHTML = '';

            // Adiciona a opção padrão
            const opcaoPadrao = document.createElement('option');
            opcaoPadrao.value = '';
            opcaoPadrao.text = 'Escolha o método';
            metodo.appendChild(opcaoPadrao);

            // Define as opções com base no tipo selecionado
            if (tipo === 'entrou') {
                const metodosDeposito = ['TED', 'Pix', 'Dinheiro', 'Cheque', 'Salário', 'Presente', 'Outros'];
                metodosDeposito.forEach(function (metodoDeposito) {
                    const opcao = document.createElement('option');
                    opcao.value = metodoDeposito.toLowerCase().replace(/ /g, '_');
                    opcao.text = metodoDeposito;
                    metodo.appendChild(opcao);
                });
            } else if (tipo === 'saiu') {
                const metodosSaque = ['Comida', 'Lazer', 'Saúde', 'Transporte', 'Trabalho', 'Compras', 'Outros'];
                metodosSaque.forEach(function (metodoSaque) {
                    const opcao = document.createElement('option');
                    opcao.value = metodoSaque.toLowerCase().replace(/ /g, '_');
                    opcao.text = metodoSaque;
                    metodo.appendChild(opcao);
                });
            }
        }

        <?php if (!empty($mensagem) || !empty($erro)): ?>
            document.addEventListener('DOMContentLoaded', function () {
                <?php if (!empty($mensagem)): ?>
                    setTimeout(function () {
                        document.querySelector('.alert-success').style.display = 'none';
                    }, 3000);
                <?php endif; ?>

                <?php if (!empty($erro)): ?>
                    setTimeout(function () {
                        document.querySelector('.alert-danger').style.display = 'none';
                    }, 3000);
                <?php endif; ?>
            });
        <?php endif; ?>
    </script>

</body>

</html>
<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare('SELECT * FROM despesas WHERE usuario_id = ?');
$stmt->execute([$usuario_id]);
$despesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$saldoTotal = calcularSaldoTotal($despesas);

function calcularSaldoTotal($despesas)
{
    $saldoTotal = 0;

    foreach ($despesas as $despesa) {
        $valorNumerico = str_replace(',', '.', $despesa['valor']);
        if ($despesa['tipo'] === 'entrou') {
            $saldoTotal += (float) $valorNumerico;
        } elseif ($despesa['tipo'] === 'saiu') {
            $saldoTotal -= (float) $valorNumerico;
        }
    }

    return $saldoTotal;
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
        .painelSaldo {
            align-items: center;
            margin: auto;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 576px) {
            .painelSaldo {
                font-size: 28px;
            }

            .form-control {
                margin-bottom: 10px;
            }
        }

        .consulta-title {
            margin-bottom: 20px;
        }

        .consulta-form {
            margin-bottom: 20px;
        }

        .consulta-table {
            margin-top: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        #saldo {
            font-size: 3rem;
        }

        .painelSaldo {
            align-items: center;
            margin: auto;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .painelSaldo {
                font-size: 28px;
            }

            .form-control {
                margin-bottom: 10px;
            }
        }

        .consulta-title {
            margin-bottom: 20px;
        }

        .consulta-form {
            margin-bottom: 20px;
        }

        .consulta-table {
            margin-top: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        #saldo {
            font-size: 3rem;
        }

        .popover-body {
            padding: 10px;
        }

        .popover .btn-fechar {
            margin-top: 10px;
        }

        .text-success {
            color: green;
        }

        .text-danger {
            color: red;
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
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro.php">Cadastro</a>
                    </li>
                    <li class="nav-item active">
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

        <div class="painelSaldo">
            <div class="mb-5">
                <h1 id="saldo" class="display-1" style="font-size: 3rem;">
                    <?php echo 'R$ ' . number_format($saldoTotal, 2, ',', '.'); ?>
                </h1>
            </div>
        </div>


        <div class="row consulta-title">
            <div class="col">
                <h1 class="display-5">Consulta</h1>
            </div>
        </div>

        <div class="row consulta-form mb-2">
            <div class="col-md-2">
                <select class="form-control" id="ano">
                    <option value="">Ano</option>
                    <option value="2024">2024</option>
                </select>
            </div>

            <div class="col-md-2">
                <select class="form-control" id="mes">
                    <option value="">Mês</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
            </div>

            <div class="col-md-2 col-sm-6">
                <select class="form-control" name="dia" id="dia">
                    <option value="">Dia</option>
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <select class="form-control" name="tipo" id="tipo" onchange="atualizarMetodo()">
                    <option value="">Método</option>
                    <option value="entrou">Deposito</option>
                    <option value="saiu">Saque</option>
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <select class="form-control" name="metodo" id="metodo">
                    <option value="">Escolha o tipo</option>
                </select>
            </div>
        </div>

        <div class="row consulta-form mb-5">
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="Descrição" id="descricao" />
            </div>

            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Valor" id="valor" />
            </div>

            <div class="col-md-2 d-flex justify-content-end">
                <button type="button" id="btnBuscar" class="btn bg-info btn-block">
                    Buscar
                </button>
            </div>
        </div>

        <div class="row consulta-table">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody id="listaDespesas"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
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

            if (tipo === 'entrou') {
                const metodosDeposito = ['TED', 'Pix', 'Dinheiro', 'Cheque', 'Salario', 'Presente', 'Outros'];
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

        function buscarDespesas() {
            const ano = document.querySelector('#ano').value;
            const mes = document.querySelector('#mes').value;
            const dia = document.querySelector('#dia').value;
            const tipo = document.querySelector('#tipo').value;
            const metodo = document.querySelector('#metodo').value;
            const descricao = document.querySelector('#descricao').value;

            const params = {
                ano: ano,
                mes: mes,
                dia: dia,
                tipo: tipo,
                metodo: metodo,
                descricao: descricao
            };

            fetchDespesas(params);
        }

        function carregarDespesas() {
            fetchDespesas({});
        }

        function fetchDespesas(params) {
            fetch('buscarDespesas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(params)
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Resposta da busca:', data);
                    document.querySelector('#listaDespesas').innerHTML = data.html;
                    document.querySelector('#saldo').textContent = 'R$ ' + data.saldoTotal;

                    inicializarPopovers();
                })
                .catch(error => console.error('Erro ao buscar despesas:', error));
        }

        function inicializarPopovers() {
            $('[data-toggle="popover"]').popover({
                html: true,
                sanitize: false
            });
            configurarBotoesExclusao();
            configurarBotaoFechar();
        }

        function configurarBotaoFechar() {
            $(document).on('click', '.btn-fechar', function () {
                $(this).closest('.popover').popover('hide');
            });
        }


        function configurarBotoesExclusao() {
            const botoesExclusao = document.querySelectorAll('.btn-excluir');

            botoesExclusao.forEach(botao => {
                botao.addEventListener('click', function () {
                    const idDespesa = this.getAttribute('data-id');

                    if (confirm('Tem certeza que deseja excluir esta despesa?')) {
                        fetch('excluirDespesa.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `id=${idDespesa}`
                        })
                            .then(response => response.text())
                            .then(() => {
                                carregarDespesas();
                            })
                            .catch(error => console.error('Erro ao excluir despesa:', error));
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            carregarDespesas();


            document.querySelector('#btnBuscar').addEventListener('click', function () {
                console.log('Botão Buscar clicado');
                buscarDespesas();
            });
        });
    </script>
</body>

</html>
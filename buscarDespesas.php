<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    exit('Erro: Usuário não autenticado.');
}

$usuario_id = $_SESSION['usuario_id'];

$params = json_decode(file_get_contents('php://input'), true);

$ano = $params['ano'] ?? '';
$mes = $params['mes'] ?? '';
$dia = $params['dia'] ?? '';
$metodo = $params['metodo'] ?? '';
$tipo = $params['tipo'] ?? '';
$descricao = $params['descricao'] ?? '';

$sql = "SELECT *, CASE 
            WHEN tipo = 'entrou' THEN 'Depósito' 
            WHEN tipo = 'saiu' THEN 'Saque' 
            ELSE tipo 
        END AS tipo_formatado
        FROM despesas 
        WHERE usuario_id = $usuario_id";

if (!empty($ano)) {
    $sql .= " AND ano = '$ano'";
}
if (!empty($mes)) {
    $sql .= " AND mes = '$mes'";
}
if (!empty($dia)) {
    $sql .= " AND dia = '$dia'";
}
if (!empty($metodo)) {

    $sql .= " AND metodo = '$metodo'";
}
if (!empty($tipo)) {

    $sql .= " AND tipo = '$tipo'";
}
if (!empty($descricao)) {
    $sql .= " AND descricao LIKE '%$descricao%'";
}

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$saldoTotal = calcularSaldoTotal($rows);

$html = '';
foreach ($rows as $row) {

    $classeValor = ($row['tipo'] === 'entrou') ? 'text-success' : 'text-danger';

    $html .= '<tr>';
    $html .= '<td>' . $row['dia'] . '/' . $row['mes'] . '/' . $row['ano'] . '</td>';
    $html .= '<td>' . ucfirst($row['metodo']) . '</td>';
    $html .= '<td class="' . $classeValor . '">' . number_format($row['valor'], 2, ',', '.') . '</td>';
    $html .= '<td>';
    $html .= '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" data-placement="left" data-content="<strong>Descrição:</strong> ' . $row['descricao'] . '<br><strong>Método:</strong> ' . ucfirst($row['tipo_formatado']) . '<br><form action=\'excluirDespesa.php\' method=\'POST\' class=\'mt-2\'><input type=\'hidden\' name=\'id\' value=\'' . $row['id'] . '\'><button type=\'submit\' class=\'btn btn-danger btn-sm\'>Excluir</button></form><button type=\'button\' class=\'btn btn-danger btn-sm btn-fechar\'>Fechar</button>" data-html="true">Detalhes</button>';
    $html .= '</td>';
    $html .= '</tr>';
}

echo json_encode([
    'html' => $html,
    'saldoTotal' => number_format($saldoTotal, 2, ',', '.')
]);

function calcularSaldoTotal($despesas)
{
    $saldoTotal = 0;

    foreach ($despesas as $despesa) {
        $saldoTotal += $despesa['tipo'] === 'entrou' ? $despesa['valor'] : -$despesa['valor'];
    }

    return $saldoTotal;
}
?>
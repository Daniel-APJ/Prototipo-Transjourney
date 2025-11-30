<?php
session_start();
require "conexao.php"; 

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["erro" => "Não logado"]);
    exit;
}

$uid = $_SESSION['usuario_id'];

// 1. CONSULTAS (Datas ocupadas)
$consultas = [];
$sql = $conn->query("SELECT DATE_FORMAT(data_consulta, '%Y-%m-%d') as data_fmt FROM consultas WHERE usuario_id = $uid AND data_consulta IS NOT NULL AND status != 'Cancelado'");

while ($row = $sql->fetch_assoc()) {
    $consultas[] = $row['data_fmt']; 
}

// 2. MEDICAMENTOS (Para as bolinhas vermelhas)
$medicamentos = [];
// IMPORTANTE: Busca os campos de data para o cálculo correto no JS
$sqlMed = $conn->query("SELECT nome, frequencia, data_inicio, data_fim, uso_continuo FROM medicamentos WHERE usuario_id = $uid");

while ($row = $sqlMed->fetch_assoc()) {
    $medicamentos[] = $row;
}

echo json_encode([
    "consultas" => $consultas,
    "medicamentos" => $medicamentos
]);
?>
<?php
session_start();
require "conexao.php";

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["erro" => "Usuário não logado"]);
    exit;
}

$uid = $_SESSION['usuario_id'];
$metodo = $_SERVER['REQUEST_METHOD'];

// --- LISTAR (GET) ---
if ($metodo === 'GET') {
    $lista = [];
    $dataFiltro = $_GET['data'] ?? date('Y-m-d');
    
    $dosesTomadas = [];
    $check = $conn->query("SHOW TABLES LIKE 'doses'");
    if($check->num_rows > 0) {
        $stmtDoses = $conn->prepare("SELECT medicamento_id FROM doses WHERE usuario_id = ? AND DATE(data_hora) = ?");
        $stmtDoses->bind_param("is", $uid, $dataFiltro);
        $stmtDoses->execute();
        $res = $stmtDoses->get_result();
        while($d = $res->fetch_assoc()) $dosesTomadas[] = $d['medicamento_id'];
    }

    $sql = $conn->query("SELECT * FROM medicamentos WHERE usuario_id = $uid");
    while ($row = $sql->fetch_assoc()) {
        $row['tomou_hoje'] = in_array($row['id'], $dosesTomadas);
        $lista[] = $row;
    }
    echo json_encode($lista);
    exit;
}

// --- AÇÕES (POST) ---
if ($metodo === 'POST') {
    $dados = json_decode(file_get_contents("php://input"), true);
    $acao = $dados['acao'] ?? null;

    if ($acao === 'registrar_dose') {
        $medId = $dados['id'];
        $dataRegistro = $dados['data'] ?? date('Y-m-d');
        $dataHora = $dataRegistro . ' ' . date('H:i:s');

        $stmt = $conn->prepare("INSERT INTO doses (usuario_id, medicamento_id, data_hora) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $uid, $medId, $dataHora);
        
        if ($stmt->execute()) echo json_encode(["msg" => "Dose registrada!"]);
        else echo json_encode(["erro" => "Erro ao registrar dose."]);
        exit;
    }

    if ($acao === 'excluir') {
        $stmt = $conn->prepare("DELETE FROM medicamentos WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $dados['id'], $uid);
        $stmt->execute();
        echo json_encode(["msg" => "Excluído"]);
        exit;
    }

    // Salvar / Editar
    $nome = $dados['nome'];
    $dose = $dados['dose'];
    $hora = !empty($dados['hora']) ? $dados['hora'] : null;
    $freq = $dados['frequencia'];
    $notif = !empty($dados['notificar']) ? 1 : 0;
    
    // Novas variáveis
    $uso_continuo = !empty($dados['uso_continuo']) ? 1 : 0;
    $data_fim = (!empty($dados['data_fim']) && $uso_continuo == 0) ? $dados['data_fim'] : null;
    $data_inicio = !empty($dados['data_inicio']) ? $dados['data_inicio'] : date('Y-m-d'); // Recebe do JS

    if (isset($dados['id']) && !empty($dados['id'])) {
        // Update: Agora permitimos editar data_inicio também
        $stmt = $conn->prepare("UPDATE medicamentos SET nome=?, dose=?, horario=?, frequencia=?, notificar=?, data_fim=?, uso_continuo=?, data_inicio=? WHERE id=? AND usuario_id=?");
        // ssssisisii (10 tipos)
        $stmt->bind_param("ssssisisii", $nome, $dose, $hora, $freq, $notif, $data_fim, $uso_continuo, $data_inicio, $dados['id'], $uid);
    } else {
        // Insert: Usa a data_inicio enviada
        $stmt = $conn->prepare("INSERT INTO medicamentos (usuario_id, nome, dose, horario, frequencia, notificar, data_inicio, data_fim, uso_continuo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // issssisii (9 tipos)
        $stmt->bind_param("issssisii", $uid, $nome, $dose, $hora, $freq, $notif, $data_inicio, $data_fim, $uso_continuo);
    }
    
    if ($stmt->execute()) echo json_encode(["msg" => "Salvo com sucesso"]);
    else {
        http_response_code(500);
        echo json_encode(["erro" => "Erro SQL: " . $stmt->error]);
    }
    exit;
}
?>
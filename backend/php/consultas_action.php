<?php
session_start();
require "conexao.php";
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["erro" => "Não autorizado"]);
    exit;
}

$uid = $_SESSION['usuario_id'];
$metodo = $_SERVER['REQUEST_METHOD'];

// --- RECUPERAR DADOS ---
if ($metodo === 'GET') {
    $dataUrl = $_GET['data'] ?? null;

    if ($dataUrl) {
        $stmt = $conn->prepare("SELECT * FROM consultas WHERE usuario_id = ? AND data_consulta = ? LIMIT 1");
        $stmt->bind_param("is", $uid, $dataUrl);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($res->num_rows > 0) {
            echo json_encode($res->fetch_assoc()); // Retorna a consulta existente para editar
        } else {
            echo json_encode(null); // Nada nesse dia = Novo agendamento
        }
    } else {
        // Sem data na URL = Novo agendamento em branco
        echo json_encode(null);
    }
    exit;
}

// --- SALVAR / CRIAR ---
if ($metodo === 'POST') {
    $dados = json_decode(file_get_contents("php://input"), true);
    
    $id_consulta = $dados['id'] ?? null; 
    $campo = $dados['campo'];
    $valor = $dados['valor'];

    // Se não tem ID, cria uma NOVA consulta
    if (!$id_consulta) {
        $stmt = $conn->prepare("INSERT INTO consultas (usuario_id, status) VALUES (?, 'Agendado')");
        $stmt->bind_param("i", $uid);
        if (!$stmt->execute()) {
            echo json_encode(["erro" => "Falha ao criar: " . $stmt->error]);
            exit;
        }
        $id_consulta = $conn->insert_id;
    }

    $camposPermitidos = ['tipo', 'data_consulta', 'horario', 'turno', 'profissional', 'especialidade', 'local_endereco'];

    if (in_array($campo, $camposPermitidos)) {
        if ($valor === null || $valor === "null") {
            $stmt = $conn->prepare("UPDATE consultas SET $campo = NULL WHERE id = ? AND usuario_id = ?");
            $stmt->bind_param("ii", $id_consulta, $uid);
        } else {
            $stmt = $conn->prepare("UPDATE consultas SET $campo = ? WHERE id = ? AND usuario_id = ?");
            $stmt->bind_param("sii", $valor, $id_consulta, $uid);
        }
        
        $stmt->execute();
        
        echo json_encode(["status" => "sucesso", "id" => $id_consulta]);
    } else {
        echo json_encode(["erro" => "Campo inválido"]);
    }
    exit;
}
?>
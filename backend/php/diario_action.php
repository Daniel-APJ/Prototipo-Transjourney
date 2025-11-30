<?php
session_start();
require "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$uid = $_SESSION['usuario_id'];

// Recebe os dados do formulário
$id = $_POST['id'] ?? null; // Se vier ID, é edição
$data = $_POST['data'];
$texto = $_POST['texto'];
$reflexao = $_POST['reflexao'];
$emoji = $_POST['emoji'];

if ($id) {
    // --- ATUALIZAR ---
    $stmt = $conn->prepare("UPDATE diario SET data_registro=?, texto=?, reflexao=?, emoji=? WHERE id=? AND usuario_id=?");
    $stmt->bind_param("ssssii", $data, $texto, $reflexao, $emoji, $id, $uid);
} else {
    // --- CRIAR NOVO ---
    $stmt = $conn->prepare("INSERT INTO diario (usuario_id, data_registro, texto, reflexao, emoji) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $uid, $data, $texto, $reflexao, $emoji);
}

if ($stmt->execute()) {
    header("Location: ../../assets/pages/diario.php");
    exit;
} else {
    echo "Erro ao salvar: " . $conn->error;
}
?>
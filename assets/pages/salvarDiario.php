<?php
session_start();
require "../../backend/php/conexao.php";

$uid = $_SESSION['usuario_id'];
$data = $_POST['data'];
$texto = $_POST['texto'];
$reflexao = $_POST['reflexao'];
$emoji = $_POST['emoji'];

// Verifica se é Edição (se tiver ID) ou Criação
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Update logic...
} else {
    $stmt = $conn->prepare("INSERT INTO diario (usuario_id, data_registro, texto, reflexao, emoji) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $uid, $data, $texto, $reflexao, $emoji);
    $stmt->execute();
}

header("Location: diario.php");
?>
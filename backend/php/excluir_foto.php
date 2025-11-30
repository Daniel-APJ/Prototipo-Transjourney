<?php
session_start();
require "conexao.php";

if (!isset($_SESSION['usuario_id']) || !isset($_POST['id'])) {
    header("Location: ../../index.php");
    exit;
}

$uid = $_SESSION['usuario_id'];
$id_foto = $_POST['id'];
$ano = $_POST['ano']; 

// 1. Busca o caminho do arquivo para apagar da pasta
$stmt = $conn->prepare("SELECT caminho_arquivo FROM fotos WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id_foto, $uid);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $foto = $res->fetch_assoc();

    $caminhoFisico = "../../assets" . str_replace("..", "", $foto['caminho_arquivo']);

    if (file_exists($caminhoFisico)) {
        unlink($caminhoFisico);
    }

    // 2. Apaga do Banco
    $del = $conn->prepare("DELETE FROM fotos WHERE id = ?");
    $del->bind_param("i", $id_foto);
    $del->execute();
}

// Redireciona de volta para a grade do ano
header("Location: ../../assets/pages/grade_ano.php?ano=" . $ano);
exit;
?>
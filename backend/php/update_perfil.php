<?php
session_start();
require "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

$genero = $_POST['genero'];
$humor = $_POST['humor'];
$transicao_social = !empty($_POST['transicao_social']) ? $_POST['transicao_social'] : 0;
$transicao_hormonal = !empty($_POST['transicao_hormonal']) ? $_POST['transicao_hormonal'] : 0;
$altura = !empty($_POST['altura']) ? $_POST['altura'] : 0.00;
$peso = !empty($_POST['peso']) ? $_POST['peso'] : 0.00;

$queryFoto = ""; 
$tipos = "ssiiddi"; // String, String, Int, Int, Decimal, Decimal, Int (para o WHERE)
$params = [$genero, $humor, $transicao_social, $transicao_hormonal, $altura, $peso];

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    
    $arquivo = $_FILES['foto'];
    $ext = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png'];

    if (in_array($ext, $permitidos)) {
        $novoNome = "perfil_" . $id_usuario . "_" . time() . "." . $ext;
        
        $destinoFisico = "../../assets/uploads/perfil/" . $novoNome;
        $caminhoBanco = "../uploads/perfil/" . $novoNome;

        if (move_uploaded_file($arquivo['tmp_name'], $destinoFisico)) {
            $queryFoto = ", foto_perfil = ?";
            $tipos = "ssiiddsi"; 
            $params[] = $caminhoBanco;
        }
    }
}

$params[] = $id_usuario;

$sqlStr = "UPDATE perfil SET 
    genero = ?, 
    humor = ?, 
    transicao_social = ?, 
    transicao_hormonal = ?, 
    altura = ?, 
    peso = ? 
    $queryFoto 
    WHERE usuario_id = ?";

$stmt = $conn->prepare($sqlStr);

$stmt->bind_param($tipos, ...$params);

if ($stmt->execute()) {
    header("Location: ../../assets/pages/perfil.php?atualizado=1");
    exit;
} else {
    echo "Erro ao atualizar: " . $conn->error;
}
?>
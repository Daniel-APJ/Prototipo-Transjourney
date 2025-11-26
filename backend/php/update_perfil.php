<?php
session_start();
require "conexao.php";

$id = $_SESSION['usuario_id'];

$genero = $_POST['genero'];
$humor = $_POST['humor'];
$transicao_social = $_POST['transicao_social'];
$transicao_hormonal = $_POST['transicao_hormonal'];
$altura = $_POST['altura'];
$peso = $_POST['peso'];

$sql = $pdo->prepare("UPDATE perfil SET 
    genero = ?, humor = ?, transicao_social = ?, transicao_hormonal = ?, altura = ?, peso = ?
    WHERE id = ?");

$sql->execute([
    $genero, $humor, $transicao_social, $transicao_hormonal, $altura, $peso, $id
]);

header("Location: ../../assets/pages/perfil.php?atualizado=1");
exit;

<?php
require "conexao.php";

$nome = $_POST['nome_social'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$nasc = $_POST['nasc'];

$sql = $conn->prepare("INSERT INTO usuarios (nome_social, email, senha, nascimento) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $nome, $email, $senha, $nasc);

if ($sql->execute()) {
    header("Location: ../index.php?msg=conta_criada");
    exit;
} else {
    echo "Erro ao registrar: " . $conn->error;
}
?>

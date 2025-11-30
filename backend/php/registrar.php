<?php
require "conexao.php";

$nome = $_POST['nome_social'];
$email = $_POST['email'];
$senhaPlain = $_POST['senha']; 
$nasc = $_POST['nasc'];

// --- VALIDAÇÃO DE SEGURANÇA ---

// 1. Verifica tamanho (mínimo 5)
if (strlen($senhaPlain) < 5) {
    echo "<script>alert('Erro: A senha deve ter pelo menos 5 caracteres.'); window.history.back();</script>";
    exit;
}

// 2. Verifica se tem letra e número
if (!preg_match('/[a-zA-Z]/', $senhaPlain) || !preg_match('/[0-9]/', $senhaPlain)) {
    echo "<script>alert('Erro: A senha deve conter pelo menos uma letra e um número.'); window.history.back();</script>";
    exit;
}

$senhaHash = password_hash($senhaPlain, PASSWORD_DEFAULT);

$sql = $conn->prepare("INSERT INTO usuarios (nome_social, email, senha, nascimento) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $nome, $email, $senhaHash, $nasc);

if ($sql->execute()) {
    $novo_id = $conn->insert_id;
    $sqlPerfil = $conn->prepare("INSERT INTO perfil (usuario_id) VALUES (?)");
    $sqlPerfil->bind_param("i", $novo_id);
    $sqlPerfil->execute();

    header("Location: ../../index.php?msg=conta_criada");
    exit;
} else {
    echo "Erro ao registrar: " . $conn->error;
}
?>
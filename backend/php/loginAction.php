<?php
session_start();
require "conexao.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = $conn->prepare("SELECT id, nome_social, senha FROM usuarios WHERE email = ? LIMIT 1");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($senha, $user['senha'])) {
        
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['nome_social'] = $user['nome_social'];

        header("Location: ../../assets/pages/menu.php");
        exit;

    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "E-mail não encontrado.";
}
?>

<?php
session_start();
require "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$uid = $_SESSION['usuario_id'];
$nomeExame = $_POST['nome'];
$data = $_POST['data'];

if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
    
    $arquivo = $_FILES['arquivo'];
    
    // Aceita PDF e Imagens
    $extensoesPermitidas = ['pdf', 'jpg', 'jpeg', 'png'];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

    if (!in_array($extensao, $extensoesPermitidas)) {
        die("Formato inválido. Use PDF, JPG ou PNG.");
    }

    $novoNome = "exame_" . $uid . "_" . time() . "." . $extensao;
    
    // Caminhos
    $destinoFisico = "../../assets/uploads/exames/" . $novoNome;
    $caminhoBanco = "../uploads/exames/" . $novoNome;

    if (move_uploaded_file($arquivo['tmp_name'], $destinoFisico)) {
        
        // Inserção no banco
        $stmt = $conn->prepare("INSERT INTO exames (usuario_id, nome_exame, data_realizacao, caminho_arquivo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $uid, $nomeExame, $data, $caminhoBanco);
        
        if ($stmt->execute()) {
            header("Location: ../../assets/pages/historico.php");
            exit;
        } else {
            echo "Erro no banco: " . $conn->error;
        }

    } else {
        echo "Erro ao salvar arquivo na pasta.";
    }
} else {
    echo "Erro no upload.";
}
?>
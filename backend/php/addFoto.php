<?php
session_start();
require "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$uid = $_SESSION['usuario_id'];
$data = $_POST['data']; // Vem do input date

// Verifica se enviou arquivo
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    
    $arquivo = $_FILES['foto'];
    
    // Validação de Extensão
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

    if (!in_array($extensao, $extensoesPermitidas)) {
        die("Tipo de arquivo não permitido. Apenas JPG e PNG.");
    }

    // Cria um nome único: id_usuario + timestamp + aleatorio
    $novoNome = $uid . "_" . time() . "_" . uniqid() . "." . $extensao;
    
    // Caminho físico onde será salvo (relativo a este arquivo PHP)
    $destinoFisico = "../../assets/uploads/galeria/" . $novoNome;
    
    // Caminho para salvar no Banco (relativo à página galeria.php)
    $caminhoBanco = "../uploads/galeria/" . $novoNome;

    // Move o arquivo da pasta temporária para a pasta final
    if (move_uploaded_file($arquivo['tmp_name'], $destinoFisico)) {
        
        // Salva no MySQL
        $stmt = $conn->prepare("INSERT INTO fotos (usuario_id, data_foto, caminho_arquivo) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $uid, $data, $caminhoBanco);
        
        if ($stmt->execute()) {
            header("Location: ../../assets/pages/galeria.php");
            exit;
        } else {
            echo "Erro ao salvar no banco: " . $conn->error;
        }

    } else {
        echo "Erro ao mover o arquivo para a pasta de uploads.";
    }

} else {
    echo "Nenhum arquivo enviado ou erro no upload.";
}
?>
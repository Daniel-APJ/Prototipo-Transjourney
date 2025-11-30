<?php
session_start();
require "../../backend/php/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$id_user = $_SESSION['usuario_id'];

$sql = $conn->prepare("
    SELECT p.*, u.nascimento 
    FROM perfil p 
    INNER JOIN usuarios u ON p.usuario_id = u.id 
    WHERE p.usuario_id = ?
");

$sql->bind_param("i", $id_user);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $dados_banco = $result->fetch_assoc();
    
    $data_nasc = new DateTime($dados_banco['nascimento']);
    $hoje = new DateTime();
    $idade = $hoje->diff($data_nasc)->y;

    // Foto de perfil: se tiver no banco, usa. Se não, usa o gato padrão.
    $fotoCaminho = "../img/gatoFeliz.jpg"; // Padrão
    if (!empty($dados_banco['foto_perfil']) && $dados_banco['foto_perfil'] !== 'default.jpg') {
        $fotoCaminho = $dados_banco['foto_perfil'];
    }

    $usuario = [
        "nome_social" => $_SESSION['nome_social'],
        "idade" => $idade,
        "genero" => $dados_banco['genero'],
        "humor" => $dados_banco['humor'],
        "transicao_social" => $dados_banco['transicao_social'],
        "transicao_hormonal" => $dados_banco['transicao_hormonal'],
        "altura" => $dados_banco['altura'],
        "peso" => $dados_banco['peso'],
        "descricao" => $dados_banco['descricao'] ?? "Sem descrição."
    ];
} else {
    // Fallback
    $fotoCaminho = "../img/gatoFeliz.jpg";
    $usuario = [
        "nome_social" => $_SESSION['nome_social'], 
        "idade" => "--",
        "descricao" => "",
        "genero" => "",
        "humor" => "",
        "transicao_social" => "",
        "transicao_hormonal" => "",
        "altura" => "",
        "peso" => ""
    ]; 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Transjourney</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <style>
        .foto-editavel {
            cursor: pointer;
            border: 3px dashed var(--azul) !important;
            opacity: 0.8;
        }
        .foto-editavel:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <a href="../pages/menu.php" class="btn-voltar"><i class="fa-solid fa-circle-left"></i></a>
            <button id="btnEditar"><i class="fa-solid fa-pen-to-square"></i></button>
            <button id="btnSalvar" class="hidden">
                <i class="fa-solid fa-circle-check"></i>
            </button>
        </header>

        <main>
            <section class="header-perfil">
                <div style="position:relative; display:inline-block;">
                    <input type="file" id="fotoInput" name="foto" form="formPerfil" accept="image/*" class="hidden">
                    
                    <img src="<?= $fotoCaminho ?>" id="fotoPerfil" alt="Foto do usuário">
                    
                    <i id="iconCam" class="fa-solid fa-camera hidden" 
                       style="position:absolute; bottom:10px; right:10px; background:var(--azul); color:white; padding:8px; border-radius:50%; pointer-events:none;"></i>
                </div>
                <div class="descricao">
                    <h1 id="nomeExibicao"><?php echo htmlspecialchars($usuario["nome_social"]); ?></h1>
                    <h3><?php echo $usuario["idade"]; ?> anos</h3>
                    <p id="descricaoExibicao"><?php echo htmlspecialchars($usuario["descricao"]); ?></p>
                </div>
            </section>
            <section class="infos-perfil">
                <form id="formPerfil" action="../../backend/php/update_perfil.php" method="POST" enctype="multipart/form-data" class="grid-infos">
                    <label>Identidade de gênero:
                        <input type="text" name="genero" value="<?= htmlspecialchars($usuario['genero']) ?>" disabled>
                    </label>
                    <label>Principal humor:
                        <input type="text" name="humor" value="<?= htmlspecialchars($usuario['humor']) ?>" disabled>
                    </label>
                    <label>Idade de transição:
                        <input type="number" name="transicao_social" min="0"
                               value="<?= htmlspecialchars($usuario['transicao_social']) ?>" disabled placeholder="Social">
                        <input type="number" name="transicao_hormonal" min="0"
                               value="<?= htmlspecialchars($usuario['transicao_hormonal']) ?>" disabled placeholder="Hormonal">
                    </label>
                    <div class="imc">
                        <label>Altura:
                            <input type="number" step="0.01" name="altura" value="<?= htmlspecialchars($usuario['altura']) ?>" disabled>
                        </label>
                        <label>Peso:
                            <input type="number" step="0.01" name="peso" value="<?= htmlspecialchars($usuario['peso']) ?>" disabled>
                        </label>
                    </div>
                    
                </form>
            </section>
        </main>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    <script src="../JS/perfil.js"></script>
</body>
</html>
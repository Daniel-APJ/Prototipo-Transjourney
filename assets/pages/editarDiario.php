<?php
require "../../backend/php/conexao.php";
require "../../backend/php/auth.php";

$uid = $_SESSION['usuario_id'];

$modo = $_GET['modo'] ?? 'criar';
$id = $_GET['id'] ?? null;

// --- DADOS PADRÃO (Modo Criar) ---
$data = date('Y-m-d'); 
$texto = "";
$reflexao = "";
$emoji = ""; 

// --- BUSCA DADOS (Modo Editar) ---
if ($modo === "editar" && $id) {
    $stmt = $conn->prepare("SELECT * FROM diario WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $id, $uid);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $reg = $res->fetch_assoc();
        $data = $reg['data_registro'];
        $texto = $reg['texto'];
        $reflexao = $reg['reflexao'];
        $emoji = $reg['emoji'];
    }
}

// Define o Título da Página dinamicamente
$tituloPagina = ($modo === "editar") ? "Editar Entrada" : "Nova Entrada";
$textoBotao = ($modo === "editar") ? "Salvar Alterações" : "Criar Entrada";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" href="../CSS/editarDiario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <a href="./diario.php" class="btn-voltar">
                <i class="fa-solid fa-circle-left"></i>
            </a>
            <h1><?= $tituloPagina ?></h1>
        </header>

        <main>
            <form action="../../backend/php/diario_action.php" method="post">
                
                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="campo data">
                    <label>Data:</label>
                    <input type="date" name="data" value="<?= $data ?>" required>
                </div>
                
                <div class="campo">
                    <label>Diário:</label>
                    <textarea name="texto" placeholder="Como foi seu dia?" required><?= htmlspecialchars($texto) ?></textarea>
                </div>
                
                <div class="campo">
                    <label>Reflexão:</label>
                    <textarea name="reflexao" placeholder="Uma frase ou pensamento..."><?= htmlspecialchars($reflexao) ?></textarea>
                </div>
                
                <div class="campo">
                    <label>Como você está se sentindo?</label>
                    <div class="emoji-selector">
                        <div class="emoji-item <?= $emoji == '😍' ? 'ativo' : '' ?>" data-emoji="😍">😍</div>
                        <div class="emoji-item <?= $emoji == '😊' ? 'ativo' : '' ?>" data-emoji="😊">😊</div>
                        <div class="emoji-item <?= $emoji == '😀' ? 'ativo' : '' ?>" data-emoji="😀">😀</div>
                        <div class="emoji-item <?= $emoji == '🤔' ? 'ativo' : '' ?>" data-emoji="🤔">🤔</div>
                        <div class="emoji-item <?= $emoji == '😥' ? 'ativo' : '' ?>" data-emoji="😥">😥</div>
                    </div>
                    <input type="hidden" name="emoji" id="emojiEscolhido" value="<?= $emoji ?>">
                </div>
                
                <button type="submit"><?= $textoBotao ?></button>
            </form>
        </main>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    <script src="../JS/editarDiario.js"></script>
</body>
</html>
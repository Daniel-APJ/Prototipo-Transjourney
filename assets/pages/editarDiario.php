<?php
require "../../backend/php/auth.php";

// Define o modo (criar ou editar)
$modo = $_GET['modo'] ?? 'criar';

// Dados iniciais (vazios)
$data = "";
$texto = "";
$reflexao = "";
$emoji = "";

// Se estiver editando, carregar dados (mais tarde puxa do MySQL)
if ($modo === "editar" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // 🟦 Quando tiver banco:
    // SELECT * FROM diario WHERE id = $id AND usuario_id = $_SESSION['id']

    // Por enquanto, dados fictícios para teste:
    $data = "2025-09-10";
    $texto = "Hoje senti meu corpo diferente...";
    $reflexao = "Sempre mantendo foco!";
    $emoji = "😄";
}

// Texto do título
$tituloPagina = $modo === "editar" ? "Editar Entrada" : "Nova Entrada";

// Texto do botão
$textoBotao = $modo === "editar" ? "Salvar Alterações" : "Criar Entrada";

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
            <form action="./salvarDiario.php" method="post">
                <!-- necessário quando editar -->
                <?php if ($modo === "editar"): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>

                <div class="campo">
                    <label>Data:</label>
                    <input type="date" name="data" value="<?= $data ?>" required>
                </div>
                <div class="campo">
                    <label>Diário:</label>
                    <textarea name="texto" placeholder="Escreva aqui..." required><?= $texto ?></textarea>
                </div>
                <div class="campo">
                    <label>Reflexão:</label>
                    <textarea name="reflexao" placeholder="Sua reflexão..."><?= $reflexao ?></textarea>
                </div>
                <div class="campo">
                    <label>Como você está se sentindo?</label>
                    <div class="emoji-selector">
                        <div class="emoji-item <?= $emoji === '😍' ? 'ativo' : '' ?>" data-emoji="😍">😍</div>
                        <div class="emoji-item <?= $emoji === '😊' ? 'ativo' : '' ?>" data-emoji="😊">😊</div>
                        <div class="emoji-item <?= $emoji === '😀' ? 'ativo' : '' ?>" data-emoji="😀">😀</div>
                        <div class="emoji-item <?= $emoji === '🤔' ? 'ativo' : '' ?>" data-emoji="🤔">🤔</div>
                        <div class="emoji-item <?= $emoji === '😥' ? 'ativo' : '' ?>" data-emoji="😥">😥</div>
                    </div>
                    <!-- campo real enviado ao PHP -->
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
    <script src="./JS/editarDiario.js"></script>
</body>
</html>

<?php
require "../../backend/php/auth.php";

// Exemplo de fotos temporárias
$fotos = [
    "2025" => [
        ["arquivo" => "../img/gatoFeliz.jpg", "data" => "10/09/2025"],
        ["arquivo" => "../fotos/img2.jpg", "data" => "01/09/2025"],
    ],
    "2024" => []
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria</title>

    <link rel="stylesheet" href="../CSS/galeria.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <!-- HEADER -->
        <header>
            <section class="cabecalho">
                <a href="./menu.php" class="btn-voltar">
                    <i class="fa-solid fa-circle-left"></i>
                </a>
                <h1>Galeria</h1>
            </section>
            <section class="add-foto-btn">  
                <button id="btnAddFoto">
                    <h2>Adicionar foto</h2>
                    <i class="fa-solid fa-circle-plus"></i>
                </button>
            </section>
        </header>

        <!-- POPUP ADICIONAR FOTO -->
        <div id="popupFoto" class="popup-foto">
            <div class="popup-box">
                <button class="close-btn" onclick="fecharPopup()">✕</button>
                <h2>Nova Foto</h2>
                <form action="../../backend/php/addFoto.php" method="post"
                    enctype="multipart/form-data">
                    <label>Data</label>
                    <input type="date" name="data" required>
                    <label>Arquivo (PNG/JPG até 10MB)</label>
                    <input type="file" name="foto" accept=".png,.jpg,.jpeg" required>
                    <button type="submit" class="btn-salvar">Salvar</button>
                </form>
            </div>
        </div>

        <main>
            <?php foreach ($fotos as $ano => $lista): ?>
                <section class="ano-box">
                    <h3><?= $ano ?></h3>
                    <?php if (empty($lista)): ?>
                        <p class="sem-registro">Sem fotos registradas...</p>
                    <?php else: ?>
                        <div class="grade-fotos">
                            <?php foreach ($lista as $foto): ?>
                                <div class="foto-card">
                                    <img src="<?= $foto['arquivo'] ?>" alt="foto">
                                    <div class="info">
                                        <span><?= $foto['data'] ?></span>
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        </main>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    <script src="../JS/galeria.js"></script>
</body>
</html>

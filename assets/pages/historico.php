<?php
require "../../backend/php/auth.php";

// Exemplo temporário até vir do banco:
$exames = [
    "2025" => [
        ["nome" => "Exame 02", "data" => "31/09"],
        ["nome" => "Exame 01", "data" => "20/08"]
    ],
    "2024" => [],
    "2023" => [
        ["nome" => "Exame Checkup", "data" => "10/03"]
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico</title>
    <link rel="stylesheet" href="../CSS/historico.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <section class="topo-row">
                <a href="./menu.php" class="btn-voltar">
                    <i class="fa-solid fa-circle-left"></i>
                </a>
                <h1>Histórico</h1>
            </section>
            <section class="add-row">
                <button id="btnAdd">
                    <h2>Adicionar novo exame</h2>
                    <i class="fa-solid fa-circle-plus"></i>
                </button>
            </section>
        </header>

        <main id="listaExames">
            <?php foreach ($exames as $ano => $lista): ?>
                <section class="ano-box">
                    <h3><?= $ano ?></h3>
                    <?php if (count($lista) === 0): ?>
                        <p class="sem-registro">Sem registro de exames...</p>
                    <?php else: ?>
                        <?php foreach ($lista as $ex): ?>
                            <div class="exame-card">
                                <span><?= $ex["nome"] ?> - <?= $ex["data"] ?></span>
                                <button class="btn-share">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        </main>

        <!-- POPUP ADICIONAR EXAME -->
        <div id="popupAdd" class="popup-add">
            <div class="popup-box">
                <button class="close-btn" onclick="fecharPopup()">✕</button>

                <h2>Novo Exame</h2>

                <form id="formExame" method="post" action="../../backend/php/addExame.php" enctype="multipart/form-data">
                    <label>Nome do Exame</label>
                    <input type="text" name="nome" required placeholder="Ex: Exame de Sangue">

                    <label>Data</label>
                    <input type="date" name="data" required>

                    <label>Arquivo (PDF/JPG/PNG até 10MB)</label>
                    <input type="file" name="arquivo" accept=".pdf,.png,.jpg,.jpeg" required>

                    <button type="submit" class="btn-salvar">Salvar</button>
                </form>
            </div>
        </div>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    <script src="../JS/historico.js"></script>
</body>
</html>

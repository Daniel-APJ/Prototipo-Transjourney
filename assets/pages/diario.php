<?php
require "../../backend/php/auth.php"; // Protege a página

// Exemplo de frases motivacionais (depois deve puxar do banco)
$frases = [
    ["O Nosso Destino Não Oferece A Taça Do Desespero, Mas, Sim, O Cálice Da Oportunidade.", "Richard Nixon"],
    ["Seja forte o suficiente para recomeçar sempre que necessário.", "Desconhecido"],
    ["A jornada é sua. Concentre-se em progredir, não em ser perfeito.", "Desconhecido"]
    //Tá para colocar a frase em uma célula e o autor em outra, assim fica fácil de transformar em array
];

$escolhida = $frases[array_rand($frases)];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário</title>
    <link rel="stylesheet" href="../CSS/diario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <!-- HEADER -->
        <header>
            <div class="quote-box">
                <p><?= $escolhida[0] ?></p>
                <h3>– <?= $escolhida[1] ?></h3>
            </div>
        </header>

        <main id="listaDiario">
            <!-- O resto é preenchido pelo JS -->
        </main>

        <div id="popup">
            <div class="popup-box">
                <button class="close-btn" onclick="closePopup()">✕</button>
                <div class="popup-botoes">
                    <a id="addEntrada" href="./editarDiario.php">Registrar um novo sentimento</a>
                    <a href="./gerenciarDiario.php?modo=editar&id=1">Conferir reflexões</a>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer>
            <a href="../pages/menu.php" class="btn-voltar" id="btnVoltar">
                <i class="fa-solid fa-circle-left"></i>
            </a>
            <h1>DIÁRIO</h1>
            <button id="btnMenu">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
        </footer>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>

    <script src="../JS/diario.js"></script>
</body>
</html>

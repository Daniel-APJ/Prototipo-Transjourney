<?php
require "../../backend/php/conexao.php";
require "../../backend/php/auth.php";

$uid = $_SESSION['usuario_id'];

// Frases motivacionais (virá do banco depois, mantendo array por enquanto)
$frases = [
    ["O Nosso Destino Não Oferece A Taça Do Desespero, Mas, Sim, O Cálice Da Oportunidade.", "Richard Nixon"],
    ["Seja forte o suficiente para recomeçar sempre que necessário.", "Desconhecido"],
    ["A jornada é sua. Concentre-se em progredir, não em ser perfeito.", "Desconhecido"]
];
$escolhida = $frases[array_rand($frases)];

$sql = $conn->query("SELECT * FROM diario WHERE usuario_id = $uid ORDER BY data_registro DESC");

$entradas = [];
while ($row = $sql->fetch_assoc()) {
    $entradas[] = [
        "id" => $row['id'], 
        "data" => date('d/m/Y', strtotime($row['data_registro'])),
        "texto" => $row['texto'], 
        "reflexao" => $row['reflexao'],
        "emoji" => $row['emoji']
    ];
}
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

        <header>
            <div class="quote-box">
                <p><?= $escolhida[0] ?></p>
                <h3>– <?= $escolhida[1] ?></h3>
            </div>
        </header>

        <main id="listaDiario">
            </main>

        <div id="popup">
            <div class="popup-box">
                <button class="close-btn" onclick="closePopup()">✕</button>
                <div class="popup-botoes">
                    <a id="addEntrada" href="./editarDiario.php?modo=criar">Registrar um novo sentimento</a>
                </div>
                <div class="popup-botoes">
                    <a id="statusDiario" href="./template.html">Estatísticas</a>
                </div>
            </div>
        </div>

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
            <i class="fa-solid fa-play"></i><i class="fa-solid fa-circle"></i><i class="fa-solid fa-square-full"></i>
        </div>
    </div>

    <script>
        const entradasDoBanco = <?= json_encode($entradas) ?>;
    </script>
    <script src="../JS/diario.js?v=<?= time() ?>"></script>
</body>
</html>
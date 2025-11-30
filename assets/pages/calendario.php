<!--
<?php
/*

require "../../backend/php/auth.php";
require "../../backend/php/conexao.php";

// Busca consultas, medicações etc.
$eventos = [];

$sql = $conn->query("SELECT * FROM eventos WHERE usuario_id = ".$_SESSION['usuario_id']);

while ($row = $sql->fetch_assoc()) {
    $eventos[] = $row;
}

// Isso envia a lista de eventos para o JS
echo "<script>
        let eventosDoBanco = ".json_encode($eventos).";
      </script>";

      */
?>
    -->


<!-- 
    ATENÇÃO: A versão php não funciona pela falta de um banco de dados chamado eventos, se necessário alterar linha:9
-->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário</title>
    <link rel="stylesheet" href="../CSS/calendario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <a href="../pages/menu.php" class="btn-voltar" id="btnVoltar">
                <i class="fa-solid fa-circle-left"></i>
            </a>
            <h1>Calendário</h1>
        </header>

        <main>
            <div id="popup">
                <div class="popup-box">
                    <button class="close-btn" onclick="closePopup()">✕</button>
                    <p id="popup-msg"></p>
                    <div class="popup-botoes">
                        <a href="javascript:void(0)" class="action-btn medicamento" onclick="addMedicamento()">
                            <i class="fa-solid fa-pills"></i>
                        </a>
                        <a href="javascript:void(0)" class="action-btn consulta" onclick="addConsulta()">
                            <i class="fa-solid fa-notes-medical"></i>
                        </a>
                        <button class="action-btn danger" onclick="removerItem()">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="calendar">
                <div id="calendar-header">
                    <button id="prev">&#9664;</button>
                    <h2 id="month-year"></h2>
                    <button id="next">&#9654;</button>
                </div>
                <div id="weekdays">
                    <div>Dom</div>
                    <div>Seg</div>
                    <div>Ter</div>
                    <div>Qua</div>
                    <div>Qui</div>
                    <div>Sex</div>
                    <div>Sáb</div>
                </div>
                <div id="days"></div> <!--Vão ser gerados vários dias conforme o mês e o ano-->
                </div>
        </main>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>

    <script src="../JS/calendario.js?v=<?= time() ?>"></script>
</body>
</html>
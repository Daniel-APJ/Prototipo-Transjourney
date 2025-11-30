<?php
require "../../backend/php/auth.php"; // garante login do usuário
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Consulta</title>

    <link rel="stylesheet" href="../CSS/consultas.css">
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <a href="./calendario.php" class="btn-voltar">
                <i class="fa-solid fa-circle-left"></i>
            </a>
            <h1>Agendar Consulta</h1>
        </header>

        <main>
            <!-- TIPO DE CONSULTA -->
            <section class="tipo-consulta">
                <label class="opcao">
                    <input type="radio" name="tipo" id="presencial" checked>
                    <span>Consulta Presencial</span>
                </label>
                <label class="opcao">
                    <input type="radio" name="tipo" id="online">
                    <span>Consulta Online</span>
                </label>
            </section>

            <!-- SELECTOR DE DATAS -->
            <section class="data-consulta">
                <button id="prevDia"><i class="fa-solid fa-caret-left"></i></button>
                <section class="dias" id="diasConsulta">
                    <!-- será preenchido pelo JS -->
                </section>
                <button id="nextDia"><i class="fa-solid fa-caret-right"></i></button>
            </section>

            <!-- BLOCO PRINCIPAL -->
            <section class="container">
                <!-- LOCAL -->
                <article class="caixa">
                    <h3>Hospital</h3> <!--Alterar com PHP-->
                    <h4>Endereço da consulta</h4> <!--Alterar com PHP-->
                    <div class="turnos">
                        <button class="turno ativo" data-turno="manha">Manhã</button>
                        <button class="turno" data-turno="tarde">Tarde</button>
                        <button class="turno" data-turno="noite">Noite</button>
                    </div>
                    <h4>Selecione um horário:</h4>
                    <div id="horarios" class="horarios">
                        <!-- preenchido pelo JS -->
                    </div>
                </article>
                <br>
                <article class="caixa">
                    <h4>Selecione um profissional:</h4>
                    <div id="medicos" class="lista-medicos">
                        <!-- preenchido pelo JS -->
                    </div>
                </article>
            </section>
        </main>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>

    <script src="../JS/consultas.js?v=<?= time() ?>"></script>
</body>
</html>

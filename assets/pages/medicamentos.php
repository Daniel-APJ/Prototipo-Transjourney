<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamentos</title>
    <link rel="stylesheet" href="../CSS/medicamentos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <a href="../pages/calendario.php" class="btn-voltar" id="btnVoltar">
                <i class="fa-solid fa-circle-left"></i>
            </a>
            <h1>Medicamentos</h1>
        </header>

        <main>
            <section class="lista-medicamentos" id="listaMedicamentos">
                <!-- Os medicamentos serão carregados pelo JS depois via PHP -->
                <article class="medicamento-item">
                    <div class="banner-remedio">
                        <img src="" alt=""> <!--Mudar conforme o php-->
                    </div>
                    <strong>Remédio</strong>
                    <div class="medicamento-meta">
                        Dose:<br>
                        Horário:<br>
                        Frequência:
                    </div>
                    <div class="btn-area">
                        <button class="btn-edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="btn-delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </article>
            </section>
            <section class="lista-btn-add">
                <!--
                Adicionar Medicação (03.2.1): registrar uma nova medicação. 
                Registrar Dose (03.2.2): informar tipo, quantidade e data; sistema gera lembrete automático. -->
                <button class="add-btn" onclick="openDosePopup()">✓ Registrar Dose</button>
                <button class="add-btn" onclick="openMedicamentoPopup()">+ Adicionar Medicamento</button>
            </section>
        </main>

        <!-- Pop-up Medicamento -->
        <div id="popup-medicamento" class="hidden popup">
            <div class="popup-box">
                <button class="close-btn" onclick="closeMedicamentoPopup()">✕</button>
                <h3>Novo Medicamento</h3>
                <input type="text" id="nome" placeholder="Nome do medicamento">
                <input type="text" id="dose" placeholder="Dosagem (ex: 2ml)">
                <input type="time" id="hora">
                <select id="frequencia">
                    <option value="Diário">Diário</option>
                    <option value="Alternado">Alternado</option>
                    <option value="Semanal">Semanal</option>
                </select>
                <label><input type="checkbox" id="notificar"> Enviar lembrete</label>
                <button class="salvar" onclick="salvarMedicamento()">Salvar</button>
            </div>
        </div>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    <script src="../JS/medicamentos.js"></script>
</body>
</html>
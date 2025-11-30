<?php
require "../../backend/php/conexao.php";
require "../../backend/php/auth.php";

$uid = $_SESSION['usuario_id'];

// Busca apenas os ANOS que têm exames registrados
$sql = $conn->query("SELECT DISTINCT YEAR(data_realizacao) as ano FROM exames WHERE usuario_id = $uid ORDER BY ano DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Exames</title>
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

        <div id="popupAdd" class="popup-add">
            <div class="popup-box">
                <button class="close-btn" onclick="fecharPopup()">✕</button>
                <h2>Novo Exame</h2>
                <form id="formExame" method="post" action="../../backend/php/addExame.php" enctype="multipart/form-data">
                    <label>Nome do Exame</label>
                    <input type="text" name="nome" required placeholder="Ex: Hemograma">

                    <label>Data</label>
                    <input type="date" name="data" required>

                    <label>Arquivo (PDF/JPG/PNG até 10MB)</label>
                    <input type="file" name="arquivo" accept=".pdf,.png,.jpg,.jpeg" required>

                    <button type="submit" class="btn-salvar">Salvar</button>
                </form>
            </div>
        </div>

        <main id="listaExames">
            <?php if ($sql->num_rows == 0): ?>
                <p class="sem-registro" style="text-align:center; margin-top:50px; color:#fff">
                    Nenhum exame registrado.
                </p>
            <?php else: ?>
                <div class="lista-anos">
                    <?php while ($row = $sql->fetch_assoc()): ?>
                        <a href="./lista_exames.php?ano=<?= $row['ano'] ?>" class="ano-box link-ano">
                            <h3><?= $row['ano'] ?></h3>
                            <i class="fa-solid fa-chevron-right" style="color:#000"></i>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </main>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    
    <script src="../JS/historico.js"></script>
    
    <style>
        .link-ano {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            color: var(--preto);
            margin-bottom: 15px;
            transition: transform 0.2s;
        }
        .link-ano:hover { transform: scale(1.02); }
        .link-ano h3 { margin: 0; }
    </style>
</body>
</html>
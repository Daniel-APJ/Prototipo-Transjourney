<?php
require "../../backend/php/conexao.php";
require "../../backend/php/auth.php";

$uid = $_SESSION['usuario_id'];

// Busca apenas os anos que possuem fotos
$sql = $conn->query("SELECT DISTINCT YEAR(data_foto) as ano FROM fotos WHERE usuario_id = $uid ORDER BY ano DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria</title>
    <link rel="stylesheet" href="../CSS/galeria.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <section class="cabecalho">
                <a href="./menu.php" class="btn-voltar"><i class="fa-solid fa-circle-left"></i></a>
                <h1>Galeria</h1>
            </section>
            <section class="add-foto-btn">  
                <button id="btnAddFoto">
                    <h2>Adicionar foto</h2>
                    <i class="fa-solid fa-circle-plus"></i>
                </button>
            </section>
        </header>

        <div id="popupFoto" class="popup-foto">
            <div class="popup-box">
                <button class="close-btn" onclick="fecharPopup()">✕</button>
                <h2>Nova Foto</h2>
                <form action="../../backend/php/addFoto.php" method="post" enctype="multipart/form-data">
                    <label>Data</label>
                    <input type="date" name="data" required>
                    <label>Arquivo (PNG/JPG até 10MB)</label>
                    <input type="file" name="foto" accept=".png,.jpg,.jpeg" required>
                    <button type="submit" class="btn-salvar">Salvar</button>
                </form>
            </div>
        </div>

        <main>
            <?php if ($sql->num_rows == 0): ?>
                <p class="sem-registro" style="text-align:center; margin-top:50px; color:#fff">Nenhuma foto adicionada.</p>
            <?php else: ?>
                <div class="lista-anos">
                    <?php while ($row = $sql->fetch_assoc()): ?>
                        <a href="./grade_ano.php?ano=<?= $row['ano'] ?>" class="ano-box link-ano">
                            <h3><?= $row['ano'] ?></h3>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </main>
        
        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i><i class="fa-solid fa-circle"></i><i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    <script src="../JS/galeria.js"></script>
    <style>
        .link-ano {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .link-ano:active { transform: scale(0.98); }
        .link-ano i { font-size: 20px; color: var(--preto); }
    </style>
</body>
</html>
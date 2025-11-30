<?php
require "../../backend/php/conexao.php";
require "../../backend/php/auth.php";

$uid = $_SESSION['usuario_id'];
$ano = $_GET['ano'] ?? date('Y');

// Busca exames DO ANO ESPECÍFICO
$sql = $conn->prepare("SELECT * FROM exames WHERE usuario_id = ? AND YEAR(data_realizacao) = ? ORDER BY data_realizacao DESC");
$sql->bind_param("ii", $uid, $ano);
$sql->execute();
$res = $sql->get_result();

$exames = [];
while ($row = $res->fetch_assoc()) {
    // Identifica se é PDF ou Imagem para escolher o ícone
    $ext = strtolower(pathinfo($row['caminho_arquivo'], PATHINFO_EXTENSION));
    $isPdf = ($ext === 'pdf');
    
    $exames[] = [
        "nome" => $row['nome_exame'],
        "data" => date('d/m', strtotime($row['data_realizacao'])),
        "arquivo" => $row['caminho_arquivo'],
        "tipo_icon" => $isPdf ? "fa-file-pdf" : "fa-image",
        "cor_icon" => $isPdf ? "var(--vermelho)" : "var(--azul)"
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exames de <?= $ano ?></title>
    <link rel="stylesheet" href="../CSS/historico.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <section class="topo-row">
                <a href="./historico.php" class="btn-voltar">
                    <i class="fa-solid fa-circle-left"></i>
                </a>
                <h1>Exames <?= $ano ?></h1>
            </section>
        </header>

        <main style="padding-top: 20px;">
            <?php if (empty($exames)): ?>
                <p class="sem-registro" style="text-align:center; color:#fff">Nenhum exame neste ano.</p>
            <?php else: ?>
                
                <?php foreach ($exames as $ex): ?>
                    <div class="exame-card">
                        
                        <div class="info-area" onclick="window.open('<?= $ex['arquivo'] ?>', '_blank')" style="display:flex; align-items:center; gap:10px; flex:1; cursor:pointer;">
                            <i class="fa-solid <?= $ex['tipo_icon'] ?>" style="font-size:24px; color:<?= $ex['cor_icon'] ?>;"></i>
                            <div style="display:flex; flex-direction:column;">
                                <span style="font-weight:bold; font-size:15px;"><?= $ex["nome"] ?></span>
                                <span style="font-size:13px; opacity:0.8;"><?= $ex["data"] ?></span>
                            </div>
                        </div>

                        <button class="btn-share" onclick="compartilharExame('<?= $ex['nome'] ?>', '<?= $ex['arquivo'] ?>')">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>

                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </main>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>

    <script>
        function compartilharExame(nome, urlCaminho) {
            const urlCompleta = window.location.origin + window.location.pathname.replace('/assets/pages/lista_exames.php', '') + urlCaminho.replace('..', '');
            
            const assunto = encodeURIComponent("Compartilhamento de Exame: " + nome);
            const corpo = encodeURIComponent("Olá,\n\nEstou compartilhando o exame '" + nome + "'.\n\nVocê pode visualizá-lo ou baixá-lo neste link:\n" + urlCompleta);
            
            window.location.href = `mailto:?subject=${assunto}&body=${corpo}`;
        }
    </script>
    
    <style>
        .exame-card {
            background: var(--branco);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-share {
            background: none;
            border: none;
            color: var(--azul-forte);
            font-size: 22px;
            cursor: pointer;
            padding: 5px;
            transition: transform 0.2s;
        }
        .btn-share:hover {
            transform: scale(1.2);
            color: var(--azul);
        }
    </style>
</body>
</html>
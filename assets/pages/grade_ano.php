<?php
require "../../backend/php/conexao.php";
require "../../backend/php/auth.php";

$uid = $_SESSION['usuario_id'];
$ano = $_GET['ano'] ?? date('Y');

$sql = $conn->prepare("SELECT * FROM fotos WHERE usuario_id = ? AND YEAR(data_foto) = ? ORDER BY data_foto ASC");
$sql->bind_param("ii", $uid, $ano);
$sql->execute();
$res = $sql->get_result();

$fotos = [];
while ($row = $res->fetch_assoc()) {
    $fotos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotos de <?= $ano ?></title>
    <link rel="stylesheet" href="../CSS/galeria.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .grade-fotos {
            display: grid;
            grid-template-columns: 1fr 1fr; 
            gap: 10px;
            padding-bottom: 50px;
            overflow-x: hidden; 
        }

        .popup-opcoes {
            position: absolute; top:0; left:0; width:100%; height:100%;
            background: rgba(0,0,0,0.85);
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }
        .popup-opcoes.show { display: flex; }
        
        .img-preview {
            max-width: 90%;
            max-height: 60%;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 0 15px rgba(255,255,255,0.2);
        }
        
        .botoes-acao {
            display: flex;
            gap: 20px;
        }
        
        .btn-opcao {
            background: var(--branco);
            color: var(--preto);
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.2s;
        }
        .btn-opcao:hover { transform: scale(1.1); }
        .btn-opcao.delete { background: var(--vermelho); color: white; }
        
        .fullscreen-img {
            position: fixed; top:0; left:0; width:100vw; height:100vh;
            background: black; z-index: 100;
            object-fit: contain; display: none;
        }
    </style>
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <section class="cabecalho">
                <a href="./galeria.php" class="btn-voltar"><i class="fa-solid fa-circle-left"></i></a>
                <h1><?= $ano ?></h1>
            </section>
        </header>

        <main>
            <?php if (empty($fotos)): ?>
                <p class="sem-registro" style="text-align:center; color:#fff">Sem fotos.</p>
            <?php else: ?>
                <div class="grade-fotos">
                    <?php foreach ($fotos as $f): ?>
                        <div class="foto-card" onclick="abrirOpcoes('<?= $f['id'] ?>', '<?= $f['caminho_arquivo'] ?>')">
                            <img src="<?= $f['caminho_arquivo'] ?>" alt="foto" loading="lazy">
                            <div class="info">
                                <span><?= date('d/m', strtotime($f['data_foto'])) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>

        <div id="popupOpcoes" class="popup-opcoes">
            <button class="close-btn" onclick="fecharOpcoes()" style="position:absolute; top:20px; right:20px; color:white;">✕</button>
            
            <img id="imgPreview" src="" class="img-preview">
            
            <div class="botoes-acao">
                <button class="btn-opcao" onclick="maximizar()" title="Maximizar">
                    <i class="fa-solid fa-expand"></i>
                </button>
                
                <button class="btn-opcao" onclick="compartilhar()" title="Enviar por Email">
                    <i class="fa-solid fa-envelope"></i>
                </button>
                
                <form action="../../backend/php/excluir_foto.php" method="POST" onsubmit="return confirm('Excluir esta foto?')">
                    <input type="hidden" name="ano" value="<?= $ano ?>">
                    <input type="hidden" name="id" id="idParaDeletar">
                    <button type="submit" class="btn-opcao delete" title="Excluir">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <img id="imgFullscreen" class="fullscreen-img" onclick="fecharMaximizar()">

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i><i class="fa-solid fa-circle"></i><i class="fa-solid fa-square-full"></i>
        </div>
    </div>

    <script>
        let imgAtual = "";

        function abrirOpcoes(id, url) {
            imgAtual = url;
            document.getElementById("imgPreview").src = url;
            document.getElementById("idParaDeletar").value = id;
            document.getElementById("popupOpcoes").classList.add("show");
        }

        function fecharOpcoes() {
            document.getElementById("popupOpcoes").classList.remove("show");
        }

        // 1. Maximizar
        function maximizar() {
            const fs = document.getElementById("imgFullscreen");
            fs.src = imgAtual;
            fs.style.display = "block";
        }
        function fecharMaximizar() {
            document.getElementById("imgFullscreen").style.display = "none";
        }

        // 2. Compartilhar 
        function compartilhar() {
            const assunto = encodeURIComponent("Olha essa foto da minha jornada!");
            const corpo = encodeURIComponent("Oi! Queria compartilhar essa foto com você: " + window.location.origin + imgAtual);
            window.location.href = `mailto:?subject=${assunto}&body=${corpo}`;
        }
    </script>
</body>
</html>
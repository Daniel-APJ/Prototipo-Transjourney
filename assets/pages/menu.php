<?php
session_start();
require "../../backend/php/conexao.php"; 

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$uid = $_SESSION['usuario_id'];
$nome = $_SESSION['nome_social'];

// Busca a foto de perfil no banco
$sql = $conn->query("SELECT foto_perfil FROM perfil WHERE usuario_id = $uid");
$fotoPerfil = "../img/gatoFeliz.jpg"; // Imagem padrão (fallback)
$temFoto = false;

if ($sql && $sql->num_rows > 0) {
    $row = $sql->fetch_assoc();
    // Verifica se existe caminho salvo e se não é o padrão 'default.jpg'
    if (!empty($row['foto_perfil']) && $row['foto_perfil'] !== 'default.jpg') {
        $fotoPerfil = $row['foto_perfil'];
        $temFoto = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <link rel="stylesheet" href="../CSS/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <style>
        /* CSS Inline para garantir que a foto apareça */
        .foto a {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden; /* Garante que a img não vaze do círculo */
        }
        
        .foto img {
            /* Sobrescreve o display:none do CSS original se tiver foto */
            display: <?= $temFoto ? 'block' : 'block' ?> !important; 
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: static; /* Remove absolute para fluir dentro do link */
        }

        .fa-circle-user {
            display: none !important;
        }
    </style>
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>
        <div id="overlay" class="overlay"></div>
        
        <header>
            <nav>
                <button class="btn-burguer" id="btnBurger">
                    <i class="fa-solid fa-bars"></i>
                </button>
                
                <div class="sidebar" id="menuLateral">
                    <button class="btn-burguer-back" id="btnBurgerBack">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <a href="./perfil.php">Perfil</a>
                    <a href="./template.html">Configurações</a>
                    <a href="./template.html">Ajuda</a>
                    <a href="./template.html">Termos de Uso</a>
                    <a href="../../backend/php/logout.php">Log Out</a>
                    <div>
                        <div class="logo">
                            <span>T</span><span>J</span>
                        </div>
                    </div>
                </div>
                
                <a href="../../backend/php/logout.php" class="btn-voltar">
                    <i class="fa-solid fa-right-to-bracket"></i>
                </a>
            </nav>
            
            <section class="foto-container">
                <div class="foto">
                    <a href="./perfil.php">
                        <img src="<?= $fotoPerfil ?>" alt="Foto do usuário">
                    </a>
                </div>
                <h2><?= htmlspecialchars($nome) ?></h2>
            </section>
        </header>
        
        <main>
            <h3>Seus Serviços</h3>
            <section class="menu-container">
                <a href="./calendario.php">
                    <div class="icon-container">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <span>Calendário</span>
                </a>
                <a href="./historico.php">
                    <div class="icon-container">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <span>Histórico</span>
                </a>
                <a href="./galeria.php">
                    <div class="icon-container">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <span>Fotos</span>
                </a>
                <a href="./diario.php">
                    <div class="icon-container">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <span>Diário</span>
                </a>
            </section>
        </main>
        
        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>

    <script src="../JS/menu.js"></script>
</body>
</html>
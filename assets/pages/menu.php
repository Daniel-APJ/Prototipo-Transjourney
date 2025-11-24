<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

$nome = $_SESSION['nome_social']; 
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <link rel="stylesheet" href="../CSS/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
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
                    <a href="./editar_perfil.php">Editar Perfil</a>
                    <a href="./config.php">Configurações</a>
                    <a href="./ajuda.php">Ajuda</a>
                    <a href="./termos.php">Termos de Uso</a>
                    <a href="../../backend/php/logout.php">Log Out</a>
                    <div>
                        <span class="logo"></span>
                    </div>
                </div>
                
                <a href="../../backend/php/logout.php" class="btn-voltar">
                    <i class="fa-solid fa-right-to-bracket"></i>
                </a>
            </nav>
            <section class="foto-container">
                <div class="foto">
                    <i class="fa-solid fa-circle-user"></i>
                    <img src="../img/gatoFeliz.jpg" alt="Foto do usuário">
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
                <a href="./fotografias.php">
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
<?php
session_start();

// Bloqueio caso não esteja logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

// Simulação temporária do que viria do BD (substituir depois):
$usuario = [
    "nome_social" => $_SESSION['nome_social'] ?? "Usuário",
    "idade" => $_SESSION['idade'] ?? "20",
    "descricao" => $_SESSION['descricao'] ?? "Breve descrição que não passa de duas linhas.",
    "genero" => $_SESSION['genero'] ?? "Não informado",
    "humor" => $_SESSION['humor'] ?? "😊",
    "transicao_social" => $_SESSION['transicao_social'] ?? "",
    "transicao_hormonal" => $_SESSION['transicao_hormonal'] ?? "",
    "altura" => $_SESSION['altura'] ?? "",
    "peso" => $_SESSION['peso'] ?? ""
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Transjourney</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <header>
            <a href="../pages/menu.php" class="btn-voltar"><i class="fa-solid fa-circle-left"></i></a>
            <!-- botão editar -->
            <button id="btnEditar"><i class="fa-solid fa-pen-to-square"></i></button>
            <!-- botão salvar -->
            <button id="btnSalvar" class="hidden">
                <i class="fa-solid fa-circle-check"></i>
            </button>
        </header>

        <main>
            <section class="header-perfil">
                <div>
                    <input type="file" id="fotoInput" class="hidden">
                    <img src="../img/gatoFeliz.jpg" id="fotoPerfil" alt="Foto do usuário">
                </div>
                <div class="descricao">
                    <h1 id="nomeExibicao"><?php echo htmlspecialchars($usuario["nome_social"]); ?></h1>
                    <h3><?php echo $usuario["idade"]; ?> anos</h3>
                    <p id="descricaoExibicao"><?php echo htmlspecialchars($usuario["descricao"]); ?></p>
                </div>
            </section>
            <section class="infos-perfil">
                <form id="formPerfil" action="../../backend/php/update_perfil.php" method="POST" class="grid-infos">
                    <label>Identidade de gênero:
                        <input type="text" name="genero" value="<?= $usuario['genero'] ?>" disabled>
                    </label>
                    <label>Principal humor:
                        <!-- Mudar para algo que recebe a média dos humores-->
                        <input type="text" name="humor" value="<?= $usuario['humor'] ?>" disabled>
                    </label>
                    <label>Idade de transição:
                        <input type="number" name="transicao_social" min="5"
                               value="<?= $usuario['transicao_social'] ?>" disabled placeholder="Social">
                        <input type="number" name="transicao_hormonal" min="5"
                               value="<?= $usuario['transicao_hormonal'] ?>" disabled placeholder="Hormonal">
                    </label>
                    <label>Altura:
                        <input type="number" name="altura" value="<?= $usuario['altura'] ?>" disabled>
                    </label>
                    <label>Peso:
                        <input type="number" name="peso" value="<?= $usuario['peso'] ?>" disabled>
                    </label>
                </form>
            </section>
        </main>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    <script src="../JS/perfil.js"></script>
</body>
</html>

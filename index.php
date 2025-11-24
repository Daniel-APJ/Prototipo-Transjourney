<?php
    // Se usuário já estiver logado, manda pra home
    session_start();
    if (isset($_SESSION['usuario_id'])) {
    header("Location: ./assets/pages/menu.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TransJourney</title>
    <link rel="stylesheet" href="./assets/CSS/main.css">
    <link rel="stylesheet" href="./assets/CSS/cadastrar.css">
    <!--Fonte de ícones-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head>
<body>
    <div class="celular">
        <div class="botoes-celular topo"></div>

        <section class="logar-container" id="loginContainer">
            <header>
                <div class="logo login">
                    <span>T</span><span>J</span>
                </div>
            </header>
            <main>
                <h1>Login</h1>
                <h3>Acesse sua jornada</h3>
                <form id="fazerLogin" action="./backend/php/loginAction.php" method="POST">
                    <input type="email" name="email" id="iptEmail" required placeholder="E-MAIL">
                    <br>
                    <input 
                        type="password" 
                        id="iptSenhaLogin" 
                        name="senha"
                        required 
                        minlength="5" 
                        title="A senha deve conter pelo menos um número"
                        placeholder="SENHA">
                    <button id="btnLogin" type="submit">Entrar</button>
                </form>
                <section>
                    <a href="#">Esqueceu sua senha?</a> <!--Enviar para uma futura tela de esqueceu a senha-->
                    <br>
                    <a id="aCadastro">Criar uma conta!</a>
                </section>
            </main>
        </section>

        <!-- Container para quando alterar para o modo cadastrar -->
        <section class="cadastrar-container desativado" id="cadContainer">
            <header>
                <button class="btn-voltar" id="btnVoltar">
                    <i class="fa-solid fa-circle-left"></i>
                </button>
                <div class="logo">
                    <span>T</span><span>J</span>
                </div>
            </header>
            <main>
                <h1>Criar Nova Conta</h1>
                <a id="linkLoginVoltar" href="#">Já tem uma conta? Entre aqui</a>
                <form class="fazerRegistro" id="formCadastro" action="./backend/php/registrar.php" method="POST">
                    <input type="text" 
                        id="iptNome" 
                        name="nome_social" 
                        required 
                        maxlength="50" 
                        placeholder="NOME SOCIAL">
                    <br>
                    <input type="email" id="iptEmailCad" name="email" required placeholder="E-MAIL">
                    <br>
                    <input type="password" 
                        id="iptSenhaCad" 
                        name="senha"
                        required 
                        minlength="5" 
                        title="A senha deve conter pelo menos um número"
                        placeholder="SENHA">
                    <br>
                    <input type="password" id="iptConfSe" required minlength="5" placeholder="CONFIRMAR SENHA">
                    <br>
                    <input type="date" id="iptNasc" name="nasc" required>
                    <br>
                    <button type="submit">Criar Conta</button>
                </form>
            </main>
        </section>

        <div class="botoes-celular chao">
            <i class="fa-solid fa-play"></i>
            <i class="fa-solid fa-circle"></i>
            <i class="fa-solid fa-square-full"></i>
        </div>
    </div>
    <script src="./assets/JS/index.js"></script>
</body>
</html>
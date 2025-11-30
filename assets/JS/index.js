const loginContainer = document.getElementById("loginContainer");
const cadContainer = document.getElementById("cadContainer");

const btnCadastro = document.getElementById("aCadastro");
const btnVoltar = document.getElementById("btnVoltar");
const linkLoginVoltar = document.getElementById("linkLoginVoltar");

// Alternância entre telas de Login e Cadastro
btnCadastro.addEventListener("click", () => {
    loginContainer.classList.add("desativado");
    cadContainer.classList.remove("desativado");
});

btnVoltar.addEventListener("click", () => {
    cadContainer.classList.add("desativado");
    loginContainer.classList.remove("desativado");
});

linkLoginVoltar.addEventListener("click", () => {
    cadContainer.classList.add("desativado");
    loginContainer.classList.remove("desativado");
});

// --- VALIDAÇÃO DO FORMULÁRIO DE CADASTRO ---
const formCadastro = document.getElementById("formCadastro");

formCadastro?.addEventListener("submit", (e) => {
    const senha = document.getElementById("iptSenhaCad")?.value;
    const conf = document.getElementById("iptConfSe")?.value;

    // 1. Verifica se as senhas são iguais
    if (senha !== conf) {
        e.preventDefault();
        alert("As senhas não coincidem!");
        return; 
    }

    // 2. Verifica requisitos: Min 5 chars, 1 Letra, 1 Número
    const regexSeguranca = /^(?=.*[a-zA-Z])(?=.*[0-9]).{5,}$/;

    if (!regexSeguranca.test(senha)) {
        e.preventDefault();
        alert("A senha deve ter pelo menos 5 caracteres, contendo pelo menos uma letra e um número.");
    }
});
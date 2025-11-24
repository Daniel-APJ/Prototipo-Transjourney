const loginContainer = document.getElementById("loginContainer");
const cadContainer = document.getElementById("cadContainer");

const btnCadastro = document.getElementById("aCadastro");
const btnVoltar = document.getElementById("btnVoltar");
const linkLoginVoltar = document.getElementById("linkLoginVoltar");

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

// Validação de senhas iguais
const formCadastro = document.getElementById("formCadastro");

formCadastro?.addEventListener("submit", (e) => {
    const senha = document.getElementById("iptSenhaCad")?.value;
    const conf = document.getElementById("iptConfSe")?.value;

    if (senha !== conf) {
        e.preventDefault();
        alert("As senhas não coincidem!");
    }
});

const btnEditar = document.getElementById("btnEditar");
const btnSalvar = document.getElementById("btnSalvar");
const inputs = document.querySelectorAll("input:not(#fotoInput)");
const form = document.getElementById("formPerfil");

// Ativar edição
btnEditar.addEventListener("click", () => {
    inputs.forEach(i => i.disabled = false);

    btnEditar.classList.add("hidden");
    btnSalvar.classList.remove("hidden");
});

// Salvar
btnSalvar.addEventListener("click", () => {
    form.submit();
});

// Abrir popup
document.getElementById("btnAdd").addEventListener("click", () => {
    document.getElementById("popupAdd").classList.add("show");
});

// Fechar popup
function fecharPopup() {
    document.getElementById("popupAdd").classList.remove("show");
}

// Validação do tamanho do arquivo (até 10MB)
document.querySelector("input[name='arquivo']").addEventListener("change", (e) => {
    const file = e.target.files[0];

    if (file.size > 10 * 1024 * 1024) {
        alert("Arquivo maior que 10MB não é permitido!");
        e.target.value = "";
    }
});

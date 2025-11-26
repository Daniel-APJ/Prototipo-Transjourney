document.getElementById("btnAddFoto").addEventListener("click", () => {
    document.getElementById("popupFoto").classList.add("show");
});

function fecharPopup() {
    document.getElementById("popupFoto").classList.remove("show");
}

// Validação 10MB
document.querySelector("input[name='foto']").addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file.size > 10 * 1024 * 1024) {
        alert("Arquivo maior que 10MB!");
        e.target.value = "";
    }
});

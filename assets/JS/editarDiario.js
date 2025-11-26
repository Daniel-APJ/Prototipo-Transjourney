// Seleção de emoji
document.querySelectorAll(".emoji-item").forEach(item => {
    item.addEventListener("click", () => {

        // Remove o ativo anterior
        document.querySelectorAll(".emoji-item").forEach(e => e.classList.remove("ativo"));

        // Marca o clicado
        item.classList.add("ativo");

        // Atualiza o input hidden
        document.getElementById("emojiEscolhido").value = item.dataset.emoji;
    });
});

const lista = document.getElementById("listaDiario");
const popup = document.getElementById("popup");
const btnMenu = document.getElementById("btnMenu");

// Entradas temporárias
const entradas = [
    {
        data: "08/08/2025",
        titulo: "Querido Diário",
        texto: "Hoje foi meu primeiro dia tomando...",
        reflexao: "Tudo funciona quando você tenta uma segunda vez.",
        emoji: "😊"
    },
    {
        data: "01/09/2025",
        titulo: "Querido Diário",
        texto: "Eu fiquei me perguntando hoje como...",
        reflexao: "Nem tudo funciona quando você tenta uma segunda vez.",
        emoji: "🤔"
    },
    {
        data: "10/09/2025",
        titulo: "Funcionou",
        texto: "Hoje sinto meu corpo diferente...",
        reflexao: "Mantenha-se firme na jornada!",
        emoji: "😄"
    }
];

// Renderiza cards do diário
function carregarEntradas() {
    lista.innerHTML = "";

    entradas.forEach(ent => {
        lista.innerHTML += `
            <div class="card-diario">
                <span class="emoji">${ent.emoji}</span>
                <p class="data">${ent.data}</p>
                <p class="titulo">${ent.titulo}</p>
                <p class="texto">${ent.texto}</p>
                <p class="texto"><b>Reflexão:</b> ${ent.reflexao}</p>
            </div>
        `;
    });
}

carregarEntradas();

// Abrir menu
btnMenu.addEventListener("click", () => {
    popup.classList.add("show");
});

// Fechar popup
function closePopup() {
    popup.classList.remove("show");
}

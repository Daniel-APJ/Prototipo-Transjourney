const lista = document.getElementById("listaDiario");
const popup = document.getElementById("popup");
const btnMenu = document.getElementById("btnMenu");


const entradas = (typeof entradasDoBanco !== 'undefined') ? entradasDoBanco : [];

function carregarEntradas() {
    lista.innerHTML = "";

    if (entradas.length === 0) {
        lista.innerHTML = "<p style='text-align:center; color:white; margin-top:20px; opacity:0.8;'>Nenhum registro no diário ainda.</p>";
        return;
    }

    entradas.forEach(ent => {
        lista.innerHTML += `
            <div class="card-diario">
                <span class="emoji">${ent.emoji}</span>
                <p class="data">${ent.data}</p>
                <p class="texto">${ent.texto}</p>
                
                ${ent.reflexao ? `<p class="texto"><b>Reflexão:</b> ${ent.reflexao}</p>` : ''}
                
                <a href="./editarDiario.php?modo=editar&id=${ent.id}">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </div>
        `;
    });
}

carregarEntradas();

if (btnMenu) {
    btnMenu.addEventListener("click", () => {
        popup.classList.add("show");
    });
}

function closePopup() {
    popup.classList.remove("show");
}
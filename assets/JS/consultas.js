// ------------- GERA DIAS -------------


//Obs: Alterar o código para pegar a data que foi selecionada ao invés do dia atual

const diasDiv = document.getElementById("diasConsulta");

const hoje = new Date();

function formatarData(d) {
    return d.toLocaleDateString("pt-BR", { day: "2-digit", month: "2-digit" });
}

function gerarDias() {
    diasDiv.innerHTML = "";

    for (let i = 0; i < 3; i++) {
        let data = new Date();
        data.setDate(hoje.getDate() + i);

        const diaSemana = data.toLocaleDateString("pt-BR", { weekday: "long" });
        const rotulo =
            i === 0 ? "HOJE" :
            i === 1 ? "AMANHÃ" : diaSemana.toUpperCase();

        diasDiv.innerHTML += `
            <article class="dia ${i === 0 ? "ativo" : ""}" data-dia="${data}">
                <p>${formatarData(data)}</p>
                <span>${rotulo}</span>
            </article>
        `;
    }

    ativarSelecaoDias();
}

function ativarSelecaoDias() {
    const botoes = document.querySelectorAll(".dia");

    botoes.forEach(btn => {
        btn.onclick = () => {
            document.querySelector(".dia.ativo")?.classList.remove("ativo");
            btn.classList.add("ativo");
        };
    });
}

gerarDias();

// ------------- TURNOS -------------
const horarios = {
    manha: ["07:00", "07:30", "08:00", "08:30"],
    tarde: ["13:00", "13:30", "14:00", "14:30"],
    noite: ["18:00", "18:30", "19:00", "19:30"]
};

const horariosDiv = document.getElementById("horarios");

function carregarHorarios(turno) {
    horariosDiv.innerHTML = "";
    horarios[turno].forEach(h => {
        horariosDiv.innerHTML += `<button class="hora">${h}</button>`;
    });

    document.querySelectorAll(".hora").forEach(hora => {
        hora.onclick = () => {
            document.querySelector(".hora.ativo")?.classList.remove("ativo");
            hora.classList.add("ativo");
        };
    });
}

carregarHorarios("manha");

// Eventos dos botões de turno
document.querySelectorAll(".turno").forEach(btn => {
    btn.onclick = () => {
        document.querySelector(".turno.ativo")?.classList.remove("ativo");
        btn.classList.add("ativo");
        carregarHorarios(btn.dataset.turno);
    };
});

// ----------- MÉDICOS (fake por enquanto) -----------
const medicosDiv = document.getElementById("medicos");

const medicos = [
    { nome: "Dra. Júlia", esp: "Endocrinologia" },
    { nome: "Dr. Victor", esp: "Psiquiatria" },
    { nome: "Dra. Alice", esp: "Clínica Geral" }
];

function carregarMedicos() {
    medicosDiv.innerHTML = "";
    medicos.forEach((m, idx) => {
        medicosDiv.innerHTML += `
            <div class="medico" data-id="${idx}">
                <span class="icone">
                    <img src="../img/gatoFeliz.jpg" alt="foto-medico">
                </span>
                <div>
                    <p>${m.nome}</p>
                    <small>${m.esp}</small>
                </div>
            </div>
        `;
    });

    document.querySelectorAll(".medico").forEach(m => {
        m.onclick = () => {
            document.querySelector(".medico.ativo")?.classList.remove("ativo");
            m.classList.add("ativo");
        };
    });
}

carregarMedicos();

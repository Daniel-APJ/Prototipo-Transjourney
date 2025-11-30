let estadoAtual = {}; 
let dataVisualizacao = new Date(); 

document.addEventListener("DOMContentLoaded", async () => {
    lerDataDaUrl();
    renderizarDias();
    await carregarEstado();
    configurarNavegacao();
});

// --- LÊ A DATA DA URL ---
function lerDataDaUrl() {
    const params = new URLSearchParams(window.location.search);
    const dataUrl = params.get('data'); 

    if (dataUrl) {
        const partes = dataUrl.split('-'); 
        dataVisualizacao = new Date(partes[0], partes[1] - 1, partes[2]);        
        estadoAtual.data_consulta = dataUrl;       
        console.log("Data definida via URL:", dataUrl);
    } else {
        console.log("Nenhuma data na URL, usando HOJE.");
        dataVisualizacao = new Date();
    }
}

// --- RENDERIZAÇÃO DOS DIAS ---
function renderizarDias() {
    const diasDiv = document.getElementById("diasConsulta");
    if (!diasDiv) return;

    diasDiv.innerHTML = "";
    
    // Loop de -1 (Ontem) a +1 (Amanhã) relativo à dataVisualizacao (Centro)
    for (let i = -1; i <= 1; i++) {
        let dataLoop = new Date(dataVisualizacao);
        dataLoop.setDate(dataVisualizacao.getDate() + i);
        
        let dbFormat = formatarDataISO(dataLoop); 
        let diaSemana = dataLoop.toLocaleDateString("pt-BR", { weekday: "short" }).replace('.', '');
        
        // Rótulos (Hoje/Amanhã)
        const hojeReal = new Date();
        hojeReal.setHours(0,0,0,0);
        
        let dataLoopSemHora = new Date(dataLoop);
        dataLoopSemHora.setHours(0,0,0,0);

        const diffTempo = dataLoopSemHora - hojeReal;
        const diffDias = Math.round(diffTempo / (1000 * 60 * 60 * 24));
        
        let rotulo = diaSemana.toUpperCase();
        if (diffDias === 0) rotulo = "HOJE";
        if (diffDias === 1) rotulo = "AMANHÃ";
        if (diffDias === -1) rotulo = "ONTEM";

        let article = document.createElement('article');
        article.className = "dia";
        
        if (dbFormat === estadoAtual.data_consulta) {
            article.classList.add('ativo');
        }

        article.innerHTML = `<p>${formatarDataVisivel(dataLoop)}</p><span>${rotulo}</span>`;
        
        // Evento de Clique no Dia
        article.onclick = () => {
            document.querySelectorAll('.dia').forEach(d => d.classList.remove('ativo'));
            article.classList.add('ativo');
            dataVisualizacao = new Date(dataLoop);
            salvarAutomatico('data_consulta', dbFormat);
        };
        
        diasDiv.appendChild(article);
    }
}

// --- NAVEGAÇÃO ---
function configurarNavegacao() {
    const btnPrev = document.getElementById("prevDia");
    const btnNext = document.getElementById("nextDia");

    if (btnPrev) {
        btnPrev.onclick = () => {
            dataVisualizacao.setDate(dataVisualizacao.getDate() - 1);
            renderizarDias();
        };
    }

    if (btnNext) {
        btnNext.onclick = () => {
            dataVisualizacao.setDate(dataVisualizacao.getDate() + 1);
            renderizarDias();
        };
    }
}

// --- BANCO DE DADOS ---
async function carregarEstado() {
    try {
        const params = new URLSearchParams(window.location.search);
        const dataUrl = params.get('data');
        
        let urlFetch = "../../backend/php/consultas_action.php";
        if (dataUrl) urlFetch += `?data=${dataUrl}`;

        const req = await fetch(urlFetch);
        const dados = await req.json();
        
        if (dados) {
            estadoAtual = dados;
            
            if (dataUrl) {
                estadoAtual.data_consulta = dataUrl;
            } else if (dados.data_consulta) {
                const partes = dados.data_consulta.split('-');
                dataVisualizacao = new Date(partes[0], partes[1] - 1, partes[2]);
                renderizarDias();
            }
        } else {
            estadoAtual = { id: null };
            if (dataUrl) {
                estadoAtual.data_consulta = dataUrl;
                await salvarAutomatico('data_consulta', dataUrl);
            }
        }
        
        aplicarVisualCampos();
    } catch (e) {
        console.error("Erro ao carregar consultas", e);
    }
}

async function salvarAutomatico(campo, valor) {    
    let valorParaEnviar = valor;

    if (campo !== 'data_consulta' && estadoAtual[campo] == valor) {
        valorParaEnviar = null; 
    }

    estadoAtual[campo] = valorParaEnviar;
    aplicarVisualCampos();
    
    if (campo === 'data_consulta') renderizarDias();

    try {
        await fetch("../../backend/php/consultas_action.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                id: estadoAtual.id, 
                campo: campo,
                valor: valorParaEnviar
            })
        })
        .then(r => r.json())
        .then(res => {
            if (res.id) estadoAtual.id = res.id;
        });

    } catch (e) {
        console.error("Erro ao salvar:", e);
    }
}

// --- VISUAL DOS CAMPOS ---
function aplicarVisualCampos() {
    // Tipo
    if (estadoAtual.tipo === 'Presencial') document.getElementById('presencial').checked = true;
    else if (estadoAtual.tipo === 'Online') document.getElementById('online').checked = true;
    else {
        if(document.getElementById('presencial')) document.getElementById('presencial').checked = false;
        if(document.getElementById('online')) document.getElementById('online').checked = false;
    }

    // Turnos
    document.querySelectorAll('.turno').forEach(t => {
        t.classList.remove('ativo');
        if (t.dataset.turno === estadoAtual.turno) {
            t.classList.add('ativo')
        };
    });

    /* essa daqui funciona o hover:
    document.querySelectorAll(".turno").forEach(btn => {
        btn.onclick = () => {
            document.querySelector(".turno.ativo")?.classList.remove("ativo");
            btn.classList.add("ativo");
            carregarHorarios(btn.dataset.turno);
        };
    });
    */

    // Horários
    document.querySelectorAll('.hora').forEach(h => {
        h.classList.remove('ativo');
        if (estadoAtual.horario && estadoAtual.horario.startsWith(h.innerText)) {
            h.classList.add('ativo');
        }
    });

    // Médicos
    document.querySelectorAll('.medico').forEach(m => {
        m.classList.remove('ativo');
        if (m.querySelector('p').innerText === estadoAtual.profissional) {
            m.classList.add('ativo');
        }
    });
}

// --- UTILITÁRIOS ---
function formatarDataISO(d) { 
    const ano = d.getFullYear();
    const mes = String(d.getMonth() + 1).padStart(2, '0');
    const dia = String(d.getDate()).padStart(2, '0');
    return `${ano}-${mes}-${dia}`;
}
function formatarDataVisivel(d) {
    return d.toLocaleDateString("pt-BR", { day: "2-digit", month: "2-digit" });
}

// --- LISTENERS ---
document.querySelectorAll('input[name="tipo"]').forEach(r => r.addEventListener('click', e => salvarAutomatico('tipo', e.target.id === 'presencial' ? 'Presencial' : 'Online')));

document.querySelectorAll(".turno").forEach(btn => btn.onclick = () => {
    let t = btn.dataset.turno; 
    let tBanco = t === 'manha' ? 'Manhã' : t.charAt(0).toUpperCase() + t.slice(1);
    salvarAutomatico('turno', tBanco);
    carregarHorarios(t); 
});

const listaHorarios = {
    manha: ["07:00", "07:30", "08:00", "08:30"],
    tarde: ["13:00", "13:30", "14:00", "14:30"],
    noite: ["18:00", "18:30", "19:00", "19:30"]
};
function carregarHorarios(turno) {
    const div = document.getElementById("horarios");
    if(!div) return;
    div.innerHTML = "";
    if(!listaHorarios[turno]) return;
    listaHorarios[turno].forEach(h => {
        let btn = document.createElement('button');
        btn.className = 'hora';
        btn.innerText = h;
        if (estadoAtual.horario && estadoAtual.horario.startsWith(h)) btn.classList.add('ativo');
        btn.onclick = () => salvarAutomatico('horario', h + ":00");
        div.appendChild(btn);
    });
}
carregarHorarios("manha");

// ----------- MÉDICOS (fake por enquanto) -----------
const listaMedicos = [
    { nome: "Dra. Júlia", esp: "Endocrinologia" },
    { nome: "Dr. Victor", esp: "Psiquiatria" },
    { nome: "Dra. Alice", esp: "Clínica Geral" }
];
function carregarMedicosLista() {
    const div = document.getElementById("medicos");
    if(!div) return;
    div.innerHTML = "";
    listaMedicos.forEach(m => {
        let el = document.createElement('div');
        el.className = 'medico';
        el.innerHTML = `<span class="icone"><img src="../img/placeholder.jpeg"></span><div><p>${m.nome}</p><small>${m.esp}</small></div>`;
        el.onclick = () => salvarAutomatico('profissional', m.nome);
        div.appendChild(el);
    });
}
carregarMedicosLista();
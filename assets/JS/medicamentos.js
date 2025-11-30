let editId = null; 
let medicamentos = [];
let dataFiltro = null;
let idMedicamentoSelecionado = null; 

document.addEventListener("DOMContentLoaded", () => {
    configurarInputs();
    configurarDataUrl();
    carregarDoBanco();
});

function configurarInputs() {
    const checkContinuo = document.getElementById('uso_continuo');
    const inputDataFim = document.getElementById('data_fim');
    if(checkContinuo && inputDataFim) {
        checkContinuo.addEventListener('change', () => {
            inputDataFim.disabled = checkContinuo.checked;
            if (checkContinuo.checked) inputDataFim.value = "";
        });
    }
}

function configurarDataUrl() {
    const params = new URLSearchParams(window.location.search);
    const dataUrl = params.get('data');
    
    if (dataUrl) {
        dataFiltro = dataUrl;
    } else {
        const hoje = new Date();
        const offset = hoje.getTimezoneOffset();
        const localDate = new Date(hoje.getTime() - (offset*60*1000));
        dataFiltro = localDate.toISOString().split('T')[0];
    }

    const titulo = document.querySelector("h1");
    if (titulo) {
        const [ano, mes, dia] = dataFiltro.split('-');
        titulo.innerText = `Medicamentos (${dia}/${mes})`;
    }
}

async function carregarDoBanco() {
    try {
        const req = await fetch(`../../backend/php/medicamentos_action.php?data=${dataFiltro}`);
        const todosMedicamentos = await req.json();
        
        medicamentos = todosMedicamentos.filter(med => deveTomarNaData(med, dataFiltro));
        renderMedicamentos();
    } catch (e) {
        console.error("Erro ao buscar medicamentos:", e);
    }
}

function selecionarCard(id) {
    if (idMedicamentoSelecionado == id) {
        idMedicamentoSelecionado = null;
    } else {
        idMedicamentoSelecionado = id;
    }
    renderMedicamentos();
}

async function registrarDoseSelecionada() {
    if (!idMedicamentoSelecionado) {
        alert("Selecione um medicamento primeiro clicando nele.");
        return;
    }

    try {
        const req = await fetch("../../backend/php/medicamentos_action.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                acao: 'registrar_dose',
                id: idMedicamentoSelecionado,
                data: dataFiltro 
            })
        });
        
        const res = await req.json();
        
        if (res.msg) {
            const med = medicamentos.find(m => m.id == idMedicamentoSelecionado);
            if(med) med.tomou_hoje = true;
            idMedicamentoSelecionado = null; 
            renderMedicamentos(); 
        } else {
            alert("Erro: " + res.erro);
        }
    } catch (e) {
        console.error("Erro ao registrar:", e);
    }
}

function openMedicamentoPopup(index = null) {
    document.getElementById("popup-medicamento").style.display = "flex";
    const checkContinuo = document.getElementById('uso_continuo');
    const inputDataFim = document.getElementById('data_fim');
    const inputDataInicio = document.getElementById('data_inicio'); // Novo campo

    if (index !== null) {
        // MODO EDIÇÃO
        const m = medicamentos[index];
        editId = m.id; 
        document.querySelector("#popup-medicamento h3").textContent = "Editar Medicamento";
        document.getElementById("nome").value = m.nome;
        document.getElementById("dose").value = m.dose;
        document.getElementById("hora").value = m.horario; 
        document.getElementById("frequencia").value = m.frequencia;
        document.getElementById("notificar").checked = (m.notificar == 1);
        
        // Preenche datas existentes
        inputDataInicio.value = m.data_inicio || "";
        
        checkContinuo.checked = (m.uso_continuo == 1);
        inputDataFim.value = m.data_fim || "";
        inputDataFim.disabled = checkContinuo.checked;

    } else {
        // MODO NOVO REGISTRO
        editId = null;
        document.querySelector("#popup-medicamento h3").textContent = "Novo Medicamento";
        document.getElementById("nome").value = "";
        document.getElementById("dose").value = "";
        document.getElementById("hora").value = "";
        document.getElementById("frequencia").value = "Diário";
        document.getElementById("notificar").checked = false;
        
        // Define a Data de Início como a data selecionada no calendário (ou hoje)
        inputDataInicio.value = dataFiltro;

        checkContinuo.checked = true;
        inputDataFim.value = "";
        inputDataFim.disabled = true;
    }
}

async function salvarMedicamento() {
    const med = {
        id: editId,
        nome: document.getElementById("nome").value,
        dose: document.getElementById("dose").value,
        hora: document.getElementById("hora").value,
        frequencia: document.getElementById("frequencia").value,
        notificar: document.getElementById("notificar").checked,
        // Envia as datas
        data_inicio: document.getElementById("data_inicio").value,
        uso_continuo: document.getElementById("uso_continuo").checked,
        data_fim: document.getElementById("data_fim").value
    };

    await fetch("../../backend/php/medicamentos_action.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(med)
    });
    carregarDoBanco(); 
    closeMedicamentoPopup();
}

// ... (Mantenha as funções auxiliares: closeMedicamentoPopup, excluirMedicamento, deveTomarNaData, renderMedicamentos, formatarData) ...
// (Abaixo repito elas para garantir que você tenha o arquivo completo e funcional)

function closeMedicamentoPopup() {
    document.getElementById("popup-medicamento").style.display = "none";
}

function renderMedicamentos() {
    const lista = document.getElementById("listaMedicamentos"); 
    if(!lista) return;
    lista.innerHTML = "";

    if (medicamentos.length === 0) {
        lista.innerHTML = `<p style="text-align:center; width:100%; margin-top:20px; color:gray;">Nenhum medicamento programado para esta data.</p>`;
        return;
    }

    medicamentos.forEach((m, i) => {
        let img = "../img/placeholder.jpeg"; 
        let infoDuracao = (m.uso_continuo == 1) ? "Uso Contínuo" : `Até ${formatarData(m.data_fim)}`;
        
        let classes = "medicamento-item";
        if (m.tomou_hoje) {
            classes += " tomado";
        } else if (idMedicamentoSelecionado != null && m.id == idMedicamentoSelecionado) {
            classes += " selecionado";
        }
        
        lista.innerHTML += `
        <article class="${classes}" onclick="selecionarCard(${m.id})">
            <div class="banner-remedio">
                <img src="${img}" alt="Remédio"> 
            </div>
            <strong>${m.nome}</strong>
            <div class="medicamento-meta">
                Dose: ${m.dose}<br>
                Horário: ${m.horario || '--:--'}<br>
                Frequência: ${m.frequencia}<br>
                <small style="color:var(--azul); font-weight:bold;">${infoDuracao}</small>
            </div>
            <div class="btn-area">
                <button class="btn-edit" onclick="event.stopPropagation(); openMedicamentoPopup(${i})">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="btn-delete" onclick="event.stopPropagation(); excluirMedicamento(${m.id})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </article>
        `;
    });
}

function deveTomarNaData(med, dataAlvoStr) {
    if (!med.data_inicio) return true;
    const inicio = new Date(med.data_inicio); 
    const alvo = new Date(dataAlvoStr);
    
    const utcInicio = Date.UTC(inicio.getFullYear(), inicio.getMonth(), inicio.getDate());
    const utcAlvo = Date.UTC(alvo.getFullYear(), alvo.getMonth(), alvo.getDate());

    const diffTempo = utcAlvo - utcInicio;
    const diffDias = Math.floor(diffTempo / (1000 * 60 * 60 * 24));

    if (diffDias < 0) return false;

    if (med.uso_continuo != 1 && med.data_fim) {
        const fim = new Date(med.data_fim);
        const utcFim = Date.UTC(fim.getFullYear(), fim.getMonth(), fim.getDate());
        if (utcAlvo > utcFim) return false;
    }

    if (med.frequencia === 'Diário') return true;
    if (med.frequencia === 'Alternado') return diffDias % 2 === 0;
    if (med.frequencia === 'Semanal') return diffDias % 7 === 0;

    return true; 
}

function formatarData(dataISO) {
    if(!dataISO) return "";
    const [ano, mes, dia] = dataISO.split('-');
    return `${dia}/${mes}/${ano}`;
}

async function excluirMedicamento(id) {
    if (confirm("Deseja realmente excluir esta medicação?")) {
        await fetch("../../backend/php/medicamentos_action.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ acao: 'excluir', id: id })
        });
        carregarDoBanco();
    }
}
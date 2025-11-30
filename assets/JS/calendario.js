let date = new Date();
const monthYear = document.getElementById("month-year");
const daysDiv = document.getElementById("days");

const months = [
  "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
  "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];

let dadosBanco = { consultas: [], medicamentos: [] };

document.addEventListener("DOMContentLoaded", () => {
    buscarDadosDoBanco();
});

async function buscarDadosDoBanco() {
    try {
        const req = await fetch("../../backend/php/calendario_action.php");
        if (!req.ok) throw new Error(req.status);
        
        const resposta = await req.json();
        if (resposta.consultas) dadosBanco = resposta;
        
        renderCalendar();
    } catch (e) {
        console.error("Erro:", e);
    }
}

function renderCalendar() {
    const year = date.getFullYear();
    const month = date.getMonth();
    monthYear.textContent = `${months[month]} ${year}`;
    daysDiv.innerHTML = "";
    
    const firstDay = new Date(year, month, 1).getDay();
    const lastDay = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) daysDiv.innerHTML += `<div class="day empty"></div>`;

    for (let d = 1; d <= lastDay; d++) {
        const mesF = (month + 1).toString().padStart(2, '0');
        const diaF = d.toString().padStart(2, '0');
        const dataAtual = `${year}-${mesF}-${diaF}`;

        let indicadoresHtml = '';
        if (dadosBanco.consultas.includes(dataAtual)) indicadoresHtml += `<span class="dot consulta"></span>`;
        
        // Verifica se há remédios para ESTE dia específico
        const temRemedioHoje = dadosBanco.medicamentos.some(med => deveTomarHoje(med, dataAtual));
        if (temRemedioHoje) indicadoresHtml += `<span class="dot medicamento"></span>`;

        daysDiv.innerHTML += `
            <div class="day" onclick="openDay(${d})">
                ${d}
                ${indicadoresHtml}
            </div>
        `;
    }
}

// LÓGICA DE DATAS
function deveTomarHoje(med, dataCalendarioStr) {
    if (!med.data_inicio) return true; // Se por algum motivo não tiver data, assume sim

    // Converte tudo para data zerada (00:00:00) para evitar bugs de fuso horário
    const inicio = new Date(med.data_inicio + "T00:00:00");
    const atual = new Date(dataCalendarioStr + "T00:00:00");

    // 1. Verifica se já passou da data final (se não for contínuo)
    if (med.uso_continuo != 1 && med.data_fim) {
        const fim = new Date(med.data_fim + "T00:00:00");
        if (atual > fim) return false; 
    }

    // 2. Calcula diferença em dias
    const diffTempo = atual - inicio;
    const diffDias = Math.floor(diffTempo / (1000 * 60 * 60 * 24));

    // Se a data do calendário é anterior ao início do remédio, não mostra
    if (diffDias < 0) return false;

    // 3. Frequência
    if (med.frequencia === 'Diário') return true;
    if (med.frequencia === 'Alternado') return diffDias % 2 === 0;
    if (med.frequencia === 'Semanal') return diffDias % 7 === 0;

    return false;
}

// ... (Mantenha as funções openDay, showPopupHTML, closePopup, nav prev/next e actions iguais) ...
// (Só copiei a parte lógica crítica acima. O resto do arquivo permanece o mesmo do passo anterior)

let dataSelecionadaPopup = null;

function openDay(day) {
    const year = date.getFullYear();
    const month = date.getMonth();
    const mesF = (month + 1).toString().padStart(2, '0');
    const diaF = day.toString().padStart(2, '0');
    dataSelecionadaPopup = `${year}-${mesF}-${diaF}`;

    const remediosDoDia = dadosBanco.medicamentos.filter(med => deveTomarHoje(med, dataSelecionadaPopup));

    let htmlConteudo = `<strong>Dia ${day}</strong><br><br>`;
    
    if (remediosDoDia.length > 0) {
        htmlConteudo += `<div style="text-align:left; margin-bottom:10px; color:var(--vermelho); font-weight:bold;"><u>Medicamentos:</u><ul style="padding-left:20px; margin-top:5px;">`;
        remediosDoDia.forEach(m => {
            htmlConteudo += `<li>${m.nome}</li>`;
        });
        htmlConteudo += `</ul></div>`;
    } else {
        htmlConteudo += `<p>Nenhum medicamento.</p>`;
    }

    if (dadosBanco.consultas.includes(dataSelecionadaPopup)) {
        htmlConteudo += `<br><div style="color:var(--azul); font-weight:bold;">• Consulta Agendada</div>`;
    }

    showPopupHTML(htmlConteudo);
}

function showPopupHTML(html) {
    const el = document.getElementById("popup-msg");
    if(el) el.innerHTML = html;
    document.getElementById("popup").classList.add("show");
}

function closePopup() {
    document.getElementById("popup").classList.remove("show");
}

document.getElementById("prev").onclick = () => { date.setMonth(date.getMonth() - 1); renderCalendar(); };
document.getElementById("next").onclick = () => { date.setMonth(date.getMonth() + 1); renderCalendar(); };

function addMedicamento() {
    if (dataSelecionadaPopup) window.location.href = `./medicamentos.php?data=${dataSelecionadaPopup}`;
    else window.location.href = "./medicamentos.php";
}
function addConsulta() {
    if (dataSelecionadaPopup) window.location.href = `./consultas.php?data=${dataSelecionadaPopup}`;
    else window.location.href = "./consultas.php";
}
function removerItem() { closePopup(); }
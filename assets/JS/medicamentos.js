let editIndex = null; 
let medicamentos = []; // TESTE SOMENTE NO FRONT

function openMedicamentoPopup(edit = null) {
    document.getElementById("popup-medicamento").style.display = "flex";

    if (edit !== null) {
        editIndex = edit;
        document.getElementById("popup-title").textContent = "Editar Medicamento";

        const m = medicamentos[edit];

        document.getElementById("nome").value = m.nome;
        document.getElementById("dose").value = m.dose;
        document.getElementById("hora").value = m.hora;
        document.getElementById("frequencia").value = m.frequencia;
        document.getElementById("notificar").checked = m.notificar;

    } else {
        editIndex = null;
        document.getElementById("popup-title").textContent = "Novo Medicamento";

        document.getElementById("nome").value = "";
        document.getElementById("dose").value = "";
        document.getElementById("hora").value = "";
        document.getElementById("frequencia").value = "diario";
        document.getElementById("notificar").checked = false;
    }
}

function closeMedicamentoPopup() {
    document.getElementById("popup-medicamento").style.display = "none";
}

function salvarMedicamento() {

    const med = {
        nome: document.getElementById("nome").value,
        dose: document.getElementById("dose").value,
        hora: document.getElementById("hora").value,
        frequencia: document.getElementById("frequencia").value,
        notificar: document.getElementById("notificar").checked
    };

    if (editIndex !== null) {
        medicamentos[editIndex] = med;
    } else {
        medicamentos.push(med);
    }

    renderMedicamentos();
    closeMedicamentoPopup();
}

function renderMedicamentos() {
    const lista = document.getElementById("lista-medicamentos");
    lista.innerHTML = "";

    medicamentos.forEach((m, i) => {
        lista.innerHTML += `
        <div class="medicamento-item">
            <strong>${m.nome}</strong>
            <div class="medicamento-meta">
                Dose: ${m.dose}<br>
                Horário: ${m.hora}<br>
                Frequência: ${m.frequencia}
            </div>

            <div class="btn-area">
                <button class="btn-edit" onclick="openMedicamentoPopup(${i})">Editar</button>
                <button class="btn-delete" onclick="excluirMedicamento(${i})">Excluir</button>
            </div>
        </div>
        `;
    });
}

function excluirMedicamento(index) {
    if (confirm("Deseja realmente excluir esta medicação?")) {
        medicamentos.splice(index, 1);
        renderMedicamentos();
    }
}

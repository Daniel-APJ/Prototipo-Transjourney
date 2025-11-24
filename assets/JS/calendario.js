let date = new Date();
const monthYear = document.getElementById("month-year");
const daysDiv = document.getElementById("days");

const months = [
  "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
  "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];

function renderCalendar() {
    const year = date.getFullYear();
    const month = date.getMonth();

    monthYear.textContent = `${months[month]} ${year}`;
    daysDiv.innerHTML = "";

    const firstDay = new Date(year, month, 1).getDay();
    const lastDay = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        daysDiv.innerHTML += `<div class="day empty"></div>`;
    }

    for (let d = 1; d <= lastDay; d++) {
        /*const dataClick = d + " / " + (month + 1) + " / " + year;
        console.log(dataClick);*/
        daysDiv.innerHTML += `
            <div class="day" onclick="openDay(${d})">
                ${d}
                <span class="event">Hormônio</span> 
            </div>
        `;
    }
}

document.getElementById("prev").onclick = () => {
    date.setMonth(date.getMonth() - 1);
    renderCalendar();
};

document.getElementById("next").onclick = () => {
    date.setMonth(date.getMonth() + 1);
    renderCalendar();
};

function openDay(day) {
    showPopup(day);
}

renderCalendar();

//----------- Mensagem Menu: ----------
function showPopup(msg) {
    document.getElementById("popup-msg").textContent = msg;
    document.getElementById("popup").classList.add("show");
}

function closePopup() {
    document.getElementById("popup").classList.remove("show");
}

// Depois colocar a lógica real de cada ação:
function addMedicamento() {
    console.log("Adicionar medicamento");
    closePopup();
}

function addConsulta() {
    console.log("Adicionar consulta");
    closePopup();
}

function removerItem() {
    console.log("Remover item");
    closePopup();
}
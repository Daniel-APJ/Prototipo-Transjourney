const btnEditar = document.getElementById("btnEditar");
const btnSalvar = document.getElementById("btnSalvar");
const inputs = document.querySelectorAll("#formPerfil input");
const form = document.getElementById("formPerfil");

// Elementos da Foto
const fotoPerfil = document.getElementById("fotoPerfil");
const fotoInput = document.getElementById("fotoInput");
const iconCam = document.getElementById("iconCam");

let emEdicao = false;

// Ativar edição
btnEditar.addEventListener("click", () => {
    emEdicao = true;
    
    inputs.forEach(i => i.disabled = false);

    btnEditar.classList.add("hidden");
    btnSalvar.classList.remove("hidden");

    fotoPerfil.classList.add("foto-editavel");
    iconCam.classList.remove("hidden"); 
});

fotoPerfil.addEventListener("click", () => {
    if (emEdicao) {
        fotoInput.click(); 
    }
});

// Pré-visualização da imagem selecionada
fotoInput.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            fotoPerfil.src = e.target.result; 
        };
        reader.readAsDataURL(file);
    }
});

// Salvar
btnSalvar.addEventListener("click", () => {
    form.submit();
});
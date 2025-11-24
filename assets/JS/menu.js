const btnBurger = document.getElementById('btnBurger');
const btnBack = document.getElementById('btnBurgerBack');

btnBurger.addEventListener('click', () => {
    document.getElementById('menuLateral').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('ativo');
    btnBurger.classList.toggle('open');
});
btnBack.addEventListener('click', () => {
    document.getElementById('menuLateral').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('ativo');
    btnBurger.classList.toggle('open');
});


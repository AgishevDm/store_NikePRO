document.addEventListener('DOMContentLoaded', () => {
    const burgerMenu = document.getElementById('burgerMenu');
    const mainNav = document.getElementById('mainNav');
    burgerMenu.addEventListener('click', () => {
        mainNav.classList.toggle('mobile-menu');
        burgerMenu.classList.toggle('close');
        burgerMenu.textContent = burgerMenu.classList.contains('close') ? '✕' : '☰'; 

        burgerMenu.classList.add('clicked');
        setTimeout(() => {
            burgerMenu.classList.remove('clicked');
        }, 300); 
    });
});


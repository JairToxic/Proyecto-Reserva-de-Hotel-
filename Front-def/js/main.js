// Script para el carrusel
let currentIndex = 0;
const productosContainer = document.querySelector('.productos-container');
const productos = document.querySelectorAll('.producto');

function moverCarrusel(direction) {
    currentIndex += direction;

    if (currentIndex < 0) {
        currentIndex = productos.length - 1;
    } else if (currentIndex >= productos.length) {
        currentIndex = 0;
    }

    const translateValue = -currentIndex * productos[0].offsetWidth;
    productosContainer.style.transform = `translateX(${translateValue}px)`;
}

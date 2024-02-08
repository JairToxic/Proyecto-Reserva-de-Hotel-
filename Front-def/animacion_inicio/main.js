// Espera a que la página se cargue completamente
document.addEventListener("DOMContentLoaded", function () {
    // Simula un retraso de 3 segundos 
    setTimeout(function () {
      // Agrega la clase 'loaded' al preloader para ocultarlo
      document.querySelector(".page-loader").classList.add("loaded");
  
      // Después de ocultar el preloader, redirige a la página principal
      setTimeout(function () {
        window.location.href = "../index.php"; // redireige a index momentaneamente en desarrollo
      }, 500); // Tiempo de espera antes de la redirección
    }, 3000); //Tiempo de espera antes de ocultar el preloader
  });
  
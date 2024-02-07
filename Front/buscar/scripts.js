//Validar
function validarFechas(checkIn, checkOut) {
    return new Date(checkOut) > new Date(checkIn);
  }
  
  function validarFormulario() {
    var checkIn = document.getElementById("checkIn").value;
    var checkOut = document.getElementById("checkOut").value;
  
    // Validar fechas
    if (!validarFechas(checkIn, checkOut)) {
      alert("La fecha de check-out debe ser posterior a la fecha de check-in.");
      return false; // Evitar envío del formulario
    }
  
    // Otras validaciones si es necesario...
  
    return true; // Permitir envío del formulario
  }
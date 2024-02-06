<?php
// Obtener datos del formulario
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$tipos = $_POST['tipo'];

// Recorrer los tipos de habitaciones seleccionadas
foreach ($tipos as $tipo) {
    // Redireccionar a la página específica según el tipo de habitación
    header("Location: ../site/tipohabitacion1/{$tipo}.php?checkin={$checkin}&checkout={$checkout}");
}
exit; // Asegura que el script se detenga después de las redirecciones

?>
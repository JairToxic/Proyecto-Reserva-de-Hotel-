<?php
// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $tipo = $_POST['tipo'];

    // Redireccionar a la página específica según el tipo de habitación
    header("Location: ../site/tipohabitacion1/{$tipo}.php?checkin={$checkin}&checkout={$checkout}");
    exit; // Asegura que el script se detenga después de la redirección
}
?>
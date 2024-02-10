<?php
// Obtener datos del formulario
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];


// Recorrer los tipos de habitaciones seleccionadas

header("Location: ../site/habitaciones/prueba.php?checkin={$checkin}&checkout={$checkout}");

exit; // Asegura que el script se detenga después de las redirecciones

?>
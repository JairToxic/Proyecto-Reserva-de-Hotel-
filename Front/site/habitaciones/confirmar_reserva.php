<?php
include '../../../basedatos/basedatos.php';

// Verificar si se reciben los parámetros necesarios
if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin']) && isset($_GET['noches']) && isset($_GET['precioTotal'])) {
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];
    $noches = $_GET['noches'];
    $precioTotal = $_GET['precioTotal'];

    // Verificar disponibilidad
    $habitacion_id = $_GET['habitacion_id'];
    $disponible = verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin);

    if (!$disponible) {
        // Mostrar mensaje de error y salir
        echo "Error: La habitación no está disponible para las fechas seleccionadas.";
        exit();
    }

    // Aquí puedes realizar cualquier lógica adicional que necesites

} else {
    // Si no se proporcionan los parámetros necesarios, redireccionar o manejar el error según sea necesario
    echo "Error: No se han proporcionado los parámetros necesarios para la reserva.";
    exit();
}

function verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin) {
    global $mysqli;

    // Consulta SQL para verificar la disponibilidad de la habitación
    $consultaDisponibilidad = "SELECT hr.ID_HABITACION FROM habitacion_reserva hr
                              JOIN reserva r ON hr.ID_RESERVA = r.ID_RESERVA
                              WHERE hr.ID_HABITACION = ? 
                              AND (r.FECHACHECKIN <= ? AND r.FECHACHECKOUT >= ?)";

    // Usar consulta preparada para seguridad
    $stmt = $mysqli->prepare($consultaDisponibilidad);
    $stmt->bind_param("iss", $habitacion_id, $fechaFin, $fechaInicio);
    $stmt->execute();

    // Obtener resultados
    $resultado = $stmt->get_result();

    // Verificar si hay reservas que coincidan
    if ($resultado->num_rows > 0) {
        // La habitación no está disponible en esas fechas
        return false;
    } else {
        // La habitación está disponible
        return true;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Agrega aquí tus metaetiquetas, enlaces a CSS y otros elementos head -->
    <title>Confirmar Reserva</title>
</head>
<body>
    <!-- Agrega aquí el contenido de tu página de confirmación -->
    <h1>Confirmación de Reserva</h1>
    <p>Fecha de Check-in: <?php echo $fechaInicio; ?></p>
    <p>Fecha de Check-out: <?php echo $fechaFin; ?></p>
    <p>Noches: <?php echo $noches; ?></p>
    <p>Precio Total: <?php echo $precioTotal; ?></p>

    <!-- Formulario de detalles del cliente -->
<form method="post" action="procesar_reserva.php">
    <input type="hidden" name="fechaInicio" value="<?php echo $fechaInicio; ?>">
    <input type="hidden" name="fechaFin" value="<?php echo $fechaFin; ?>">
    <input type="hidden" name="noches" value="<?php echo $noches; ?>">
    <input type="hidden" name="precioTotal" value="<?php echo $precioTotal; ?>">
    <input type="hidden" name="habitacion_id" value="<?php echo $habitacion_id; ?>"> <!-- Asegúrate de tener esta línea -->

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" required>

    <label for="celular">Celular:</label>
    <input type="text" name="celular" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <button type="submit" name="confirmar_reserva">Confirmar Reserva</button>
</form>
</body>
</html>

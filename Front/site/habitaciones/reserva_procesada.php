<?php
include '../../../basedatos/basedatos.php';

// Obtener los datos del POST
$fechaInicio = $_POST['fechaInicio'] ?? '';
$fechaFin = $_POST['fechaFin'] ?? '';
$precioTotal = $_POST['precioTotal'] ?? 0;
$habitaciones = $_POST['habitaciones'] ?? [];
// Obtener los datos del POST
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$celular = $_POST['celular'] ?? '';
$email = $_POST['email'] ?? '';
// Verificar si se reciben los parámetros necesarios
if (!empty($fechaInicio) && !empty($fechaFin) && !empty($habitaciones)) {
    // Calcular el número de noches y el precio total
    $noches = calcularNoches($fechaInicio, $fechaFin);

    // Verificar disponibilidad
    foreach ($habitaciones as $habitacion_id) {
        $disponible = verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin);

        if (!$disponible) {
            // La habitación no está disponible para las fechas seleccionadas.
            // Redirigir a una página de habitaciones disponibles o a otra de tu elección.
            header("Location: habitacion_no_disponible.php");
            exit();
        }
    }

    // Lógica de procesamiento de reserva

    // Insertar datos en la tabla cliente
// Insertar datos en la tabla cliente
$stmt = $mysqli->prepare("INSERT INTO cliente (NOMBRE, APELLIDO, CELULAR, EMAIL) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $apellido, $celular, $email);
$stmt->execute();
$id_cliente = $stmt->insert_id;
$stmt->close();


    // Insertar datos en la tabla reserva
    $stmt = $mysqli->prepare("INSERT INTO reserva (ID_CLIENTE, FECHACHECKIN, FECHACHECKOUT, ESTADORESERVA) VALUES (?, ?, ?, 'Confirmada')");
    $stmt->bind_param("iss", $id_cliente, $fechaInicio, $fechaFin);
    $stmt->execute();
    $id_reserva = $stmt->insert_id;
    $stmt->close();

    // Insertar datos en la tabla pago
    $monto = $precioTotal;
    $metodo_pago = "PayPal";
    $estado_pago = "Pagado";
    $fecha_pago = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("INSERT INTO pago (ID_RESERVA, MONTO, ESTADOPAGO, METODOPAGO, FECHAPAGO) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idsss", $id_reserva, $monto, $estado_pago, $metodo_pago, $fecha_pago);
    $stmt->execute();
    $stmt->close();

    // Insertar datos en la tabla habitacion_reserva
    foreach ($habitaciones as $habitacion_id) {
        $stmt = $mysqli->prepare("INSERT INTO habitacion_reserva (ID_HABITACION, ID_RESERVA) VALUES (?, ?)");
        $stmt->bind_param("ii", $habitacion_id, $id_reserva);
        $stmt->execute();
        $stmt->close();
    }

    // Redirigir a la página de reserva exitosa
    header("Location: reserva_exitosa.php?id_reserva=" . $id_reserva);
    exit();

} else {
    // Si no se proporcionan los parámetros necesarios, redireccionar o manejar el error según sea necesario
    echo "Error: No se han proporcionado los parámetros necesarios para la reserva.";
    exit();
}

// Función para verificar disponibilidad
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
    return $resultado->num_rows === 0;
}

// Resto del código...

// Función para calcular noches (ya existente en tu script)
function calcularNoches($fechaInicio, $fechaFin) {
    // Lógica para calcular el número de noches entre dos fechas
    $dateInicio = new DateTime($fechaInicio);
    $dateFin = new DateTime($fechaFin);
    $diferencia = $dateInicio->diff($dateFin);
    return $diferencia->days;
}

// Resto del código...
?>

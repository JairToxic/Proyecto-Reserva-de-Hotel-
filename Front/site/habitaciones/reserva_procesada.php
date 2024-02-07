<?php
include '../../../basedatos/basedatos.php';

// Verificar si se ha recibido la confirmación de PayPal y los datos necesarios por POST
if (
    isset($_POST['paypal_payment'], $_POST['fechaInicio'], $_POST['fechaFin'], $_POST['noches'], $_POST['precioTotal'], $_POST['habitaciones'], $_POST['idCliente'])
) {
    // Recuperar los datos de la reserva
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $noches = $_POST['noches'];
    $precioTotal = $_POST['precioTotal'];
    $habitaciones = $_POST['habitaciones'];
    $idCliente = $_POST['idCliente'];

    // Verificar disponibilidad
    foreach ($habitaciones as $habitacion_id) {
        $disponible = verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin);

        if (!$disponible) {
            // La habitación no está disponible para las fechas seleccionadas.
            // Redirigir a una página de habitaciones no disponibles o a otra de tu elección.
            header("Location: habitacion_no_disponible.php");
            exit();
        }
    }

    // Insertar datos en la tabla reserva
    $stmt = $mysqli->prepare("INSERT INTO reserva (ID_CLIENTE, FECHACHECKIN, FECHACHECKOUT, ESTADORESERVA) VALUES (?, ?, ?, 'Confirmada')");
    $stmt->bind_param("iss", $idCliente, $fechaInicio, $fechaFin);
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

    // Redirigir a la página de reserva exitosa con la ID de la reserva
    header("Location: reserva_exitosa.php?id_reserva=" . $id_reserva);
    exit();
} else {
    // Si no se reciben los datos necesarios, imprimir los datos para depuración
    echo "Error: No se han proporcionado los datos necesarios o no se ha completado la transacción de PayPal.";
    // Añadir mensajes de depuración
    echo "<pre>";
    print_r($_POST); // Imprimir datos recibidos por POST para depuración
    echo "</pre>";
    exit();
}

// Función para verificar disponibilidad
function verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin) {
    global $mysqli;

    $consultaDisponibilidad = "SELECT hr.ID_HABITACION FROM habitacion_reserva hr
                              JOIN reserva r ON hr.ID_RESERVA = r.ID_RESERVA
                              WHERE hr.ID_HABITACION = ? 
                              AND (r.FECHACHECKIN <= ? AND r.FECHACHECKOUT >= ?)";

    $stmt = $mysqli->prepare($consultaDisponibilidad);
    $stmt->bind_param("iss", $habitacion_id, $fechaFin, $fechaInicio);
    $stmt->execute();

    $resultado = $stmt->get_result();

    return $resultado->num_rows === 0;
}
?>

<?php
include '../../../basedatos/basedatos.php';

// Verificar si se ha recibido la confirmación de PayPal y los datos necesarios por POST
if (isset($_POST['paypal_payment']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin']) && isset($_POST['noches']) && isset($_POST['precioTotal'])) {
    // Recuperar los datos de la reserva
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $noches = $_POST['noches'];
    $precioTotal = $_POST['precioTotal'];

    // Verificar disponibilidad
    $habitacion_id = $_POST['habitacion_id'];
    $disponible = verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin);

    if (!$disponible) {
        // La habitación no está disponible para las fechas seleccionadas.
        // Redirigir a una página de habitaciones disponibles o a otra de tu elección.
        header("Location: habitacion_no_disponible.php");
        exit();
    }

    // Recuperar los detalles del cliente desde el formulario o la respuesta de PayPal
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];

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
    // (Asumiendo que tienes información de pago, de lo contrario, ajusta esta parte)
    $monto = $precioTotal; // Tomar el monto del precio total
    $metodo_pago = "PayPal"; // Cambiado a PayPal
    $estado_pago = "Pagado"; // Ejemplo, debes obtener este valor según tus necesidades
    $fecha_pago = date('Y-m-d H:i:s'); // Fecha actual

    $stmt = $mysqli->prepare("INSERT INTO pago (ID_RESERVA, MONTO, ESTADOPAGO, METODOPAGO, FECHAPAGO) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idsss", $id_reserva, $monto, $estado_pago, $metodo_pago, $fecha_pago);
    $stmt->execute();
    $stmt->close();

    // Insertar datos en la tabla habitacion_reserva
    $stmt = $mysqli->prepare("INSERT INTO habitacion_reserva (ID_HABITACION, ID_RESERVA) VALUES (?, ?)");
    $stmt->bind_param("ii", $habitacion_id, $id_reserva);
    $stmt->execute();
    $stmt->close();

    // Redirigir a la página de reserva exitosa
    // Redirigir a la página de reserva exitosa con la ID de la reserva
        header("Location: reserva_exitosa.php?id_reserva=" . $id_reserva);
        exit();

} else {
    // Si no se reciben los datos necesarios o no hay confirmación de PayPal, redireccionar o manejar el error según sea necesario
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
?>

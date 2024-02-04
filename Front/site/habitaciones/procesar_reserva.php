<?php
include '../../../basedatos/basedatos.php';

// Verificar si se envían los datos necesarios por POST
if (isset($_POST['confirmar_reserva'])) {
    // Recuperar los datos de la reserva
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $noches = $_POST['noches'];
    $precioTotal = $_POST['precioTotal'];

    // Verificar disponibilidad
    $habitacion_id = $_POST['habitacion_id'];
    $disponible = verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin);

    if (!$disponible) {
        // Mostrar mensaje de error y salir
        echo "Error: La habitación no está disponible para las fechas seleccionadas.";
        exit();
    }

    // Recuperar los detalles del cliente
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
$monto = 100; // Ejemplo, debes obtener este valor según tus necesidades
$metodo_pago = "Tarjeta"; // Ejemplo, debes obtener este valor según tus necesidades
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
header("Location: reserva_exitosa.php");
exit();

    // Resto del código...
} else {
    // Si no se envían los datos necesarios, redireccionar o manejar el error según sea necesario
    echo "Error: No se han proporcionado los datos necesarios para la reserva.";
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

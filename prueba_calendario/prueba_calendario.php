<?php
// Aquí iría el código para procesar la reserva en la base de datos prueba_hotel

// Recibir datos del formulario y procesar la reserva si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $fecha_checkin = $_POST['fecha_checkin'];
    $fecha_checkout = $_POST['fecha_checkout'];
    $id_habitacion = $_POST['id_habitacion'];
    $id_cliente = $_POST['id_cliente'];

    // Conectar a la base de datos
    $mysqli = new mysqli("localhost", "root", "", "prueba_hotel");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Preparar la consulta para insertar la reserva
    $sql = "INSERT INTO RESERVA (ID_CLIENTE, FECHACHECKIN, FECHACHECKOUT) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("iss", $id_cliente, $fecha_checkin, $fecha_checkout);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Reserva realizada exitosamente";
    } else {
        echo "Error al realizar la reserva: " . $mysqli->error;
    }

    // Cerrar declaración y conexión
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calendario de Reservas</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<div id="calendar"></div>

<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        dateClick: function(info) {
            alert('Fecha seleccionada: ' + info.dateStr);
            // Aquí puedes implementar la lógica para realizar la reserva
            // por ejemplo, mostrando un formulario de reserva con la fecha seleccionada
        }
    });
    calendar.render();
});
</script>
</body>
</html>

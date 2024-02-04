<?php
include '../../../basedatos/basedatos.php';

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_reserva'])) {

    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];

    // Crear el cliente en la tabla cliente
    $query_cliente = "INSERT INTO cliente (NOMBRE, APELLIDO, CELULAR, EMAIL) 
                      VALUES ('$nombre', '$apellido', '$celular', '$email')";

    if ($conexion->query($query_cliente) === TRUE) {
        // Obtener el ID del cliente recién insertado
        $id_cliente = $conexion->insert_id;

        // Crear la reserva en la tabla reserva
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];
        $id_habitacion = $_GET['habitacion_id'];

        $query_reserva = "INSERT INTO reserva (_ID_DETALLEPERSONA, ID_CLIENTE, FECHACHECKIN, FECHACHECKOUT, ESTADORESERVA) 
                          VALUES (NULL, $id_cliente, '$fechaInicio', '$fechaFin', 'Pendiente')";

        if ($conexion->query($query_reserva) === TRUE) {
            // Obtener el ID de la reserva recién insertada
            $id_reserva = $conexion->insert_id;

            // Relacionar la habitación con la reserva en la tabla habitacion_reserva
            $query_habitacion_reserva = "INSERT INTO habitacion_reserva (ID_HABITACION, ID_RESERVA) 
                                         VALUES ($id_habitacion, $id_reserva)";

            if ($conexion->query($query_habitacion_reserva) === TRUE) {
                echo "Reserva confirmada y datos del cliente almacenados correctamente.";
            } else {
                echo "Error al relacionar la habitación con la reserva: " . $conexion->error;
            }
        } else {
            echo "Error al crear la reserva: " . $conexion->error;
        }
    } else {
        echo "Error al crear el cliente: " . $conexion->error;
    }

    // Cerrar la conexión después de su uso
    $conexion->close();
} else {
    // Manejar el caso en el que se acceda directamente a este archivo sin enviar el formulario
    echo "Error: Acceso no autorizado.";
    exit();
}
?>

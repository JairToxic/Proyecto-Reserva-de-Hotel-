<?php
// Conexión a la base de datos (debes proporcionar tus propios detalles de conexión)
include'../basedatos/basedatos.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el ID de la reserva a borrar
if (isset($_GET['borrar_reserva'])) {
    // Obtener el ID de la reserva a eliminar
    $id_reserva = $_GET['borrar_reserva'];

    // Eliminar los registros relacionados en la tabla habitacion_reserva
    $sql_delete_habitacion_reserva = "DELETE FROM habitacion_reserva WHERE ID_RESERVA = ?";
    $stmt_delete_habitacion_reserva = $conn->prepare($sql_delete_habitacion_reserva);
    $stmt_delete_habitacion_reserva->bind_param("i", $id_reserva);

    if ($stmt_delete_habitacion_reserva->execute()) {
        echo "Los registros relacionados en la tabla habitacion_reserva han sido eliminados.<br>";
    } else {
        echo "Error al eliminar los registros relacionados en la tabla habitacion_reserva: " . $stmt_delete_habitacion_reserva->error . "<br>";
    }

    // Eliminar los registros relacionados en la tabla pago
    $sql_delete_pagos = "DELETE FROM pago WHERE ID_RESERVA = ?";
    $stmt_delete_pagos = $conn->prepare($sql_delete_pagos);
    $stmt_delete_pagos->bind_param("i", $id_reserva);

    if ($stmt_delete_pagos->execute()) {
        echo "Los registros relacionados en la tabla pago han sido eliminados.<br>";
    } else {
        echo "Error al eliminar los registros relacionados en la tabla pago: " . $stmt_delete_pagos->error . "<br>";
    }

    // Preparar la consulta de borrado de la reserva
    $sql_delete_reserva = "DELETE FROM reserva WHERE ID_RESERVA = ?";
    $stmt_delete_reserva = $conn->prepare($sql_delete_reserva);
    $stmt_delete_reserva->bind_param("i", $id_reserva);

    // Ejecutar la consulta de borrado de la reserva
    if ($stmt_delete_reserva->execute()) {
        // Redireccionar a la página principal después de eliminar la reserva
        header("Location: eliminar_reserva.php");
        exit();
    } else {
        // Manejar el error si la ejecución de la consulta falla
        echo "Error al eliminar la reserva: " . $stmt_delete_reserva->error;
    }
}

// Obtener la lista de reservas
$sql = "SELECT r.*, c.NOMBRE, c.APELLIDO FROM reserva r INNER JOIN cliente c ON r.ID_CLIENTE = c.ID_CLIENTE";
$result = $conn->query($sql);

$reservas = array();
if ($result->num_rows > 0) {
    // Obtener cada fila de la tabla y agregarla a la lista de reservas
    while ($row = $result->fetch_assoc()) {
        $reservas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Reservas</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Administrador de Reservas</h1>
        <?php
        // Mostrar la alerta si se ha borrado una habitación
        if (isset($_GET['borrado']) && $_GET['borrado'] == 1) {
            echo "<div class='alert alert-success' role='alert'>Reserva eliminada correctamente.</div>";
        }
        ?>

        <!-- Mostrar la lista de reservas -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID de Reserva</th>
                        <th>ID de Cliente</th>
                        <th>Nombre del Cliente</th>
                        <th>Fecha de Check-in</th>
                        <th>Fecha de Check-out</th>
                        <th>Estado de Reserva</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?php echo $reserva['ID_RESERVA']; ?></td>
                            <td><?php echo $reserva['ID_CLIENTE']; ?></td>
                            <td><?php echo $reserva['NOMBRE'] . ' ' . $reserva['APELLIDO']; ?></td>
                            <td><?php echo $reserva['FECHACHECKIN']; ?></td>
                            <td><?php echo $reserva['FECHACHECKOUT']; ?></td>
                            <td><?php echo $reserva['ESTADORESERVA']; ?></td>
                            <td>
                                <a href="?borrar_reserva=<?php echo $reserva['ID_RESERVA']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas borrar esta reserva?')">Borrar</a>
                                <!-- Puedes agregar más acciones como editar -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Puedes agregar enlaces o botones para agregar nuevas reservas, editar, etc. -->
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>




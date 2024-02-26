<?php
// Crear una conexión a la base de datos
include '../basedatos/basedatos.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado una solicitud para borrar una habitación
if (isset($_GET['borrar_habitacion'])) {
    $id_habitacion = $_GET['borrar_habitacion'];
    borrarHabitacion($id_habitacion, $conn);
}

// Obtener la lista de habitaciones desde la base de datos
$habitaciones = obtenerHabitaciones($conn);

// Función para obtener la lista de habitaciones
function obtenerHabitaciones($conn) {
    $consulta = "SELECT * FROM HABITACIONES";
    $resultado = $conn->query($consulta);

    $habitaciones = array();
    while ($habitacion = $resultado->fetch_assoc()) {
        $habitaciones[] = $habitacion;
    }

    return $habitaciones;
}

// Función para borrar una habitación por ID y sus referencias relacionadas
function borrarHabitacion($id_habitacion, $conn) {
    // Eliminar referencias de habitacion_reserva
    $stmt1 = $conn->prepare("DELETE FROM habitacion_reserva WHERE ID_HABITACION = ?");
    $stmt1->bind_param("i", $id_habitacion);
    $stmt1->execute();
    $stmt1->close();

    // Eliminar imágenes asociadas en imagenes_habitaciones
    $stmt2 = $conn->prepare("DELETE FROM imagenes_habitaciones WHERE id_habitacion = ?");
    $stmt2->bind_param("i", $id_habitacion);
    $stmt2->execute();
    $stmt2->close();

    
    // Eliminar la entrada de la habitación en la tabla habitaciones
    $stmt5 = $conn->prepare("DELETE FROM habitaciones WHERE ID_HABITACION = ?");
    $stmt5->bind_param("i", $id_habitacion);
    $stmt5->execute();
    $stmt5->close();

    // Redirigir a la misma página después de borrar
    header("Location: eliminar_habitaciones.php?borrado=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Habitaciones</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Administrador de Habitaciones</h1>
        <?php
        // Mostrar la alerta si se ha borrado una habitación
        if (isset($_GET['borrado']) && $_GET['borrado'] == 1) {
            echo "<div class='alert alert-success' role='alert'>Habitación eliminada correctamente.</div>";
        }
        ?>

        <!-- Mostrar la lista de habitaciones -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio por Noche</th>
                        <th>Capacidad</th>
                        <th>Camas</th>
                        <th>Baño</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($habitaciones as $habitacion): ?>
                        <tr>
                            <td><?php echo $habitacion['ID_HABITACION']; ?></td>
                            <td><?php echo $habitacion['TIPO']; ?></td>
                            <td><?php echo $habitacion['DESCRIPCION']; ?></td>
                            <td><?php echo $habitacion['PRECIOPORNOCHE']; ?></td>
                            <td><?php echo $habitacion['CAPACIDAD']; ?></td>
                            <td><?php echo $habitacion['CAMAS']; ?></td>
                            <td><?php echo $habitacion['BANO']; ?></td>
                            <td>
                                <a href="?borrar_habitacion=<?php echo $habitacion['ID_HABITACION']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas borrar esta habitación?')">Borrar</a>
                                <!-- Puedes agregar más acciones como editar -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Puedes agregar enlaces o botones para agregar nuevas habitaciones, editar, etc. -->
    </div>
</body>
</html>



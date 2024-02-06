<?php
include '../basedatos/basedatos.php';

// Verificar si se ha enviado una solicitud para borrar una habitación
if (isset($_GET['borrar_habitacion'])) {
    $id_habitacion = $_GET['borrar_habitacion'];
    borrarHabitacion($id_habitacion);
}

// Obtener la lista de habitaciones desde la base de datos
$habitaciones = obtenerHabitaciones();

// Función para obtener la lista de habitaciones
function obtenerHabitaciones() {
    global $mysqli;
    
    $consulta = "SELECT * FROM HABITACIONES";
    $resultado = $mysqli->query($consulta);

    $habitaciones = array();
    while ($habitacion = $resultado->fetch_assoc()) {
        $habitaciones[] = $habitacion;
    }

    return $habitaciones;
}

// Función para borrar una habitación por ID
function borrarHabitacion($id_habitacion) {
    global $mysqli;

    $stmt = $mysqli->prepare("DELETE FROM HABITACIONES WHERE ID_HABITACION = ?");
    $stmt->bind_param("i", $id_habitacion);
    $stmt->execute();
    $stmt->close();
    
    // Redirigir a la misma página después de borrar
    header("Location: admin_habitaciones.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Habitaciones</title>
    <!-- Agrega tus estilos y enlaces a scripts si es necesario -->
</head>
<body>
    <h1>Administrador de Habitaciones</h1>

    <!-- Mostrar la lista de habitaciones -->
    <table border="1">
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
                        <a href="?borrar_habitacion=<?php echo $habitacion['ID_HABITACION']; ?>" onclick="return confirm('¿Seguro que deseas borrar esta habitación?')">Borrar</a>
                        <!-- Puedes agregar más acciones como editar -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Puedes agregar enlaces o botones para agregar nuevas habitaciones, editar, etc. -->

</body>
</html>

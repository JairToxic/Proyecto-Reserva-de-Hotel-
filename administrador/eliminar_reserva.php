<?php
// Conexión a la base de datos (debes proporcionar tus propios detalles de conexión)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Crear conexión
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Verificar si se ha enviado el ID de la reserva a borrar
if (isset($_GET['borrar_reserva'])) {
    // Obtener el ID de la reserva a eliminar
    $id_reserva = $_GET['borrar_reserva'];

    // Preparar la consulta de borrado
    $sql = "DELETE FROM reserva WHERE ID_RESERVA = ?";

    // Ejecutar la consulta de borrado
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id_reserva);

    // Verificar la ejecución de la consulta
    if ($stmt->execute()) {
        // Redireccionar a la página principal después de eliminar la reserva
        header("Location: eliminar_reserva.php");
        exit();
    } else {
        // Manejar el error si la ejecución de la consulta falla
        echo "Error al eliminar la reserva: " . $stmt->error;
    }
}

// Obtener la lista de reservas
$sql = "SELECT * FROM reserva";
$result = $mysqli->query($sql);

$reservas = array();
if ($result->num_rows > 0) {
    // Obtener cada fila de la tabla y agregarla a la lista de reservas
    while ($row = $result->fetch_assoc()) {
        $reservas[] = $row;
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Reservas</title>
    <!-- Agrega tus estilos y enlaces a scripts si es necesario -->
</head>
<body>
    <h1>Administrador de Reservas</h1>

    <!-- Mostrar la lista de reservas -->
    <table border="1">
        <thead>
            <tr>
                <?php
                // Obtener los nombres de las columnas de la tabla reserva y mostrarlos como encabezados de la tabla HTML
                $columnas = array_keys($reservas[0]);
                foreach ($columnas as $columna) {
                    echo "<th>$columna</th>";
                }
                ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <?php foreach ($reserva as $valor): ?>
                        <td><?php echo $valor; ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="?borrar_reserva=<?php echo $reserva['ID_RESERVA']; ?>" onclick="return confirm('¿Seguro que deseas borrar esta reserva?')">Borrar</a>
                        <!-- Puedes agregar más acciones como editar -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Puedes agregar enlaces o botones para agregar nuevas reservas, editar, etc. -->

</body>
</html>

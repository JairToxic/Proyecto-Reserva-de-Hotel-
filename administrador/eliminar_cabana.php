<?php
// Crear una conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Verificar si se ha enviado una solicitud para borrar una cabaña
if (isset($_GET['borrar_cabana'])) {
    $id_cabana = $_GET['borrar_cabana'];
    borrarCabana($id_cabana);
}

// Obtener la lista de cabañas desde la base de datos
$cabanas = obtenerCabanas();

// Función para obtener la lista de cabañas
function obtenerCabanas() {
    global $mysqli;
    
    $consulta = "SELECT * FROM CABANAS";
    $resultado = $mysqli->query($consulta);

    $cabanas = array();
    while ($cabana = $resultado->fetch_assoc()) {
        $cabanas[] = $cabana;
    }

    return $cabanas;
}

// Función para borrar una cabaña por ID
function borrarCabana($id_cabana) {
    global $mysqli;

    $stmt = $mysqli->prepare("DELETE FROM CABANAS WHERE ID_CABANA = ?");
    $stmt->bind_param("i", $id_cabana);
    $stmt->execute();
    $stmt->close();
    
    // Redirigir a la misma página después de borrar
    header("Location: eliminar_cabanas.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Cabañas</title>
    <!-- Agrega tus estilos y enlaces a scripts si es necesario -->
</head>
<body>
    <h1>Administrador de Cabañas</h1>

    <!-- Mostrar la lista de cabañas -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Capacidad</th>
                <th>Precio por Noche</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cabanas as $cabana): ?>
                <tr>
                    <td><?php echo $cabana['ID_CABANA']; ?></td>
                    <td><?php echo $cabana['NOMBRE']; ?></td>
                    <td><?php echo $cabana['DESCRIPCION']; ?></td>
                    <td><?php echo $cabana['CAPACIDAD']; ?></td>
                    <td><?php echo $cabana['PRECIOPORNOCHE']; ?></td>
                    <td>
                        <a href="?borrar_cabana=<?php echo $cabana['ID_CABANA']; ?>" onclick="return confirm('¿Seguro que deseas borrar esta cabaña?')">Borrar</a>
                        <!-- Puedes agregar más acciones como editar -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Puedes agregar enlaces o botones para agregar nuevas cabañas, editar, etc. -->

</body>
</html>

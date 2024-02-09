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

// Verificar si se ha enviado una solicitud para borrar un comentario
if (isset($_GET['borrar_comentario'])) {
    $id_comentario = $_GET['borrar_comentario'];
    borrarComentario($id_comentario);
}

// Obtener la lista de comentarios desde la base de datos
$comentarios = obtenerComentarios();

// Función para obtener la lista de comentarios
function obtenerComentarios() {
    global $mysqli;
    
    $consulta = "SELECT * FROM COMENTARIOS";
    $resultado = $mysqli->query($consulta);

    $comentarios = array();
    while ($comentario = $resultado->fetch_assoc()) {
        $comentarios[] = $comentario;
    }

    return $comentarios;
}

// Función para borrar un comentario por ID
function borrarComentario($id_comentario) {
    global $mysqli;

    $stmt = $mysqli->prepare("DELETE FROM COMENTARIOS WHERE ID_COMENTARIO = ?");
    $stmt->bind_param("i", $id_comentario);
    $stmt->execute();
    $stmt->close();
    
    // Redirigir a la misma página después de borrar
    header("Location: eliminar_comentario.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Comentarios</title>
    <!-- Agrega tus estilos y enlaces a scripts si es necesario -->
</head>
<body>
    <h1>Administrador de Comentarios</h1>

    <!-- Mostrar la lista de comentarios -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Comentario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comentarios as $comentario): ?>
                <tr>
                    <td><?php echo $comentario['ID_COMENTARIO']; ?></td>
                    <td><?php echo $comentario['NOMBRE_USUARIO']; ?></td>
                    <td><?php echo $comentario['COMENTARIO']; ?></td>
                    <td>
                        <a href="?borrar_comentario=<?php echo $comentario['ID_COMENTARIO']; ?>" onclick="return confirm('¿Seguro que deseas borrar este comentario?')">Borrar</a>
                        <!-- Puedes agregar más acciones -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Puedes agregar enlaces o botones para agregar nuevos comentarios, editar, etc. -->

</body>
</html>

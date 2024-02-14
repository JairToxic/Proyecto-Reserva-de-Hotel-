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
    borrarComentario($id_comentario, $mysqli);
}

// Obtener la lista de comentarios desde la base de datos
$comentarios = obtenerComentarios($mysqli);

// Función para obtener la lista de comentarios
function obtenerComentarios($mysqli) {
    $consulta = "SELECT * FROM comentarios";
    $resultado = $mysqli->query($consulta);

    $comentarios = array();
    while ($comentario = $resultado->fetch_assoc()) {
        $comentarios[] = $comentario;
    }

    return $comentarios;
}

// Función para borrar un comentario por ID
function borrarComentario($id_comentario, $mysqli) {
    $stmt = $mysqli->prepare("DELETE FROM comentarios WHERE co_id = ?");
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
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Administrador de Comentarios</h1>

    <!-- Mostrar la lista de comentarios -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Habitación</th>
                <th>Nombre</th>
                <th>Calificación</th>
                <th>Comentario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comentarios as $comentario): ?>
                <tr>
                    <td><?php echo $comentario['co_id']; ?></td>
                    <td><?php echo $comentario['parent_id']; ?></td>
                    <td><?php echo $comentario['comentario_nombre']; ?></td>
                    <td><?php echo $comentario['stars']; ?></td>
                    <td><?php echo $comentario['comentarios']; ?></td>
                    <td>
                        <a href="?borrar_comentario=<?php echo $comentario['co_id']; ?>" onclick="return confirm('¿Seguro que deseas borrar este comentario?')">Borrar</a>
                        <!-- Puedes agregar más acciones como editar -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Puedes agregar enlaces o botones para agregar nuevos comentarios, editar, etc. -->

</body>
</html>

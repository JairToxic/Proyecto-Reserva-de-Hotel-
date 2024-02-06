<?php
include '../basedatos/basedatos.php';

// Verificar si se ha enviado una solicitud para borrar, editar o agregar una imagen de habitación
if (isset($_GET['borrar_imagen'])) {
    $id_imagen = $_GET['borrar_imagen'];
    borrarImagenHabitacion($id_imagen);
} elseif (isset($_GET['editar_imagen'])) {
    // Mostrar formulario de edición
    $id_imagen = $_GET['editar_imagen'];
    $imagenEditar = obtenerImagenHabitacionPorId($id_imagen);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar el formulario de edición
        editarImagenHabitacion($id_imagen);
    }
} elseif (isset($_GET['agregar_imagen'])) {
    // Mostrar formulario de agregar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar el formulario de agregar
        agregarImagenHabitacion();
    }
}

// Obtener la lista de imágenes de habitaciones desde la base de datos
$imagenesHabitaciones = obtenerImagenesHabitaciones();

// Función para obtener la lista de imágenes de habitaciones
function obtenerImagenesHabitaciones() {
    global $mysqli;

    $consulta = "SELECT * FROM imagenes_habitaciones";
    $resultado = $mysqli->query($consulta);

    $imagenesHabitaciones = array();
    while ($imagen = $resultado->fetch_assoc()) {
        $imagenesHabitaciones[] = $imagen;
    }

    return $imagenesHabitaciones;
}

// Función para obtener una imagen de habitación por ID
function obtenerImagenHabitacionPorId($id_imagen) {
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT * FROM imagenes_habitaciones WHERE id = ?");
    $stmt->bind_param("i", $id_imagen);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $imagen = $resultado->fetch_assoc();

    $stmt->close();

    return $imagen;
}

// Función para borrar una imagen de habitación por ID
function borrarImagenHabitacion($id_imagen) {
    global $mysqli;

    $stmt = $mysqli->prepare("DELETE FROM imagenes_habitaciones WHERE id = ?");
    $stmt->bind_param("i", $id_imagen);
    $stmt->execute();
    $stmt->close();
    
    // Redirigir a la misma página después de borrar
    header("Location: admin_imagenes_habitaciones.php");
    exit();
}

// Función para editar una imagen de habitación por ID
function editarImagenHabitacion($id_imagen) {
    global $mysqli;

    // Obtener datos del formulario
    $id_habitacion = $_POST['id_habitacion'];
    $url = $_POST['url'];

    $stmt = $mysqli->prepare("UPDATE imagenes_habitaciones SET id_habitacion = ?, url = ? WHERE id = ?");
    $stmt->bind_param("isi", $id_habitacion, $url, $id_imagen);
    $stmt->execute();
    $stmt->close();
    
    // Redirigir a la misma página después de editar
    header("Location: admin_imagenes_habitaciones.php");
    exit();
}

// Función para agregar una nueva imagen de habitación
function agregarImagenHabitacion() {
    global $mysqli;

    // Obtener datos del formulario
    $id_habitacion = $_POST['id_habitacion'];
    $url = $_POST['url'];

    $stmt = $mysqli->prepare("INSERT INTO imagenes_habitaciones (id_habitacion, url) VALUES (?, ?)");
    $stmt->bind_param("is", $id_habitacion, $url);
    $stmt->execute();
    $stmt->close();
    
    // Redirigir a la misma página después de agregar
    header("Location: admin_imagenes_habitaciones.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Imágenes de Habitaciones</title>
    <!-- Agrega tus estilos y enlaces a scripts si es necesario -->
</head>
<body>
    <h1>Administrador de Imágenes de Habitaciones</h1>

    <!-- Mostrar la lista de imágenes de habitaciones -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Habitación</th>
                <th>URL</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($imagenesHabitaciones as $imagen): ?>
                <tr>
                    <td><?php echo $imagen['id']; ?></td>
                    <td><?php echo $imagen['id_habitacion']; ?></td>
                    <td><?php echo $imagen['url']; ?></td>
                    <td>
                        <a href="?borrar_imagen=<?php echo $imagen['id']; ?>" onclick="return confirm('¿Seguro que deseas borrar esta imagen?')">Borrar</a>
                        <a href="?editar_imagen=<?php echo $imagen['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulario para editar o agregar imágenes de habitaciones -->
    <?php if (isset($_GET['editar_imagen'])): ?>
        <h2>Editar Imagen de Habitación</h2>
        <?php $imagenEditar = obtenerImagenHabitacionPorId($_GET['editar_imagen']); ?>
        <form method="post">
            <input type="hidden" name="id_habitacion" value="<?php echo $imagenEditar['id_habitacion']; ?>">
            <input type="hidden" name="url" value="<?php echo $imagenEditar['url']; ?>">
            <button type="submit">Guardar Cambios</button>
        </form>
    <?php elseif (isset($_GET['agregar_imagen'])): ?>
        <h2>Agregar Nueva Imagen de Habitación</h2>
        <form method="post">
            <label for="id_habitacion">ID Habitación:</label>
            <input type="text" name="id_habitacion" required>
            <label for="url">URL:</label>
            <input type="text" name="url" required>
            <button type="submit">Agregar Imagen</button>
        </form>
    <?php else: ?>
        <p><a href="?agregar_imagen">Agregar Nueva Imagen</a></p>
    <?php endif; ?>

</body>
</html>

<?php
// Conectar a la base de datos
$mysqli = new mysqli("localhost", "root", "", "hotel");

// Verificar la conexión
if ($mysqli->connect_error) {
    echo "<script>alert('Conexión fallida: " . $mysqli->connect_error . "');</script>";
    exit(); // Detener la ejecución si hay un error
} else {
    echo "<script>alert('Conexión exitosa');</script>";
}

// Obtener todas las habitaciones
$resultado = $mysqli->query("SELECT * FROM habitaciones");

// Verificar si la consulta fue exitosa
if (!$resultado) {
    echo "<script>alert('Error al ejecutar la consulta: " . $mysqli->error . "');</script>";
    exit(); // Detener la ejecución si hay un error
}

$habitaciones = $resultado->fetch_all(MYSQLI_ASSOC);

// Resto del código...
?>

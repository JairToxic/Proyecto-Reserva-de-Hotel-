<?php
// basedatos.php
$mysqli = new mysqli("localhost", "root", "", "hotel");

// Verificar si la conexión se estableció correctamente
if ($mysqli->connect_errno) {
    echo "Error al conectar a la base de datos: " . $mysqli->connect_error;
} else {
    echo "Conexión exitosa a la base de datos.";
}
?>

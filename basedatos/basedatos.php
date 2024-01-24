<?php
// basedatos.php
$mysqli = new mysqli("localhost", "root", "", "hotel");

if ($mysqli->connect_error) {
    echo "<script>alert('Conexión fallida: " . $mysqli->connect_error . "');</script>";
    exit();
} else {
    echo "<script>alert('Conexión exitosa');</script>";
}
?>

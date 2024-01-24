<?php
include 'basedatos/basedatos.php';

// Se usa la variable $mysqli para realizar consultas
$resultado = $mysqli->query("SELECT * FROM habitaciones");
if (!$resultado) {
    echo "<script>alert('Error al ejecutar la consulta: " . $mysqli->error . "');</script>";
    exit();
}

$habitaciones = $resultado->fetch_all(MYSQLI_ASSOC);

?>

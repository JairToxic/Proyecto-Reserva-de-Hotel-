<?php
require_once("dbconnect.php"); // Archivo para conectar a la base de datos

// Consulta SQL para seleccionar todas las estrellas de la tabla comentarios
$query = "SELECT stars FROM comentarios";

// Ejecutar consulta
$result = $conn->query($query);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Arreglo para almacenar las estrellas
    $starsArray = array();

    // Obtener cada fila de resultados y almacenar las estrellas en el arreglo
    while ($row = $result->fetch_assoc()) {
        $starsArray[] = (int)$row['stars']; // Convertir a entero
    }

    // Codificar el arreglo como JSON y enviarlo como respuesta
    echo json_encode($starsArray);
} else {
    // Si no hay resultados, enviar un mensaje de error
    echo "No se encontraron datos de estrellas en la tabla de comentarios.";
}

// Cerrar conexión a la base de datos
$conn->close();
?>

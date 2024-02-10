<?php

// Conexión a la base de datos (debes proporcionar tus propios detalles de conexión)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Crear conexión
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Obtener el nombre del botón seleccionado de la URL
if (isset($_GET['type'])) {
    $tipoEntidad = $_GET['type'];

    // Realizar acciones según el tipo de entidad (reserva, habitacion, cabaña, comentarios)
    switch ($tipoEntidad) {
        case 'reserva':
            // Coloca aquí el código para administrar las reservas
            include 'eliminar_reserva.php';
            break;
        
        case 'habitacion':
            // Coloca aquí el código para administrar las habitaciones
            include 'eliminar_habitaciones.php';
            break;
        
        case 'cabana':
            // Coloca aquí el código para administrar las cabañas
            include 'eliminar_cabana.php';
            break;
        
        case 'comentarios':
            // Coloca aquí el código para administrar los comentarios
            include 'eliminar_comentario.php';
            break;
        
        default:
            // Tipo de entidad no válido
            echo "Error: Tipo de entidad no válido.";
            break;
    }

} 
?>
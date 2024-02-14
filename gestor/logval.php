<?php

$mysqli = new mysqli("localhost", "root", "", "hotel");

// Verificar la conexión
if ($mysqli->connect_error) {
    die("La conexión a la base de datos falló: " . $mysqli->connect_error);
}


// Función para limpiar y validar la entrada del usuario
function limpiar_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar y validar los datos del formulario
    $email = limpiar_input($_POST["email"]);
    $cod_reserva = limpiar_input($_POST["cod_reserva"]);

    $sql = "SELECT h.TIPO, h.DESCRIPCION, h.CAPACIDAD, h.CAMAS, h.BANO
    FROM cliente c
    JOIN reserva r ON c.ID_CLIENTE = r.ID_CLIENTE
    JOIN habitacion_reserva hr ON r.ID_RESERVA = hr.ID_RESERVA
    JOIN habitaciones h ON hr.ID_HABITACION = h.ID_HABITACION
    WHERE c.EMAIL = '$email' AND r.ID_RESERVA = $cod_reserva;";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Usuario y contraseña válidos
        header("Location: Reserva/verReserva.php?email=$email&cod_reserva=$cod_reserva");
        exit();
    } else {
        // Usuario o contraseña incorrectos
        $error_message = "Usuario o contraseña incorrectos.";

    }
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Result</title>
</head>
<body>
    <?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
        <!-- Agregar un botón o enlace para regresar a la página anterior -->
        <button onclick="goBack()">Volver</button>
    <?php } ?>

    <script>
        // Función para regresar a la página anterior
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
<?php
    include '../../../basedatos/basedatos.php';

    // Define variables e inicializa con valores vacíos
    $habitacion_id = $nombre = $apellido = $celular = $email = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservar'])) {
        // Valida y sanitiza los datos del formulario
        $habitacion_id = $_POST['habitacion_id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $celular = $_POST['celular'];
        $email = $_POST['email'];

        // Aquí debes realizar la validación adecuada según tus necesidades
        // ...

        // Puedes almacenar estos datos en una variable de sesión para usarlos en la página de pago
        session_start();
        $_SESSION['reserva_temporal'] = array(
            'habitacion_id' => $habitacion_id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'celular' => $celular,
            'email' => $email
        );

        // Después de la validación, redirige al usuario a la página de pago
        header("Location: pagar.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Reserva</title>
    <!-- Enlaces a hojas de estilo u otras metaetiquetas según sea necesario -->
</head>
<body>

<div class="reserva-container">
    <h2>Reservar Habitación</h2>

    <form action="" method="post">
        <!-- Agrega los campos del formulario según tus necesidades -->
        <input type="hidden" name="habitacion_id" value="<?php echo $habitacion_id; ?>">
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required>
        
        <label for="celular">Celular:</label>
        <input type="text" name="celular" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <input type="submit" name="reservar" value="Ir a Pagar">
    </form>

    <a href="../tipo de habitaciones/habitaciones_cuadruples.php">Volver a la lista de habitaciones</a>
</div>

</body>
</html>

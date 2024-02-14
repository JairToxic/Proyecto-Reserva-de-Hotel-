<?php
session_start();

if (isset($_SESSION['reserva_temporal'])) {
    include '../../../basedatos/basedatos.php';

    // Obtén los datos de la reserva temporal
    $reserva_temporal = $_SESSION['reserva_temporal'];
    $habitacion_id = $reserva_temporal['habitacion_id'];
    $nombre = $reserva_temporal['nombre'];
    $apellido = $reserva_temporal['apellido'];
    $celular = $reserva_temporal['celular'];
    $email = $reserva_temporal['email'];

    // Inserta los datos en la tabla de clientes
    $insert_query = "INSERT INTO cliente (NOMBRE, APELLIDO, CELULAR, EMAIL) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insert_query);

    // Verifica si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $mysqli->error);
    }

    $stmt->bind_param("ssss", $nombre, $apellido, $celular, $email);

    // Ejecuta la consulta preparada
    if ($stmt->execute()) {
        // Elimina la variable de sesión después de guardar los datos
        unset($_SESSION['reserva_temporal']);

        // Puedes redirigir al usuario a una página de confirmación o a donde desees
        echo "Pago exitoso. Los datos se han guardado en la base de datos.";
    } else {
        echo "Error al guardar los datos en la base de datos: " . $stmt->error;
    }

    // Cierra la consulta preparada y la conexión
    $stmt->close();
    $mysqli->close();
} else {
    // Si no hay datos de reserva temporal, redirige a la página principal u otra página según tus necesidades
    header("Location: ../index.php");
    exit();
}
?>

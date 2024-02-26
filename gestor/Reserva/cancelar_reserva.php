<?php

include '../../basedatos/basedatos.php';

// Obtén el ID de la reserva (ajusta el nombre del campo según tu estructura de base de datos)


$cod_reserva = $_GET['cod_reserva'];

global $mysqli;
$mysqli->begin_transaction();

try {
    // Consultas SQL para eliminar registros relacionados con la reserva
    $cancelar_reserva = "DELETE FROM Habitacion_reserva WHERE ID_RESERVA = $cod_reserva";
    $mysqli->query($cancelar_reserva);

    $cancelar_reserva = "DELETE FROM Pago WHERE ID_RESERVA = $cod_reserva";
    $mysqli->query($cancelar_reserva);

    $cancelar_reserva = "DELETE FROM Reserva WHERE ID_RESERVA = $cod_reserva";
    $mysqli->query($cancelar_reserva);

    // Verificar si hay resultados y la transacción se ha completado correctamente
    if (!$mysqli->errno && $mysqli->commit()) {
        $mysqli->close();

        // Redirige a otra página después de la eliminación (ajusta la URL según tus necesidades)
        header("Location: ../../Front-def/site/index.html");
        exit();
    } else {
        throw new Exception("Error en la transacción: " . $mysqli->error);
    }
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $mysqli->rollback();
    $mysqli->close();
    echo "Error: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Reserva</title>
</head>
<body>
    <h2>F</h2>
</body>
</html>
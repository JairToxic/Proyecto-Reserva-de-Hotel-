<?php

include '../../basedatos/basedatos.php';

// Obtén el ID de la reserva (ajusta el nombre del campo según tu estructura de base de datos)
$cod_reserva = $_GET['cod_reserva'];

if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    // Procede con la cancelación si se confirma
    cancelarReserva($cod_reserva);
} else {
    // Muestra el mensaje de confirmación con un alert
    echo '<!DOCTYPE html>
          <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Confirmar Cancelación</title>
              <script>
                  function confirmarCancelacion() {
                      var confirmacion = confirm("¿Seguro que quieres cancelar la reserva?");
                      if (confirmacion) {
                          window.location.href = "cancelar_reserva.php?cod_reserva=' . $cod_reserva . '&confirm=true";
                      } else {
                          alert("Cancelación de reserva cancelada.");
                          window.location.href = "../../Front-def/site/index.html";
                      }
                  }
              </script>
          </head>
          <body onload="confirmarCancelacion()">
              <h2>Espera un momento...</h2>
          </body>
          </html>';
}

function cancelarReserva($cod_reserva) {
    global $mysqli;
    $mysqli->begin_transaction();

    try {
        // Consultas SQL para eliminar registros relacionados con la reserva
        $cancelar_habitacion_reserva = "DELETE FROM Habitacion_reserva WHERE ID_RESERVA = $cod_reserva";
        $mysqli->query($cancelar_habitacion_reserva);

        $cancelar_pago = "DELETE FROM Pago WHERE ID_RESERVA = $cod_reserva";
        $mysqli->query($cancelar_pago);

        $cancelar_reserva = "DELETE FROM Reserva WHERE ID_RESERVA = $cod_reserva";
        $mysqli->query($cancelar_reserva);

        // Verificar si hay resultados y la transacción se ha completado correctamente
        if ($mysqli->commit()) {
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
}
?>

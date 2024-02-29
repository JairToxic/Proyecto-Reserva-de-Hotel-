<?php

include '../../basedatos/basedatos.php';

// Obtén el ID de la reserva (ajusta el nombre del campo según tu estructura de base de datos)
$cod_reserva = $_GET['cod_reserva'];

// Consulta para obtener el monto asociado a la reserva
$queryMonto = "SELECT MONTO FROM pago WHERE ID_RESERVA = $cod_reserva";
$resultMonto = $mysqli->query($queryMonto);

// Verificar si la consulta fue exitosa y hay resultados
if ($resultMonto && $resultMonto->num_rows > 0) {
    // Obtener el monto
    $monto = $resultMonto->fetch_assoc()['MONTO'];
    
    // Calcular el 10% del monto
    $monto_10_porcentaje = $monto * 0.15;

    // Calcular el total después de descontar el 10%
    $total_descontado = $monto - $monto_10_porcentaje;
} else {
    // Definir un valor por defecto en caso de no haber resultados
    $monto = "No disponible";
    $monto_10_porcentaje = 0;
    $total_descontado = 0;
}

if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    // Procede con la cancelación si se confirma
    cancelarReserva($cod_reserva);
} else {
    // Muestra el mensaje de confirmación con botones
    echo '<!DOCTYPE html>
          <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Confirmar Cancelación</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                  }
                  .container {
                      max-width: 600px;
                      margin: 50px auto;
                      padding: 20px;
                      background-color: #fff;
                      border-radius: 8px;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }
                  .btn-container {
                      text-align: center;
                  }
                  .btn {
                      display: inline-block;
                      padding: 10px 20px;
                      margin: 0 10px;
                      border: none;
                      border-radius: 5px;
                      cursor: pointer;
                  }
                  .btn-confirm {
                      background-color: #007bff;
                      color: #fff;
                  }
                  .btn-cancel {
                      background-color: #dc3545;
                      color: #fff;
                  }
              </style>
          </head>
          <body>
              <div class="container">
                  <h2>¿Seguro que quieres cancelar la reserva?</h2>
                  <p>Por favor, tenga en cuenta que de acuerdo con nuestra política de cancelación, se aplicará una penalización del 15% sobre el monto total de la reserva. Sin embargo, nos complace informarle que el restante 85% de su pago será reembolsado íntegramente.</p>
                  <p>Pago original: $' . $monto . '</p>
                  <p>Penalización: $' . $monto_10_porcentaje . '</p>
                  <p>Cantidad rembolsada si cancela: $' . $total_descontado . '</p>
                  <div class="btn-container">
                      <button class="btn btn-confirm" onclick="confirmarCancelacion()">Sí, cancelar reserva</button>
                      <button class="btn btn-cancel" onclick="cancelarCancelacion()">No, mantener reserva</button>
                  </div>
              </div>
              <script>
                  function confirmarCancelacion() {
                      window.location.href = "cancelar_reserva.php?cod_reserva=' . $cod_reserva . '&confirm=true";
                  }
                  function cancelarCancelacion() {
                      window.location.href = "../../Front-def/site/index.html";
                  }
              </script>
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
            // Muestra el mensaje de cancelación
            mostrarMensajeCancelacion();
            $mysqli->close();
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

function mostrarMensajeCancelacion() {
    // Mostramos el mensaje de cancelación con los datos proporcionados
    echo '<!DOCTYPE html>
          <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Cancelación Confirmada</title>
              <style>
              body {
                font-family: "Times New Roman", Times, serif;
                margin: 0;
                padding: 0;
             
                color: #333;
                line-height: 1.6;
                }
                .container {
                    max-width: 800px;
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    color: #007bff;
                    margin-top: 10px;
                   margin-left: 20px;
                }
                p {
                    margin: 10px 50px; /* Añadido margen a izquierda y derecha */
                    text-align: justify; /* Justificado */
                    font-size: 20px;
                }
                a {
                    color: white;
                    text-decoration: none;
                    margin-left: 20px;
                    background-color: #007bff;
                    padding: 10px;
                    font-size: 20px;
                }
                a:hover {
                    text-decoration: underline;
                }

            </style>
          </head>
          <body>
              <h1>Cancelación Confirmada</h1>
              <p>Estimado/a,</p>
              <p>Lamentamos mucho tener que recibir la notificación de la cancelación de su reserva en el Hotel Copo de Nieve. Entendemos que a veces surgen imprevistos que requieren cambios en los planes de viaje.</p>
              <p>Por favor, tenga en cuenta que de acuerdo con nuestra política de cancelación, se aplicará una penalización del 15% sobre el monto total de la reserva. Sin embargo, nos complace informarle que el restante 85% de su pago será reembolsado íntegramente.</p>
              <p><strong> El reembolso se procesará dentro de un plazo de 5 días hábiles a partir de la fecha de cancelación</strong>. Tenga en cuenta que el tiempo exacto para que los fondos estén disponibles en su cuenta bancaria puede variar según el método de pago y las políticas de su banco.</p>
              <p>Si necesita cualquier tipo de asistencia adicional o tiene alguna pregunta sobre el proceso de cancelación o reembolso, no dude en ponerse en contacto con nuestro equipo de atención al cliente. Estamos aquí para ayudarle en todo lo que necesite.</p>
              <p>Una vez más, lamentamos los inconvenientes que esta cancelación pueda causarle y esperamos poder darle la bienvenida en el futuro en el Hotel Copo de Nieve.</p>
              <p>Atentamente,</p>
              <p>[Hotel Copo de Nieve]</p>
              <p>Equipo de Servicio al Cliente</p>
              <a href="../../Front-def/site/index.html">Regresa al inicio</a>
          </body>
          </html>';
}
?>

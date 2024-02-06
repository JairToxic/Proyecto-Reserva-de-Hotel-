<?php
include '../../../basedatos/basedatos.php';

// Verificar si se reciben los parámetros necesarios
if (isset($_GET['fechaInicio']) && isset($_GET['fechaFin']) && isset($_GET['noches']) && isset($_GET['precioTotal'])) {
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];
    $noches = $_GET['noches'];
    $precioTotal = $_GET['precioTotal'];

    // Verificar disponibilidad
    $habitacion_id = $_GET['habitacion_id'];
    $disponible = verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin);

    if (!$disponible) {
        // La habitación no está disponible para las fechas seleccionadas.
        // Redirigir a una página de habitaciones disponibles o a otra de tu elección.
        header("Location: habitacion_no_disponible.php");
        exit();
    }

    // Aquí puedes realizar cualquier lógica adicional que necesites

} else {
    // Si no se proporcionan los parámetros necesarios, redireccionar o manejar el error según sea necesario
    echo "Error: No se han proporcionado los parámetros necesarios para la reserva.";
    exit();
}

function verificarDisponibilidad($habitacion_id, $fechaInicio, $fechaFin) {
    global $mysqli;

    // Consulta SQL para verificar la disponibilidad de la habitación
    $consultaDisponibilidad = "SELECT hr.ID_HABITACION FROM habitacion_reserva hr
                              JOIN reserva r ON hr.ID_RESERVA = r.ID_RESERVA
                              WHERE hr.ID_HABITACION = ? 
                              AND (r.FECHACHECKIN <= ? AND r.FECHACHECKOUT >= ?)";

    // Usar consulta preparada para seguridad
    $stmt = $mysqli->prepare($consultaDisponibilidad);
    $stmt->bind_param("iss", $habitacion_id, $fechaFin, $fechaInicio);
    $stmt->execute();

    // Obtener resultados
    $resultado = $stmt->get_result();

    // Verificar si hay reservas que coincidan
    if ($resultado->num_rows > 0) {
        // La habitación no está disponible en esas fechas
        return false;
    } else {
        // La habitación está disponible
        return true;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Reserva</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AWgZnde6LENtYx86KBDDmY6X6slBw5fef6Pfa7W8Rrdp1L1c5yX3mL-cuJoyBVACPxBqscr7Ii58Ukol&currency=USD"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #555;
            font-size: 16px;
            text-align: left;
            width: 100%;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        #paypal-button-container {
            display: none; /* Inicialmente oculto */
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmación de Reserva</h1>
        <p><strong>Fecha de Check-in:</strong> <?php echo $fechaInicio; ?></p>
        <p><strong>Fecha de Check-out:</strong> <?php echo $fechaFin; ?></p>
        <p><strong>Noches:</strong> <?php echo $noches; ?></p>
        <p><strong>Precio Total:</strong> <?php echo $precioTotal; ?></p>

        <!-- Formulario de detalles del cliente -->
        <form id="confirmarReservaForm" method="post" action="procesar_reserva.php">
            <input type="hidden" name="fechaInicio" value="<?php echo $fechaInicio; ?>">
            <input type="hidden" name="fechaFin" value="<?php echo $fechaFin; ?>">
            <input type="hidden" name="noches" value="<?php echo $noches; ?>">
            <input type="hidden" name="precioTotal" value="<?php echo $precioTotal; ?>">

            <!-- Iterar sobre las habitaciones seleccionadas -->
            <?php foreach ($habitaciones as $habitacion_id): ?>
                <input type="hidden" name="habitaciones[]" value="<?php echo $habitacion_id; ?>">
            <?php endforeach; ?>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required placeholder="Ingrese su nombre">

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required placeholder="Ingresa tu apellido">

            <label for="celular">Celular:</label>
            <input type="text" name="celular" required placeholder="Ingresa tu numero celular">

            <label for="email">Email:</label>
            <input type="email" name="email" required placeholder="alguien@gmail.com">

            <button type="button" onclick="validarYMostrarPaypal()">Confirmar Reserva</button>

            <!-- Campo oculto para indicar que el pago se realizó a través de PayPal -->
            <input type="hidden" name="paypal_payment" value="1">
        </form>
        

        <div id="paypal-button-container">
            <h4>Para confirmar su reserva paga con:</h4>
        </div>
    </div>

    <script>
        function validarYMostrarPaypal() {
            if (validarFormulario()) {
                // Deshabilitar el botón después de la validación exitosa
                document.querySelector('#confirmarReservaForm button').disabled = true;

                // Mostrar el botón de PayPal
                document.getElementById('paypal-button-container').style.display = 'block';

                // Iniciar el flujo de PayPal
                iniciarPaypal();
            }
        }

        function validarFormulario() {
            // Agrega aquí la lógica de validación del formulario si es necesario
            // Por ejemplo, puedes verificar que todos los campos estén llenos
            var inputs = document.querySelectorAll('#confirmarReservaForm input[required]');
            for (var i = 0; i < inputs.length; i++) {
                if (!inputs[i].value.trim()) {
                    alert('Por favor, complete todos los campos antes de confirmar la reserva.');
                    return false;
                }
            }
            return true;
        }

        function iniciarPaypal() {
            // Configurar el flujo de PayPal
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '<?php echo $precioTotal; ?>'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    // Después de la aprobación de PayPal, enviar el formulario
                    document.getElementById('confirmarReservaForm').submit();
                }
            }).render('#paypal-button-container');
        }
    </script>
</body>
</html>

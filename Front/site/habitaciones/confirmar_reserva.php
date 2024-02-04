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
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #555;
            font-size: 16px;
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
  position: relative;
  margin: 0;
  padding: 0.8em 1em;
  outline: none;
  text-decoration: none;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  border: none;
  text-transform: uppercase;
  background-color: #333;
  border-radius: 10px;
  color: #fff;
  font-weight: 300;
  font-size: 18px;
  font-family: inherit;
  z-index: 0;
  overflow: hidden;
  transition: all 0.3s cubic-bezier(0.02, 0.01, 0.47, 1);
}

button:hover {
  animation: sh0 0.5s ease-in-out both;
}

@keyframes sh0 {
  0% {
    transform: rotate(0deg) translate3d(0, 0, 0);
  }

  25% {
    transform: rotate(7deg) translate3d(0, 0, 0);
  }

  50% {
    transform: rotate(-7deg) translate3d(0, 0, 0);
  }

  75% {
    transform: rotate(1deg) translate3d(0, 0, 0);
  }

  100% {
    transform: rotate(0deg) translate3d(0, 0, 0);
  }
}

button:hover span {
  animation: storm 0.7s ease-in-out both;
  animation-delay: 0.06s;
}

button::before,
button::after {
  content: '';
  position: absolute;
  right: 0;
  bottom: 0;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #fff;
  opacity: 0;
  transition: transform 0.15s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.15s cubic-bezier(0.02, 0.01, 0.47, 1);
  z-index: -1;
  transform: translate(100%, -25%) translate3d(0, 0, 0);
}

button:hover::before,
button:hover::after {
  opacity: 0.15;
  transition: transform 0.2s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.2s cubic-bezier(0.02, 0.01, 0.47, 1);
}

button:hover::before {
  transform: translate3d(50%, 0, 0) scale(0.9);
}

button:hover::after {
  transform: translate(50%, 0) scale(1.1);
}


        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmación de Reserva</h1>
        <p>Fecha de Check-in: <?php echo $fechaInicio; ?></p>
        <p>Fecha de Check-out: <?php echo $fechaFin; ?></p>
        <p>Noches: <?php echo $noches; ?></p>
        <p>Precio Total: <?php echo $precioTotal; ?></p>

        <!-- Formulario de detalles del cliente -->
        <form method="post" action="procesar_reserva.php">
            <input type="hidden" name="fechaInicio" value="<?php echo $fechaInicio; ?>">
            <input type="hidden" name="fechaFin" value="<?php echo $fechaFin; ?>">
            <input type="hidden" name="noches" value="<?php echo $noches; ?>">
            <input type="hidden" name="precioTotal" value="<?php echo $precioTotal; ?>">
            <input type="hidden" name="habitacion_id" value="<?php echo $habitacion_id; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required>

            <label for="celular">Celular:</label>
            <input type="text" name="celular" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <button type="submit" name="confirmar_reserva">Confirmar Reserva</button>
        </form>
    </div>
</body>
</html>

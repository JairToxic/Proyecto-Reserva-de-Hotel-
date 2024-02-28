<?php
include '../../basedatos/basedatos.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos del formulario y sanitízalos
    $fechaInicio = mysqli_real_escape_string($mysqli, $_POST["checkinDate"]);
    $fechaFin = mysqli_real_escape_string($mysqli, $_POST["checkoutDate"]);
    $cod_reserva = mysqli_real_escape_string($mysqli, $_POST["cod_reserva"]);

     // Obtén las fechas originales de la reserva
    $fechaCheckinOriginal = obtenerFechaOriginalCheckin($cod_reserva);
    $fechaCheckoutOriginal = obtenerFechaOriginalCheckout($cod_reserva);

    // Realiza la validación del número de noches
    $nochesOriginal = calcularNoches($fechaCheckinOriginal, $fechaCheckoutOriginal);
    $nochesNuevas = calcularNoches($fechaInicio, $fechaFin);

    // Obtén la fecha actual y la fecha de check-in
    $fechaActual = new DateTime();
    $fechaCheckin = new DateTime($fechaCheckinOriginal);

    // Calcula la diferencia en días entre la fecha actual y la fecha de check-in
    $diferenciaDias = $fechaActual->diff($fechaCheckin)->days;
    

    $fechaCheckinMod = new DateTime($fechaInicio);
    // Calcula la diferencia en días entre la fecha actual y la fecha de check-in
    $diferenciaDiasMod = $fechaActual->diff($fechaCheckin)->days;

    // Verifica si faltan menos de dos días para la reserva
    
    if ($diferenciaDiasMod < 2) {
        echo "<script>
                    setTimeout(function() {
                        alert('Falta menos de 2 dias para el check-in de la nueva reserva. No esta disponible');
                        window.location.href = '../logger.php';
                    }, 1000);
                  </script>";
        exit();
    }

    // Verifica si faltan menos de dos días para la reserva
    if ($diferenciaDias < 2) {
        echo "<script>
                    setTimeout(function() {
                        alert('Falta menos de 2 dias para el check-in de tu reserva, no puedes modificarla.');
                        window.location.href = '../logger.php';
                    }, 1000);
                  </script>";
        exit();
    }

    // Verificar disponibilidad de fecha
    if (!verificarDisponibilidadFecha($fechaInicio, $fechaFin, $cod_reserva)) {
        echo "<script>
                    setTimeout(function() {
                        alert('Las fechas seleccionadas no están disponibles.');
                        window.location.href = '../logger.php';
                    }, 1000);
                  </script>";
        exit();
    }

    // Verificar disponibilidad de habitación
    if (!verificarDisponibilidadHabitacion($fechaInicio, $fechaFin, $cod_reserva)) {
        echo "<script>
                    setTimeout(function() {
                        alert('La habitación asociada a esta reserva no está disponible en las fechas seleccionadas.');
                        window.location.href = '../logger.php';
                    }, 1000);
                  </script>";
        exit();
    }

   
    

    if ($nochesNuevas == $nochesOriginal) {
        // Actualiza las fechas en la base de datos
        $actualizarReserva = "UPDATE Reserva SET FECHACHECKIN = '$fechaInicio', FECHACHECKOUT = '$fechaFin' WHERE ID_RESERVA = $cod_reserva";

        if ($mysqli->query($actualizarReserva)) {
            

            // Agregar un retraso de 1 segundo y redirigir o mostrar una alerta
            echo "<script>
                    setTimeout(function() {
                        alert('Reserva actualizada correctamente.');
                        window.location.href = '../../Front-def/site/index.html';
                    }, 1000);
                  </script>";
        } else {
            echo "Error al actualizar la reserva: " . $mysqli->error;
        }
    } else {
        echo "<script>
                    setTimeout(function() {
                        alert('Los dias seleccionados son distintos a la reserva original');
                        window.location.href = '../logger.php';
                    }, 1000);
                  </script>";
    }
}

function verificarDisponibilidadFecha($fechaInicio, $fechaFin, $cod_reserva) {
    global $mysqli;

    // Consulta para verificar si hay reservas que se superpongan con las fechas nuevas
    $consulta = "SELECT COUNT(*) AS count FROM Reserva WHERE ID_RESERVA != $cod_reserva AND (FECHACHECKIN BETWEEN '$fechaInicio' AND '$fechaFin' OR FECHACHECKOUT BETWEEN '$fechaInicio' AND '$fechaFin')";
    $resultado = $mysqli->query($consulta);

    if ($resultado) {
        $fila = $resultado->fetch_assoc();
        return ($fila["count"] == 0);
    } else {
        echo "Error al verificar disponibilidad de fecha: " . $mysqli->error;
        exit();
    }
}

function verificarDisponibilidadHabitacion($fechaInicio, $fechaFin, $cod_reserva) {
    global $mysqli;

    // Consulta para verificar si la habitación asociada a la reserva está disponible en las fechas nuevas
    $consulta = "SELECT COUNT(*) AS count FROM Habitacion_Reserva WHERE ID_RESERVA != $cod_reserva AND ID_HABITACION IN (SELECT ID_HABITACION FROM Reserva WHERE (FECHACHECKIN BETWEEN '$fechaInicio' AND '$fechaFin' OR FECHACHECKOUT BETWEEN '$fechaInicio' AND '$fechaFin'))";
    $resultado = $mysqli->query($consulta);

    if ($resultado) {
        $fila = $resultado->fetch_assoc();
        return ($fila["count"] == 0);
    } else {
        echo "Error al verificar disponibilidad de habitación: " . $mysqli->error;
        exit();
    }
}

function obtenerFechaOriginalCheckin($cod_reserva) {
    global $mysqli;

    $consultaFechaCheckin = "SELECT FECHACHECKIN FROM Reserva WHERE ID_RESERVA = $cod_reserva";
    $resultado = $mysqli->query($consultaFechaCheckin);

    if ($resultado) {
        $fechaCheckinOriginal = $resultado->fetch_assoc()["FECHACHECKIN"];
        return $fechaCheckinOriginal;
    } else {
        echo "Error al obtener la fecha original de check-in: " . $mysqli->error;
        exit();
    }
}

function obtenerFechaOriginalCheckout($cod_reserva) {
    global $mysqli;

    $consultaFechaCheckout = "SELECT FECHACHECKOUT FROM Reserva WHERE ID_RESERVA = $cod_reserva";
    $resultado = $mysqli->query($consultaFechaCheckout);

    if ($resultado) {
        $fechaCheckoutOriginal = $resultado->fetch_assoc()["FECHACHECKOUT"];
        return $fechaCheckoutOriginal;
    } else {
        echo "Error al obtener la fecha original de check-out: " . $mysqli->error;
        exit();
    }
}

function calcularNoches($fechaInicio, $fechaFin) {
    $date1 = new DateTime($fechaInicio);
    $date2 = new DateTime($fechaFin);
    $interval = $date1->diff($date2);
    return $interval->days;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .mensaje-contenedor {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
        }

        .mensaje img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
    <title>Copo de Nieve</title>
</head>
<body>
    <div class="mensaje-contenedor">
        <div class="mensaje">
            <img src="../styles/logo1.PNG" alt="Copo de nieve">
        </div>
    </div>
</body>
</html>
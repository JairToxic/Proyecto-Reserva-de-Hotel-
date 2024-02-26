<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones Disponibles</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Enlace a tu archivo de estilos CSS personalizado -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
include '../../../basedatos/basedatos.php';

// Función para verificar disponibilidad
function verificarDisponibilidad($habitacion_id, $fechaInicio) {
    global $mysqli;

    // Consulta SQL para verificar la disponibilidad de la habitación
    $consultaDisponibilidad = "SELECT hr.ID_HABITACION FROM habitacion_reserva hr
                              JOIN reserva r ON hr.ID_RESERVA = r.ID_RESERVA
                              WHERE hr.ID_HABITACION = ? 
                              AND r.FECHACHECKIN <= ?";

    // Preparar la consulta
    $stmt = $mysqli->prepare($consultaDisponibilidad);

    // Vincular parámetros
    $stmt->bind_param("is", $habitacion_id, $fechaInicio);

    // Ejecutar la consulta
    $stmt->execute();

    // Almacenar el resultado
    $stmt->store_result();

    // Obtener el número de filas devueltas
    $num_filas = $stmt->num_rows;

    // Cerrar la consulta
    $stmt->close();

    // Devolver true si la habitación está disponible, false en caso contrario
    return $num_filas == 0;
}
// Consulta para obtener todas las habitaciones
$resultado = $mysqli->query("SELECT * FROM habitaciones");

if (!$resultado) {
    echo "<script>alert('Error al ejecutar la consulta: " . $mysqli->error . "');</script>";
    exit();
}

$habitaciones = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-4">
    <h1 class="display-4 text-center mb-4">Habitaciones Disponibles</h1>
    <?php foreach ($habitaciones as $habitacion) : ?>
        <?php
            // Verificar disponibilidad para las fechas deseadas (cambia las fechas según tus necesidades)
            $disponible = verificarDisponibilidad($habitacion['ID_HABITACION'], '2024-02-12', '2024-02-16');
            $clase_card = ($disponible) ? 'card' : 'card text-white bg-secondary';
            $estado = ($disponible) ? 'Disponible' : 'No Disponible';
        ?>

        <div class="<?php echo $clase_card; ?> mb-4 shadow">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="../imagenes/<?php echo $habitacion['ID_HABITACION']; ?>.jpg" class="card-img" alt="Imagen de la habitación">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold"><?php echo $habitacion['TIPO']; ?></h5>
                        <p class="card-text"><?php echo $habitacion['DESCRIPCION']; ?></p>
                        <p class="card-text small text-muted">Capacidad: <?php echo $habitacion['CAPACIDAD']; ?> personas</p>
                        <div class="precio bg-success text-white text-center font-weight-bold">
                            Precio por noche: $<?php echo $habitacion['PRECIOPORNOCHE']; ?>
                        </div>
                        <p class="mt-2"><?php echo $estado; ?></p>
                        <?php if (!$disponible) : ?>
                            <button class="btn btn-secondary" disabled>No Disponible</button>
                            <?php else : ?>
    <button class="btn btn-success" id="hacerReservaBtn">Hacer Reserva</button>

    <script>
        // Asignar un evento de clic al botón
        document.getElementById('hacerReservaBtn').addEventListener('click', function() {
            // Redireccionar a la página de reserva
            window.location.href = '../habitaciones/prueba.php';
        });
    </script>
<?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Enlace a Bootstrap JS y Popper.js (necesarios para el funcionamiento de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

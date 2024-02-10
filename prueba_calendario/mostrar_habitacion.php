<?php
// Recuperar los datos del formulario de la URL
$fecha_checkin = $_GET['fecha_checkin'] ?? '';
$fecha_checkout = $_GET['fecha_checkout'] ?? '';
$num_huespedes = $_GET['num_huespedes'] ?? '';

// Verificar si se enviaron los datos del formulario
if ($fecha_checkin && $fecha_checkout && $num_huespedes) {
    // Aquí puedes utilizar los datos recuperados para realizar la consulta SQL y mostrar las habitaciones disponibles

    // Establecer conexión a la base de datos
    $mysqli = new mysqli("localhost", "root", "", "prueba_hotel");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Consulta SQL para seleccionar las habitaciones disponibles en función de los criterios seleccionados
    $sql = "SELECT * FROM HABITACIONES 
            WHERE CAPACIDAD >= ? 
            AND ID_HABITACION NOT IN (
                SELECT ID_HABITACION 
                FROM HABITACION_RESERVA 
                INNER JOIN RESERVA ON HABITACION_RESERVA.ID_RESERVA = RESERVA.ID_RESERVA 
                WHERE (FECHACHECKIN BETWEEN ? AND ?) 
                OR (FECHACHECKOUT BETWEEN ? AND ?) 
                OR (FECHACHECKIN < ? AND FECHACHECKOUT > ?)
            )";

    // Preparar la consulta
    $stmt = $mysqli->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("issssss", $num_huespedes, $fecha_checkin, $fecha_checkout, $fecha_checkin, $fecha_checkout, $fecha_checkin, $fecha_checkout);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener resultados de la consulta
    $result = $stmt->get_result();
}

// Cerrar la conexión y liberar recursos
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mostrar Habitaciones Disponibles</title>
<style>
    .habitacion {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
    }
    .habitacion img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }
</style>
</head>
<body>

<?php if ($result && $result->num_rows > 0) { ?>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="habitacion">
            <img src="1.jpg/<?php echo $row['IMAGEN']; ?>" alt="Habitación <?php echo $row['ID_HABITACION']; ?>">
            <p>ID de habitación: <?php echo $row['ID_HABITACION']; ?></p>
            <p>Descripción: <?php echo $row['DESCRIPCION']; ?></p>
            <p>Precio por noche: <?php echo $row['PRECIOPORNOCHE']; ?></p>
            <p>Capacidad: <?php echo $row['CAPACIDAD']; ?></p>
            <p>Camas: <?php echo $row['CAMAS']; ?></p>
            <p>Baños: <?php echo $row['BANO']; ?></p>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No hay habitaciones disponibles para las fechas y número de huéspedes seleccionados.</p>
<?php } ?>

</body>
</html>



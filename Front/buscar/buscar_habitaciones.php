<?php
// Conexión a la base de datos (asegúrate de tener tu configuración correcta)
$conexion = new mysqli("localhost", "root", "", "hotel");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Inicializar el array para almacenar las habitaciones disponibles
$habitacionesDisponibles = array();

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $capacidad = $_POST['capacidad'];

    // Consulta SQL para obtener habitaciones disponibles
    $query = "SELECT * FROM habitaciones
              WHERE CAPACIDAD >= $capacidad
              AND ID_HABITACION NOT IN (
                  SELECT hr.ID_HABITACION FROM habitacion_reserva hr
                  JOIN reserva r ON hr.ID_RESERVA = r.ID_RESERVA
                  WHERE (r.FECHACHECKIN <= '$checkout' AND r.FECHACHECKOUT >= '$checkin')
              )";

    $resultado = $conexion->query($query);

    // Almacenar resultados en el array
    while ($habitacion = $resultado->fetch_assoc()) {
        $habitacionesDisponibles[] = $habitacion;
    }
}

// Cerrar conexión
$conexion->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones Disponibles</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .productos-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .producto {
            flex: 0 0 300px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .producto-imagen {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .contenido {
            padding: 15px;
        }

        .producto-titulo {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .card-title {
            margin-bottom: 5px;
        }

        .btn {
            width: 100%;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>




    <!-- Mostrar todas las habitaciones -->
<div class="productos-container">
    <?php foreach ($habitacionesDisponibles as $habitacion) : ?>
        <div class="producto">
            <!-- Asume que todas las imágenes son .jpg. Modifica según tus necesidades -->
            <img src="imagenes/<?php echo $habitacion['ID_HABITACION']; ?>.jpg" alt="Imagen de la habitación" class="producto-imagen">
            <div class="contenido">
                <h2 class="producto-titulo"><?php echo $habitacion['TIPO']; ?></h2>
                <p class="card-title">👥<?php echo $habitacion['CAPACIDAD']; ?> personas</p>
                <p class="card-title">Precio: $<?php echo $habitacion['PRECIOPORNOCHE']; ?></p>
                <p class="card-title"><?php echo $habitacion['DESCRIPCION']; ?></p>
                <!-- Botón de Pago PayPal para cada Habitación -->
                <form action="pago.php" method="post">
                    <input type="hidden" name="producto_id" value="<?php echo $habitacion['ID_HABITACION']; ?>">
                    <input type="submit" value="Pagar con PayPal" class="btn btn-success">
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>

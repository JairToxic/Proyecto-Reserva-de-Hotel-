<?php
    include '../basedatos/basedatos.php';

    // Se usa la variable $mysqli para realizar consultas
    $resultado = $mysqli->query("SELECT * FROM habitaciones ");

    if (!$resultado) {
        echo "<script>alert('Error al ejecutar la consulta: " . $mysqli->error . "');</script>";
        exit();
    }
    // Convertir el resultado en un array asociativo
    $habitaciones = $resultado->fetch_all(MYSQLI_ASSOC);
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
    <?php foreach ($habitaciones as $habitacion) : ?>
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

<?php
include '../basedatos/basedatos.php';

// Se usa la variable $mysqli para realizar consultas
$resultado = $mysqli->query("SELECT * FROM habitaciones");
if (!$resultado) {
    echo "<script>alert('Error al ejecutar la consulta: " . $mysqli->error . "');</script>";
    exit();
}
// Convertir el resultado en un array asociativo
$habitaciones = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copo De Nieve</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles/style.css" rel="stylesheet">
</head>

<body>
    <!--Barra de navegación - header -->
    <header class="header-outer">
        <div class="header-inner responsive-wrapper">
            <div class="header-logo">
                <img src="styles/copo.jpg" />
            </div>
            <p id="Titulo">Copo de Nieve</p>
            <nav class="header-navigation">
                <a href="#">Inicio</a>
                <a href="#">Galeria</a>
                <a href="#">Contactanos</a>
                <button>Menu</button>
            </nav>
        </div>
    </header>

    <!-- Mostrar todas las habitaciones -->
    <div class="productos-container">
        <?php foreach ($habitaciones as $habitacion) : ?>
            <div class="producto">
                <!-- Asume que todas las imágenes son .jpg. Modifica según tus necesidades -->
                <img src="imagenes/<?php echo $habitacion['ID_HABITACION']; ?>.jpg" alt="Imagen de la habitación">
                <div class="contenido">
                    <h2><?php echo $habitacion['TIPO']; ?></h2>
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

    <!-- Contenedor de reserva (mismo que en tu código original) -->
    <div class="container">
        <div class="card">
            <div class="face back">
                <div class="content">
                    <span class="stars"></span>
                    <b class="desc">Su Reserva</b>
                    <p class="desc">
                        <p>Fecha de entrada: 01/02/2023</p>
                        <p>Fecha de salida: 10/02/2023</p>
                        <p>Número de adultos: 2</p>
                        <p>Número de niños: 1</p>
                    </p>
                </div>
            </div>
            <div class="face front">
                <b>Reserva</b>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <!-- Script para el carrusel -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="Front/js/main.js"></script>

</body>
</html>

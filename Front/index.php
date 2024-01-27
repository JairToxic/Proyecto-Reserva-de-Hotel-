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


  <!-- Archivo principal HTML para mostrar datos de la base de datos -->

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copo De Nieve</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles/style.css" rel="stylesheet">
</head>

<body>
    <!--Barra de navegación - header -->
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark"> <!--Utilizamos estilos de boostrap -->
            <div class="container"> <!--Contenedor -->
                <a href="#" class="navbar-brand">
                    <strong>Copo de Nieve</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Catálogo</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contacto</a>
                        </li>
                    </ul>
                    
                </div>
            </div><!--Fin del contenedor -->
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
</body>
</html>
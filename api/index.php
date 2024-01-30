<?php
// Conectar a la base de datos
$mysqli = new mysqli("localhost", "root", "", "tienda");

// Obtener todos los productos
$resultado = $mysqli->query("SELECT * FROM habitaciones");
$productos = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <!--Barra de navegación-->
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <strong>Tienda Online</strong>
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
                    <a href="carrito.php" class="btn btn-primary">Carrito</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Estilos para las tarjetas de producto -->
<style>
    .producto {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin: 10px;
        text-align: center;
    }
    .producto img {
    width: 300px; /* Ancho fijo para todas las imágenes */
    height: 200px; /* Alto fijo para todas las imágenes */
    object-fit: cover; /* Ajusta la imagen para cubrir el área sin distorsionarla */
    border-radius: 5px;
}
    .btn-success {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-success:hover {
        background-color: #45a049;
    }
</style>

 <!-- Mostrar todos los productos -->
<?php foreach ($productos as $producto) : ?>
    <div class="producto">
        <!-- Asume que todas las imágenes son .jpg. Modifica según tus necesidades -->
        <img src="imagenes/<?php echo $producto['ID_HABITACION']; ?>.jpg" alt="Imagen de la habitación">
        <h2><?php echo $producto['TIPO']; ?></h2>
        <p class="card-title">Precio: $<?php echo $producto['PRECIOPORNOCHE']; ?></p>

        <!-- Botón de Pago PayPal para cada Producto -->
        <form action="pago.php" method="post">
            <input type="hidden" name="producto_id" value="<?php echo $producto['ID_HABITACION']; ?>">
            <input type="submit" value="Pagar con PayPal" class="btn btn-success">
        </form>
    </div>
<?php endforeach; ?>

  
</body>

</html>

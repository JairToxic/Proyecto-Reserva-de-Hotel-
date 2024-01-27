<?php
include '../basedatos/basedatos.php';

// Se usa la variable $mysqli para realizar consultas
$resultado = $mysqli->query("SELECT * FROM habitaciones");
if (!$resultado) {
    echo "<script>alert('Error al ejecutar la consulta: " . $mysqli->error . "');</script>";
    exit()
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
            <p class="card-title">Precio: $<?php echo $habitacion['PRECIOPORNOCHE']; ?>< PayP
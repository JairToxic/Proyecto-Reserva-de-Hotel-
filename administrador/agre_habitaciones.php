<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Habitación</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <a href="inicioCRUD.php" class="btn btn-primary position-absolute top-0 start-0 m-4">Regresar al inicio</a>
    <h2>Agregar Habitación</h2>

    <form id="habitacionForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id_habitacion">Número de Habitación:</label><br>
        <input type="text" id="id_habitacion" name="id_habitacion" required><br><br>

        <label for="tipo">Tipo:</label><br>
        <input type="text" id="tipo" name="tipo" required><br><br>
        
        <label for="descripcion">Descripción:</label><br>
        <input type="text" id="descripcion" name="descripcion"><br><br>
        
        <label for="precio_por_noche">Precio por Noche:</label><br>
        <input type="text" id="precio_por_noche" name="precio_por_noche" required><br><br>
        
        <label for="capacidad">Capacidad:</label><br>
        <input type="text" id="capacidad" name="capacidad" required><br><br>
        
        <label for="camas">Camas:</label><br>
        <input type="text" id="camas" name="camas"><br><br>
        
        <label for="bano">Baño:</label><br>
        <input type="text" id="bano" name="bano"><br><br>
        
        <!-- Agregar la columna 'IMAGEN_PRINCIPAL' -->
        <label for="imagen_principal">Imagenes de la habitación:</label><br>
        <input type="text" id="imagen_principal" name="imagen_principal"><br><br>
        
        <input type="submit" value="Agregar Habitación">
    </form>
    <div class="btn-container">
        <button id="toggleRoomsBtn" type="button" onclick="toggleRooms()">Mostrar Habitaciones</button>
    </div>
    <div class="mt-4">
            <?php echo isset($alert_success) ? $alert_success : ''; ?>
            <?php echo isset($alert_error) ? $alert_error : ''; ?>
    </div> 

    <h2>Habitaciones Agregadas</h2>
    <div id="habitacionesContainer" style="display: none;"> <!-- Contenedor de las habitaciones oculto por defecto -->
    <?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['username'])) {
        // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
        header("Location: index.php");
        exit;
    }
        include'basedatos/basedatos.php';
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar que id_habitacion sea un entero
            $id_habitacion = $_POST['id_habitacion'];
            if (!filter_var($id_habitacion, FILTER_VALIDATE_INT)) {
                echo "<script>alert('El ID de habitación debe ser un número entero.');</script>";
                exit(); // Salir del script si la validación falla
            }
            $id_habitacion = mysqli_real_escape_string($conn, $id_habitacion);
            $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
            $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
            $precio_por_noche = mysqli_real_escape_string($conn, $_POST['precio_por_noche']);
            $capacidad = mysqli_real_escape_string($conn, $_POST['capacidad']);
            $camas = mysqli_real_escape_string($conn, $_POST['camas']);
            $bano = mysqli_real_escape_string($conn, $_POST['bano']);
            $imagen_principal = mysqli_real_escape_string($conn, $_POST['imagen_principal']);

            // Actualizar los datos de la habitación en la base de datos
            $sql = "INSERT INTO habitaciones (ID_HABITACION, TIPO, DESCRIPCION, PRECIOPORNOCHE, CAPACIDAD, CAMAS, BANO) 
                    VALUES ('$id_habitacion', '$tipo', '$descripcion', '$precio_por_noche', '$capacidad', '$camas', '$bano')";

            if ($conn->query($sql) === TRUE) {
              $alert_success = "<div class='alert alert-success' role='alert'>Habitación agregada correctamente.</div>";
            } else {
                $alert_error = "<div class='alert alert-danger' role='alert'>Error al agregar la habitación: " . $conn->error . "</div>";
            }
             // Insertar la URL de la imagen en la tabla imagenes_habitaciones
            $sql_imagen = "INSERT INTO imagenes_habitaciones (id_habitacion, url) 
            VALUES ('$id_habitacion', '$imagen_principal')";
            if ($conn->query($sql_imagen) === TRUE) {
                //echo "Imagen agregada exitosamente.";
            } else {
                echo "Error al agregar la imagen: " . $conn->error;
            }
        }
        
         
         $sql = "SELECT habitaciones.*, GROUP_CONCAT(imagenes_habitaciones.url) AS imagenes_principales 
         FROM habitaciones 
         LEFT JOIN imagenes_habitaciones ON habitaciones.ID_HABITACION = imagenes_habitaciones.id_habitacion 
         GROUP BY habitaciones.ID_HABITACION";
         $result = $conn->query($sql);

         if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='container'>";
                echo "<h3>Habitación : " . $row["ID_HABITACION"] . " - " . $row["TIPO"] . "</h3>"; // Mostrar el ID de la habitación junto con el tipo
                
                // Carrusel de imágenes
                echo "<div id='carouselContainer" . $row['ID_HABITACION'] . "' class='carousel slide' data-bs-ride='carousel'>";
                echo "<div class='carousel-inner'>";
                
                $imagenes_principales = explode(",", $row["imagenes_principales"]);
                $first = true;
                foreach ($imagenes_principales as $imagen) {
                    echo "<div class='carousel-item" . ($first ? " active" : "") . "'>";
                    echo "<img src='$imagen' class='d-block w-50 mx-auto' alt='Imagen'>"; // Se cambió la clase para reducir aún más el tamaño de la imagen
                    echo "</div>";
                    $first = false;
                }
                
                echo "</div>";
                echo "<button class='carousel-control-prev' type='button' data-bs-target='#carouselContainer" . $row['ID_HABITACION'] . "' data-bs-slide='prev'>";
                echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                echo "<span class='visually-hidden'>Previous</span>";
                echo "</button>";
                echo "<button class='carousel-control-next' type='button' data-bs-target='#carouselContainer" . $row['ID_HABITACION'] . "' data-bs-slide='next'>";
                echo "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                echo "<span class='visually-hidden'>Next</span>";
                echo "</button>";
                echo "</div>";
                
                echo "<p>" . $row["DESCRIPCION"] . "</p>";
                echo "<p>Precio por noche: $" . $row["PRECIOPORNOCHE"] . "</p>";
                echo "<p>Capacidad: " . $row["CAPACIDAD"] . "</p>";
                echo "<p>Camas: " . $row["CAMAS"] . "</p>";
                echo "<p>Baño: " . $row["BANO"] . "</p>";
                
                echo "</div>";
            }
        } else {
            echo "No hay habitaciones agregadas.";
        }
        
 
        $conn->close();
    ?>
    </div>
<script>
    function toggleRooms() {
        var roomsContainer = document.getElementById("habitacionesContainer");
        var toggleBtn = document.getElementById("toggleRoomsBtn");

        if (roomsContainer.style.display === "none") {
            roomsContainer.style.display = "block";
            toggleBtn.textContent = "Ocultar Habitaciones";
        } else {
            roomsContainer.style.display = "none";
            toggleBtn.textContent = "Mostrar Habitaciones";
        }
    }
</script>
</body>
</html>




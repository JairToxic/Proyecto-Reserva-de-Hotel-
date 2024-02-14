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
    <h2>Agregar Habitación</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id_habitacion">ID de Habitación:</label><br>
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

    <h2>Habitaciones Agregadas</h2>
    <table>
        <tr>
            <th>ID_HABITACION</th>
            <th>TIPO</th>
            <th>DESCRIPCION</th>
            <th>PRECIOPORNOCHE</th>
            <th>CAPACIDAD</th>
            <th>CAMAS</th>
            <th>BANO</th>
            <th>IMAGENES DE LA HABITACIÓN</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "hotel";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        // Verificar si se ha enviado el formulario de habitación
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_habitacion = $_POST['id_habitacion'];
            $tipo = $_POST['tipo'];
            $descripcion = $_POST['descripcion'];
            $precio_por_noche = $_POST['precio_por_noche'];
            $capacidad = $_POST['capacidad'];
            $camas = $_POST['camas'];
            $bano = $_POST['bano'];
            $imagen_principal = $_POST['imagen_principal'];

            // Actualizar los datos de la habitación en la base de datos
            $sql = "INSERT INTO habitaciones (ID_HABITACION, TIPO, DESCRIPCION, PRECIOPORNOCHE, CAPACIDAD, CAMAS, BANO) 
                    VALUES ('$id_habitacion', '$tipo', '$descripcion', '$precio_por_noche', '$capacidad', '$camas', '$bano')";

            if ($conn->query($sql) === TRUE) {
                echo "Habitación agregada exitosamente.";
            } else {
                echo "Error al agregar la habitación: " . $conn->error;
            }
             // Insertar la URL de la imagen en la tabla imagenes_habitaciones
            $sql_imagen = "INSERT INTO imagenes_habitaciones (id_habitacion, url) 
            VALUES ('$id_habitacion', '$imagen_principal')";
            if ($conn->query($sql_imagen) === TRUE) {
            echo "Imagen agregada exitosamente.";
            } else {
                echo "Error al agregar la imagen: " . $conn->error;
            }
    }
        
         // Consulta para obtener las habitaciones y sus imágenes
         $sql = "SELECT habitaciones.*, GROUP_CONCAT(imagenes_habitaciones.url) AS imagenes_principales 
         FROM habitaciones 
         LEFT JOIN imagenes_habitaciones ON habitaciones.ID_HABITACION = imagenes_habitaciones.id_habitacion 
         GROUP BY habitaciones.ID_HABITACION";
         $result = $conn->query($sql);

         if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID_HABITACION"] . "</td>";
                echo "<td>" . $row["TIPO"] . "</td>";
                echo "<td>" . $row["DESCRIPCION"] . "</td>";
                echo "<td>" . $row["PRECIOPORNOCHE"] . "</td>";
                echo "<td>" . $row["CAPACIDAD"] . "</td>";
                echo "<td>" . $row["CAMAS"] . "</td>";
                echo "<td>" . $row["BANO"] . "</td>";
                
                // Mostrar las imágenes como imágenes en la tabla
                $imagenes_principales = explode(",", $row["imagenes_principales"]);
                echo "<td>";
                foreach ($imagenes_principales as $imagen) {
                    echo "<img src='$imagen' alt='Imagen' style='width: 150px; height: auto;'>";
                }
                echo "</td>";
                
                echo "</tr>";
            }
        } else {
            echo "No hay habitaciones agregadas.";
        }
        
 
        $conn->close();
        ?>
    </table>
</body>
</html>


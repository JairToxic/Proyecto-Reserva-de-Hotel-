<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Habitación</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
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
        
        <label for="reservas">Reservas:</label><br>
        <input type="text" id="reservas" name="reservas"><br><br>
        
        <label for="imagen_principal">Imagen Principal:</label><br>
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
            <th>RESERVAS</th>
            <th>IMAGEN_PRINCIPAL</th>
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
            $tipo = $_POST['tipo'];
            $descripcion = $_POST['descripcion'];
            $precio_por_noche = $_POST['precio_por_noche'];
            $capacidad = $_POST['capacidad'];
            $camas = $_POST['camas'];
            $bano = $_POST['bano'];
            $reservas = $_POST['reservas'];
            $imagen_principal = $_POST['imagen_principal'];
        
            $sql = "INSERT INTO habitaciones (TIPO, DESCRIPCION, PRECIOPORNOCHE, CAPACIDAD, CAMAS, BANO, reservas, IMAGEN_PRINCIPAL) 
                    VALUES ('$tipo', '$descripcion', '$precio_por_noche', '$capacidad', '$camas', '$bano', '$reservas', '$imagen_principal')";
        
            if ($conn->query($sql) === TRUE) {
                echo "Habitación agregada exitosamente.";
            } else {
                echo "Error al agregar la habitación: " . $conn->error;
            }
        }
        
        // Mostrar las habitaciones agregadas en la tabla
        $sql = "SELECT * FROM habitaciones";
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
                echo "<td>" . $row["reservas"] . "</td>";
                echo "<td>" . $row["IMAGEN_PRINCIPAL"] . "</td>";
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

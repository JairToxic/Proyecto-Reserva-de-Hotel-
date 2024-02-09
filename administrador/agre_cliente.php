<?php
// Verificar si se ha enviado el formulario de cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];

    // Insertar los datos en la tabla cliente
    $sql = "INSERT INTO cliente (NOMBRE, APELLIDO, CELULAR, EMAIL) VALUES ('$nombre', '$apellido', '$celular', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "Cliente agregado exitosamente.";
    } else {
        echo "Error al agregar cliente: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
</head>
<body>
    <h2>Agregar Cliente</h2>

    <form method="post" action="agregar_cliente.php">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Apellido:</label><br>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="celular">Celular:</label><br>
        <input type="text" id="celular" name="celular" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Agregar Cliente">
    </form>

    <h2>Clientes Agregados</h2>
    <table>
        <tr>
            <th>ID_CLIENTE</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>CELULAR</th>
            <th>EMAIL</th>
        </tr>
        <?php
        // Conexión a la base de datos
        $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener los clientes
        $sql = "SELECT * FROM cliente";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["ID_CLIENTE"]."</td><td>".$row["NOMBRE"]."</td><td>".$row["APELLIDO"]."</td><td>".$row["CELULAR"]."</td><td>".$row["EMAIL"]."</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay clientes.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>


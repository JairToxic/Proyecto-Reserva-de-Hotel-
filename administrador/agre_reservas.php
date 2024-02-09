<?php
// Verificar si se ha enviado el formulario de reserva
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
    $id_habitacion = $_POST['id_habitacion'];
    $id_cliente = $_POST['id_cliente'];
    $fecha_checkin = $_POST['fecha_checkin'];
    $fecha_checkout = $_POST['fecha_checkout'];
    $estado_reserva = $_POST['estado_reserva'];

    // Insertar los datos en la tabla reserva
    $sql = "INSERT INTO reserva (ID_HABITACION, ID_CLIENTE, FECHACHECKIN, FECHACHECKOUT, ESTADORESERVA) VALUES ('$id_habitacion', '$id_cliente', '$fecha_checkin', '$fecha_checkout', '$estado_reserva')";
    if ($conn->query($sql) === TRUE) {
        echo "Reserva agregada exitosamente.";
    } else {
        echo "Error al agregar reserva: " . $conn->error;
    }

    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Reserva</title>
</head>
<body>
    <h2>Agregar Reserva</h2>

    <form method="post" action="agregar_reserva.php">
        <label for="id_habitacion">ID de Habitación:</label><br>
        <input type="text" id="id_habitacion" name="id_habitacion" required><br><br>

        <label for="id_cliente">ID de Cliente:</label><br>
        <input type="text" id="id_cliente" name="id_cliente" required><br><br>

        <label for="fecha_checkin">Fecha de Check-in:</label><br>
        <input type="datetime-local" id="fecha_checkin" name="fecha_checkin" required><br><br>

        <label for="fecha_checkout">Fecha de Check-out:</label><br>
        <input type="datetime-local" id="fecha_checkout" name="fecha_checkout" required><br><br>

        <label for="estado_reserva">Estado de Reserva:</label><br>
        <input type="text" id="estado_reserva" name="estado_reserva"><br><br>
        
        <input type="submit" value="Agregar Reserva">
    </form>

    <h2>Reservas Agregadas</h2>
    <table>
        <!-- Encabezados de la tabla para reservas -->
        <tr>
            <th>ID Habitación</th>
            <th>ID Cliente</th>
            <th>Fecha Check-in</th>
            <th>Fecha Check-out</th>
            <th>Estado de Reserva</th>
        </tr>
        
        <!-- PHP para mostrar datos de reservas -->
        <?php
        // Mostrar reservas existentes en una tabla
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM reserva";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID Habitación</th><th>ID Cliente</th><th>Fecha Check-in</th><th>Fecha Check-out</th><th>Estado de Reserva</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["ID_HABITACION"]."</td><td>".$row["ID_CLIENTE"]."</td><td>".$row["FECHACHECKIN"]."</td><td>".$row["FECHACHECKOUT"]."</td><td>".$row["ESTADORESERVA"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No hay reservas.";
}

$conn->close();
        ?>
    </table>
</body>
</html>

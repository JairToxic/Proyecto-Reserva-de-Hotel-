<?php
// Configuración de la conexión a la base de datos
include'../basedatos/basedatos.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario para agregar un cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
    $celular = mysqli_real_escape_string($conn, $_POST['celular']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Preparar la consulta SQL con parámetros
    $sql = "INSERT INTO cliente (NOMBRE, APELLIDO, CELULAR, EMAIL) VALUES (?, ?, ?, ?)";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssss", $nombre, $apellido, $celular, $email);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        echo "Cliente agregado exitosamente.";
    } else {
        echo "Error al agregar el cliente: " . $conn->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Obtener clientes existentes
$sql_clientes = "SELECT * FROM cliente";
$result_clientes = $conn->query($sql_clientes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <h2>Agregar Cliente</h2>
    <div class="container">
        <form method="post">
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

        <!-- Tabla para mostrar los clientes existentes -->
        <h2>Clientes Existentes</h2>
        <table>
            <tr>
                <th>ID de Cliente</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Celular</th>
                <th>Email</th>
            </tr>
            <?php
            if ($result_clientes->num_rows > 0) {
                while ($row = $result_clientes->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_CLIENTE"] . "</td>";
                    echo "<td>" . $row["NOMBRE"] . "</td>";
                    echo "<td>" . $row["APELLIDO"] . "</td>";
                    echo "<td>" . $row["CELULAR"] . "</td>";
                    echo "<td>" . $row["EMAIL"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay clientes.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>





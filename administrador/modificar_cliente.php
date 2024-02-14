<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario para modificar un cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario y actualizar el cliente en la base de datos
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];

    $sql = "UPDATE cliente SET NOMBRE='$nombre', APELLIDO='$apellido', CELULAR='$celular', EMAIL='$email' WHERE ID_CLIENTE='$id_cliente'";

    if ($conn->query($sql) === TRUE) {
        echo "Cliente modificado exitosamente.";
    } else {
        echo "Error al modificar el cliente: " . $conn->error;
    }
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
    <title>Modificar Cliente</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectButtons = document.querySelectorAll('.select-btn');

            selectButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('id_cliente').value = this.getAttribute('data-id');
                    document.getElementById('nombre').value = this.getAttribute('data-nombre');
                    document.getElementById('apellido').value = this.getAttribute('data-apellido');
                    document.getElementById('celular').value = this.getAttribute('data-celular');
                    document.getElementById('email').value = this.getAttribute('data-email');
                });
            });
        });
    </script>
</head>
<body>
    <h2>Modificar Cliente</h2>
    <div class="container">
        <form method="post">
            <label for="id_cliente">ID de Cliente:</label><br>
            <input type="text" id="id_cliente" name="id_cliente" required><br><br>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required><br><br>
            <label for="apellido">Apellido:</label><br>
            <input type="text" id="apellido" name="apellido" required><br><br>
            <label for="celular">Celular:</label><br>
            <input type="text" id="celular" name="celular" required><br><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <input type="submit" value="Modificar Cliente">
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
                <th>Acción</th> <!-- Agregado -->
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
                    // Agregando botón de selección
                    echo "<td><button class='select-btn' data-id='" . $row["ID_CLIENTE"] . "' data-nombre='" . $row["NOMBRE"] . "' data-apellido='" . $row["APELLIDO"] . "' data-celular='" . $row["CELULAR"] . "' data-email='" . $row["EMAIL"] . "'>Seleccionar</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay clientes.</td></tr>";
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



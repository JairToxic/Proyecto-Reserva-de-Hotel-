<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: index.php");
    exit;
}

include 'basedatos/basedatos.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario para modificar un cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario y actualizar el cliente en la base de datos
    $id_cliente = mysqli_real_escape_string($conn, $_POST['id_cliente']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
    $celular = mysqli_real_escape_string($conn, $_POST['celular']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "UPDATE cliente SET NOMBRE='$nombre', APELLIDO='$apellido', CELULAR='$celular', EMAIL='$email' WHERE ID_CLIENTE='$id_cliente'";

    if ($conn->query($sql) === TRUE) {
        $alert_success = "<div class='alert alert-success' role='alert'>Cliente modificado correctamente.</div>";
    } else {
        $alert_error = "<div class='alert alert-danger' role='alert'>Error al modificar el cliente: " . $conn->error . "</div>";
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
                    document.getElementById('nombre').value = this.getAttribute('data-nombre');
                    document.getElementById('apellido').value = this.getAttribute('data-apellido');
                    document.getElementById('celular').value = this.getAttribute('data-celular');
                    document.getElementById('email').value = this.getAttribute('data-email');
                    document.getElementById('id_cliente').value = this.getAttribute('data-id');
                });
            });
        });
    </script>
</head>
<body>
    <a href="inicioCRUD.php" class="btn btn-primary position-absolute top-0 start-0 m-4">Regresar al inicio</a>
    <div class="container">
        <h2 class="mt-4">Modificar Cliente</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <!-- Campo oculto para almacenar el id_cliente -->
                    <input type="hidden" id="id_cliente" name="id_cliente">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="celular" class="form-label">Celular:</label>
                        <input type="text" class="form-control" id="celular" name="celular" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Modificar Cliente</button>
                </form>
            </div>
        </div>

        <!-- Alertas -->
        <div class="mt-4">
            <?php echo isset($alert_success) ? $alert_success : ''; ?>
            <?php echo isset($alert_error) ? $alert_error : ''; ?>
        </div>

        <!-- Encabezado de "Clientes Existentes" -->
        <h2 class="mt-4">Clientes Existentes</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="table-responsive mt-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID de Cliente</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_clientes->num_rows > 0) {
                                while ($row = $result_clientes->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["ID_CLIENTE"] . "</td>";
                                    echo "<td>" . $row["NOMBRE"] . "</td>";
                                    echo "<td>" . $row["APELLIDO"] . "</td>";
                                    echo "<td>" . $row["CELULAR"] . "</td>";
                                    echo "<td>" . $row["EMAIL"] . "</td>";
                                    echo "<td><button class='btn btn-info select-btn' data-id='" . $row["ID_CLIENTE"] . "' data-nombre='" . $row["NOMBRE"] . "' data-apellido='" . $row["APELLIDO"] . "' data-celular='" . $row["CELULAR"] . "' data-email='" . $row["EMAIL"] . "'>Seleccionar</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No hay clientes.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>




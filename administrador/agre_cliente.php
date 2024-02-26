<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: index.php");
    exit;
}

include 'basedatos/basedatos.php';


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

    
    $stmt->bind_param("ssss", $nombre, $apellido, $celular, $email);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        $alert_success = "<div class='alert alert-success' role='alert'>Cliente agregado correctamente.</div>";
    } else {
        $alert_error = "<div class='alert alert-danger' role='alert'>Error al agregar el cliente: " . $conn->error . "</div>";
    }

    
    $stmt->close();
}


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
    <a href="inicioCRUD.php" class="btn btn-primary position-absolute top-0 start-0 m-4">Regresar al inicio</a>
    <div class="container">
        <h2 class="text-center mt-4">Agregar Cliente</h2>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" class="mt-4">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="celular" class="form-label">Celular:</label>
                        <input type="text" id="celular" name="celular" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Agregar Cliente</button>
                </form>
            </div>
        </div>
        <!-- Alertas -->
        <div class="mt-4">
            <?php echo isset($alert_success) ? $alert_success : ''; ?>
            <?php echo isset($alert_error) ? $alert_error : ''; ?>
        </div> 

        <h2 class="text-center mt-5">Clientes Existentes</h2>
        <div class="table-responsive mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID de Cliente</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Email</th>
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
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay clientes.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>

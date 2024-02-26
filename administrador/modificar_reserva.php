<?php
// Configuración de la conexión a la base de datos
include '../basedatos/basedatos.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario para modificar una reserva
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario y actualizar la reserva en la base de datos
    $id_reserva = $_POST['id_reserva'];
    $fecha_checkin = $_POST['fecha_checkin'];
    $fecha_checkout = $_POST['fecha_checkout'];
    $estado_reserva = $_POST['estado_reserva'];

    $sql = "UPDATE reserva SET FECHACHECKIN='$fecha_checkin', FECHACHECKOUT='$fecha_checkout', ESTADORESERVA='$estado_reserva' WHERE ID_RESERVA='$id_reserva'";

    if ($conn->query($sql) === TRUE) {
        echo "Reserva modificada exitosamente.";
    } else {
        echo "Error al modificar la reserva: " . $conn->error;
    }
}

// Obtener reservas existentes
$sql_reservas = "SELECT r.ID_RESERVA, r.ID_CLIENTE, c.NOMBRE, c.APELLIDO, r.FECHACHECKIN, r.FECHACHECKOUT, r.ESTADORESERVA FROM reserva r INNER JOIN cliente c ON r.ID_CLIENTE = c.ID_CLIENTE";
$result_reservas = $conn->query($sql_reservas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectButtons = document.querySelectorAll('.select-btn');

            selectButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('id_reserva').value = this.getAttribute('data-id');
                    document.getElementById('fecha_checkin').value = this.getAttribute('data-checkin');
                    document.getElementById('fecha_checkout').value = this.getAttribute('data-checkout');
                    document.getElementById('estado_reserva').value = this.getAttribute('data-estado');
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Modificar Reserva</h2>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form method="post">
                    <!-- Campo oculto para almacenar el id_reserva -->
                    <input type="hidden" id="id_reserva" name="id_reserva">
                    <div class="mb-3">
                        <label for="fecha_checkin" class="form-label">Fecha de Check-in:</label>
                        <input type="datetime-local" class="form-control" id="fecha_checkin" name="fecha_checkin" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_checkout" class="form-label">Fecha de Check-out:</label>
                        <input type="datetime-local" class="form-control" id="fecha_checkout" name="fecha_checkout" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado_reserva" class="form-label">Estado de Reserva:</label>
                        <input type="text" class="form-control" id="estado_reserva" name="estado_reserva">
                    </div>
                    <button type="submit" class="btn btn-primary">Modificar Reserva</button>
                </form>
            </div>
        </div>

        <!-- Tabla para mostrar las reservas existentes -->
        <h2 class="text-center mt-4">Reservas Existentes</h2>
        <div class="table-responsive mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID de Reserva</th>
                        <th>ID de Cliente</th>
                        <th>Nombre del Cliente</th>
                        <th>Fecha de Check-in</th>
                        <th>Fecha de Check-out</th>
                        <th>Estado de Reserva</th>
                        <th>Acción</th> <!-- Agregado -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_reservas->num_rows > 0) {
                        while ($row = $result_reservas->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["ID_RESERVA"] . "</td>";
                            echo "<td>" . $row["ID_CLIENTE"] . "</td>";
                            echo "<td>" . $row["NOMBRE"] . " " . $row["APELLIDO"] . "</td>";
                            echo "<td>" . $row["FECHACHECKIN"] . "</td>";
                            echo "<td>" . $row["FECHACHECKOUT"] . "</td>";
                            echo "<td>" . $row["ESTADORESERVA"] . "</td>";
                            // Agregando botón de selección
                            echo "<td><button class='btn btn-info select-btn' data-id='" . $row["ID_RESERVA"] . "' data-checkin='" . $row["FECHACHECKIN"] . "' data-checkout='" . $row["FECHACHECKOUT"] . "' data-estado='" . $row["ESTADORESERVA"] . "'>Seleccionar</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No hay reservas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>




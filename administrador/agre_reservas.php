<?php
include 'basedatos/basedatos.php';

// Verificar si se ha enviado el formulario de reserva
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recibir los datos del formulario
    $id_cliente = $_POST['id_cliente'];
    $fecha_checkin = $_POST['fecha_checkin'];
    $fecha_checkout = $_POST['fecha_checkout'];
    $estado_reserva = $_POST['estado_reserva'];

    // Insertar los datos en la tabla reserva
    $sql = "INSERT INTO reserva (ID_CLIENTE, FECHACHECKIN, FECHACHECKOUT, ESTADORESERVA) 
            VALUES ('$id_cliente', '$fecha_checkin', '$fecha_checkout', '$estado_reserva')";
    if ($conn->query($sql) === TRUE) {
        echo "Reserva agregada exitosamente.";
    } else {
        echo "Error al agregar reserva: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Reserva</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-4">Agregar Reserva</h2>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" action="agre_reservas.php">
                    <div class="mb-3">
                        <label for="id_cliente" class="form-label">Cliente:</label>
                        <select name="id_cliente" class="form-select" required>
                            <?php
                            // Obtener nombres y apellidos de clientes de la base de datos
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }

                            $sql_clientes = "SELECT ID_CLIENTE, NOMBRE, APELLIDO FROM cliente";
                            $result_clientes = $conn->query($sql_clientes);

                            if ($result_clientes->num_rows > 0) {
                                while ($row_cliente = $result_clientes->fetch_assoc()) {
                                    echo "<option value=\"" . $row_cliente["ID_CLIENTE"] . "\">" . $row_cliente["NOMBRE"] . " " . $row_cliente["APELLIDO"] . "</option>";
                                }
                            } else {
                                echo "<option value=\"\">No hay clientes registrados</option>";
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_checkin" class="form-label">Fecha de Check-in:</label>
                        <input type="datetime-local" id="fecha_checkin" name="fecha_checkin" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_checkout" class="form-label">Fecha de Check-out:</label>
                        <input type="datetime-local" id="fecha_checkout" name="fecha_checkout" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado_reserva" class="form-label">Estado de Reserva:</label>
                        <select id="estado_reserva" name="estado_reserva" class="form-select" required>
                            <option value="Reservado">Reservado</option>
                            <option value="Confirmado">Confirmado</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Agregar Reserva</button>
                </form>
            </div>
        </div>

        <h2 class="text-center mt-5">Reservas Agregadas</h2>
        <div class="table-responsive mt-4">
            <table class="table">
                <?php
                // Mostrar reservas existentes en una tabla
                include 'basedatos/basedatos.php';
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                $sql = "SELECT r.ID_RESERVA, r.ID_CLIENTE, c.NOMBRE, c.APELLIDO, r.FECHACHECKIN, r.FECHACHECKOUT, r.ESTADORESERVA FROM reserva r
                INNER JOIN cliente c ON r.ID_CLIENTE = c.ID_CLIENTE";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table class='table table-bordered'>";
                    echo "<thead><tr><th>ID Reserva</th><th>Nombre del Cliente</th><th>Fecha Check-in</th><th>Fecha Check-out</th><th>Estado de Reserva</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>".$row["ID_RESERVA"]."</td><td>".$row["NOMBRE"]." ".$row["APELLIDO"]."</td><td>".$row["FECHACHECKIN"]."</td><td>".$row["FECHACHECKOUT"]."</td><td>".$row["ESTADORESERVA"]."</td></tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p class='text-center'>No hay reservas.</p>";
                }

                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>


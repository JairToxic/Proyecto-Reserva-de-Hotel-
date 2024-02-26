<?php
// Crear una conexión a la base de datos
include '../basedatos/basedatos.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


// Verificar si se ha enviado una solicitud para borrar un cliente
if (isset($_GET['borrar_cliente'])) {
    $id_cliente = $_GET['borrar_cliente'];
    borrarCliente($id_cliente, $conn);
}

// Obtener la lista de clientes desde la base de datos
$clientes = obtenerClientes($conn);

// Función para obtener la lista de clientes
function obtenerClientes($conn) {
    $consulta = "SELECT * FROM cliente";
    $resultado = $conn->query($consulta);

    $clientes = array();
    while ($cliente = $resultado->fetch_assoc()) {
        $clientes[] = $cliente;
    }

    return $clientes;
}

// Función para borrar un cliente por ID y sus referencias relacionadas
function borrarCliente($id_cliente, $conn) {
    // Eliminar las reservas asociadas en reserva
    $stmt1 = $conn->prepare("DELETE FROM reserva WHERE ID_CLIENTE = ?");
    $stmt1->bind_param("i", $id_cliente);
    $stmt1->execute();
    $stmt1->close();


    // Eliminar al cliente de la tabla cliente
    $stmt4 = $conn->prepare("DELETE FROM cliente WHERE ID_CLIENTE = ?");
    $stmt4->bind_param("i", $id_cliente);
    $stmt4->execute();
    $stmt4->close();

    // Redirigir a la misma página después de borrar
    header("Location: eliminar_cliente.php?borrado=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Clientes</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4">Administrador de Clientes</h1>
        <?php
        // Mostrar la alerta si se ha borrado un cliente
        if (isset($_GET['borrado']) && $_GET['borrado'] == 1) {
            echo "<div class='alert alert-success' role='alert'>Cliente eliminado correctamente.</div>";
        }
        ?>

        <!-- Mostrar la lista de clientes -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente['ID_CLIENTE']; ?></td>
                            <td><?php echo $cliente['NOMBRE']; ?></td>
                            <td><?php echo $cliente['APELLIDO']; ?></td>
                            <td><?php echo $cliente['CELULAR']; ?></td>
                            <td><?php echo $cliente['EMAIL']; ?></td>
                            <td>
                                <a href="?borrar_cliente=<?php echo $cliente['ID_CLIENTE']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas borrar este cliente?')">Borrar</a>
                                <!-- Puedes agregar más acciones como editar -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Puedes agregar enlaces o botones para agregar nuevos clientes, editar, etc. -->
    </div>
</body>
</html>

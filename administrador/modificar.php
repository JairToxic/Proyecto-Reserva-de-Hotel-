<?php
include '../basedatos/basedatos.php';
// Obtener el nombre del botón seleccionado de la URL
if (isset($_GET['type'])) {
    $tipoEntidad = $_GET['type'];

    // Realizar acciones según el tipo de entidad (reserva, habitacion, cabaña, comentarios)
    switch ($tipoEntidad) {
        case 'reserva':
            // HTML para modificar una reserva
            echo '<h2>Modificar Reserva</h2>';
            echo '<div class="container" style="display: flex; justify-content: space-between;">';
        
            // Formulario para modificar la reserva
            echo '<form method="post">';
            echo '<label for="id_reserva">ID de Reserva:</label><br>';
            echo '<input type="text" id="id_reserva" name="id_reserva" required><br><br>';
            echo '<label for="id_pago">ID de Pago:</label><br>';
            echo '<input type="text" id="id_pago" name="id_pago"><br><br>';
            echo '<label for="id_cliente">ID de Cliente:</label><br>';
            echo '<input type="text" id="id_cliente" name="id_cliente"><br><br>';
            echo '<label for="fecha_checkin">Fecha de Check-in:</label><br>';
            echo '<input type="datetime-local" id="fecha_checkin" name="fecha_checkin" required><br><br>';
            echo '<label for="fecha_checkout">Fecha de Check-out:</label><br>';
            echo '<input type="datetime-local" id="fecha_checkout" name="fecha_checkout" required><br><br>';
            echo '<label for="estado_reserva">Estado de Reserva:</label><br>';
            echo '<input type="text" id="estado_reserva" name="estado_reserva"><br><br>';
            echo '<input type="submit" value="Modificar Reserva">';
            echo '</form>';
        
            // Procesamiento del formulario para modificar la reserva
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtener los valores enviados desde el formulario
                $id_reserva = $_POST['id_reserva'];
                $id_pago = $_POST['id_pago'];
                $id_cliente = $_POST['id_cliente'];
                $fecha_checkin = $_POST['fecha_checkin'];
                $fecha_checkout = $_POST['fecha_checkout'];
                $estado_reserva = $_POST['estado_reserva'];
        
                // Actualizar los datos de la reserva en la base de datos
                $sql = "UPDATE reserva SET ID_PAGO='$id_pago', ID_CLIENTE='$id_cliente', FECHACHECKIN='$fecha_checkin', FECHACHECKOUT='$fecha_checkout', ESTADORESERVA='$estado_reserva' WHERE ID_RESERVA='$id_reserva'";
        
                if ($mysqli->query($sql) === TRUE) {
                    echo "Reserva modificada exitosamente.";
                } else {
                    echo "Error al modificar la reserva: " . $conn->error;
                }
            }
        
            // Mostrar reservas existentes en una tabla
            $sql = "SELECT * FROM reserva";
            $result = $mysqli->query($sql);
        
            if ($result->num_rows > 0) {
                echo '<table style="border-collapse: collapse; width: 50%;">';
                echo '<tr>';
                echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">ID de Reserva</th>';
                echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">ID de Pago</th>';
                echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">ID de Cliente</th>';
                echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Fecha de Check-in</th>';
                echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Fecha de Check-out</th>';
                echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Estado de Reserva</th>';
                echo '</tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['ID_RESERVA'] . '</td>';
                    echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['ID_PAGO'] . '</td>';
                    echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['ID_CLIENTE'] . '</td>';
                    echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['FECHACHECKIN'] . '</td>';
                    echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['FECHACHECKOUT'] . '</td>';
                    echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['ESTADORESERVA'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "No hay reservas.";
            }
        
            echo '</div>';
            break;
        
        
            case 'habitacion':
                // HTML para modificar una habitación
                echo '<h2>Modificar Habitación</h2>';
                echo '<div class="container" style="display: flex; justify-content: space-between;">';
            
                // Formulario para modificar la habitación
                echo '<form method="post">';
                echo '<label for="id_habitacion">ID de Habitación:</label><br>';
                echo '<input type="text" id="id_habitacion" name="id_habitacion" required><br><br>';
                echo '<label for="tipo">Tipo:</label><br>';
                echo '<input type="text" id="tipo" name="tipo"><br><br>';
                echo '<label for="descripcion">Descripción:</label><br>';
                echo '<input type="text" id="descripcion" name="descripcion"><br><br>';
                echo '<label for="precio_por_noche">Precio por Noche:</label><br>';
                echo '<input type="text" id="precio_por_noche" name="precio_por_noche"><br><br>';
                echo '<label for="capacidad">Capacidad:</label><br>';
                echo '<input type="text" id="capacidad" name="capacidad"><br><br>';
                echo '<label for="camas">Camas:</label><br>';
                echo '<input type="text" id="camas" name="camas"><br><br>';
                echo '<label for="bano">Baño:</label><br>';
                echo '<input type="text" id="bano" name="bano"><br><br>';
                echo '<label for="reservas">Reservas:</label><br>';
                echo '<input type="text" id="reservas" name="reservas"><br><br>';
                echo '<label for="imagen_principal">Imagen Principal:</label><br>';
                echo '<input type="text" id="imagen_principal" name="imagen_principal"><br><br>';
                echo '<input type="submit" value="Modificar Habitación">';
                echo '</form>';
            
                // Procesamiento del formulario para modificar la habitación
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener los valores enviados desde el formulario
                    $id_habitacion = $_POST['id_habitacion'];
                    $tipo = $_POST['tipo'];
                    $descripcion = $_POST['descripcion'];
                    $precio_por_noche = $_POST['precio_por_noche'];
                    $capacidad = $_POST['capacidad'];
                    $camas = $_POST['camas'];
                    $bano = $_POST['bano'];
                    $reservas = $_POST['reservas'];
                    $imagen_principal = $_POST['imagen_principal'];
            
                    // Actualizar los datos de la habitación en la base de datos
                    $sql = "UPDATE habitaciones SET TIPO='$tipo', DESCRIPCION='$descripcion', PRECIOPORNOCHE='$precio_por_noche', CAPACIDAD='$capacidad', CAMAS='$camas', BANO='$bano', reservas='$reservas', IMAGEN_PRINCIPAL='$imagen_principal' WHERE ID_HABITACION='$id_habitacion'";
            
                    if ($mysqli->query($sql) === TRUE) {
                        echo "Habitación modificada exitosamente.";
                    } else {
                        echo "Error al modificar la habitación: " . $conn->error;
                    }
                }
            
                // Mostrar habitaciones existentes en una tabla
                $sql = "SELECT * FROM habitaciones";
                $result = $mysqli->query($sql);
            
                if ($result->num_rows > 0) {
                    echo '<table style="border-collapse: collapse; width: 50%;">';
                    echo '<tr>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">ID de Habitación</th>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Tipo</th>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Descripción</th>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Precio por Noche</th>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Capacidad</th>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Camas</th>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Baño</th>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Reservas</th>';
                    echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">Imagen Principal</th>';
                    echo '</tr>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['ID_HABITACION'] . '</td>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['TIPO'] . '</td>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['DESCRIPCION'] . '</td>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['PRECIOPORNOCHE'] . '</td>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['CAPACIDAD'] . '</td>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['CAMAS'] . '</td>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['BANO'] . '</td>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['reservas'] . '</td>';
                        echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['IMAGEN_PRINCIPAL'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo "No hay habitaciones.";
                }
            
                echo '</div>';
                break;
            
                case 'clientes':
                   // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si se ha enviado el formulario de cliente
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Mostrar formulario para modificar el cliente y clientes existentes en una tabla
    echo '<h2>Modificar Cliente</h2>';
    echo '<div class="container" style="display: flex; justify-content: space-between;">';
    echo '<form method="post">';
    echo '<label for="id_cliente">ID de Cliente:</label><br>';
    echo '<input type="text" id="id_cliente" name="id_cliente" required><br><br>';
    echo '<label for="nombre">Nombre:</label><br>';
    echo '<input type="text" id="nombre" name="nombre"><br><br>';
    echo '<label for="apellido">Apellido:</label><br>';
    echo '<input type="text" id="apellido" name="apellido"><br><br>';
    echo '<label for="celular">Celular:</label><br>';
    echo '<input type="text" id="celular" name="celular"><br><br>';
    echo '<label for="email">Email:</label><br>';
    echo '<input type="text" id="email" name="email"><br><br>';
    echo '<input type="submit" value="Modificar Cliente">';
    echo '</form>';

    // Mostrar clientes existentes en una tabla
    $sql = "SELECT * FROM cliente";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table style="border-collapse: collapse; width: 50%;">';
        echo '<tr>';
        echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">ID_CLIENTE</th>';
        echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">NOMBRE</th>';
        echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">APELLIDO</th>';
        echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">CELULAR</th>';
        echo '<th style="border: 1px solid black; padding: 8px; text-align: left; background-color: #f2f2f2;">EMAIL</th>';
        echo '</tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['ID_CLIENTE'] . '</td>';
            echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['NOMBRE'] . '</td>';
            echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['APELLIDO'] . '</td>';
            echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['CELULAR'] . '</td>';
            echo '<td style="border: 1px solid black; padding: 8px; text-align: left;">' . $row['EMAIL'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No hay clientes.";
    }

    echo '</div>'; // Fin del contenedor
    $conn->close();
    break;
                
                
        default:
            // Tipo de entidad no válido
            echo "Error: Tipo de entidad no válido.";
            break;
    }

} else {
    // Tipo de entidad no especificado en la URL
    echo "Error: Tipo de entidad no especificado.";
}
?>

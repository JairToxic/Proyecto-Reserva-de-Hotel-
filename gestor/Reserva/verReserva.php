<?php
// basedatos.php
include '../../basedatos/basedatos.php';

if (isset($_GET['email']) && isset($_GET['cod_reserva'])) {
    $email = $_GET['email'];
    $cod_reserva = $_GET['cod_reserva'];

    // Aquí puedes utilizar $email y $cod_reserva según tus necesidades
} else {
    // Manejo de error si los parámetros no están presentes
    echo "Error: Parámetros faltantes.";
}
// Obtener todas las habitaciones disponibles
$habitacionesReservadas = obtenerHabitacionesReservadas($email,$cod_reserva);

$clienteDatos = obtenerDatosCliente($email,$cod_reserva);



function obtenerDatosCliente($email,$cod_reserva){
    global $mysqli;

    // Consulta SQL para obtener todas las habitaciones
    $consultaDatosCliente = "SELECT Reserva.ID_RESERVA, Reserva.ID_CLIENTE, Reserva.FECHACHECKIN, Reserva.FECHACHECKOUT,
    Cliente.NOMBRE, Cliente.APELLIDO, Cliente.EMAIL
FROM Reserva
JOIN Cliente ON Reserva.ID_CLIENTE = Cliente.ID_CLIENTE
WHERE Cliente.EMAIL = '$email'
AND Reserva.ID_RESERVA = $cod_reserva;";

    // Ejecutar la consulta
    $resultado = $mysqli->query($consultaDatosCliente);

    // Verificar si hay resultados
    if ($resultado) {
        // Obtener las habitaciones como un array asociativo
        $cliente = $resultado->fetch_all(MYSQLI_ASSOC);

        // Liberar el resultado
        $resultado->free();

        return $cliente;
    } else {
        // Manejar el error si la consulta no fue exitosa
        echo "Error en la consulta: " . $mysqli->error;
        return [];
  }
}

// Función para obtener todas las habitaciones disponibles
function obtenerHabitacionesReservadas($email,$cod_reserva) {
    global $mysqli;

    // Consulta SQL para obtener todas las habitaciones
    $consultaTodasLasHabitaciones = "SELECT h.ID_HABITACION, h.TIPO, h.DESCRIPCION, h.CAPACIDAD, h.CAMAS, h.BANO
    FROM cliente c
    JOIN reserva r ON c.ID_CLIENTE = r.ID_CLIENTE
    JOIN habitacion_reserva hr ON r.ID_RESERVA = hr.ID_RESERVA
    JOIN habitaciones h ON hr.ID_HABITACION = h.ID_HABITACION
    WHERE c.EMAIL = '$email' AND r.ID_RESERVA = $cod_reserva;";

    // Ejecutar la consulta
    $resultado = $mysqli->query($consultaTodasLasHabitaciones);

    // Verificar si hay resultados
    if ($resultado) {
        // Obtener las habitaciones como un array asociativo
        $habitaciones = $resultado->fetch_all(MYSQLI_ASSOC);

        // Liberar el resultado
        $resultado->free();

        return $habitaciones;
    } else {
        // Manejar el error si la consulta no fue exitosa
        echo "Error en la consulta: " . $mysqli->error;
        return [];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        // Incluye el valor de $cod_reserva en el código JavaScript
        var cod_reserva = <?php echo json_encode($cod_reserva); ?>;
    </script>
    <style>
        * {
  box-sizing: border-box;
}

body {
    font-family: 'Verdana';
    
  display: grid;
  place-items: center;
  min-height: 100vh;
}
.contenedorDatos {
  display: inline-block;
  color: black;
  background: #76D7C4;
  border: solid 0.45rem black;
  border-radius: 15px;
  padding: 1.5rem;
  margin: 4rem;
  margin-bottom: 2rem;
}

.contenedorDatos h2{
  color: black;

}

#boton_cancelar {
    font-size: 17px;
    padding: 0.5em 2em;
    border: transparent;
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
    background: #C0392B;
    color: white;
    margin: 2em;
    border-radius: 4px;
}

#boton_cancelar:hover {
    background: #E74C3C;
    
}

#boton_cancelar:active {
    transform: translate(0em, 0.2em);
}

#modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

ul {
    align:center;
  display: flex;
  width: calc(100% - 2rem);
  padding: 0;
  margin: 0;
  list-style-type: none;
}

li {
  padding: 0;
}

img {
  max-width: 100%;
  width: 100%;
  object-fit: cover;
  transition: all 0.2s ease;
}

ul:is(:hover, :focus-within) img {
  opacity: calc(0.1 + (var(--active-lerp, 0) * 0.9));
  filter: grayscale(calc(1 - var(--active-lerp, 0)));
}

:root {
  --lerp-0: 1;
  --lerp-1: 0.5787037;
  --lerp-2: 0.2962963;
  --lerp-3: 0.125;
  --lerp-4: 0.037037;
  --lerp-5: 0.0046296;
  --lerp-6: 0;
}

a {
  outline-offset: 4px;
}

li {
  flex: calc(0.1 + (var(--active-lerp, 0) * 1));
  transition: flex 0.2s ease;
}

li:is(:hover, :focus-within) {
  --active-lerp: var(--lerp-0);
  z-index: 7;
}
li:has( + li:is(:hover, :focus-within)),
li:is(:hover, :focus-within) + li {
  --active-lerp: var(--lerp-1);
  z-index: 6;
}
li:has( + li + li:is(:hover, :focus-within)),
li:is(:hover, :focus-within) + li + li {
  --active-lerp: var(--lerp-2);
  z-index: 5;
}
li:has( + li + li + li:is(:hover, :focus-within)),
li:is(:hover, :focus-within) + li + li + li {
  --active-lerp: var(--lerp-3);
  z-index: 4;
}
li:has( + li + li + li + li:is(:hover, :focus-within)),
li:is(:hover, :focus-within) + li + li + li + li {
  --active-lerp: var(--lerp-4);
  z-index: 3;
}
li:has( + li + li + li + li + li:is(:hover, :focus-within)),
li:is(:hover, :focus-within) + li + li + li + li + li {
  --active-lerp: var(--lerp-5);
  z-index: 2;
}
li:has( + li + li + li + li + li + li:is(:hover, :focus-within)),
li:is(:hover, :focus-within) + li + li + li + li + li + li {
  --active-lerp: var(--lerp-6);
  z-index: 1;
}
.cta {
	--shadowColor: 187 60% 40%;
	display: flex;
	margin-left: 80px;
	background: hsl(187 70% 85%);
	
	width: 90%;
	box-shadow: 0.65rem 0.65rem 0 hsl(var(--shadowColor) / 1);
	border-radius: 0.8rem;
	overflow: hidden;
	border: 0.5rem solid;
}


.cta__text-column {
    font-family: 'Verdana';
	padding: min(2rem, 5vw) min(2rem, 5vw) min(2.5rem, 5vw);
	flex: 1 0 50%;
}

.cta__text-column > * + * {
	margin: min(1.5rem, 2.5vw) 0 0 0;
}

.cta a {
	display: inline-block;
	color: black;
	padding: 0.5rem 1rem;
    
	text-decoration: none;
	
	border-radius: 0.6rem;
	font-weight: 700;
	
}
.columnas {
    column-count: 3; /* Número de columnas que desees */
    column-gap: 4.4rem; /* Espacio entre columnas */
}


    </style>
    <title>Tu Reserva</title>
</head>
<body>

<div id="Datos">
    <?php
    // Verificar si hay datos en $clienteDatos
    if ($clienteDatos) {
        // Obtener el primer nombre para mostrar en el mensaje de bienvenida
        $primerNombre = $clienteDatos[0]['NOMBRE'];
        $id_res = $clienteDatos[0]['ID_RESERVA'];
        $primerApellido = $clienteDatos[0]['APELLIDO'];
        $checkin = $clienteDatos[0]['FECHACHECKIN'];
        $checkout = $clienteDatos[0]['FECHACHECKOUT'];
        // Iterar sobre los resultados
        echo "<div class='contenedorDatos'>";
        echo "<h2>Bienvenido, $primerNombre $primerApellido </h2>";
        echo "<div class='columnas'>";
        foreach ($clienteDatos as $row) {
            echo "<p>ID Reserva: " . $row['ID_RESERVA'] . "</p>";
            echo "<p>ID Cliente: " . $row['ID_CLIENTE'] . "</p>";
            echo "<form id=\'formFechas\'>";
            echo "    <div class=\"form-group\">";
            echo "        <label for=\"fechaInicio\">Fecha de Check-in:</label>";
            echo "        <input type=\"date\" class=\"form-control\" id=\"fechaInicio\" name=\"fechaInicio\" value=$checkin required>";
            echo "    </div>";
            echo "    <div class=\"form-group\">";
            echo "        <label for=\"fechaFin\">Fecha de Check-out:</label>";
            echo "        <input type=\"date\" class=\"form-control\" id=\"fechaFin\" name=\"fechaFin\" value=$checkout required>";
            echo "    </div>";
            echo "</form>";
            echo "<p>Nombre: " . $row['NOMBRE'] . "  " . $row['APELLIDO'] . "</p>";
            echo "<p>Email: " . $row['EMAIL'] . "</p>";
        }
        echo "</div>"; // Cierre de la clase 'columnas'
        echo "</div>"; // Cierre de la clase 'contenedorDatos'
        echo "<button id='boton_cancelar' onclick=\"window.location.href='cancelar_reserva.php?cod_reserva=" . $id_res . "'\">Cancelar Reserva</button>";

    } else {
        echo "<p>No se encontraron datos para mostrar.</p>";
    }
    ?>
</div>


<div id="habitaciones-container">
    <?php

// Mostrar las habitaciones disponibles
foreach ($habitacionesReservadas as $habitacion) {
    // Consultar la imagen asociada a la habitación
    $id_habitacion = $habitacion['ID_HABITACION'];
$queryImagen = "SELECT url FROM imagenes_habitaciones WHERE id_habitacion = $id_habitacion";
$resultImagen = $mysqli->query($queryImagen);

// Verificar si la consulta fue exitosa y hay imágenes asociadas
if ($resultImagen && $resultImagen->num_rows > 0) {
    // Inicializar un array para almacenar las URLs de las imágenes
    $imagenesURL = array();

    // Recorrer el resultado y almacenar las URLs en el array
    while ($row = $resultImagen->fetch_assoc()) {
        $imagenesURL[] = $row['url'];
    }
} else {
    // Ruta por defecto si no hay imágenes asociadas
    $imagenesURL = array('ruta_por_defecto_si_no_hay_imagen');
}

    // Mostrar la habitación con sus detalles y la imagen



    echo "<article class='cta'>";
echo "<a href='#' data-toggle='modal' data-target='#modalImagen{$habitacion['ID_HABITACION']}'>";
echo "</a>";
echo "<div class='cta__text-column'>";
echo "<h2>Habitación ID: " . $habitacion['ID_HABITACION'] . "</h2>";
echo "<p>Tipo: " . $habitacion['TIPO'] . "</p>";
echo "<p>Descripción: " . $habitacion['DESCRIPCION'] . "</p>";

// Mostrar todas las imágenes asociadas a la habitación
echo "<ul class='results'>";
foreach ($imagenesURL as $imagenURL) {
    echo "<li class='result'>";
    echo "<a href='#'><img src='{$imagenURL}' width='500' height='500' alt=''></a>";
    echo "</li>";
}
echo "</ul>";

echo "</div>";
echo "</article>";
echo "<br><br>";
}
?>
</div>


</body>
</html>

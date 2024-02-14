<?php
// basedatos.php
$mysqli = new mysqli("localhost", "root", "", "hotel");

// Verificar la conexión
if ($mysqli->connect_error) {
    die("La conexión a la base de datos falló: " . $mysqli->connect_error);
}


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

ul {
    align:center;
  display: flex;
  width: calc(80% - 2rem);
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
    </style>
    <title>Tu Reserva</title>
</head>
<body>

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

</body>
</html>

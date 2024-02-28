verReserva
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
/*form*/
.main {
  position: relative;
  display: flex;
  flex-direction: column;
  background-color: #240046;
  max-height: 420px;
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 7px 7px 10px 3px #24004628;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 14px;
  padding: 24px;
}

/*checkbox to switch from sign up to login*/
#chk {
  display: none;
}

/*Login*/
.login {
  position: relative;
  width: 100%;
  height: 100%;
}

.login label {
  margin: 25% 0 5%;
}

label {
  color: #fff;
  font-size: 2rem;
  justify-content: center;
  display: flex;
  font-weight: bold;
  cursor: pointer;
  transition: .5s ease-in-out;
}

.input {
  width: 100%;
  height: 40px;
  background: #e0dede;
  padding: 10px;
  border: none;
  outline: none;
  border-radius: 4px;
}

/*Register*/
.register {
  background: #eee;
  border-radius: 60% / 10%;
  transform: translateY(5%);
  transition: .8s ease-in-out;
}

.register label {
  color: #573b8a;
  transform: scale(.6);
}

#chk:checked ~ .register {
  transform: translateY(-60%);
}

#chk:checked ~ .register label {
  transform: scale(1);
  margin: 10% 0 5%;
}

#chk:checked ~ .login label {
  transform: scale(.6);
  margin: 5% 0 5%;
}   
/*Button*/
.form button {
  width: 85%;
  height: 40px;
  margin: 12px auto 10%;
  color: #fff;
  background: #573b8a;
  font-size: 1rem;
  font-weight: bold;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: .2s ease-in;
}

.form button:hover {
  background-color: #6d44b8;
}

.formulario {
    margin-top: 0px; /* Ajusta el margen superior según sea necesario */
}
.main.form {
    background-color: #68b0a2;
}
.main.form button {
    background-color: #4b7554;
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
            echo "<p>Check in: " . $row['FECHACHECKIN'] . "</p>";
            echo "<p>Check out: " . $row['FECHACHECKOUT'] . "</p>";
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
<h1>Modifica tu reserva si asi lo necesitas</h1>
<p>Si necesitas modificar tu reserva ten en cuenta que solo puedes hacerlo con el mismo numero de noches que has reservado previamente</p>

<br>
<!-- Agrega este formulario dentro del bloque PHP donde muestras los datos del cliente -->
<div class="formulario">
    <form id="formFechas" method="post" action="modificar_reserva.php" class="mt-3 main form">
        <div class="checkinDate">
            <label for="fechaInicio">Fecha de Check-in:</label>
            <input type="date" class="form-control input"  required id="checkinDate" name="checkinDate" value="<?php echo $checkin; ?>" required>
        </div>
        <div class="form-group">
            <label for="checkoutDate">Fecha de Check-out:</label>
            <input type="date" class="form-control input" required id="checkoutDate" name="checkoutDate" value="<?php echo $checkout; ?>" required>
        </div>
        <input type="hidden" name="cod_reserva" value="<?php echo $id_res; ?>">
        <button type="submit" class="btn btn-primary">Modificar Reserva</button>
    </form>
</div>

<!-- Script para establecer la fecha mínima para los campos de fecha -->
<script>
    // Obtener la fecha actual en formato yyyy-mm-dd
    function getCurrentDate() {
          const today = new Date();
          const year = today.getFullYear();
          const month = String(today.getMonth() + 1).padStart(2, '0');
          const day = String(today.getDate()).padStart(2, '0');
          return `${year}-${month}-${day}`;
      }
  
      // Establecer la fecha mínima para los campos de fecha
      document.getElementById('checkinDate').setAttribute('min', getCurrentDate());
  
      // Actualizar la fecha mínima de check-out cada vez que se selecciona una fecha de check-in
      document.getElementById('checkinDate').addEventListener('change', function() {
          const checkinDate = new Date(this.value);
          const nextDay = new Date(checkinDate);
          nextDay.setDate(checkinDate.getDate() + 1); // Añadir un día
  
          // Formatear la fecha en formato yyyy-mm-dd
          const nextDayFormatted = nextDay.toISOString().split('T')[0];
  
          document.getElementById('checkoutDate').setAttribute('min', nextDayFormatted);
      });
</script>



</body>
</html>
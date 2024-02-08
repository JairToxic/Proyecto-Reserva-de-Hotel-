<?php
// Incluir el archivo de conexión a la base de datos
include '../../../basedatos/basedatos.php';


  // Obtener la fecha de check-in y check-out del formulario
$checkin = $_GET['checkin'];
$checkout = $_GET['checkout'];
// Obtener todas las habitaciones disponibles
$habitacionesDisponibles = obtenerTodasLasHabitacionesDisponibles($checkin,$checkout);

// Función para obtener todas las habitaciones disponibles
function obtenerTodasLasHabitacionesDisponibles($checkin,$checkout) {
    global $mysqli;

    // Consulta SQL para obtener todas las habitaciones
    $consultaTodasLasHabitaciones = "SELECT * FROM habitaciones 
    WHERE ID_HABITACION NOT IN (
        SELECT hr.ID_HABITACION 
        FROM habitacion_reserva hr
        JOIN reserva r ON hr.ID_RESERVA = r.ID_RESERVA
        WHERE (r.FECHACHECKIN <= '$checkout' AND r.FECHACHECKOUT >= '$checkin')
    )";

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
    <title>Seleccionar Habitaciones</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #fechas-container {
            font-family: 'Verdana';
            font-weight: bold;
            padding: 20px;
            margin-bottom: 20px;
            
            background-color: hsl(187 75% 64%);
            border: 3px solid black;
            border-radius: 4px;
            width: 90%;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .habitacion-container {
            width: 450px;
            border: solid 1px #fff;
            background-color: yellow;
            font-family: ;
            padding: 10px;
            margin-bottom: 10px;
        }


        #seleccionadas {
            background-color: #f0f0f0;
            font-family: 'Verdana';
            border: 1px solid #ccc;
            padding: 20px;
            width: 80%;
            box-sizing: border-box;
            margin-top: 20px;
        }

        #reservar-btn {
            margin-top: 20px;
            padding: 10px;
            width: 30%;
            font-size: 25px;
            font-weight: bolder;
            background-color: #0E6655;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
        }
        img {
	display: block;
	width: 50%;
}

h2 {
	margin: 0;
	font-size: 1.4rem;
}

@media (min-width: 50em) {
	h2 {
		font-size: 1.8rem;
	}
}

.cta {
	--shadowColor: 187 60% 40%;
	display: flex;
	
	background: hsl(187 70% 85%);
	max-width: 60rem;
	width: 100%;
	box-shadow: 0.65rem 0.65rem 0 hsl(var(--shadowColor) / 1);
	border-radius: 0.8rem;
	overflow: hidden;
	border: 0.5rem solid;
}

.cta img {
	
	object-fit: cover;
	flex: 1 1 300px;
	outline: 0.5rem solid;
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
	background: hsl(187 75% 64%);
	border-radius: 0.6rem;
	font-weight: 700;
	border: 0.35rem solid;
}
    .habitacion-seleccionada {
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    padding: 10px;
    box-sizing: border-box;
}

.detalle-titulo {
    font-weight: bold;
    margin: 0;
}

.detalle-info {
    margin: 0;
}

#seleccionadas {
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    padding: 20px;
    width: 80%;
    box-sizing: border-box;
    margin-top: 20px;
}
    </style>
</head>
<body>
<div id="fechas-container">
    <form id="formFechas">
        <div class="form-group">
            <label for="fechaInicio">Fecha de Check-in:</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo $checkin; ?>" required>
        </div>
        <div class="form-group">
            <label for="fechaFin">Fecha de Check-out:</label>
            <input type="date" class="form-control" id="fechaFin" name="fechaFin" value="<?php echo $checkout; ?>" required>
        </div>
    </form>
</div>


    <div id="habitaciones-container">
        <?php
        // Mostrar las habitaciones disponibles
        foreach ($habitacionesDisponibles as $habitacion) {
            // Aquí deberías mostrar cada habitación con sus detalles y opciones de selección
            echo "<article class='cta'>";
            echo "<img src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' alt='Bluetit'>";
            echo "<div class='cta__text-column'>";
            echo "<h2>Habitación ID: " . $habitacion['ID_HABITACION'] . "</h2>";
            echo "<p>Tipo: " . $habitacion['TIPO'] . "</p>";
            echo "<p>Descripción: " . $habitacion['DESCRIPCION'] . "</p>";
            echo "<p>Precio por Noche: $" . $habitacion['PRECIOPORNOCHE'] . "</p>";
            echo "<button onclick='seleccionarHabitacion(" . $habitacion['ID_HABITACION'] . ")'>Seleccionar</button>";
            echo "</div>";
            echo "</article>";
            echo "<br><br>";
        }
        ?>
    </div>

    <div id="seleccionadas">
        <!-- Aquí se mostrarán las habitaciones seleccionadas -->
        <h2>Habitaciones Seleccionadas</h2>
    </div>

    <button id="reservar-btn" onclick="confirmarReserva()">Reservar</button>

    <script>
        // Lista para almacenar las habitaciones seleccionadas
        var habitacionesSeleccionadas = [];

        // Detalles de las habitaciones disponibles
        var detallesHabitaciones = <?php echo json_encode($habitacionesDisponibles); ?>;

        // Función para seleccionar una habitación
        function seleccionarHabitacion(idHabitacion) {
            // Verificar si la habitación ya está seleccionada
            if (habitacionesSeleccionadas.includes(idHabitacion)) {
                // Si está seleccionada, quitarla de la lista
                habitacionesSeleccionadas = habitacionesSeleccionadas.filter(id => id !== idHabitacion);
            } else {
                // Si no está seleccionada, agregarla a la lista
                habitacionesSeleccionadas.push(idHabitacion);
            }

            // Actualizar la lista de habitaciones seleccionadas en el HTML
            mostrarHabitacionesSeleccionadas();
        }

        // Función para mostrar las habitaciones seleccionadas
        function mostrarHabitacionesSeleccionadas() {
            var seleccionadasDiv = document.getElementById("seleccionadas");
            seleccionadasDiv.innerHTML = "<h2>Habitaciones Seleccionadas</h2>";

            // Mostrar detalles de las habitaciones seleccionadas
            for (var i = 0; i < habitacionesSeleccionadas.length; i++) {
                var idHabitacion = habitacionesSeleccionadas[i];

                // Buscar los detalles de la habitación en el array de detallesHabitaciones
                var habitacion = detallesHabitaciones.find(h => h.ID_HABITACION == idHabitacion);

                // Aquí deberías obtener los detalles de cada habitación y mostrarlos en un cuadro
                seleccionadasDiv.innerHTML += "<div class='seleccionadas'>";
                seleccionadasDiv.innerHTML += "Detalles de la habitación ID: " + habitacion.ID_HABITACION + "<br>";
                seleccionadasDiv.innerHTML += "Precio por Noche: $" + habitacion.PRECIOPORNOCHE + "<br>";
                // Obtener más detalles según sea necesario
                seleccionadasDiv.innerHTML += "<button onclick='quitarSeleccion(" + idHabitacion + ")'>Quitar Selección</button>";
                seleccionadasDiv.innerHTML += "</div>";
                seleccionadasDiv.innerHTML += "<br>";
            }

            // Calcular el precio total tomando en cuenta el número de noches
            var fechaInicio = document.getElementById('fechaInicio').value;
            var fechaFin = document.getElementById('fechaFin').value;
            var totalNoches = calcularDiferenciaFechas(fechaInicio, fechaFin);

            // Calcular el precio total sumando el precio por noche de cada habitación por el número de noches
            var precioTotal = habitacionesSeleccionadas.reduce((total, id) => {
                var habitacion = detallesHabitaciones.find(h => h.ID_HABITACION == id);
                return total + (parseFloat(habitacion.PRECIOPORNOCHE) * totalNoches);
            }, 0);

            // Mostrar las fechas seleccionadas y el precio total
            seleccionadasDiv.innerHTML += "<hr>";
            seleccionadasDiv.innerHTML += "<p>Fechas Seleccionadas: " + fechaInicio + " - " + fechaFin + "</p>";
            seleccionadasDiv.innerHTML += "<p>Noches: " + totalNoches + "</p>";
            seleccionadasDiv.innerHTML += "<p>Precio Total: $" + precioTotal.toFixed(2) + "</p>";
        }

        // Función para quitar la selección de una habitación
        function quitarSeleccion(idHabitacion) {
            // Quitar la habitación de la lista de seleccionadas
            habitacionesSeleccionadas = habitacionesSeleccionadas.filter(id => id !== idHabitacion);

            // Actualizar la lista de habitaciones seleccionadas en el HTML
            mostrarHabitacionesSeleccionadas();
        }

        // Función para calcular la diferencia en días entre dos fechas
        function calcularDiferenciaFechas(fechaInicio, fechaFin) {
            var inicio = new Date(fechaInicio);
            var fin = new Date(fechaFin);
            var diferencia = Math.abs(fin - inicio);
            var dias = Math.ceil(diferencia / (1000 * 60 * 60 * 24));
            return dias;
        }

        // Función para confirmar la reserva
       // Función para confirmar la reserva
function confirmarReserva() {
    // Calcular el precio total tomando en cuenta el número de noches
    var fechaInicio = document.getElementById('fechaInicio').value;
    var fechaFin = document.getElementById('fechaFin').value;
    var totalNoches = calcularDiferenciaFechas(fechaInicio, fechaFin);

    // Calcular el precio total sumando el precio por noche de cada habitación por el número de noches
    var precioTotal = habitacionesSeleccionadas.reduce((total, id) => {
        var habitacion = detallesHabitaciones.find(h => h.ID_HABITACION == id);
        return total + (parseFloat(habitacion.PRECIOPORNOCHE) * totalNoches);
    }, 0);

    // Crear un formulario dinámico para enviar los datos al servidor por POST
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'confirmar.php';

    // Agregar input para las habitaciones seleccionadas
    for (var i = 0; i < habitacionesSeleccionadas.length; i++) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'habitaciones[]';
        input.value = habitacionesSeleccionadas[i];
        form.appendChild(input);
    }

    // Agregar input para las fechas
    var fechaInicioInput = document.createElement('input');
    fechaInicioInput.type = 'hidden';
    fechaInicioInput.name = 'fechaInicio';
    fechaInicioInput.value = fechaInicio;
    form.appendChild(fechaInicioInput);

    var fechaFinInput = document.createElement('input');
    fechaFinInput.type = 'hidden';
    fechaFinInput.name = 'fechaFin';
    fechaFinInput.value = fechaFin;
    form.appendChild(fechaFinInput);

    // Agregar input para el precio total
    var precioTotalInput = document.createElement('input');
    precioTotalInput.type = 'hidden';
    precioTotalInput.name = 'precioTotal';
    precioTotalInput.value = precioTotal.toFixed(2);
    form.appendChild(precioTotalInput);

    // Agregar el formulario al documento y enviarlo
    document.body.appendChild(form);
    form.submit();
}
    </script>
</body>
</html>

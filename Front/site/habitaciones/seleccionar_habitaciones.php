<?php
// Incluir el archivo de conexión a la base de datos
include '../../../basedatos/basedatos.php';

// Obtener todas las habitaciones disponibles
$habitacionesDisponibles = obtenerTodasLasHabitacionesDisponibles();

// Función para obtener todas las habitaciones disponibles
function obtenerTodasLasHabitacionesDisponibles() {
    global $mysqli;

    // Consulta SQL para obtener todas las habitaciones
    $consultaTodasLasHabitaciones = "SELECT * FROM habitaciones";

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
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            width: 80%;
            box-sizing: border-box;
        }

        #habitaciones-container {
            width: 80%;
            box-sizing: border-box;
        }

        #seleccionadas {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 20px;
            width: 80%;
            box-sizing: border-box;
            margin-top: 20px;
        }

        #reservar-btn {
            margin-top: 20px;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="fechas-container">
        <form id="formFechas">
            <div class="form-group">
                <label for="fechaInicio">Fecha de Check-in:</label>
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
            </div>
            <div class="form-group">
                <label for="fechaFin">Fecha de Check-out:</label>
                <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
            </div>
        </form>
    </div>

    <div id="habitaciones-container">
        <?php
        // Mostrar las habitaciones disponibles
        foreach ($habitacionesDisponibles as $habitacion) {
            // Aquí deberías mostrar cada habitación con sus detalles y opciones de selección
            echo "<div>";
            echo "Habitación ID: " . $habitacion['ID_HABITACION'] . "<br>";
            echo "Tipo: " . $habitacion['TIPO'] . "<br>";
            echo "Descripción: " . $habitacion['DESCRIPCION'] . "<br>";
            echo "Precio por Noche: $" . $habitacion['PRECIOPORNOCHE'] . "<br>";
            echo "<button onclick='seleccionarHabitacion(" . $habitacion['ID_HABITACION'] . ")'>Seleccionar</button>";
            echo "</div>";
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
                seleccionadasDiv.innerHTML += "<div>";
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

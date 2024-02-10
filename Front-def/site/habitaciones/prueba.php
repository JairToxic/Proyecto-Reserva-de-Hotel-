<?php
// basedatos.php
$mysqli = new mysqli("localhost", "root", "", "hotel");

// Verificar la conexión
if ($mysqli->connect_error) {
    die("La conexión a la base de datos falló: " . $mysqli->connect_error);
}

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
<!-- icon list--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <!-- Site Title-->
    <title>Contacts</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="../text/css" href="//fonts.googleapis.com/css?family=Lato:400,700,400italic%7CPoppins:300,400,500,700">
    
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            
        }

        #fechas-container {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Verdana';
            margin-left: auto;
            margin-right: auto;
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
            width: 65%;
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
	margin-left: 80px;
	background: hsl(187 70% 85%);
	max-width: 45rem;
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
    background-color: #D5DBDB;
    border: 1px solid #ccc;
    padding: 20px;
    width: 30%; /* Modifica el ancho según tus preferencias */
    box-sizing: border-box;
    margin-top: 40px;
    margin-right: 25px;
    position: fixed; /* Puedes usar 'absolute' si prefieres que sea relativo al contenido */
    top: 50%; /* Ajusta según tu preferencia para la posición vertical */
    right: 0; /* Coloca el elemento a la derecha de la página */
    transform: translate(0, -50%); /* Centra verticalmente con respecto al top: 50% */
    box-shadow: 0 0 10px #E59866;
}
    </style>
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
  </head>
  <body>
    <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <!-- Page-->
    <div class="text-center page"><a class="banner banner-top" href="https://www.templatemonster.com/website-templates/monstroid2.html" target="_blank"><img src="images/monstroid.jpg" alt="" height="0"></a>
      <!-- Page preloader-->
      <div class="page-loader">
        <div>
          <div class="page-loader-body">
            <div class="loader">
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="window"></div>
              <div class="door"></div>
              <div class="hotel-sign"><span>H</span><span>O</span><span>T</span><span>E</span><span>L</span></div>
                <div class="hotel-sign1"></span><span></span><span>C</span><span>O</span>
                    <span>P</span><span>O</span></div>
            </div>
          </div>
        </div>
      </div>
      <!-- Page Header-->
      <header class="page-header" style="padding-bottom: 24px">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-default-with-top-panel" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fullwidth" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fullwidth" data-lg-device-layout="rd-navbar-fullwidth" data-md-stick-up-offset="90px" data-lg-stick-up-offset="150px" data-stick-up="true" data-sm-stick-up="true" data-md-stick-up="true" data-lg-stick-up="true">
            <div class="rd-navbar-top-panel rd-navbar-collapse">
              <div class="rd-navbar-top-panel-inner">
                <div class="left-side">
                  <div class="group"><span class="text-italic">Siguenos en Redes Sociales:</span>
                    <ul class="list-inline">
                      <li><a class="icon icon-sm icon-secondary-5 fa fa-instagram" href="#"></a></li>
                      <li><a class="icon icon-sm icon-secondary-5 fa fa-facebook" href="#"></a></li>
                      <li><a class="icon icon-sm icon-secondary-5 fa fa-twitter" href="#"></a></li>
                    </ul>
                  </div>
                </div>
                <div class="center-side">
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand fullwidth-brand"><a class="brand-name" href="index.html"><img src="imagenes/logo.jpeg" alt="" width="214" height="28"/></a></div>
                </div>
                <div class="right-side">
                  <!-- Contact Info-->
                  <div class="contact-info">
                    <div class="unit unit-middle unit-horizontal unit-spacing-xs">
                      <div class="unit__left"><span class="icon icon-primary text-middle mdi mdi-phone"></span></div>
                      <div class="unit__body"><a class="text-middle" href="tel:#">+ (593) 987297703</a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="rd-navbar-inner">
              <!-- RD Navbar Panel-->
              <div class="rd-navbar-panel">
                <!-- RD Navbar Toggle-->
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar collapse toggle-->
                <button class="rd-navbar-collapse-toggle" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand mobile-brand"><a class="brand-name" href="index.html"><img src="images/logo-default-314x48.png" alt="" width="314" height="48"/></a></div>
              </div>
              <div class="rd-navbar-aside-right">
                <div class="rd-navbar-nav-wrap">
                  <div class="rd-navbar-nav-scroll-holder">
                    <ul class="rd-navbar-nav">
                      <li class="active"><a href="index.html">Hotel</a>
                      </li>
                      <li><a href="about-us.html">Sobre Nosotros</a>
                      </li>
                      <li><a href="contacts.html">Contactanos</a>
                      </li>
                      <li><a href="habitaciones.html">Habitaciones</a>
                      </li>
                      <li><a href="comentarios.html">Comentarios</a>
                      </li>
                      <li><a href="galeria.html">Galeria de Fotos</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <main>
      
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
    // Consultar la imagen asociada a la habitación
    $id_habitacion = $habitacion['ID_HABITACION'];
    $queryImagen = "SELECT url FROM imagenes_habitaciones WHERE id_habitacion = $id_habitacion LIMIT 1";
    $resultImagen = $mysqli->query($queryImagen);

    // Verificar si la consulta fue exitosa y hay una imagen asociada
    if ($resultImagen && $row = $resultImagen->fetch_assoc()) {
        $imagenURL = $row['url'];
    } else {
        // Ruta por defecto si no hay imagen asociada
        $imagenURL = 'ruta_por_defecto_si_no_hay_imagen';
    }

    // Mostrar la habitación con sus detalles y la imagen
    echo "<article class='cta'>";
    echo "<a href='#' data-toggle='modal' data-target='#modalImagen{$habitacion['ID_HABITACION']}'>";
    echo "<img src='{$imagenURL}' alt='Habitación' style='width: 300px; height: 300px;'>"; // Ajusta las dimensiones según tus necesidades
    echo "</a>";
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
    <!-- Agrega un contenedor para las habitaciones seleccionadas -->
    <div id="habitacionesSeleccionadasContainer"></div>
    <!-- Mueve el botón de reservar fuera del área dinámica -->
    <button id="reservar-btn" onclick="confirmarReserva()" disabled>Reservar</button>
    </div>
        
        <!-- Page Footer-->
      <footer class="page-footer text-left text-sm-left">
        <div class="shell-wide">
        
          <div class="page-footer-minimal">
            <div class="shell-wide">
              <div class="range range-50">
                <div class="cell-sm-6 cell-md-3 cell-lg-4 wow fadeInUp" data-wow-delay=".1s">
                  <div class="page-footer-minimal-inner">
                    <h4>Horario de apertura</h4>
                    <ul class="list-unstyled">
                      <li>
                        <div class="group-xs"> 
                          <div>
                            <dl class="list-desc">
                              <dt>Días laborables: </dt>
                              <dd class="text-gray-darker"><span>8:00–20:00</span></dd>
                            </dl>
                          </div>
                          <div>
                            <dl class="list-desc">
                              <dt>Fines de semana: </dt>
                              <dd class="text-gray-darker"><span>9:00–18:00</span></dd>
                            </dl>
                          </div>
                        </div>
                      </li>
                      <li>
                        <p class="rights"><span>&copy;&nbsp;</span><span>2024</span><span>&nbsp;</span><span class="copyright-year"></span>Hotel Copo de Nieve. Reservados todos los derechos. Diseñado por Jair Sanchez <a href="https://www.templatemonster.com">Jair</a></p>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="cell-sm-6 cell-md-5 cell-lg-4 wow fadeInUp" data-wow-delay=".2s">
                  <div class="page-footer-minimal-inner">
                    <h4>DIRECCIÓN</h4>
                    <ul class="list-unstyled">
                      <li>
                        <dl class="list-desc">
                          <dt><span class="icon icon-sm mdi mdi-map-marker"></span></dt>
                          <dd><a class="link link-gray-darker" href="#">Quito,12 de Octubre </a></dd>
                        </dl>
                      </li>
                      <li>
                        <dl class="list-desc">
                          <dt><span class="icon icon-sm mdi mdi-phone"></span></dt>
                          <dd class="text-gray-darker">Llamanos: <a class="link link-gray-darker" href="tel:#">+ (593) 987297703</a>
                          </dd>
                        </dl>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="cell-sm-8 cell-md-4 wow fadeInUp" data-wow-delay=".3s">
                  <div class="page-footer-minimal-inner-subscribe">
                    <h4>Suscríbase a nuestro boletín</h4>
                    <!-- RD Mailform-->
                    <form class="rd-mailform rd-mailform-inline form-center" data-form-output="form-output-global" data-form-type="subscribe" method="post" action="bat/rd-mailform.php">
                      <div class="form-wrap">
                        <input class="form-input" id="subscribe-email" type="email" name="email" data-constraints="@Email @Required">
                        <label class="form-label" for="subscribe-email">Introduce tu correo electrónico</label>
                      </div>
                      <button class="button button-primary-2 button-effect-ujarak button-square" type="submit"><span>Subscribe</span></button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- PANEL-->
    <!-- END PANEL-->
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- PhotoSwipe Gallery-->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="pswp__bg"></div>
      <div class="pswp__scroll-wrap">
        <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
          <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
            <button class="pswp__button pswp__button--share" title="Share"></button>
            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
            <div class="pswp__preloader">
              <div class="pswp__preloader__icn">
                <div class="pswp__preloader__cut">
                  <div class="pswp__preloader__donut"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip"></div>
          </div>
          <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
          <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
          <div class="pswp__caption">
            <div class="pswp__caption__cent"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Javascript-->
    <script src="../js/core.min.js"></script>
    <script src="../js/script.js"></script>
    <!--Coded by Drel-->
    <script>
        // Lista para almacenar las habitaciones seleccionadas
        var habitacionesSeleccionadas = [];

        // Detalles de las habitaciones disponibles
        var detallesHabitaciones = <?php echo json_encode($habitacionesDisponibles); ?>;

        // Función para seleccionar una habitación

        function mostrarBotonReservar() {
        var reservarBtn = document.getElementById("reservar-btn");
        reservarBtn.disabled = habitacionesSeleccionadas.length === 0;
    }

        function seleccionarHabitacion(idHabitacion) {
    // Verificar si ya se han seleccionado 3 habitaciones
    if (habitacionesSeleccionadas.length === 3) {
        alert("Solo puedes seleccionar un máximo de 3 habitaciones.");
        return; // No permitir más selecciones
    }

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
    mostrarBotonReservar();
}

        // Función para mostrar las habitaciones seleccionadas
        function mostrarHabitacionesSeleccionadas() {
            var seleccionadasDiv = document.getElementById("habitacionesSeleccionadasContainer");
            seleccionadasDiv.innerHTML = "";

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
    
mostrarBotonReservar();
    </script>
    <script>
function verDetalles(habitacionId) {
    // Enviar el formulario correspondiente al hacer clic en "Ver Detalles"
    document.getElementById(`formHabitacion${habitacionId}`).submit();
}
</script>
  </body>
</html>
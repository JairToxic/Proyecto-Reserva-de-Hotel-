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
    <title>Habitaciones Disponibles</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="../text/css" href="//fonts.googleapis.com/css?family=Lato:400,700,400italic%7CPoppins:300,400,500,700">
    
    <link rel="stylesheet" href="../css/style.css">
    
    <link rel="stylesheet" href="../css/header_footer.css">
    <style>
        body {
            color: black;
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
    border: 1px solid #2971D3;
    padding: 5px;
    width: 30%; /* Modifica el ancho según tus preferencias */
    box-sizing: border-box;
    margin-top: 20px;
    margin-right: 25px;
    position: fixed; /* Puedes usar 'absolute' si prefieres que sea relativo al contenido */
    top: 55%; /* Ajusta según tu preferencia para la posición vertical */
    right: 0; /* Coloca el elemento a la derecha de la página */
    transform: translate(0, -40%); /* Centra verticalmente con respecto al top: 50% */
    max-height: calc(100% - 80px);
    overflow-y: auto;
    box-shadow: 0 0 10px #2971D3;
}

#seleccionadas button{
    margin-left: 10px;
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
                 <!--iba redes-->
                 <div class="contact-info">
                  <div class="unit unit-middle unit-horizontal unit-spacing-xs">
                    <div class="unit__left"><span class="icon icon-primary text-middle mdi mdi-phone"></span></div>
                    <div class="unit__body"><a class="text-middle" href="tel:#">+ (593) 987297703</a></div>
                  </div>
                </div>
                </div>
                <div class="center-side">
                  <!-- RD Navbar Brand-->
                  <!--logo-->
                  <div class="rd-navbar-brand fullwidth-brand"><a class="brand-name" href="index.html"><img src="../imagenes/logo1.PNG" alt="" width="400" height="400"/></a></div>
                </div>
                <div class="right-side">
                  <!-- Contact Info-->
                  <ul class="social">
    
                    <li class="social-item">
                      <a class="social-link" href="https://www.facebook.com/?locale=es_LA"  target="_blank">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M9.19795 21.5H13.198V13.4901H16.8021L17.198 9.50977H13.198V7.5C13.198 6.94772 13.6457 6.5 14.198 6.5H17.198V2.5H14.198C11.4365 2.5 9.19795 4.73858 9.19795 7.5V9.50977H7.19795L6.80206 13.4901H9.19795V21.5Z" fill="currentColor"></path>
                        </svg>
                      </a>
                    </li>
                    <li class="social-item">
                      <a class="social-link" href="https://twitter.com/"  target="_blank">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M8 3C9.10457 3 10 3.89543 10 5V8H16C17.1046 8 18 8.89543 18 10C18 11.1046 17.1046 12 16 12H10V14C10 15.6569 11.3431 17 13 17H16C17.1046 17 18 17.8954 18 19C18 20.1046 17.1046 21 16 21H13C9.13401 21 6 17.866 6 14V5C6 3.89543 6.89543 3 8 3Z" fill="currentColor"></path>
                        </svg>
                      </a>
                    </li>
                    <li class="social-item">
                      <a class="social-link"  href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=hotelcopodenieve@gmail.com"  target="_blank">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6 12C6 15.3137 8.68629 18 12 18C14.6124 18 16.8349 16.3304 17.6586 14H12V10H21.8047V14H21.8C20.8734 18.5645 16.8379 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C15.445 2 18.4831 3.742 20.2815 6.39318L17.0039 8.68815C15.9296 7.06812 14.0895 6 12 6C8.68629 6 6 8.68629 6 12Z" fill="currentColor"></path>
                        </svg>
                      </a>
                    </li>
                    <li class="social-item">
                      <a class="social-link" href="https://www.instagram.com/accounts/login/"  target="_blank">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C9.23858 7 7 9.23858 7 12C7 14.7614 9.23858 17 12 17C14.7614 17 17 14.7614 17 12C17 9.23858 14.7614 7 12 7ZM9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12Z" fill="currentColor"></path>
                          <path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="currentColor"></path>
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M5 1C2.79086 1 1 2.79086 1 5V19C1 21.2091 2.79086 23 5 23H19C21.2091 23 23 21.2091 23 19V5C23 2.79086 21.2091 1 19 1H5ZM19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z" fill="currentColor"></path>
                        </svg>
                      </a>
                    </li>
                  </ul>

                </div>
              </div>
            </div>
            <div class="rd-navbar-inner">
              <!-- RD Navbar Panel-->
              <div class="rd-navbar-panel">
                <!-- RD Navbar Toggle-->
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar collapse toggle-->
                <button class="rd-navbar-collapse-toggle" data-rd-navbar-toggle=".contact-info"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand mobile-brand"><a class="brand-name" href="index.html"><img src="imagenes/logo3.PNG" alt="" width="314" height="48"/></a></div>
              </div>
              <div class="rd-navbar-aside-right">
                <div class="rd-navbar-nav-wrap">
                  <div class="rd-navbar-nav-scroll-holder">
                    <ul class="rd-navbar-nav">
                      <li class="active"><a href="../index.html">Hotel</a>
                      </li>
                      <li><a href="../about-us.html">Sobre Nosotros</a>
                      </li>
                      <li><a href="../contacts.html">Contactanos</a>
                      </li>
                      <li><a href="../habitaciones.html">Habitaciones</a>
                      </li>
                      <li><a href="../comentarios.html">Comentarios</a>
                      </li>
                      <li><a href="../galeria.html">Galeria de Fotos</a>
                      </li>
                    </li>
                    <li><a href="../../../gestor/logger.php">Busca tu Reserva</a>
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

<div id="body-container">
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
    echo "<h2>Numero de habitacion: " . $habitacion['ID_HABITACION'] . "</h2>";
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
    </div>
       <!-- Page Footer-->
       <footer class="page-footer text-left text-sm-left"> 

        <div class="shell-wide">
        
            <div class="page-footer-minimal">
                <div class="shell-wide">
                    <div class="range range-50">
                        <div class="cell-sm-6 cell-md-3 cell-lg-4 wow fadeInUp" data-wow-delay=".1s">
                            <div class="page-footer-minimal-inner">
                                <h4 class="footer-h4">HORARIO DE APERTURA</h4>
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
                                        <p class="rights"><span>&copy;&nbsp;</span><span>2024</span><span>&nbsp;</span><span class="copyright-year"></span>Hotel Copo de Nieve. Reservados todos los derechos.<br><br> Diseñado por:<br> &#9657; Jair Sanchez <br> &#9657; Cristina Molina<br>&#9657; Dylan Villarroel<br> &#9657; Allan Molina</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="cell-sm-6 cell-md-5 cell-lg-4 wow fadeInUp" data-wow-delay=".2s">
                            <div class="page-footer-minimal-inner">
                                <h4 class="footer-h4">DIRECCIÓN</h4>
                                <ul class="list-unstyled">
                                    <li>
                                        <dl class="list-desc">
                                            <dt><span class="icon icon-sm mdi mdi-phone"></span></dt>
                                            <dd class="text-gray-darker">Llamanos: <a class="link link-gray-darker" href="tel:#">+ (593) 987297703</a>
                                            </dd>
                                        </dl>
                                    </li>
                                    <li>
                                        <dl class="list-desc">
                                            <dt><span class="icon icon-sm mdi mdi-map-marker"></span></dt>
                                            <dd><a class="link link-gray-darker" href="#">Quito,12 de Octubre </a></dd>
                                        </dl>
                                    </li>
                                    <li>
                                        <p></p>
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7902350563786!2d-78.5102267252163!3d-0.2149813353931239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a25c31db3b5%3A0x6c011283454d8bce!2sBas%C3%ADlica%20del%20Voto%20Nacional!5e0!3m2!1ses-419!2sec!4v1708828009391!5m2!1ses-419!2sec" width="300" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Nuevo div con los botones -->

                        <div class="cell-sm-6 cell-md-5 cell-lg-4 wow fadeInUp" data-wow-delay=".2s">
                            <div class="page-footer-minimal-inner">
                                <h4 class="footer-h4" >CONTACTANOS</h4>
                                <div class="main">
                                  <div class="up">
                                      <button class="card1">
                                          <svg class="instagram" fill-rule="nonzero" height="30px" width="30px" viewBox="0,0,256,256" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                                              <g style="mix-blend-mode: normal" text-anchor="none" font-size="none" font-weight="none" font-family="none" stroke-dashoffset="0" stroke-dasharray="" stroke-miterlimit="10" stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1" stroke="none" fill-rule="nonzero">
                                                  <g transform="scale(8,8)">
                                                      <path d="M11.46875,5c-3.55078,0 -6.46875,2.91406 -6.46875,6.46875v9.0625c0,3.55078 2.91406,6.46875 6.46875,6.46875h9.0625c3.55078,0 6.46875,-2.91406 6.46875,-6.46875v-9.0625c0,-3.55078 -2.91406,-6.46875 -6.46875,-6.46875zM11.46875,7h9.0625c2.47266,0 4.46875,1.99609 4.46875,4.46875v9.0625c0,2.47266 -1.99609,4.46875 -4.46875,4.46875h-9.0625c-2.47266,0 -4.46875,-1.99609 -4.46875,-4.46875v-9.0625c0,-2.47266 1.99609,-4.46875 4.46875,-4.46875zM21.90625,9.1875c-0.50391,0 -0.90625,0.40234 -0.90625,0.90625c0,0.50391 0.40234,0.90625 0.90625,0.90625c0.50391,0 0.90625,-0.40234 0.90625,-0.90625c0,-0.50391 -0.40234,-0.90625 -0.90625,-0.90625zM16,10c-3.30078,0 -6,2.69922 -6,6c0,3.30078 2.69922,6 6,6c3.30078,0 6,-2.69922 6,-6c0,-3.30078 -2.69922,-6 -6,-6zM16,12c2.22266,0 4,1.77734 4,4c0,2.22266 -1.77734,4 -4,4c-2.22266,0 -4,-1.77734 -4,-4c0,-2.22266 1.77734,-4 4,-4z"></path>
                                                  </g>
                                              </g>
                                          </svg>
                                      </button>
                                      <button class="card2">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" class="facebook" width="24">
                                              <path d="M9.19795 21.5H13.198V13.4901H16.8021L17.198 9.50977H13.198V7.5C13.198 6.94772 13.6457 6.5 14.198 6.5H17.198V2.5H14.198C11.4365 2.5 9.19795 4.73858 9.19795 7.5V9.50977H7.19795L6.80206 13.4901H9.19795V21.5Z"></path>
                                          </svg>
                                      </button>
                                  </div>
                                  <div class="down">
                                      <button class="card3">
                                          <svg width="30" height="30" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="whatsapp">
                                              <path d="M19.001 4.908A9.817 9.817 0 0 0 11.992 2C6.534 2 2.085 6.448 2.08 11.908c0 1.748.458 3.45 1.321 4.956L2 22l5.255-1.377a9.916 9.916 0 0 0 4.737 1.206h.005c5.46 0 9.908-4.448 9.913-9.913A9.872 9.872 0 0 0 19 4.908h.001ZM11.992 20.15A8.216 8.216 0 0 1 7.797 19l-.3-.18-3.117.818.833-3.041-.196-.314a8.2 8.2 0 0 1-1.258-4.381c0-4.533 3.696-8.23 8.239-8.23a8.2 8.2 0 0 1 5.825 2.413 8.196 8.196 0 0 1 2.41 5.825c-.006 4.55-3.702 8.24-8.24 8.24Zm4.52-6.167c-.247-.124-1.463-.723-1.692-.808-.228-.08-.394-.123-.556.124-.166.246-.641.808-.784.969-.143.166-.29.185-.537.062-.247-.125-1.045-.385-1.99-1.23-.738-.657-1.232-1.47-1.38-1.716-.142-.247-.013-.38.11-.504.11-.11.247-.29.37-.432.126-.143.167-.248.248-.413.082-.167.043-.31-.018-.433-.063-.124-.557-1.345-.765-1.838-.2-.486-.404-.419-.557-.425-.142-.009-.309-.009-.475-.009a.911.911 0 0 0-.661.31c-.228.247-.864.845-.864 2.067 0 1.22.888 2.395 1.013 2.56.122.167 1.742 2.666 4.229 3.74.587.257 1.05.408 1.41.523.595.19 1.13.162 1.558.1.475-.072 1.464-.6 1.673-1.178.205-.58.205-1.075.142-1.18-.061-.104-.227-.165-.475-.29Z"></path>
                                          </svg>
                                      </button>
                                      <button class="card4">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" class="gmail" width="24">
                                              <path d="M6 12C6 15.3137 8.68629 18 12 18C14.6124 18 16.8349 16.3304 17.6586 14H12V10H21.8047V14H21.8C20.8734 18.5645 16.8379 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C15.445 2 18.4831 3.742 20.2815 6.39318L17.0039 8.68815C15.9296 7.06812 14.0895 6 12 6C8.68629 6 6 8.68629 6 12Z"></path>
                                          </svg>
                                      </button>
                                  </div>
                              </div>
                            </div>
                            <p>Encuentranos en todas nuestras redes, siguenos para estar informado de nuestras últimas novedades y ofertas</p>
                        </div>
                        <!-- Fin del nuevo div con los botones -->
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
                seleccionadasDiv.innerHTML += "Precio por Noche: $" + habitacion.PRECIOPORNOCHE;
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
            seleccionadasDiv.innerHTML += "Fechas Seleccionadas: " + fechaInicio + " - " + fechaFin + "<br>";
            seleccionadasDiv.innerHTML += "Noches: " + totalNoches + "<br>";
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
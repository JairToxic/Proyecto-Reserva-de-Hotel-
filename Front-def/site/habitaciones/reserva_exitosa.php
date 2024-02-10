<?php
include '../../../basedatos/basedatos.php';

// Recuperar la ID de la reserva desde la URL (suponiendo que se pasa como parámetro)
$id_reserva = $_GET['id_reserva']; // Asegúrate de validar y sanitizar este valor

// Consulta SQL para obtener detalles de la reserva y número de habitación
$consultaReserva = "SELECT c.NOMBRE, c.APELLIDO, c.CELULAR, c.EMAIL, r.FECHACHECKIN, r.FECHACHECKOUT, r.ESTADORESERVA, p.METODOPAGO, p.FECHAPAGO, hr.ID_HABITACION
                   FROM cliente c
                   JOIN reserva r ON c.ID_CLIENTE = r.ID_CLIENTE
                   LEFT JOIN pago p ON r.ID_RESERVA = p.ID_RESERVA
                   JOIN habitacion_reserva hr ON r.ID_RESERVA = hr.ID_RESERVA
                   WHERE r.ID_RESERVA = ?";

// Usar consulta preparada para seguridad
$stmt = $mysqli->prepare($consultaReserva);
$stmt->bind_param("i", $id_reserva);
$stmt->execute();

// Obtener resultados
$resultado = $stmt->get_result();

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Mostrar detalles de la reserva y número de habitación
    $reserva = $resultado->fetch_assoc();
    ?>
    
       
   
    <?php
} else {
    // No se encontraron resultados, manejar el caso según sea necesario
    echo "Error: No se encontraron detalles de la reserva.";
}

// Cerrar la conexión y liberar recursos
$stmt->close();
$mysqli->close();
?>

<!-- icon list--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <!-- Site Title-->
    <title>Reserva exitosa</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../images/favicon.ico" type="../image/x-icon">
    <link rel="stylesheet" href="../css/boton_hotel.css">
    <!-- Stylesheets-->
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery (required for Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<!-- Popper.js (required for Bootstrap JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="../text/css" href="//fonts.googleapis.com/css?family=Lato:400,700,400italic%7CPoppins:300,400,500,700">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
    <style>
        .miniatura-item {
            transition: transform 0.2s ease-in-out;
        }

        .miniatura-item:hover {
            transform: scale(1.1);
        }
    </style>
     <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        h1 {
            color: #4CAF50;
        }

        .confirmation-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        p {
            color: #333;
            font-size: 18px;
        }

        .thank-you-message {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            margin-top: 20px;
        }
    </style>
    </head>
  <body>
    <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="../images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <!-- Page-->
    <div class="text-center page"><a class="banner banner-top" href="https://www.templatemonster.com/website-templates/monstroid2.html" target="_blank"><img src="../images/monstroid.jpg" alt="" height="0"></a>
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
                  <div class="rd-navbar-brand fullwidth-brand"><a class="brand-name" href="../index.html"><img src="../imagenes/logo.jpeg" alt="" width="214" height="28"/></a></div>
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
                <div class="rd-navbar-brand mobile-brand"><a class="brand-name" href="../index.html"><img src="../images/logo-default-314x48.png" alt="" width="314" height="48"/></a></div>
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
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
       
      </header>
  

    <div class="confirmation-container">
        <h1>¡Reserva Exitosa!</h1>
        <p>Tu reserva ha sido confirmada. Esperamos que tengas una estancia increíble.</p>
        <p>Los detalles de la reserva han sido enviados a su correo electronico</p>
        

        <p><strong>Nombre:</strong> <?php echo $reserva['NOMBRE']; ?></p>
        <p><strong>Apellido:</strong> <?php echo $reserva['APELLIDO']; ?></p>
        <p><strong>Celular:</strong> <?php echo $reserva['CELULAR']; ?></p>
        <p><strong>Email:</strong> <?php echo $reserva['EMAIL']; ?></p>
        <p><strong>Fecha de Check-in:</strong> <?php echo $reserva['FECHACHECKIN']; ?></p>
        <p><strong>Fecha de Check-out:</strong> <?php echo $reserva['FECHACHECKOUT']; ?></p>
        <p><strong>Estado de Reserva:</strong> <?php echo $reserva['ESTADORESERVA']; ?></p>
        <p><strong>Método de Pago:</strong> <?php echo $reserva['METODOPAGO']; ?></p>
        <p><strong>Fecha de Pago:</strong> <?php echo $reserva['FECHAPAGO']; ?></p>
        <p><strong>Número de Habitación:</strong> <?php echo $reserva['ID_HABITACION']; ?></p>

        <div class="thank-you-message">¡Gracias por elegir nuestro hotel!</div>

        <h6>No olvides de dejar tus comentarios, solo pulsa el boton</h6>
        <br>
        <p>regresa a nuestra pagina web pulsando aqui</p>
        <button class="button" data-text="Awesome" onclick="window.location.href='../../site';">
    <span class="actual-text">&nbsp;Copo de Nieve&nbsp;</span>
    <span aria-hidden="true" class="hover-text">&nbsp;Copo de Nieve&nbsp;</span>
    </button>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-DcPgea9PSpwOM3EKiWLPgPUA/IwzXYBzTNn8UezZG6G8tL8foOZ//Cp82Ci9WqLg" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyO8k+5TIxg3jpuDHvjkoWw49tiSM+rL4N" crossorigin="anonymous"></script>
    <script>
        / Agregar efecto de clic a las miniaturas
        document.querySelectorAll('.miniatura-item').forEach(function(miniatura) {
            miniatura.addEventListener('click', function() {
               
            });
        });
    </script>
    
    <script src="../js/core.min.js"></script>
    <script src="../js/script.js"></script>

  </body>
</html>
<?php
    include '../../../basedatos/basedatos.php';

    if (isset($_GET['habitacion_id'])) {
        $habitacion_id = $_GET['habitacion_id'];

        // Consulta SQL para obtener detalles de la habitación específica
        $resultado = $mysqli->query("SELECT * FROM habitaciones WHERE ID_HABITACION = $habitacion_id");

        if (!$resultado) {
            echo "<script>alert('Error al ejecutar la consulta: " . $mysqli->error . "');</script>";
            exit();
        }

        $habitacion = $resultado->fetch_assoc();

        // Consulta SQL para obtener imágenes relacionadas con la habitación
        $imagenes_resultado = $mysqli->query("SELECT * FROM imagenes_habitaciones WHERE id_habitacion = $habitacion_id");
        $imagenes = $imagenes_resultado->fetch_all(MYSQLI_ASSOC);
    } else {
        // Si no se proporciona un ID de habitación válido, redireccionar o manejar el error según sea necesario
        header("Location: ../tipo de habitaciones/habitaciones_estandar.php");
        exit();
    }
?>

<!-- icon list--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <!-- Site Title-->
    <title>Habitacion Estandar</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../images/favicon.ico" type="../image/x-icon">
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
                      <li class="active"><a href="index.html">Hotel</a>
                      </li>
                      <li><a href="about-us.html">Sobre Nosotros</a>
                      </li>
                      <li><a href="contacts.html">Contactanos</a>
                      </li>
                      <li><a href="habitaciones.html">Habitaciones</a>
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

        <div class="container bg-light p-4">
        <div id="carruselPrincipal" class="carousel slide mb-4" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $first = true;
                foreach ($imagenes as $index => $imagen) : ?>
                    <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                        <img src="<?php echo $imagen['url']; ?>" class="d-block w-100" alt="Imagen de la habitación">
                    </div>
                <?php
                $first = false;
                endforeach; ?>
            </div>

            <!-- Controles del carrusel -->
            <a class="carousel-control-prev" href="#carruselPrincipal" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carruselPrincipal" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>

        
    <!-- Carrusel de miniaturas debajo del carrusel principal -->
    <div id="carruselMiniaturas" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            $chunks = array_chunk($imagenes, 6);
            foreach ($chunks as $index => $chunk) : ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="row">
                        <?php foreach ($chunk as $innerIndex => $imagen) : ?>
                            <div class="col-2">
                                <a href="#" data-toggle="modal" data-target="#modalImagen<?php echo $innerIndex + ($index * 6); ?>">
                                    <img src="<?php echo $imagen['url']; ?>" class="d-block w-100 miniatura-item" alt="Miniatura de la habitación">
                                </a>
                            </div>

                            <!-- Modal para cada imagen -->
                            <div class="modal fade" id="modalImagen<?php echo $innerIndex + ($index * 6); ?>" tabindex="-1" role="dialog" aria-labelledby="modalImagenLabel<?php echo $innerIndex + ($index * 6); ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalImagenLabel<?php echo $innerIndex + ($index * 6); ?>">Imagen de la habitación</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php echo $imagen['url']; ?>" class="d-block w-100" alt="Imagen de la habitación">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Controles del carrusel de miniaturas -->
        <a class="carousel-control-prev" href="#carruselMiniaturas" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carruselMiniaturas" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div>
</div>

<br>

    <div class="detalles-habitacion-container bg-light p-4 rounded shadow mx-auto" style="max-width: 1150px;">
    <div class="mb-4">
        <h3>Descripcion</h3>
        <p class="mb-2"><?php echo $habitacion['DESCRIPCION']; ?></p>
        <p class="mb-2">Precio por noche: $<?php echo $habitacion['PRECIOPORNOCHE']; ?></p>
        <p class="mb-2">Capacidad: <?php echo $habitacion['CAPACIDAD']; ?> personas</p>
    </div>
    <div class="mb-4">
        <p class="mb-2">Camas: <?php echo $habitacion['CAMAS']; ?></p>
        <p class="mb-2">Baño: <?php echo $habitacion['BANO']; ?></p>
        
        <!-- Agregamos iconos para hacerlo más visual -->
        <div class="mb-2">
            <span class="icon icon-primary text-middle mdi mdi-star"></span>
            <span class="ml-2">Valoración:  / 5</span>
        </div>
        <div class="mb-2">
            <span class="icon icon-primary text-middle mdi mdi-wifi"></span>
            <span class="ml-2">Wi-Fi: </span>
        </div>
        <div class="mb-2">
            <span class="icon icon-primary text-middle mdi mdi-air-conditioner"></span>
            <span class="ml-2">Aire Acondicionado: </span>
        </div>
    </div>

    <!-- Puedes agregar más detalles según sea necesario -->

    <a href="../tipos de habitaciones/habitaciones_estandar.php" class="btn btn-secondary">Volver a la lista de habitaciones</a>
</div>
<br>

<form id="formReserva">
    <div class="form-group">
        <label for="fechaInicio">Fecha de Check-in:</label>
        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
    </div>
    <div class="form-group">
        <label for="fechaFin">Fecha de Check-out:</label>
        <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
    </div>
    <!-- Agrega un campo oculto para almacenar el ID_HABITACION -->
    <input type="hidden" id="habitacion_id" name="habitacion_id" value="<?php echo $habitacion_id; ?>">
    <button type="button" class="btn btn-primary" onclick="calcularPrecio()">Reservar ahora</button>
</form>

  
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
                // Puedes agregar aquí más efectos o acciones al hacer clic en la miniatura
            });
        });
    </script>
    
    <script src="../js/core.min.js"></script>
    <script src="../js/script.js"></script>
    <!--Coded by Drel-->
    <script>
     
     function calcularPrecio() {
    // Obtener fechas del formulario
    var fechaInicio = document.getElementById('fechaInicio').value;
    var fechaFin = document.getElementById('fechaFin').value;

    // Obtener ID_HABITACION del campo oculto
    var habitacion_id = document.getElementById('habitacion_id').value;

    // Validar si se ingresaron fechas válidas
    if (fechaInicio && fechaFin && fechaFin >= fechaInicio) {
        // Calcular número de noches
        var fecha1 = new Date(fechaInicio);
        var fecha2 = new Date(fechaFin);
        var diffTiempo = Math.abs(fecha2 - fecha1);
        var diffDias = Math.ceil(diffTiempo / (1000 * 60 * 60 * 24));

        // Calcular precio total
        var precioPorNoche = <?php echo $habitacion['PRECIOPORNOCHE']; ?>;
        var precioTotal = diffDias * precioPorNoche;

        // Redirigir a la página de confirmación con parámetros
        window.location.href = 'confirmar_reserva.php?habitacion_id=' + habitacion_id + '&fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFin + '&noches=' + diffDias + '&precioTotal=' + precioTotal;
    } else {
        // Manejar caso de fechas no válidas
        alert('Por favor, seleccione fechas válidas de check-in y check-out.');
    }
}
</script>
</script>



  </body>
</html>
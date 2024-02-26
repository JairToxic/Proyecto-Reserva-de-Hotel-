<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Inicio CRUD</title>
    <style>
        #inicio{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        .center-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Ajustar el tamaño del contenedor para centrar verticalmente */
        }
        .logo {
            width: 150px; /* Ajustar el tamaño del logo si es necesario */
            margin-bottom: 200px; /* Espacio entre el logo y el título */
        }
        .hotel-title {
            font-size: 2.5rem; /* Ajustar el tamaño del título si es necesario */
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Administración del Hotel Copo de Nieve</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Hotel Copo de Nieve</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reservas</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="agre_reservas.php?type=reserva">Agregar</a></li>
                                <li><a class="dropdown-item" href="modificar_reserva.php?type=reserva">Modificar</a></li>
                                <li><a class="dropdown-item" href="eliminar_reserva.php?type=reserva">Eliminar</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Habitaciones</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="agre_habitaciones.php?type=habitacion">Agregar</a></li>
                                <li><a class="dropdown-item" href="modificar_habitaciones.php?type=habitacion">Modificar</a></li>
                                <li><a class="dropdown-item" href="eliminar_habitaciones.php?type=habitacion">Eliminar</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Clientes</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="agre_cliente.php?type=clientes">Agregar</a></li>
                                <li><a class="dropdown-item" href="modificar_cliente.php?type=clientes">Modificar</a></li>
                                <li><a class="dropdown-item" href="eliminar_cliente.php?type=clientes">Eliminar</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Comentarios</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="eliminar_comentario.php?type=comentarios">Eliminar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>   
</header>

<div id="inicio" class="container text-center mt-5">
    <img src="logo.png" class="img-fluid" alt="Hotel Logo">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>




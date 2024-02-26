<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>Inicio CRUD</title>
    <script>
        function handleClick(buttonId) {
            var buttons = document.getElementsByClassName("crud-button");
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].disabled = false; // Habilitar todos los botones primero
            }
            
            // Deshabilitar botón agregar y modificar si se hace clic en "Comentarios"
            if (buttonId === 'comentarios') {
                document.getElementById("agregar-button").disabled = true;
                document.getElementById("modificar-button").disabled = true;
            }

            document.getElementById("crud-actions").style.display = "block";
            // Guardar el nombre del botón seleccionado en una variable global
            window.selectedButton = buttonId;
        }

        function redirectToAction(action) {
            var selectedButton = window.selectedButton;
            if (selectedButton) {
                var url;
                if (action === 'eliminar') {
                    url = 'eliminar.php?type=' + selectedButton;
                } else {
                    url = action + '.php?type=' + selectedButton; // Corrección aquí
                }
                window.location.href = url;
            }
        }
    </script>
    <style>
      /*ESTILO FORM*/
        .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Ajusta la altura al 100% del viewport */
    margin-top: 60px;
    margin-bottom: 60px;
}

       .form {
    display: flex;
    flex-direction: column;
    width: 500px; 
    height: 750px; 
    background-color: #FFF;
    margin: 0;
    box-shadow: -1px 0px 25px 0px #21719369;
    padding: 2.25em;
    box-sizing: border-box;
    border: solid 1px #DDD;
    border-radius: 0.5em;
    font-family: sans-serif;
    font-size: 16px;
    font-weight: 400;
}

.form .Group {
    margin-bottom: 2em;
}

.form label {
    margin: 0 0 10px;
    display: block;
    font-size: 1.25em;
    color: #217093;
    font-weight: 600;
    font-family: inherit;
}

.form input {
    padding: 0.3em 0.5em 0.4em;
    background-color: #f3fafd;
    border: solid 2px #217093;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
    height: 50px;
    font-size: 1.3em;
    color: #353538;
    font-weight: 600;
    font-family: inherit;
    transition: box-shadow 0.2s linear, border-color 0.25s ease-out;
}

.form input:focus {
    outline: none;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    background-color: #edf8fc;
    border: solid 2px #4eb8dd;
}

.form input::placeholder {
    color: #21719383;
}

.form .btn {
    margin: 0;
    padding: 0.5em;
    background-color: #4eb8dd;
    border: none;
    border-radius: 4px;
    box-sizing: border-box;
    box-shadow: none;
    width: 100%;
    height: 50px;
    font-size: 1.4em;
    color: #FFF;
    font-weight: 600;
    font-family: inherit;
    transition: transforme 0.1s ease-in-out, background-color 0.2s ease-out;
}

.form .btn:hover {
    cursor: pointer;
    background-color: #217093;
}

.form .btn:active {
    transform: scale(0.98);
}

/*ESTILO TABLA*/
table {
  background: white;
  width: 50%;
  margin: 0 auto;
  margin-top: 2%;
  border-collapse: collapse;
  text-align: center;
  margin-bottom: 10px;
}

th {
  background-color: #4eb8dd;
  height: 35px;
  border-bottom: 1px solid rgb(210, 220, 250);
  color: black;
}

td {
  color: rgba(100, 100, 100, 60);
  height: 30px;
  border: 0.5px solid rgba(240, 240, 240, 10);
}

tfoot {
  font-weight: bold;
}

/*Pseudo-clases*/
th:hover {
  background-color: #7AA6BF;
}

tr:hover {
  background-color: #7AA6BF;
}

/* Estililos de clases*/
.PrecioTotal:hover,
.CantidadTotal:hover {
  color: rgb(230, 50, 50);
}

    </style>
</head>
<body>
<header>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
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
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Reservas
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="agre_reservas.php.php?type=reserva" id="agregar-reserva-link" onclick="handleClick('agregar')">Agregar</a></li>
              <li><a class="dropdown-item" href="modificar.php?type=reserva" id="modificar-reserva-link" onclick="handleClick('modificar')">Modificar</a></li>
              <li><a class="dropdown-item" href="eliminar.php?type=reserva" id="eliminar-reserva-link" onclick="handleClick('eliminar')">Eliminar</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Habitaciones
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="agregar.php?type=habitacion" id="agregar-reserva-link" onclick="handleClick('agregar')">Agregar</a></li>
              <li><a class="dropdown-item" href="modificar.php?type=habitacion" id="modificar-reserva-link" onclick="handleClick('modificar')">Modificar</a></li>
              <li><a class="dropdown-item" href="eliminar.php?type=habitacion" id="eliminar-reserva-link" onclick="handleClick('eliminar')">Eliminar</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Clientes
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="agregar.php?type=clientes" id="agregar-reserva-link" onclick="handleClick('agregar')">Agregar</a></li>
              <li><a class="dropdown-item" href="modificar.php?type=clientes" id="modificar-reserva-link" onclick="handleClick('modificar')">Modificar</a></li>
              <li><a class="dropdown-item" href="eliminar.php?type=clientes" id="eliminar-reserva-link" onclick="handleClick('eliminar')">Eliminar</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Comentarios
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="eliminar.php?type=comentarios" id="eliminar-reserva-link" onclick="handleClick('eliminar')">Eliminar</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </div>
</nav>   
</header>

<h2>Agregar Reserva</h2>
<div class="container">
<form method="post" action="agregar_reserva.php" class="form">
    <div class="Group">
        <label for="id_habitacion" class="form-label">ID de Habitación:</label>
        <input type="text" id="id_habitacion" name="id_habitacion" class="form-control" required>
    </div>

    <div class="Group">
        <label for="id_cliente" class="form-label">ID de Cliente:</label>
        <input type="text" id="id_cliente" name="id_cliente" class="form-control" required>
    </div>

    <div class="Group">
        <label for="fecha_checkin" class="form-label">Fecha de Check-in:</label>
        <input type="datetime-local" id="fecha_checkin" name="fecha_checkin" class="form-control" required>
    </div>

    <div class="Group">
        <label for="fecha_checkout" class="form-label">Fecha de Check-out:</label>
        <input type="datetime-local" id="fecha_checkout" name="fecha_checkout" class="form-control" required>
    </div>

    <div class="Group">
        <label for="estado_reserva" class="form-label">Estado de Reserva:</label>
        <input type="text" id="estado_reserva" name="estado_reserva" class="form-control">
    </div>
    
    <button type="submit" class="btn btn-primary">Agregar Reserva</button>
</form>

</div>
    
    <table>
    <thead>
        <tr>
        <th> # </th>
        <th>Nombre de Producto</th>
        <th>Precio unitario</th>
        <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td> 1 </td>
        <td>Refresco de Limón</td>
        <td> $12 </td>
        <td> 2 </td>
        </tr>
        <tr>
        <td> 2 </td>
        <td>Refresco de Toronja</td>
        <td> $11 </td>
        <td> 3 </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
        <td colspan="2"> Totales</td>
        <td class="PrecioTotal"> $23 </td>
        <td class="CantidadTotal"> 5 </td>
        </tr>
    </tfoot>
    </table>
</body>
</html>

<?php
// Verificar si se ha enviado el formulario de reserva
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recibir los datos del formulario
    $id_habitacion = $_POST['id_habitacion'];
    $id_cliente = $_POST['id_cliente'];
    $fecha_checkin = $_POST['fecha_checkin'];
    $fecha_checkout = $_POST['fecha_checkout'];
    $estado_reserva = $_POST['estado_reserva'];

    // Insertar los datos en la tabla reserva
    $sql = "INSERT INTO reserva (ID_HABITACION, ID_CLIENTE, FECHACHECKIN, FECHACHECKOUT, ESTADORESERVA) VALUES ('$id_habitacion', '$id_cliente', '$fecha_checkin', '$fecha_checkout', '$estado_reserva')";
    if ($conn->query($sql) === TRUE) {
        echo "Reserva agregada exitosamente.";
    } else {
        echo "Error al agregar reserva: " . $conn->error;
    }

    
}
?>
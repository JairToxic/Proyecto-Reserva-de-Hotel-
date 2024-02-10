<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio CRUD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        #message {
            margin-top: 50px;
            font-size: 24px;
        }
        .crud-button {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
        #crud-actions {
            display: none;
        }
        .crud-action-button {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #008CBA;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
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
</head>
<body>
    <h1>Inicio CRUD</h1>
    <button id="reserva" class="crud-button" onclick="handleClick('reserva')">Reserva</button>
    <button id="habitacion" class="crud-button" onclick="handleClick('habitacion')">Habitación</button>
    <button id="clientes" class="crud-button" onclick="handleClick('clientes')">Clientes</button>
    <button id="comentarios" class="crud-button" onclick="handleClick('comentarios')">Comentarios</button>

    <div id="crud-actions" style="display: none;">
        <button id="agregar-button" class="crud-action-button" onclick="redirectToAction('agregar')">Agregar</button>
        <button id="modificar-button" class="crud-action-button" onclick="redirectToAction('modificar')">Modificar</button>
        <button id="eliminar-button" class="crud-action-button" onclick="redirectToAction('eliminar')">Eliminar</button>
    </div>
</body>
</html>

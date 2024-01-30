<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Copo de Nieve</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (necesario para Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JavaScript (requiere jQuery) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <!--CABECERA-->
    <header id="header">
         <nav id="menu">
            <ul>
                <li><a href="#">HOTEL</a></li>
                <li><a href="#">SOBRE NOSOTROS</a></li>
                <li><a href="#">CONTACTANOS</a></li>
                <li><a href="#">GALERIA DE FOTOS</a></li>
                <li><a href="#">COMENTARIOS</a></li>
            </ul>
         </nav>
       </div>
    </header>
     <!--Fin de cabecera-->
    <br><br><br><br>
    <section id="noticias">
        <h2>Comentarios</h2>
        <div class="clearfix"></div>
    </section>
            
    <!--formulario
    <div id="formulario">
    <form id="formulario1">
        <h5>Agrega opinión del Hotel Copo de Nieve</h5>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario" rows="4" required></textarea>

        <label for="habitacion">Habitación:</label>
        <select id="habitacion" name="habitacion" required>
            <option value="habitacion_doble">Habitación Doble</option>
            <option value="habitacion_cuadruple">Habitación Cuádruple</option>
            <option value="habitacion_familiar">Habitación Familiar</option>
            <option value="cabana">Cabaña</option>
        </select>

        <label for="pais">País:</label>
        <input type="text" id="pais" name="pais" required>

        <label for="puntuacion">Puntuación:</label>
        <input type="number" id="puntuacion" name="puntuacion" min="1" max="10" required>

        <button type="submit">Enviar</button>
    </form>
    </div>-->
        <div class="output-container">
        <div class="comment-form-container">
        <form id="frm-comment">
            <div class="input-row">
                <input type="hidden" name="comment_id" id="commentId" placeholder="Name" /> 
                <input class="form-control" type="text" name="name" id="name" placeholder="Nombres" />
            </div>

                <div class="form-group">
                    <textarea class="form-control" type="text" name="comment" id="comment" placeholder="Agregue su mensaje" required></textarea>
                </div>

                <div class="form-group">
                    <input type="button" class="btn btn-primary" id="submitButton" value="Agregar Comentario" />
                    <div id="comment-message">Comentario creado con éxito!</div>
                </div>
            </form>
        </div>
    </div>
    <!--Inicio pie de pagina-->
<div class="clearfix"></div>
<footer id="footer">
    <div class="wrap">
        <div id="info">
            <h5>Contactanos: </h5>
            <p>
                ¡Pregúntenos cualquier cosa! Estamos aquí para responder cualquier pregunta que tengas.
                <br><br><br>
                    Correo electrónico: info@mysite.com
                    <br>
                    <br>
                    <br>
                    Copyright &copy; 2024 HOTEL COPO DE NIEVE
            </p>
        </div>
        <div id="info">
            <h5>Siguenos en</h5>
            <p>
                <a href="#" class="icon">f</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" class="icon">t</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" class="icon">@</a>
                
            </p>
        </div>
        <div id="contact-form">
            <h5>Suscribete</h5>
            <fform action="" method="post">

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>

                <button type="submit">Suscribe</button>
            </form>
        </div>
    </div>
</footer>

    <script>
    // Maneja el evento click del botón "Agregar Comentario"
    $("#submitButton").click(function () {
        $("#comment-message").css('display', 'none'); // Oculta el mensaje de comentario creado con éxito (si está visible)
        var str = $("#frm-comment").serialize(); // Serializa los datos del formulario en formato de cadena para enviarlos

        // Envía los datos del formulario al script "AgregarComentario.php" utilizando AJAX
        $.ajax({
            url: "agregar_comentario.php", // URL del script PHP que procesará el formulario
            data: str, // Datos del formulario serializados
            type: 'post', // Método de envío (POST)
            success: function (response) // Función a ejecutar cuando la solicitud AJAX es exitosa
            {
                console.log("Respuesta del servidor:", response);
                // Verifica la respuesta del servidor
                if (response.trim() == 'success') {
                    $("#comment-message").css('display', 'inline-block').html('Comentario creado con éxito!'); // Muestra el mensaje de comentario creado con éxito
                    $("#name").val(""); // Limpia el campo de nombre
                    $("#comment").val(""); // Limpia el campo de comentario
                    $("#commentId").val(""); // Limpia el campo oculto de ID de comentario

                      // Redirigir a comentarios.php después de 2 segundos
                    setTimeout(function() {
                        window.location.href = "comentarios.php";
                    }, 2000);

                } else {
                    // Maneja el caso en el que ocurrió un error al agregar el comentario
                    $("#comment-message").css('display', 'inline-block').html('Comentario creado con éxito!');
                    $("#name").val(""); // Limpia el campo de nombre
                    $("#comment").val(""); // Limpia el campo de comentario
                    $("#commentId").val(""); // Limpia el campo oculto de ID de comentario

                      // Redirigir a comentarios.php después de 2 segundos
                    setTimeout(function() {
                        window.location.href = "comentarios.php";
                    }, 2000);
                }
            },
            error: function () // Función a ejecutar si hay un error en la solicitud AJAX
            {
                // Maneja el caso en el que ocurrió un error de comunicación con el servidor
                $("#comment-message").css('display', 'inline-block').html('Hubo un error de comunicación con el servidor. Por favor, inténtalo de nuevo más tarde.');
            }
        });
    });
</script>
</body>
</html>
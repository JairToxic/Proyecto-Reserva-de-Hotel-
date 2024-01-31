<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Copo de Nieve</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="../Front/styles/comentarios.css">
    
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
                <br><br><br>
                <div id="puntuacion-container">
                    Puntuación:
                    <span class="estrella">&#9733;</span>
                    <span class="estrella">&#9733;</span>
                    <span class="estrella">&#9733;</span>
                    <span class="estrella">&#9734;</span>
                    <span class="estrella">&#9734;</span>
                </div>
                <br><br><br>

                <!-- Mostrar Comentarios -->
                <div id="comentarios-container"></div>
            </section>
            
               <!-- Botón para agregar opinión -->
        <div id="agregar-opinion">
            <button onclick="redirigirAFormulario()">Agrega Comentario</button>
        </div>
<!--Fin contenido-->

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   
function listComment() {
$.post("lista_comentarios.php",
function (data) {
	var data = JSON.parse(data);

	var comments = "";
	var replies = "";
	var item = "";
	var parent = -1;
	var results = new Array();

	var list = $("<ul class='outer-comment'>");
	var item = $("<li>").html(comments);

	for (var i = 0; (i < data.length); i++)
	{
		var commentId = data[i]['co_id'];
		parent = data[i]['parent_id'];

		if (parent == "0")
		{
			comments =  "<div class='comment-row' >"+
            "<div class='comment-info'><img src='../Front/imagenes/user.png'><span class='posted-by'>" + data[i]['comentario_nombre'].toUpperCase() + "</span></div>" + 
            "<div class='comment-text' style='font-size: 18px;'>" + data[i]['comentarios'] + "</div>"+
            "</div>";

			var item = $("<li>").html(comments);
			list.append(item);
			var reply_list = $("<ul>");
			item.append(reply_list);
			listReplies(commentId, data, reply_list);
		}
	}
	$("#comentarios-container").html(list)
});
}
function listReplies(commentId, data, list) {

for (var i = 0; (i < data.length); i++)
{
    if (commentId == data[i].parent_id)
    {
        var comments = "<div class='comment-row' >"+
        " <div class='comment-info'><../Front/imagenes/user.png'><span class='posted-by'>" + data[i]['comentario_nombre'].toUpperCase() + " </span></div>" + 
        "<div class='comment-text'>" + data[i]['comentarios'] + "</div>"+
        "</div>";
        var item = $("<li>").html(comments);
        var reply_list = $("<ul class='outer-comment' style='list-style: none;'>");
        list.append(item);
        item.append(reply_list);
        listReplies(data[i].co_id, data, reply_list);

    }
}
}

document.addEventListener("DOMContentLoaded", function() {
        listComment();
});
function redirigirAFormulario() {
        window.location.href = 'formulario.php';
    }
</script>

</body>
</html>
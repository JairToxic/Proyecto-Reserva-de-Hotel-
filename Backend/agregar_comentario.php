<?php
require_once("dbconnect.php");

// Verifica si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si los campos obligatorios están vacíos
    if (empty($_POST["name"]) || empty($_POST["comment"])) {
        // Si alguno de los campos está vacío, devuelve un mensaje de error
        echo "error";
    } else {
        // Verifica si el nombre y el comentario contienen solo letras
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"]) || !preg_match("/^[a-zA-Z0-9,.!? ]*$/", $_POST["comment"])) {
            // Si alguno de los campos contiene caracteres no permitidos, devuelve un mensaje de error
            echo "error";
        } else {
            // Todos los campos están completos y contienen solo letras, procede con la inserción del comentario
            $commentId = isset($_POST['comment_id']) ? $_POST['comment_id'] : "";
            $comment = isset($_POST['comment']) ? $_POST['comment'] : "";
            $commentSenderName = isset($_POST['name']) ? $_POST['name'] : "";
            $date = date('Y-m-d H:i:s');
            $stars = isset($_POST['stars']) ? $_POST['stars'] : "";

            $query = "INSERT INTO comentarios(parent_id, comentarios, comentario_nombre, fecha, stars) VALUES (?, ?, ?, ?, ?)";
            $sql_stmt = $conn->prepare($query);

            $param_type = "dsssi";
            $param_value_array = array(
                $commentId,
                $comment,
                $commentSenderName,
                $date,
                $stars
            );

            $param_value_reference[] = & $param_type;
            for ($i = 0; $i < count($param_value_array); $i ++) {
                $param_value_reference[] = & $param_value_array[$i];
            }

            call_user_func_array(array(
                $sql_stmt,
                'bind_param'
            ), $param_value_reference);

            $sql_stmt->execute();

            if ($sql_stmt->error) {
                echo "Error al ejecutar la consulta: " . $sql_stmt->error;
            } else {
                echo "success";
            }
        }
    }
} else {
    // Si no se enviaron los datos del formulario, devuelve un mensaje de error
    echo "error";
}
?>

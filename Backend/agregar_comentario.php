<?php
require_once ("dbconnect.php");

$commentId = isset($_POST['comment_id']) ? $_POST['comment_id'] : "";
$comment = isset($_POST['comment']) ? $_POST['comment'] : "";
$commentSenderName = isset($_POST['name']) ? $_POST['name'] : "";
$date = date('Y-m-d H:i:s');
$stars = isset($_POST['stars']) ? $_POST['stars'] : ""; // Recupera el valor de las estrellas

$query = "INSERT INTO comentarios(parent_id, comentarios, comentario_nombre, fecha, stars) VALUES (?, ?, ?, ?, ?)";

$sql_stmt = $conn->prepare($query);

$param_type = "dsssi"; // Ajusta los tipos de parámetros según sea necesario
$param_value_array = array(
    $commentId,
    $comment,
    $commentSenderName,
    $date,
    $stars // Incluye el valor de las estrellas en el array de valores de parámetros
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
    echo "Comentario agregado con éxito!";
}

?>

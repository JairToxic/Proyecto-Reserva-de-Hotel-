<?php
// Obtener el nombre del botón seleccionado de la URL
if (isset($_GET['type'])) {
    $tipoEntidad = $_GET['type'];

    // Realizar acciones según el tipo de entidad (reserva, habitacion, cabaña, comentarios)
    switch ($tipoEntidad) {
        case 'reserva':
            // HTML para modificar una reserva
            echo '<h3>Modificar Reserva</h3>';
            echo '<form id="modificar-reserva-form" method="post">
                    <label for="reserva-id">ID de la reserva:</label>
                    <input type="text" id="reserva-id" name="reserva-id"><br>
                    
                    <label for="nombre-columna">Nombre de la columna:</label>
                    <input type="text" id="nombre-columna" name="nombre-columna"><br>
            
                    <label for="dato-cambiar">Dato a cambiar:</label>
                    <input type="text" id="dato-cambiar" name="dato-cambiar"><br>
            
                    <input type="submit" name="submit" value="Modificar Reserva">
                </form>';
        
            // Procesamiento de datos si se envió el formulario
            if (isset($_POST['submit'])) {
                // Aquí colocas el código PHP para procesar los datos del formulario
                // Por ejemplo, puedes obtener los valores enviados desde el formulario utilizando $_POST y luego ejecutar una consulta SQL para modificar la reserva en la base de datos
                $reservaId = $_POST['reserva-id'];
                $nombreColumna = $_POST['nombre-columna'];
                $datoCambiar = $_POST['dato-cambiar'];
        
                // Ejemplo de consulta SQL para actualizar los datos de la reserva
                $sql = "UPDATE RESERVA SET $nombreColumna = '$datoCambiar' WHERE ID_RESERVA = $reservaId";
                // Ejecutar la consulta SQL y manejar cualquier error si es necesario
            }
            break;
        
            case 'habitacion':
                // HTML para modificar una habitación
                echo '<h3>Modificar Habitación</h3>';
                echo '<form id="modificar-habitacion-form" method="post">
                        <label for="habitacion-id">ID de la habitación:</label>
                        <input type="text" id="habitacion-id" name="habitacion-id"><br>
                        
                        <label for="nombre-columna">Nombre de la columna:</label>
                        <input type="text" id="nombre-columna" name="nombre-columna"><br>
                
                        <label for="dato-cambiar">Dato a cambiar:</label>
                        <input type="text" id="dato-cambiar" name="dato-cambiar"><br>
                
                        <input type="submit" name="submit" value="Modificar Habitación">
                    </form>';
            
                // Procesamiento de datos si se envió el formulario
                if (isset($_POST['submit'])) {
                    // Aquí colocas el código PHP para procesar los datos del formulario
                    // Por ejemplo, puedes obtener los valores enviados desde el formulario utilizando $_POST y luego ejecutar una consulta SQL para modificar la habitación en la base de datos
                    $habitacionId = $_POST['habitacion-id'];
                    $nombreColumna = $_POST['nombre-columna'];
                    $datoCambiar = $_POST['dato-cambiar'];
            
                    // Ejemplo de consulta SQL para actualizar los datos de la habitación
                    $sql = "UPDATE HABITACIONES SET $nombreColumna = '$datoCambiar' WHERE ID_HABITACION = $habitacionId";
                    // Ejecutar la consulta SQL y manejar cualquier error si es necesario
                }
                break;
            
                case 'cabana':
                    // HTML para modificar una cabaña
                    echo '<h3>Modificar Cabaña</h3>';
                    echo '<form id="modificar-cabana-form" method="post">
                            <label for="cabana-id">ID de la cabaña:</label>
                            <input type="text" id="cabana-id" name="cabana-id"><br>
                            
                            <label for="nombre-columna">Nombre de la columna:</label>
                            <input type="text" id="nombre-columna" name="nombre-columna"><br>
                    
                            <label for="dato-cambiar">Dato a cambiar:</label>
                            <input type="text" id="dato-cambiar" name="dato-cambiar"><br>
                    
                            <input type="submit" name="submit" value="Modificar Cabaña">
                        </form>';
                
                    // Procesamiento de datos si se envió el formulario
                    if (isset($_POST['submit'])) {
                        // Aquí colocas el código PHP para procesar los datos del formulario
                        // Por ejemplo, puedes obtener los valores enviados desde el formulario utilizando $_POST y luego ejecutar una consulta SQL para modificar la cabaña en la base de datos
                        $cabanaId = $_POST['cabana-id'];
                        $nombreColumna = $_POST['nombre-columna'];
                        $datoCambiar = $_POST['dato-cambiar'];
                
                        // Ejemplo de consulta SQL para actualizar los datos de la cabaña
                        $sql = "UPDATE CABANAS SET $nombreColumna = '$datoCambiar' WHERE ID_HABITACION2 = $cabanaId";
                        // Ejecutar la consulta SQL y manejar cualquier error si es necesario
                    }
                    break;
                
                    case 'comentarios':
                        // HTML para modificar comentarios
                        echo '<h3>Modificar Comentarios</h3>';
                        echo '<form id="modificar-comentarios-form" method="post">
                                <label for="comentario-id">ID del comentario:</label>
                                <input type="text" id="comentario-id" name="comentario-id"><br>
                                
                                <label for="nombre-columna">Nombre de la columna:</label>
                                <input type="text" id="nombre-columna" name="nombre-columna"><br>
                        
                                <label for="dato-cambiar">Dato a cambiar:</label>
                                <input type="text" id="dato-cambiar" name="dato-cambiar"><br>
                        
                                <input type="submit" name="submit" value="Modificar Comentarios">
                            </form>';
                    
                        // Procesamiento de datos si se envió el formulario
                        if (isset($_POST['submit'])) {
                            // Aquí colocas el código PHP para procesar los datos del formulario
                            // Por ejemplo, puedes obtener los valores enviados desde el formulario utilizando $_POST y luego ejecutar una consulta SQL para modificar los comentarios en la base de datos
                            $comentarioId = $_POST['comentario-id'];
                            $nombreColumna = $_POST['nombre-columna'];
                            $datoCambiar = $_POST['dato-cambiar'];
                    
                            // Ejemplo de consulta SQL para actualizar los datos de los comentarios
                            $sql = "UPDATE COMENTARIOS SET $nombreColumna = '$datoCambiar' WHERE ID_COMENTARIO = $comentarioId";
                            // Ejecutar la consulta SQL y manejar cualquier error si es necesario
                        }
                        break;
                    
        default:
            // Tipo de entidad no válido
            echo "Error: Tipo de entidad no válido.";
            break;
    }

} else {
    // Tipo de entidad no especificado en la URL
    echo "Error: Tipo de entidad no especificado.";
}
?>

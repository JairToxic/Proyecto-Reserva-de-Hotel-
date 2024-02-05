<?php
// Obtener el nombre del botón seleccionado de la URL
if (isset($_GET['type'])) {
    $tipoEntidad = $_GET['type'];

    // Realizar acciones según el tipo de entidad (reserva, habitacion, cabaña, comentarios)
    switch ($tipoEntidad) {
        case 'reserva':
            // HTML para eliminar una reserva
            echo '<h3>Eliminar Reserva</h3>';
            echo '<form id="eliminar-reserva-form" method="post">
                    <label for="reserva-id">ID de la reserva:</label>
                    <input type="text" id="reserva-id" name="reserva-id"><br>
                    <input type="submit" name="submit" value="Eliminar Reserva">
                </form>';
        
            // Procesamiento de datos si se envió el formulario
            if (isset($_POST['submit'])) {
                // Aquí colocas el código PHP para procesar los datos del formulario
                // Por ejemplo, puedes obtener el ID de la reserva a eliminar desde el formulario y luego ejecutar una consulta SQL para eliminar la reserva correspondiente en la base de datos
                $reservaId = $_POST['reserva-id'];
        
                // Ejemplo de consulta SQL para eliminar una reserva
                $sql = "DELETE FROM RESERVA WHERE ID_RESERVA = $reservaId";
                // Ejecutar la consulta SQL y manejar cualquier error si es necesario
            }
            break;
        
            case 'habitacion':
                // HTML para eliminar una habitación
                echo '<h3>Eliminar Habitación</h3>';
                echo '<form id="eliminar-habitacion-form" method="post">
                        <label for="habitacion-id">ID de la habitación:</label>
                        <input type="text" id="habitacion-id" name="habitacion-id"><br>
                        <input type="submit" name="submit" value="Eliminar Habitación">
                    </form>';
            
                // Procesamiento de datos si se envió el formulario
                if (isset($_POST['submit'])) {
                    // Aquí colocas el código PHP para procesar los datos del formulario
                    // Por ejemplo, puedes obtener el ID de la habitación a eliminar desde el formulario y luego ejecutar una consulta SQL para eliminar la habitación correspondiente en la base de datos
                    $habitacionId = $_POST['habitacion-id'];
            
                    // Ejemplo de consulta SQL para eliminar una habitación
                    $sql = "DELETE FROM HABITACIONES WHERE ID_HABITACION = $habitacionId";
                    // Ejecutar la consulta SQL y manejar cualquier error si es necesario
                }
                break;
            
                case 'cabana':
                    // HTML para eliminar una cabaña
                    echo '<h3>Eliminar Cabaña</h3>';
                    echo '<form id="eliminar-cabana-form" method="post">
                            <label for="cabana-id">ID de la cabaña:</label>
                            <input type="text" id="cabana-id" name="cabana-id"><br>
                            <input type="submit" name="submit" value="Eliminar Cabaña">
                        </form>';
                
                    // Procesamiento de datos si se envió el formulario
                    if (isset($_POST['submit'])) {
                        // Aquí colocas el código PHP para procesar los datos del formulario
                        // Por ejemplo, puedes obtener el ID de la cabaña a eliminar desde el formulario y luego ejecutar una consulta SQL para eliminar la cabaña correspondiente en la base de datos
                        $cabanaId = $_POST['cabana-id'];
                
                        // Ejemplo de consulta SQL para eliminar una cabaña
                        $sql = "DELETE FROM CABANAS WHERE ID_HABITACION2 = $cabanaId";
                        // Ejecutar la consulta SQL y manejar cualquier error si es necesario
                    }
                    break;
                
                    case 'comentarios':
                        // HTML para eliminar comentarios
                        echo '<h3>Eliminar Comentarios</h3>';
                        echo '<form id="eliminar-comentarios-form" method="post">
                                <label for="comentario-id">ID del comentario:</label>
                                <input type="text" id="comentario-id" name="comentario-id"><br>
                                <input type="submit" name="submit" value="Eliminar Comentarios">
                            </form>';
                    
                        // Procesamiento de datos si se envió el formulario
                        if (isset($_POST['submit'])) {
                            // Aquí colocas el código PHP para procesar los datos del formulario
                            // Por ejemplo, puedes obtener el ID del comentario a eliminar desde el formulario y luego ejecutar una consulta SQL para eliminar el comentario correspondiente en la base de datos
                            $comentarioId = $_POST['comentario-id'];
                    
                            // Ejemplo de consulta SQL para eliminar comentarios
                            $sql = "DELETE FROM COMENTARIOS WHERE ID_COMENTARIO = $comentarioId";
                            // Ejecutar la consulta SQL y manejar cualquier error si es necesario
                        }
                        break;
                    
        default:
            // Tipo de entidad no válido
            break;
    }

    // Ejemplo de cómo mostrar el tipo de entidad en la página
    echo "Eliminar $tipoEntidad";
} else {
    // Tipo de entidad no especificado en la URL
    echo "Error: Tipo de entidad no especificado.";
}
?>

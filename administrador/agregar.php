<?php
// Obtener el nombre del botón seleccionado de la URL
if (isset($_GET['type'])) {
    $tipoEntidad = $_GET['type'];

    // Realizar acciones según el tipo de entidad (reserva, habitacion, cabaña, comentarios)
    switch ($tipoEntidad) {
        case 'reserva':
            // Formulario para agregar una reserva
            echo '
            <h3>Agregar Reserva</h3>
            <form action="agregar.php?type=reserva" method="post">
                <label for="detalle_persona">Detalle Persona:</label>
                <input type="text" id="detalle_persona" name="detalle_persona"><br>
                
                <label for="id_pago">ID Pago:</label>
                <input type="text" id="id_pago" name="id_pago"><br>
        
                <label for="id_cliente">ID Cliente:</label>
                <input type="text" id="id_cliente" name="id_cliente"><br>
        
                <label for="fecha_checkin">Fecha Check-in:</label>
                <input type="text" id="fecha_checkin" name="fecha_checkin"><br>
        
                <label for="fecha_checkout">Fecha Check-out:</label>
                <input type="text" id="fecha_checkout" name="fecha_checkout"><br>
        
                <label for="estado_reserva">Estado Reserva:</label>
                <input type="text" id="estado_reserva" name="estado_reserva"><br>
        
                <!-- Agregar más campos de texto según las columnas de la tabla RESERVA -->
        
                <input type="submit" value="Agregar Reserva">
            </form>';
            break;
        
            case 'habitacion':
                // Formulario para agregar una habitación
                echo '
                <h3>Agregar Habitación</h3>
                <form action="agregar.php?type=habitacion" method="post">
                    <label for="tipo_habitacion">Tipo:</label>
                    <input type="text" id="tipo_habitacion" name="tipo_habitacion"><br>
                    
                    <label for="descripcion_habitacion">Descripción:</label>
                    <input type="text" id="descripcion_habitacion" name="descripcion_habitacion"><br>
            
                    <label for="precio_por_noche_habitacion">Precio por Noche:</label>
                    <input type="text" id="precio_por_noche_habitacion" name="precio_por_noche_habitacion"><br>
            
                    <label for="capacidad_habitacion">Capacidad:</label>
                    <input type="text" id="capacidad_habitacion" name="capacidad_habitacion"><br>
            
                    <label for="camas_habitacion">Camas:</label>
                    <input type="text" id="camas_habitacion" name="camas_habitacion"><br>
            
                    <label for="bano_habitacion">Baño:</label>
                    <input type="text" id="bano_habitacion" name="bano_habitacion"><br>
            
                    <!-- Agregar más campos de texto según las columnas de la tabla HABITACIONES -->
            
                    <input type="submit" value="Agregar Habitación">
                </form>';
                break;
            
                case 'cabana':
                    // Formulario para agregar una cabaña
                    echo '
                    <h3>Agregar Cabaña</h3>
                    <form action="agregar.php?type=cabana" method="post">
                        <label for="descripcion_cabana">Descripción:</label>
                        <input type="text" id="descripcion_cabana" name="descripcion_cabana"><br>
                        
                        <label for="precio_por_noche_cabana">Precio por Noche:</label>
                        <input type="text" id="precio_por_noche_cabana" name="precio_por_noche_cabana"><br>
                
                        <label for="capacidad_cabana">Capacidad:</label>
                        <input type="text" id="capacidad_cabana" name="capacidad_cabana"><br>
                
                        <label for="camas_cabana">Camas:</label>
                        <input type="text" id="camas_cabana" name="camas_cabana"><br>
                
                        <label for="bano_cabana">Baño:</label>
                        <input type="text" id="bano_cabana" name="bano_cabana"><br>
                
                        <!-- Agregar más campos de texto según las columnas de la tabla CABANAS -->
                
                        <input type="submit" value="Agregar Cabaña">
                    </form>';
                    break;
                
                    case 'comentarios':
                        // Formulario para agregar comentarios
                        echo '
                        <h3>Agregar Comentario</h3>
                        <form action="agregar.php?type=comentarios" method="post">
                            <label for="id_habitacion2_comentario">ID Habitación2:</label>
                            <input type="text" id="id_habitacion2_comentario" name="id_habitacion2_comentario"><br>
                            
                            <label for="id_cliente_comentario">ID Cliente:</label>
                            <input type="text" id="id_cliente_comentario" name="id_cliente_comentario"><br>
                    
                            <label for="id_habitacion_comentario">ID Habitación:</label>
                            <input type="text" id="id_habitacion_comentario" name="id_habitacion_comentario"><br>
                    
                            <label for="calificacion_comentario">Calificación:</label>
                            <input type="text" id="calificacion_comentario" name="calificacion_comentario"><br>
                    
                            <label for="comentario_comentario">Comentario:</label>
                            <input type="text" id="comentario_comentario" name="comentario_comentario"><br>
                    
                            <!-- Agregar más campos de texto según las columnas de la tabla COMENTARIOS -->
                    
                            <input type="submit" value="Agregar Comentario">
                        </form>';
                        break;
                    
        default:
            // Tipo de entidad no válido
            echo 'No existe la tabla';
            break;
    }

    // Ejemplo de cómo mostrar el tipo de entidad en la página
    echo "Agregar nueva $tipoEntidad";
} else {
    // Tipo de entidad no especificado en la URL
    echo "Error: Tipo de entidad no especificado.";
}
?>

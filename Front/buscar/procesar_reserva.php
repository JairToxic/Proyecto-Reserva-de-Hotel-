<?php
function obtenerHabitacionesDisponibles($checkIn, $checkOut, $numGuests) {
    // Configura tu conexión a la base de datos
    $host = "localhost";
    $dbname = "hotel";
    $usuario = "root";
    $contraseña = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $contraseña);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Utilizamos un LEFT JOIN para comparar las fechas de reserva correctamente
        $sql = "SELECT h.ID_HABITACION
                FROM habitaciones h
                LEFT JOIN reservas r ON h.ID_HABITACION = r.ID_HABITACION
                WHERE h.CAPACIDAD >= :numGuests
                AND (
                    (r.CHECK_IN IS NULL AND r.CHECK_OUT IS NULL)
                    OR NOT (
                        :checkIn < r.CHECK_IN AND :checkOut < r.CHECK_IN
                        OR :checkIn > r.CHECK_OUT AND :checkOut > r.CHECK_OUT
                    )
                )";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':checkIn', $checkIn);
        $stmt->bindParam(':checkOut', $checkOut);
        $stmt->bindParam(':numGuests', $numGuests);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>

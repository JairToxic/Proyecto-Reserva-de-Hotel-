<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserva de Habitaciones</title>
  <link rel="stylesheet" href="styles.css">
  <script src="script.js"></script>
</head>
<body onload="initializePage()">

<div class="container">
  <form id="reservationForm" method="post" action="procesar_reserva.php">
    <label for="checkIn">Check-in:</label>
    <input type="date" id="checkIn" name="checkIn" required>

    <label for="checkOut">Check-out:</label>
    <input type="date" id="checkOut" name="checkOut" required>

    <label for="numGuests">Número de Huéspedes:</label>
    <select id="numGuests" name="numGuests" required>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <!-- Agrega más opciones según sea necesario -->
    </select>

    <div id="roomsContainer" style="display: none;">
      <!-- Contenido de las habitaciones se agrega dinámicamente con JavaScript -->
    </div>

    <!-- Botón de envío con nombre específico para identificarlo en el procesamiento -->
    <button type="submit" name="submitReservation" value="submit">Reservar</button>
  </form>
</div>

<script src="script.js"></script>
</body>
</html>

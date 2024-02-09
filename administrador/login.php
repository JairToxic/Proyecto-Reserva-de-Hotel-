<?php
include '../basedatos/basedatos.php';

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta SQL para validar las credenciales
$sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // Credenciales válidas, redirigir o realizar otras acciones necesarias
    header("Location: inicioCRUD.php");
    exit;
} else {
    // Credenciales inválidas, mostrar mensaje de error
    echo "Credenciales inválidas. Intenta de nuevo.";
}

// Cerrar la conexión
$conn->close();
?>

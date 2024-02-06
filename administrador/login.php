<?php
// Conexión a la base de datos (asegúrate de llenar los valores correctos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta SQL para validar las credenciales
$sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Credenciales válidas, redirigir a la página de éxito
    header("Location: admin_habitaciones.php");
    exit(); // Asegura que no se ejecute más código después de la redirección
} else {
    // Credenciales inválidas, mostrar mensaje de error
    echo "Credenciales inválidas. Intenta de nuevo.";
}

// Cerrar la conexión
$conn->close();
?>

<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // Cambiar a localhost

$username = "root";
$password = ""; // Sin contraseña en XAMPP por defecto
$dbname = "gestionsuscripciones";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Error de conexión a la base de datos: " . $conn->connect_error]));
}

// Verificar si se envió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Evitar inyección SQL
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Consultar en la base de datos
    $sql = "SELECT * FROM Recepcionista WHERE Username = '$username' AND Contrasenia = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso
        echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso"]);
    } else {
        // Usuario o contraseña incorrectos
        echo json_encode(["status" => "error", "message" => "Usuario o contraseña incorrectos"]);
    }
    exit;
}

// Cerrar conexión
$conn->close();
?>

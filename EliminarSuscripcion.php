<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Contraseña predeterminada de XAMPP
$dbname = "gestionsuscripciones";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se recibió el ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Asegurarse de que el ID sea un número entero

    // Verificar que el ID sea válido
    if ($id > 0) {
        // Preparar la consulta para eliminar
        $stmt = $conn->prepare("DELETE FROM Suscripciones WHERE SuscripcionID = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Suscripción eliminada correctamente.";
        } else {
            echo "Error al eliminar la suscripción: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "ID inválido.";
    }
} else {
    echo "No se recibió ningún ID.";
}

$conn->close();
?>

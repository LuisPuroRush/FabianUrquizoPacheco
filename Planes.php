<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionsuscripciones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT PlanID AS ID, Nombre, Descripcion, Megabytes, Precio FROM Planes";
$result = $conn->query($sql);

$planes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $planes[] = $row;
    }
}

// Devolver datos como JSON
echo json_encode($planes);
$conn->close();
?>

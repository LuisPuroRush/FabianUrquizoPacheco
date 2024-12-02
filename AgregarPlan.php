<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $megabytes = $_POST['megabytes'];
    $precio = $_POST['precio'];

    $conn = new mysqli("localhost", "root", "", "GestionSuscripciones");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO Planes (Nombre, Descripcion, Megabytes, Precio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdd", $nombre, $descripcion, $megabytes, $precio);

    if ($stmt->execute()) {
        echo "Plan agregado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

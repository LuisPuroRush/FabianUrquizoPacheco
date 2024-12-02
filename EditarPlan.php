<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $megabytes = $_POST['megabytes'];
    $precio = $_POST['precio'];

    $conn = new mysqli("localhost", "root", "", "GestionSuscripciones");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE Planes SET Nombre = ?, Descripcion = ?, Megabytes = ?, Precio = ? WHERE PlanID = ?");
    $stmt->bind_param("ssdsi", $nombre, $descripcion, $megabytes, $precio, $id);

    if ($stmt->execute()) {
        echo "Plan actualizado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

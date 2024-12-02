<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli("localhost", "root", "", "GestionSuscripciones");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM Planes WHERE PlanID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Plan eliminado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

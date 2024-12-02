<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($nombre && $email) {
        // Conexión a la base de datos
        $conn = new mysqli('localhost', 'root', '', 'tu_base_datos');

        if ($conn->connect_error) {
            die('Error en la conexión: ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('INSERT INTO clientes (nombre, email) VALUES (?, ?)');
        $stmt->bind_param('ss', $nombre, $email);

        if ($stmt->execute()) {
            echo 'Cliente agregado exitosamente.';
        } else {
            echo 'Error al agregar el cliente.';
        }

        $stmt->close();
        $conn->close();
    } else {
        echo 'Todos los campos son obligatorios.';
    }
} else {
    echo 'Método no permitido.';
}
?>

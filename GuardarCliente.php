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

// Verificar si los datos se enviaron correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir y limpiar datos del formulario
    $clienteID = isset($_POST['cliente-id']) && is_numeric($_POST['cliente-id']) ? intval($_POST['cliente-id']) : null;
    $dni = trim($_POST['dni'] ?? '');
    $nombres = trim($_POST['nombres'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');

    // Validar campos obligatorios
    if (empty($dni) || empty($nombres) || empty($apellidos) || empty($correo)) {
        echo json_encode(["status" => "error", "message" => "Por favor, completa todos los campos obligatorios."]);
    } else {
        if ($clienteID) {
            // Actualizar cliente existente
            $stmt = $conn->prepare("UPDATE Clientes SET Dni = ?, Nombres = ?, Apellidos = ?, Correo = ?, Direccion = ?, Telefono = ? WHERE ClienteID = ?");
            $stmt->bind_param("ssssssi", $dni, $nombres, $apellidos, $correo, $direccion, $telefono, $clienteID);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Cliente actualizado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar el cliente: " . $conn->error]);
            }
        } else {
            // Insertar un nuevo cliente
            $stmt = $conn->prepare("INSERT INTO Clientes (Dni, Nombres, Apellidos, Correo, Direccion, Telefono) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $dni, $nombres, $apellidos, $correo, $direccion, $telefono);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Cliente guardado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al guardar el cliente: " . $conn->error]);
            }
        }

        $stmt->close();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método de solicitud no permitido."]);
}

$conn->close();
?>

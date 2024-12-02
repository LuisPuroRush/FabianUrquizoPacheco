<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GestionSuscripciones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibiendo el cliente ID
$clienteID = isset($_POST['cliente-id']) ? $conn->real_escape_string($_POST['cliente-id']) : null;
$fechaCancelacion = date("Y-m-d");

// Validar que el ID no esté vacío
if (empty($clienteID)) {
    echo json_encode(["status" => "error", "message" => "Debe proporcionar un ID válido"]);
    exit;
}

// Validar si el cliente existe
$sql = "SELECT * FROM Clientes WHERE ClienteID = '$clienteID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cliente = $result->fetch_assoc();
    $dni = $conn->real_escape_string($cliente['Dni']);
    $nombres = $conn->real_escape_string($cliente['Nombres']);
    $apellidos = $conn->real_escape_string($cliente['Apellidos']);
    $correo = $conn->real_escape_string($cliente['Correo']);
    $direccion = $conn->real_escape_string($cliente['Direccion']);
    $telefono = $conn->real_escape_string($cliente['Telefono']);

    // Insertar los datos en la tabla de Cancelados
    $sqlInsert = "INSERT INTO Cancelados (Dni, Nombres, Apellidos, Correo, Direccion, Telefono, FechaCancelacion)
                  VALUES ('$dni', '$nombres', '$apellidos', '$correo', '$direccion', '$telefono', '$fechaCancelacion')";

    if ($conn->query($sqlInsert) === TRUE) {
        // Eliminar las suscripciones relacionadas del cliente
        $sqlDeleteSuscripcion = "DELETE FROM Suscripciones WHERE ClienteID = '$clienteID'";
        $conn->query($sqlDeleteSuscripcion);

        // Eliminar al cliente de la tabla original
        $sqlDelete = "DELETE FROM Clientes WHERE ClienteID = '$clienteID'";

        if ($conn->query($sqlDelete) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Cliente cancelado correctamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar el cliente de la tabla Clientes."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al mover el cliente a la tabla Cancelados."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Cliente no encontrado."]);
}

$conn->close();
?>

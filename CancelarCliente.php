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
$clienteID = $_POST['cliente-id'];
$fechaCancelacion = date("Y-m-d"); // Fecha actual

// Validar que el ID no esté vacío
if (empty($clienteID)) {
    echo json_encode(["status" => "error", "message" => "Debe proporcionar un ID válido"]);
    exit;
}

// Obtener los datos del cliente a cancelar
$sql = "SELECT * FROM Clientes WHERE ClienteID = '$clienteID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Transferir los datos a la tabla Cancelados
    $cliente = $result->fetch_assoc();
    $dni = $cliente['Dni'];
    $nombres = $cliente['Nombres'];
    $apellidos = $cliente['Apellidos'];
    $correo = $cliente['Correo'];
    $direccion = $cliente['Direccion'];
    $telefono = $cliente['Telefono'];

    // Insertar en la tabla Cancelados
    $sqlInsert = "INSERT INTO Cancelados (Dni, Nombres, Apellidos, Correo, Direccion, Telefono, FechaCancelacion) 
                  VALUES ('$dni', '$nombres', '$apellidos', '$correo', '$direccion', '$telefono', '$fechaCancelacion')";

    if ($conn->query($sqlInsert) === TRUE) {
        // Eliminar el cliente de la tabla Clientes
        $sqlDelete = "DELETE FROM Clientes WHERE ClienteID = '$clienteID'";

        if ($conn->query($sqlDelete) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Cliente cancelado y movido a la tabla de cancelados"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar el cliente"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al mover el cliente a la tabla Cancelados"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Cliente no encontrado"]);
}

$conn->close();
?>

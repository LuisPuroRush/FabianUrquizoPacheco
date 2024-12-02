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

// Recibiendo los datos del formulario
$dni = $_POST['dni'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

// Validar que los campos requeridos no estén vacíos
if (empty($dni) || empty($nombres) || empty($apellidos) || empty($correo) || empty($direccion) || empty($telefono)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios"]);
    exit;
}

// Verificar si el cliente ya existe por su DNI o correo
$sql = "SELECT ClienteID FROM Clientes WHERE Dni = '$dni' OR Correo = '$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "El cliente ya existe"]);
} else {
    // Si el cliente no existe, insertamos uno nuevo
    $sql = "INSERT INTO Clientes (Dni, Nombres, Apellidos, Correo, Direccion, Telefono) 
            VALUES ('$dni', '$nombres', '$apellidos', '$correo', '$direccion', '$telefono')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Cliente agregado exitosamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar cliente: " . $conn->error]);
    }
}

$conn->close();
?>

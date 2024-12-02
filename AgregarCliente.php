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
        // Obtener el ID del cliente recién insertado
        $cliente_id = $conn->insert_id;

        // Valores predeterminados para suscripciones
        $recepcionista_id = 1; // Cambia este valor según corresponda
        $plan_id = 1; // ID del plan predeterminado
        $descuento_id = 1; // ID del descuento predeterminado
        $meses = 1; // Cantidad de meses predeterminada
        $fecha_registro = date("Y-m-d H:i:s");

        // Insertar en la tabla Suscripciones
        $sql_suscripcion = "INSERT INTO Suscripciones (ClienteID, RecepcionistaID, PlanID, DescuentoID, CantidadMeses, FechaRegistro)
                            VALUES ('$cliente_id', '$recepcionista_id', '$plan_id', '$descuento_id', '$meses', '$fecha_registro')";

        if ($conn->query($sql_suscripcion) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Cliente y suscripción agregados exitosamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Cliente agregado, pero error al crear suscripción: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar cliente: " . $conn->error]);
    }
}

$conn->close();
?>

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

// Consulta de datos SOLO de la tabla Suscripciones
$sql = "SELECT SuscripcionID, ClienteID, RecepcionistaID, PlanID, DescuentoID, CantidadMeses, FechaRegistro FROM Suscripciones";

$result = $conn->query($sql);

// Generar tabla
if ($result->num_rows > 0) {
    echo '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left;">';
    echo '<tr>
            <th>ID</th>
            <th>Cliente ID</th>
            <th>Recepcionista ID</th>
            <th>Plan ID</th>
            <th>Descuento ID</th>
            <th>Meses</th>
            <th>Fecha de Registro</th>
          </tr>';

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['SuscripcionID']}</td>
                <td>{$row['ClienteID']}</td>
                <td>{$row['RecepcionistaID']}</td>
                <td>{$row['PlanID']}</td>
                <td>{$row['DescuentoID']}</td>
                <td>{$row['CantidadMeses']}</td>
                <td>{$row['FechaRegistro']}</td>
              </tr>";
    }

    echo '</table>';
} else {
    echo '<p>No hay suscripciones registradas.</p>';
}

$conn->close();
?>

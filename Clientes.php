<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "gestionsuscripciones";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$sql = "SELECT ClienteID, Dni, Nombres, Apellidos, Correo, Direccion, Telefono FROM clientes";

$result = $conn->query($sql);

// Generar tabla
if ($result->num_rows > 0) {
    echo '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left;">';
    echo '<tr>
            <th>ID</th>
            <th>DNI</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Teléfono</th>
          </tr>';

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ClienteID']}</td>
                <td>{$row['Dni']}</td>
                <td>{$row['Nombres']}</td>
                <td>{$row['Apellidos']}</td>
                <td>{$row['Correo']}</td>
                <td>{$row['Direccion']}</td>
                <td>{$row['Telefono']}</td>
              </tr>";
    }

    echo '</table>';
} else {
    echo '<p>No hay clientes registrados.</p>';
}

$conn->close();
?>

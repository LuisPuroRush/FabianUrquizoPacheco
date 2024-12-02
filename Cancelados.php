<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionsuscripciones";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los datos de la tabla "cancelados"
$sql = "SELECT CanceladoID, Dni, Nombres, Apellidos, Correo, Direccion, Telefono, FechaCancelacion FROM cancelados";

$result = $conn->query($sql);

// Generar tabla
if ($result->num_rows > 0) {
    echo '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left;">';
    echo '<tr>
            <th>ID Cancelado</th>
            <th>DNI</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Fecha de Cancelación</th>
          </tr>';

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['CanceladoID']}</td>
                <td>{$row['Dni']}</td>
                <td>{$row['Nombres']}</td>
                <td>{$row['Apellidos']}</td>
                <td>{$row['Correo']}</td>
                <td>{$row['Direccion']}</td>
                <td>{$row['Telefono']}</td>
                <td>{$row['FechaCancelacion']}</td>
              </tr>";
    }

    echo '</table>';
} else {
    echo '<p>No hay clientes cancelados registrados.</p>';
}

// Cerrar la conexión
$conn->close();
?>

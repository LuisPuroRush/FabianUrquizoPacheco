<?php
$servername = "localhost";
$username = "root"; // Cambiar si el usuario es otro
$password = ""; // Contraseña para el usuario (deja en blanco si no tienes)
$dbname = "gestionsuscripciones"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

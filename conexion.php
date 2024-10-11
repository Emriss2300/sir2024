<?php
$servername = "localhost";
$username = "Francisco1234";
$password = "1234";
$dbname = "productos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>


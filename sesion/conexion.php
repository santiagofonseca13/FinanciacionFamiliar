<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbHogar";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

//echo $conn->host_info;

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
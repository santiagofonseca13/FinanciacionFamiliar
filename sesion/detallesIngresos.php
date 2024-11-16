<?php
session_start();
include 'sesion/conexion.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../login.html");
    exit();
}

if (isset($_GET['monto-ingreso'], $_GET['fecha-ingreso'], $_GET['descripcion-ingreso'])) {
    // Recibimos los datos del ingreso
    $montoIngreso = $_GET['monto-ingreso'];
    $fechaIngreso = $_GET['fecha-ingreso'];
    $descripcionIngreso = $_GET['descripcion-ingreso'];
} else {
    echo "No se encontraron los detalles del ingreso.";
    exit();
}

$conn->close();
?>



<?php
session_start();
include 'conexion.php';

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $monto = $_POST['monto-ingreso'];
    $fecha = $_POST['fecha-ingreso'];
    $descripcion = $_POST['descripcion-ingreso'];
    $id_usuario = $_SESSION['id_usuario'];

    if ($monto > 0 && !empty($fecha) && !empty($descripcion)) {

        $stmt = $conn->prepare("INSERT INTO ingresos (monto_in, fecha_in, fuente_in, id_usuario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("dssi", $monto, $fecha, $descripcion, $id_usuario);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Ingreso agregado exitosamente.";
        } else {
            $_SESSION['message'] = "Error al agregar ingreso: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, complete todos los campos correctamente.";
    }
    
}

$conn->close();
header("Location: ../ingresosGastos.php");
?>
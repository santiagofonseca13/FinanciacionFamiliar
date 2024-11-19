<?php
session_start();
include 'conexion.php';

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $monto = $_POST['monto-gasto'];
    $fecha = $_POST['fecha-gasto'];
    $categoria = $_POST['categoria-gasto'];
    $id_usuario = $_SESSION['id_usuario'];

    if ($monto> 0 && !empty($fecha) && !empty($categoria)) {

        $consulta = $conn->prepare("INSERT INTO gastos (monto_ga, fecha_ga, id_categoria, id_usuario) VALUES (?, ?, ?, ?)");
        $consulta->bind_param("dssi", $monto, $fecha, $categoria, $id_usuario);

        if ($consulta->execute()) {
            $_SESSION['message'] = "Gasto agregado exitosamente.";
        } else {
            $_SESSION['message'] = "Error al agregar gasto: " . $consulta->error;
        }

        $consulta->close();
    } else {
        echo "Por favor, complete todos los campos correctamente.";
    }
    
}

$conn->close();
header("Location: ../ingresosGastos.php");
?>
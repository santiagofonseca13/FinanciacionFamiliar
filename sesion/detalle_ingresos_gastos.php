<?php
session_start();
include 'conexion.php';

// Revisa si el usuario está conectado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Asigna el ID de usuario a una variable
$usuario_id = $_SESSION['id_usuario'];

// Obtiene los ingresos del usuario
$ingresos_query = "SELECT monto_in AS monto, fecha_in AS fecha, fuente_in AS descripcion FROM ingresos WHERE id_usuario = $usuario_id";
$ingresos_result = mysqli_query($conn, $ingresos_query);

if (!$ingresos_result) {
    echo "Error en la consulta de ingresos: " . mysqli_error($conn);
    exit();
}

// Obtiene los gastos del usuario
$gastos_query = "SELECT monto_ga AS monto, fecha_ga AS fecha, id_categoria AS categoria FROM gastos WHERE id_usuario = $usuario_id";
$gastos_result = mysqli_query($conn, $gastos_query);

if (!$gastos_result) {
    echo "Error en la consulta de gastos: " . mysqli_error($conn);
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Ingresos y Gastos</title>
    <link rel="stylesheet" href="../css/detalles.css">   
</head>
<body>
    <h1>Detalles de Mis Ingresos y Gastos</h1>

    <h2 style="text-align:center;">Ingresos</h2>
    <table>
        <tr>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Descripción</th>
        </tr>
        <?php while ($ingreso = mysqli_fetch_assoc($ingresos_result)): ?>
            <tr>
                <td><?php echo $ingreso['monto']; ?></td>
                <td><?php echo $ingreso['fecha']; ?></td>
                <td><?php echo $ingreso['descripcion']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2 style="text-align:center;">Gastos</h2>
    <table>
        <tr>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Categoría</th>
        </tr>
        <?php while ($gasto = mysqli_fetch_assoc($gastos_result)): ?>
            <tr>
                <td><?php echo $gasto['monto']; ?></td>
                <td><?php echo $gasto['fecha']; ?></td>
                <td><?php echo $gasto['categoria']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    
</body>
</html>
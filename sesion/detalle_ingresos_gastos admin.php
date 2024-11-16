<?php
session_start();
include 'conexion.php';

// Revisa si el usuario está conectado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$usuario_id = $_SESSION['id_usuario'];
$rol_query = "SELECT rol FROM usuarios WHERE id_usuario = $usuario_id";
$rol_result = mysqli_query($conn, $rol_query);

if (!$rol_result) {
    echo "Error en la consulta del rol: " . mysqli_error($conn);
    exit();
}

$rol_data = mysqli_fetch_assoc($rol_result);
$rol_usuario = $rol_data['rol'];

// Condiciona las consultas según el rol
if ($rol_usuario == 'mama') {
    $ingresos_query = "SELECT monto_in AS monto, fecha_in AS fecha, fuente_in AS descripcion FROM ingresos WHERE id_usuario = $usuario_id";
    $gastos_query = "SELECT monto_ga AS monto, fecha_ga AS fecha, id_categoria AS categoria FROM gastos WHERE id_usuario = $usuario_id";
} else {
    $ingresos_query = "SELECT monto_in AS monto, fecha_in AS fecha, fuente_in AS descripcion FROM ingresos";
    $gastos_query = "SELECT monto_ga AS monto, fecha_ga AS fecha, id_categoria AS categoria FROM gastos";
}

// Obtiene los ingresos del usuario
$ingresos_result = mysqli_query($conn, $ingresos_query);
if (!$ingresos_result) {
    echo "Error en la consulta de ingresos: " . mysqli_error($conn);
    exit();
}

// Muestra los ingresos obtenidos
$ingresos_data = mysqli_fetch_all($ingresos_result, MYSQLI_ASSOC);

// Si no hay ingresos, puedes insertar datos de prueba
if (empty($ingresos_data)) {
    $insert_ingreso_query = "INSERT INTO ingresos (id_usuario, monto_in, fecha_in, fuente_in) VALUES ($usuario_id, 1000, '2023-01-01', 'Salario')";
    if (!mysqli_query($conn, $insert_ingreso_query)) {
        echo "Error al insertar datos de prueba de ingresos: " . mysqli_error($conn);
    }
}

// Obtiene los gastos del usuario
$gastos_result = mysqli_query($conn, $gastos_query);
if (!$gastos_result) {
    echo "Error en la consulta de gastos: " . mysqli_error($conn);
    exit();
}

// Muestra los gastos obtenidos
$gastos_data = mysqli_fetch_all($gastos_result, MYSQLI_ASSOC);

// Si no hay gastos, puedes insertar datos de prueba
if (empty($gastos_data)) {
    $insert_gasto_query = "INSERT INTO gastos (id_usuario, monto_ga, fecha_ga, id_categoria) VALUES ($usuario_id, 500, '2023-01-02', 1)";
    if (!mysqli_query($conn, $insert_gasto_query)) {
        echo "Error al insertar datos de prueba de gastos: " . mysqli_error($conn);
    }
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
            <th>Fuente</th>
        </tr>
        <?php foreach ($ingresos_data as $ingreso): ?>
            <tr>
                <td><?php echo $ingreso['monto']; ?></td>
                <td><?php echo $ingreso['fecha']; ?></td>
                <td><?php echo $ingreso['descripcion']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2 style="text-align:center;">Gastos</h2>
    <table>
        <tr>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Categoría</th>
        </tr>
        <?php foreach ($gastos_data as $gasto): ?>
            <tr>
                <td><?php echo $gasto['monto']; ?></td>
                <td><?php echo $gasto['fecha']; ?></td>
                <td><?php echo $gasto['categoria']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
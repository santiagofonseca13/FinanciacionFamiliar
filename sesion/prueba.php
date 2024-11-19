<?php
session_start();
include 'conexion.php'; // Asegúrate de que la conexión esté bien

// Verifica si el usuario está logueado
if (!isset($_SESSION['email'])) {
    header("Location: ../login.html");
    exit();
}

// Obtiene el ID de la familia del administrador
$email = $_SESSION['email'];
$query = "SELECT id_familia, rol FROM usuarios WHERE email = ?";
$variable = $conn->prepare($query);
$variable->bind_param("s", $email);
$variable->execute();
$variable->bind_result($id_familia, $rol);
$variable->fetch();
$variable->close();

// Verifica si el rol incluye "mama"
$esMama = (strpos($rol, 'mama') !== false);//|| (strpos($rol, 'papa') !== false);

// Si no es "mama", obtenemos los ingresos y gastos solo para ese usuario
$usuario_id = $_SESSION['id_usuario'];

// Preparar los valores que se pasarán a bind_param
$param_ingresos = $esMama ? $id_familia : $usuario_id;
$param_gastos = $esMama ? $id_familia : $usuario_id;

// Consulta de ingresos
$ingresos_query = $esMama 
    ? "SELECT monto_in AS monto, fecha_in AS fecha, fuente_in AS descripcion, u.nombre, u.rol 
       FROM ingresos i 
       JOIN usuarios u ON i.id_usuario = u.id_usuario 
       WHERE u.id_familia = ?"
    : "SELECT monto_in AS monto, fecha_in AS fecha, fuente_in AS descripcion, u.rol 
       FROM ingresos i 
       JOIN usuarios u ON i.id_usuario = u.id_usuario 
       WHERE i.id_usuario = ?";

// Consulta de gastos
$gastos_query = $esMama
    ? "SELECT g.monto_ga AS monto, g.fecha_ga AS fecha, cg.nombre_categoria AS categoria, u.nombre, u.rol 
       FROM gastos g 
       JOIN usuarios u ON g.id_usuario = u.id_usuario 
       JOIN categoriagastos cg ON g.id_categoria = cg.id_categoria 
       WHERE u.id_familia = ?"
    : "SELECT g.monto_ga AS monto, g.fecha_ga AS fecha, cg.nombre_categoria AS categoria, u.rol 
       FROM gastos g 
       JOIN usuarios u ON g.id_usuario = u.id_usuario 
       JOIN categoriagastos cg ON g.id_categoria = cg.id_categoria 
       WHERE g.id_usuario = ?";

// Preparar y ejecutar las consultas de ingresos
$ingresos_consulta = $conn->prepare($ingresos_query);
$ingresos_consulta->bind_param("i", $param_ingresos);  // Pasamos la variable intermedia
$ingresos_consulta->execute();
$ingresos_result = $ingresos_consulta->get_result();

// Preparar y ejecutar las consultas de gastos
$gastos_consulta = $conn->prepare($gastos_query);
$gastos_consulta->bind_param("i", $param_gastos);  // Pasamos la variable intermedia
$gastos_consulta->execute();
$gastos_result = $gastos_consulta->get_result();

// Sumar todos los ingresos
$total_ingresos = 0;
while ($ingreso = mysqli_fetch_assoc($ingresos_result)) {
    $total_ingresos += $ingreso['monto'];
}

// Sumar todos los gastos
$total_gastos = 0;
while ($gasto = mysqli_fetch_assoc($gastos_result)) {
    $total_gastos += $gasto['monto'];
}

// Calcular la diferencia
$diferencia = $total_ingresos - $total_gastos;
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
    <button onclick="window.location.href='../ingresosGastos.php'">Volver</button>
    <h1>Detalles de Ingresos y Gastos</h1>
    <h2>Ingresos</h2>
    <table>
        <tr>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <?php if ($esMama) echo "<th>Nombre del Usuario</th><th>Rol</th>"; ?>
        </tr>
        <?php while ($ingreso = mysqli_fetch_assoc($ingresos_result)): ?>
            <tr>
                <td><?php echo $ingreso['monto']; ?></td>
                <td><?php echo $ingreso['fecha']; ?></td>
                <td><?php echo $ingreso['descripcion']; ?></td>
                <?php if ($esMama) echo "<td>" . htmlspecialchars($ingreso['nombre']) . "</td><td>" . htmlspecialchars($ingreso['rol']) . "</td>"; ?>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Gastos</h2>
    <table>
        <tr>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Categoría</th>
            <?php if ($esMama) echo "<th>Nombre del Usuario</th><th>Rol</th>"; ?>
        </tr>
        <?php while ($gasto = mysqli_fetch_assoc($gastos_result)): ?>
            <tr>
                <td><?php echo $gasto['monto']; ?></td>
                <td><?php echo $gasto['fecha']; ?></td>
                <td><?php echo $gasto['categoria']; ?></td>
                <?php if ($esMama) echo "<td>" . htmlspecialchars($gasto['nombre']) . "</td><td>" . htmlspecialchars($gasto['rol']) . "</td>"; ?>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Resumen Financiero</h2>
    <table>
        <tr>
            <th>Total Ingresos</th>
            <th>Total Gastos</th>
            <th>Diferencia</th>
        </tr>
        <tr>
            <td><?php echo number_format($total_ingresos, 2); ?></td>
            <td><?php echo number_format($total_gastos, 2); ?></td>
            <td><?php echo number_format($diferencia, 2); ?></td>
        </tr>
    </table>
</body>
</html>

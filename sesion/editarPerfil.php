<?php
session_start();
include 'conexion.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Obtener el correo actual del usuario desde la sesión
$emailActual = $_SESSION['email'];

// Mensaje de error o éxito
$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Consultar los datos actuales del usuario
$query = "SELECT nombre, email FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}
$stmt->bind_param("s", $emailActual);
$stmt->execute();
$stmt->bind_result($nombreActual, $emailActualDB);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../css/editarPerfil.css">
</head>
<body>
    <div class="section">
        <h1>Editar Perfil</h1>

        <!-- Mostrar mensaje de error o éxito -->
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="actualizarPerfil.php" method="POST">
            <label for="nuevo-nombre">Nuevo Nombre:</label>
            <input type="text" id="nuevo-nombre" name="nuevo-nombre" value="<?php echo htmlspecialchars($nombreActual); ?>" required>

            <label for="nuevo-email">Nuevo Correo Electrónico:</label>
            <input type="email" id="nuevo-email" name="nuevo-email" value="<?php echo htmlspecialchars($emailActualDB); ?>" required>

            <label for="nueva-contrasena">Nueva Contraseña (opcional):</label>
            <input type="password" id="nueva-contrasena" name="nueva-contrasena" placeholder="Nueva contraseña">

            <input type="submit" value="Guardar Cambios">
        </form>
        <br>

        <form action="logout.php" method="POST">
            <input type="submit" value="Cerrar Sesión">
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>

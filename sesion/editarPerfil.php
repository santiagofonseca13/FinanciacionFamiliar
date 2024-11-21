<?php
session_start();
include 'conexion.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['email'])) {
    header("Location: ../login.html");
    exit();
}

$emailActual = $_SESSION['email'];
$rol = $_SESSION['rol'];
$esMama = (strpos($rol, 'mama') !== false);
$usuarioSeleccionado = ''; 

// Obtiene el id_familia del usuario actual
$queryFamilia = "SELECT id_familia FROM usuarios WHERE email = ?";
$consultaFamilia = $conn->prepare($queryFamilia);
$consultaFamilia->bind_param("s", $emailActual);
$consultaFamilia->execute();
$consultaFamilia->bind_result($idFamilia);
$consultaFamilia->fetch();
$consultaFamilia->close();

// Obtiene la lista de usuarios de la misma familia
$query = "SELECT id_usuario, nombre, email FROM usuarios WHERE id_familia = ?";
$consultaUsuarios = $conn->prepare($query);
$consultaUsuarios->bind_param("i", $idFamilia);
$consultaUsuarios->execute();
$result = $consultaUsuarios->get_result();
$usuarios = $result->fetch_all(MYSQLI_ASSOC);
$consultaUsuarios->close();

$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
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

        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="actualizarPerfil.php" method="POST">
            <?php if ($esMama): ?>
                <label for="usuario">Usuario:</label>
                <select id="usuario" name="usuario" required>
                    <option value="">Seleccione un usuario</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id_usuario']; ?>" 
                            <?php echo ($usuario['id_usuario'] == $usuarioSeleccionado) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($usuario['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            <?php endif; ?>
            <label for="nuevo-nombre">Nuevo Nombre:</label>
            <input type="text" id="nuevo-nombre" name="nuevo-nombre" placeholder="Nombre" value="Nombre" required>

            <label for="nuevo-email">Nuevo Correo Electrónico:</label>
            <input type="email" id="nuevo-email" name="nuevo-email" placeholder="Correo" value="Correo"required>

            <label for="nueva-contrasena">Nueva Contraseña (opcional):</label>
            <input type="password" id="nueva-contrasena" name="nueva-contrasena" placeholder="Nueva contraseña" value="">

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
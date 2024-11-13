<?php
session_start();
include 'sesion/conexion.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Obtiene el rol del usuario actual
$email = $_SESSION['email'];
$query = "SELECT rol FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($rol);
$stmt->fetch();
$stmt->close();

// Define $mostrarAside si el rol incluye "mama"
$mostrarAside = strpos($rol, 'mama') !== false;

// Obtiene la lista de las categoriasde Gasto
$query = "SELECT id_categoria, nombre_categoria FROM categoriagastos";
$result = mysqli_query($conn, $query);
$categorias = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categorias[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresos y Gastos</title>
    <link rel="stylesheet" href="css/ingresosGastos.css">
    <link rel="icon" href="imagenes/economia.webp">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
        
        <!-- Botón de cerrar sesión -->
        <form action="sesion/logout.php" method="POST">
            <input type="submit" value="Cerrar Sesión">
        </form>

        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Contenedor principal en dos columnas -->
        <div class="main-layout">
            <!-- Sección de Ingresos y Gastos -->
            <div class="section">
                <h2>Seleccionar Ingresos o Gastos</h2>

                <details>
                    <summary>Ingresos</summary>
                    <form action="sesion/agregar_ingreso.php" method="POST">
                        <label for="monto-ingreso">Monto del Ingreso</label>
                        <input type="number" id="monto-ingreso" name="monto-ingreso" required>

                        <label for="fecha-ingreso">Fecha del Ingreso</label>
                        <input type="date" id="fecha-ingreso" name="fecha-ingreso" required>

                        <label for="descripcion-ingreso">Fuente</label>
                        <input type="text" id="descripcion-ingreso" name="descripcion-ingreso" placeholder="Ej. Salario, Venta, etc." required>

                        <input type="submit" value="Agregar Ingreso">
                    </form>
                </details>

                <details>
                    <summary>Gastos</summary>
                    <form action="sesion/agregar_gasto.php" method="POST">
                        <label for="monto-gasto">Monto del Gasto</label>
                        <input type="number" id="monto-gasto" name="monto-gasto" required>

                        <label for="fecha-gasto">Fecha del Gasto</label>
                        <input type="date" id="fecha-gasto" name="fecha-gasto" required>

                        <label for="categoria-gasto">Categoría</label>
                        <select id="categoria-gasto" name="categoria-gasto" required>
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id_categoria']; ?>">
                                    <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" value="Agregar Gasto">
                    </form>
                </details>

                <form action="sesion/detalle_ingresos_gastos.php" method="GET">
                    <input type="submit" value="Detalles">
                </form>
            </div>

            <!-- Aside para la modificación del perfil -->
            <?php if ($mostrarAside): ?>
            <aside>
                <h2>Ingresar Perfil</h2>
                <form action="sesion/agregarIntegrante.php" method="POST">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>
                    
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
                    
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>

                    <div class="integrantes">
                        <h2>Agregar integrantes</h2>
                        <label>
                            <input type="checkbox" name="rol[]" value="papa">Papá
                        </label><br>
                        <label>
                            <input type="checkbox" name="rol[]" value="mama">Mamá
                        </label><br>
                        <label>
                            <input type="checkbox" name="rol[]" value="cuñada">Cuñada
                        </label><br>
                        <label>
                            <input type="checkbox" name="rol[]" value="hijos">Hijos
                        </label><br>
                        <label>
                            <input type="checkbox" name="rol[]" value="abuelo">Abuelos
                        </label><br>
                        <input type="submit" value="Agregar">
                    </div>
                </form>
            </aside>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
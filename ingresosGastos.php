<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.html"); // Redirigir al login si no ha iniciado sesión
    exit();
}
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

        <!-- Contenedor principal en dos columnas -->
        <div class="main-layout">
            <!-- Sección de Ingresos y Gastos -->
            <div class="section">
                <h2>Seleccionar Ingresos o Gastos</h2>

                <details>
                    <summary>Ingresos</summary>
                    <form action="#" method="POST">
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
                    <form action="#" method="POST">
                        <label for="monto-gasto">Monto del Gasto</label>
                        <input type="number" id="monto-gasto" name="monto-gasto" required>

                        <label for="fecha-gasto">Fecha del Gasto</label>
                        <input type="date" id="fecha-gasto" name="fecha-gasto" required>

                        <label for="categoria-gasto">Fuente</label>
                        <input type="text" id="categoria-gasto" name="categoria-gasto" placeholder="Ej. Alimentación, Transporte, etc." required>

                        <input type="submit" value="Agregar Gasto">
                        
                    </form>
                    
                </details>
                <input type="submit" value="Detalles">
            </div>

            <!-- Aside para la modificación del perfil -->
            <aside>
                <h2>Modificar Perfil</h2>
                <form action="#" method="POST">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>
                    <label for="Contraseña">Contraseña</label>
                    <input type="text" id="Contraseña" name="Contraseña" placeholder="contraseña" required>

                    <div class="integrantes">
                        <h2>Agregar integrantes</h2>
                        <label>
                            <input type="checkbox" name="integrantes" value="papa">
                            Papá
                        </label><br>
                        <label>
                            <input type="checkbox" name="integrantes" value="mama">
                            Mamá
                        </label><br>
                        <label>
                            <input type="checkbox" name="integrantes" value="cuñada">
                            Cuñada
                        </label><br>
                        <label>
                            <input type="checkbox" name="integrantes" value="hijos">
                            Hijos
                        </label><br>
                        <label>
                            <input type="checkbox" name="integrantes" value="abuelos">
                            Abuelos
                        </label><br>
                        <input type="submit" value="Agregar">
                        
                    </div>
    
                    
                </form>
                
            </aside>
        </div>
    </div>
</body>
</html>
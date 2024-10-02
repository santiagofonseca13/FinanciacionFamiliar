<!DOCTYPE html>
<html lang="es">
<?php include 'src/head.php'; ?>
<body>
    <!--Cabezera-->
    <header>
        <div class="header-content">
            <div class="logo">
                <h1><b>S-S</b> Financiacion Familiar</h1>
            </div>
        </div>
    </header>

    <div class="container-all" id="move-content">
    <!--Contenido-->

    <div class="container-content">
        <div class="login-container">
            <h2>Login</h2>
            <form action="/login" method="POST">
                    
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>

    <!--Pie de pagina-->
    <?php include 'src/footer.php'; ?>
</div>
</body>
<script src="js/script.js"></script>
<script src="js/reloj.js"></script>
</html>
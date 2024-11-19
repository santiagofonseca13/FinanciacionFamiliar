<?php
session_start();
include 'conexion.php';

// Procesar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que los campos no estén vacíos
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "Por favor, complete todos los campos.";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Verificar el usuario
        $consulta = $conn->prepare("SELECT id_usuario, nombre, contrasena, rol FROM usuarios WHERE email = ?");
        $consulta->bind_param("s", $email);
        $consulta->execute();
        $consulta->store_result();

        if ($consulta->num_rows > 0) {
            $consulta->bind_result($id_usuario, $nombre, $hashed_password, $rol);
            $consulta->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['rol'] = $rol;
                header("Location: ../ingresosGastos.php");
                exit();
            } else {
                echo "contrasena incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

        $consulta->close();
    }
}

$conn->close();
?>
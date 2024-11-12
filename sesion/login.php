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
        $stmt = $conn->prepare("SELECT id_usuario, nombre, contasena, rol FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_usuario, $nombre, $hashed_password, $rol);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['rol'] = $rol;
                echo "Contraseña correcta. Redirigiendo...";
                header("refresh:2; url=../ingresosGastos.php");
                exit(); // Asegúrate de detener la ejecución después de redirigir
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
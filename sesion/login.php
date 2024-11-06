<?php
session_start();
include 'conexion.php';

// Verifica si hay un error en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que los campos no estén vacíos
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "Por favor, complete todos los campos.";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Verificar el usuario
        $stmt = $conn->prepare("SELECT contasena FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                echo "Contraseña correcta. Redirigiendo...";
                header("refresh:2; url=../ingresosGastos.html");
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
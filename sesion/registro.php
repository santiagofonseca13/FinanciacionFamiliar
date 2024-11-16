<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves están definidas
    $username = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : '';
    $confirm_password = isset($_POST['confirmar_contrasena']) ? trim($_POST['confirmar_contrasena']) : '';

    // Validación de campos vacíos
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "Todos los campos son obligatorios.";
    } elseif ($password !== $confirm_password) {
        echo "Las contrasenas no coinciden.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt_familia = $conn->prepare("INSERT INTO familia (descripcion) VALUES (?)");
        $descripcion_familia = $username . "'s Family";
        $stmt_familia->bind_param("s", $descripcion_familia);

        if ($stmt_familia->execute()) {
            $id_familia = $stmt_familia->insert_id; // Obtener el ID de la familia creada

            // Insertar el nuevo usuario con la referencia a la nueva familia
            $stmt_usuario = $conn->prepare("INSERT INTO usuarios (nombre, email, contrasena, rol, id_familia) VALUES (?, ?, ?, 'mama', ?)");
            $stmt_usuario->bind_param("sssi", $username, $email, $hashed_password, $id_familia);

            if ($stmt_usuario->execute()) {
                $_SESSION['mensaje'] = "Usuario creado con éxito. Ahora puedes iniciar sesión.";
                header("Location: ../ingresosGastos.php");
                exit();
            } else {
                echo "Error al registrar el usuario: " . $stmt_usuario->error;
            }

            $stmt_usuario->close();
        } else {
            echo "Error al crear la familia: " . $stmt_familia->error;
        }

        $stmt_familia->close();
    }
}

$conn->close();
?>
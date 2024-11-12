<?php
session_start();
include 'conexion.php';

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves están definidas
    $username = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['contraseña']) ? trim($_POST['contraseña']) : '';
    $confirm_password = isset($_POST['confirmar_contraseña']) ? trim($_POST['confirmar_contraseña']) : '';

    // Validación de campos vacíos
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "Todos los campos son obligatorios."; // Mensaje de error si algún campo está vacío
    } elseif ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden."; // Mensaje de error si las contraseñas no coinciden
    } else {
        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Crear una nueva familia
        $stmt_familia = $conn->prepare("INSERT INTO familia (descripcion) VALUES (?)");
        $descripcion_familia = $username . "'s Family"; // Descripción de la familia
        $stmt_familia->bind_param("s", $descripcion_familia);

        if ($stmt_familia->execute()) {
            $id_familia = $stmt_familia->insert_id; // Obtener el ID de la familia creada

            // Insertar el nuevo usuario con la referencia a la nueva familia
            $stmt_usuario = $conn->prepare("INSERT INTO usuarios (nombre, email, contasena, rol, id_familia) VALUES (?, ?, ?, 'mama', ?)");
            $stmt_usuario->bind_param("sssi", $username, $email, $hashed_password, $id_familia);

            if ($stmt_usuario->execute()) {
                $_SESSION['mensaje'] = "Usuario creado con éxito. Ahora puedes iniciar sesión."; // Guardar mensaje en la sesión
                header("Location: ../ingresosGastos.php"); // Redirige al usuario a la página de ingresos y gastos si el registro es exitoso
                exit();
            } else {
                echo "Error al registrar el usuario: " . $stmt_usuario->error; // Mensaje de error si ocurre un problema en la inserción del usuario
            }

            $stmt_usuario->close(); // Cierra el objeto de consulta del usuario
        } else {
            echo "Error al crear la familia: " . $stmt_familia->error; // Mensaje de error si ocurre un problema en la inserción de la familia
        }

        $stmt_familia->close(); // Cierra el objeto de consulta de la familia
    }
}

$conn->close(); // Cierra la conexión a la base de datos
?>
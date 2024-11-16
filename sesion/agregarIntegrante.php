<?php
session_start();
include 'conexion.php'; // Asegúrate de que la conexión esté bien

// Verifica si el usuario está logueado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Obtiene el ID de la familia del administrador
$email = $_SESSION['email'];
$query = "SELECT id_familia FROM usuarios WHERE email = ?";
$variable = $conn->prepare($query);
$variable->bind_param("s", $email);
$variable->execute();
$variable->bind_result($id_familia);
$variable->fetch();
$variable->close();
$mostrarAside = strpos($rol, 'mama') !== false;

// Revisa si los campos del formulario están completos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si los campos nombre, email, contraseña y rol están definidos
    if (!empty($_POST['nombre']) && !empty($_POST['email']) && !empty($_POST['contrasena']) && !empty($_POST['rol'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        
        // Verifica si al menos un rol ha sido seleccionado
        $rol = isset($_POST['rol']) ? implode(", ", $_POST['rol']) : '';

        // Cifra la contraseña
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Inserta los datos en la base de datos, incluyendo el ID de la familia
        $sql = "INSERT INTO usuarios (nombre, email, contrasena, rol, id_familia) VALUES (?, ?, ?, ?, ?)";

        if ($variable = $conn->prepare($sql)) {
            // Asocia los parámetros y ejecuta la consulta
            $variable->bind_param("sssss", $nombre, $email, $hashed_password, $rol, $id_familia);

            if ($variable->execute()) {
                $_SESSION['message'] = "Usuario agregado exitosamente.";
                header("Location: ../ingresosGastos.php");
                exit();
            } else {
                echo "Error al agregar el usuario: " . $variable->error;
            }

            $variable->close();
        } else {
            echo "Error en la consulta: " . $conn->error;
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}

$conn->close();
?>

<?php
session_start();
include 'conexion.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['email'])) {
    header("Location: ../login.html");
    exit();
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los valores del formulario
    $nuevoNombre = trim($_POST['nuevo-nombre']);
    $nuevoEmail = trim($_POST['nuevo-email']);
    $nuevaContrasena = trim($_POST['nueva-contrasena']);
    
    // Obtener el correo actual del usuario desde la sesión
    $emailActual = $_SESSION['email'];

    // Verifica que el nombre y el correo no estén vacíos
    if (!empty($nuevoNombre) && !empty($nuevoEmail)) {
        // Preparar la consulta para actualizar nombre y correo
        $query = "UPDATE usuarios SET nombre = ?, email = ? WHERE email = ?";
        $consulta = $conn->prepare($query);
        if (!$consulta) {
            $_SESSION['message'] = "Error al preparar la consulta: " . $conn->error;
            header("Location: editarPerfil.php");
            exit();
        }

        $consulta->bind_param("sss", $nuevoNombre, $nuevoEmail, $emailActual);
        
        if ($consulta->execute()) {
            $_SESSION['message'] = "Perfil actualizado correctamente.";

            // Si se cambia la contraseña
            if (!empty($nuevaContrasena)) {
                // Encriptar la nueva contraseña
                $nuevaContrasenaHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

                // Verifica que la encriptación haya sido exitosa
                if ($nuevaContrasenaHash === false) {
                    $_SESSION['message'] = "Error al encriptar la contraseña.";
                    header("Location: editarPerfil.php");
                    exit();
                }

                // Consulta para actualizar la contraseña
                $updateContrasenaQuery = "UPDATE usuarios SET contrasena = ? WHERE email = ?";
                $consultaContrasena = $conn->prepare($updateContrasenaQuery);
                if (!$consultaContrasena) {
                    $_SESSION['message'] = "Error al preparar la consulta de la contraseña: " . $conn->error;
                    header("Location: editarPerfil.php");
                    exit();
                }

                $consultaContrasena->bind_param("ss", $nuevaContrasenaHash, $emailActual);
                if ($consultaContrasena->execute()) {
                    $_SESSION['message'] = "Perfil actualizado correctamente.";
                } else {
                    $_SESSION['message'] = "Error al actualizar la contraseña: " . $consultaContrasena->error;
                    header("Location: editarPerfil.php");
                    exit();
                }
                $consultaContrasena->close();
            } else {
                $_SESSION['message'] = "Perfil actualizado correctamente, sin cambios en la contraseña.";
            }

            // Actualizar el correo en la sesión si se cambia
            $_SESSION['email'] = $nuevoEmail;

        } else {
            $_SESSION['message'] = "Error al actualizar el perfil: " . $consulta->error;
        }
        $consulta->close();
    } else {
        $_SESSION['message'] = "El nombre y el correo son obligatorios.";
    }

    // Redirigir de vuelta al perfil
    header("Location: editarPerfil.php");
    exit();
}

$conn->close();
?>

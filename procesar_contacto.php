<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar datos del formulario
    $nombre = test_input($_POST["nombre"]);
    $email = test_input($_POST["email"]);
    $mensaje = test_input($_POST["mensaje"]);

    // Verificar si el nombre contiene solo letras y espacios
    if (!preg_match("/^[a-zA-Z ]*$/", $nombre)) {
        echo "El nombre solo puede contener letras y espacios.";
        exit();
    }

    // Verificar si el email es válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El formato del email no es válido.";
        exit();
    }

    // Guardar los mensajes en la base de datos
    $sql = "INSERT INTO notificaciones (nombre, email, mensaje) VALUES ('$nombre', '$email', '$mensaje')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Notificación guardada correctamente."); setTimeout(function(){ window.location.href = "contacto.php"; }, 5);</script>';
    } else {
        echo "Error al enviar el mensaje: " . $conn->error;
    }

    $conn->close();
} else {
    // Si alguien intenta acceder directamente a este archivo, redirigirlo a la página de contacto
    header("Location: contacto.php");
    exit();
}

// Función para limpiar y validar datos del formulario
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

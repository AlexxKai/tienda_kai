<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['ID_usuario'])) {
    header("Location: index.php");  // Redirigir a la página de inicio si no hay sesión activa
    exit();
}

include 'db.php';

// Obtener datos del usuario
$usuario_id = $_SESSION['ID_usuario'];
$sql = "SELECT * FROM usuarios WHERE ID_usuario = $usuario_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    // Manejar el caso en que no se encuentren datos del usuario
    echo "Error al recuperar los datos del usuario.";
    exit();
}

// Procesar el cambio de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cambiar_contrasena'])) {
    $nueva_contrasena = password_hash($_POST["nueva_contrasena"], PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET contrasena = '$nueva_contrasena' WHERE ID_usuario = $usuario_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Contraseña actualizada exitosamente.";
        // Puedes redirigir al usuario o realizar otras acciones después de cambiar la contraseña
    } else {
        echo "Error al actualizar la contraseña: " . $conn->error;
    }
}

// Procesar la solicitud de cambio de correo electrónico
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cambiar_correo'])) {
    // Aquí puedes obtener el nuevo correo electrónico desde el formulario
    $nuevo_correo = $_POST['nuevo_correo'];

    // Implementa la lógica para solicitar al administrador un cambio de correo electrónico
    // Puedes enviar un correo al administrador o realizar otras acciones según tus necesidades
    echo "Solicitud de cambio de correo electrónico enviada al administrador.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil - Tienda de Piercing</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <nav>
        <div class="container">
            <a href="index.php">Inicio</a>
            <a href="contacto.php">Contacto</a>
            <a href="logout.php">Logout</a>
            <a href="perfil.php">Perfil</a>
            <a href="catalogo.php">Catálogo</a>
        </div>
    </nav>

    <div class="container">
        <h1>Perfil de Usuario</h1>

        <h2>Datos del Usuario</h2>
        <p>Nombre: <?php echo $usuario['nombre_apellidos']; ?></p>
        <p>Email: <?php echo $usuario['email']; ?></p>

        <h2>Cambiar Contraseña</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nueva_contrasena">Nueva Contraseña:</label>
            <input type="password" name="nueva_contrasena" required>

            <button type="submit" name="cambiar_contrasena">Cambiar Contraseña</button>
        </form>

        <h2>Solicitar Cambio de Correo Electrónico</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nuevo_correo">Nuevo Correo Electrónico:</label>
            <input type="email" name="nuevo_correo" required>

            <button type="submit" name="cambiar_correo">Solicitar Cambio de Correo Electrónico</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

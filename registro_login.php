<?php
include 'db.php';

// Iniciar sesión
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['ID_usuario'])) {
    header("Location: index.php");
    exit();
}

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $nombre = test_input($_POST["nombre"]);
    $telefono = test_input($_POST["telefono"]);
    $email = test_input($_POST["email"]);
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

    // Verificar si el email ya está registrado
    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El email ya está registrado. Por favor, inicia sesión o utiliza otro email.";
    } else {
        // Insertar nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre_apellidos, telefono, email, contrasena) VALUES ('$nombre', '$telefono', '$email', '$contrasena')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso. Por favor, inicia sesión.";
        } else {
            echo "Error en el registro: " . $conn->error;
        }
    }
}

// Procesar el formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = test_input($_POST["email"]);
    $contrasena = $_POST["contrasena"];

    // Obtener el hash de la contraseña almacenado en la base de datos
    $sql = "SELECT ID_usuario, contrasena FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['contrasena'];

        // Verificar la contraseña
        if (password_verify($contrasena, $hashed_password)) {
            // Iniciar sesión y redirigir al usuario a la página de inicio
            $_SESSION['ID_usuario'] = $row['ID_usuario'];
            header("Location: index.php");
            exit();
        } else {
            echo "Contraseña incorrecta. Inténtalo de nuevo.";
        }
    } else {
        echo "No se encontró ninguna cuenta asociada a ese email. Regístrate primero.";
    }
}

// Función para limpiar y validar datos del formulario
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro/Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav>
        <div class="container">
            <a href="index.php">Inicio</a>
            <a href="contacto.php">Contacto</a>

            <?php
            if(isset($_SESSION['ID_usuario'])) {
                // Mostrar opciones adicionales si el usuario está autenticado
                echo '<a href="logout.php">Logout</a>';
                echo '<a href="perfil.php">Perfil</a>';  // Puedes enlazar a una página de perfil aquí
            } else {
                echo '<a href="registro_login.php">Registro/Login</a>';
            }
            ?>

            <a href="catalogo.php">Catálogo</a>
        </div>
    </nav>

    <div class="container">
        <h1>Registro/Login</h1>

        <!-- Formulario de Registro -->
        <section>
            <h2>Registro</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>

                <label for="telefono">Teléfono:</label>
                <input type="tel" name="telefono">

                <label for="email_reg">Email:</label>
                <input type="email" name="email" id="email_reg" required>
                
                <label for="contrasena_reg">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena_reg" required>

                <button type="submit" name="register">Registrarse</button>
            </form>
        </section>

        <!-- Formulario de Login -->
        <section>
            <h2>Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="email_login">Email:</label>
                <input type="email" name="email" id="email_login" required>

                <label for="contrasena_login">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena_login" required>

                <button type="submit" name="login">Iniciar Sesión</button>
            </form>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

<?php
include 'db.php';

// Iniciar sesión
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['ID_usuario'])) {
    header("Location: index.php");
    exit();
}

// Verificar si el administrador está autenticado
$es_admin = false;  // Define cómo determinar si un usuario es administrador (puedes adaptarlo según tus necesidades)

if ($es_admin && isset($_SESSION['ID_admin'])) {
    // Si el administrador ya está autenticado, redirige a la página de administrador
    header("Location: admin_panel.php");
    exit();
}

// Lógica de inicio de sesión y registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['iniciar_sesion'])) {
        // Lógica para iniciar sesión
        // ...

        // Redirigir al usuario a la página correspondiente después del inicio de sesión
        header("Location: perfil.php");
        exit();
    } elseif (isset($_POST['registro'])) {
        // Lógica para el registro de usuarios
        // ...

        // Redirigir al usuario a la página correspondiente después del registro
        header("Location: perfil.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro / Login - Tienda de Piercing</title>
    <link rel="stylesheet" href="./styles.css">
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
        <h1>Bienvenido a la Tienda de Piercing</h1>

        <div class="login-register-container">
            <div id="login-form">
                <h2>Iniciar Sesión</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- Campos de inicio de sesión -->
                    <!-- ... -->

                    <button type="submit" name="iniciar_sesion">Iniciar Sesión</button>
                </form>
                <p>¿Aún no tienes una cuenta? <a href="#" onclick="toggleForm('registro-form')">Regístrate</a></p>
            </div>

            <div id="registro-form" style="display: none;">
                <h2>Registro</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- Campos de registro -->
                    <!-- ... -->

                    <button type="submit" name="registro">Registrarse</button>
                </form>
                <p>¿Ya tienes una cuenta? <a href="#" onclick="toggleForm('login-form')">Iniciar Sesión</a></p>
            </div>
        </div>

        <!-- Agregar opción exclusiva para el administrador -->
        <div id="admin-login">
            <h2>Iniciar Sesión como Administrador</h2>
            <form action="admin_login.php" method="post">
                <!-- Campos de inicio de sesión del administrador -->
                <!-- ... -->

                <button type="submit" name="admin_iniciar_sesion">Iniciar Sesión</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Función para alternar entre el formulario de inicio de sesión y el de registro
        function toggleForm(formId) {
            var loginForm = document.getElementById('login-form');
            var registroForm = document.getElementById('registro-form');

            if (formId === 'registro-form') {
                loginForm.style.display = 'none';
                registroForm.style.display = 'block';
            } else {
                loginForm.style.display = 'block';
                registroForm.style.display = 'none';
            }
        }
    </script>
</body>
</html>

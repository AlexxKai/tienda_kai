<?php
include 'db.php';

// Iniciar sesión
session_start();



// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $nombre = test_input($_POST["nombre"]);
    $telefono = test_input($_POST["telefono"]);
    $email = test_input($_POST["email"]);
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

    // Verificar si el email ya está registrado
    $sql = "SELECT * FROM administrador WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El email ya está registrado. Por favor, inicia sesión o utiliza otro email.";
    } else {
        // Insertar nuevo usuario en la base de datos
        $sql = "INSERT INTO administrador (nombre_apellidos, telefono, email, contrasena) VALUES ('$nombre', '$telefono', '$email', '$contrasena')";

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
    $sql = "SELECT ID_administrador, contrasena FROM administrador WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['contrasena'];

        // Verificar la contraseña
        if (password_verify($contrasena, $hashed_password)) {
            // Iniciar sesión y redirigir al administrador a su panel
            $_SESSION['ID_administrador'] = $row['ID_administrador'];
            header("Location: admin_panel.php");
            exit();
        } else {
            echo "Contraseña incorrecta. Inténtalo de nuevo.";
        }
    } else {
        echo "No se encontró ninguna cuenta asociada a ese email. Regístrate primero.";
    }
}

// Función para limpiar y validar datos del formulario
function test_input($data)
{
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
            if (isset($_SESSION['ID_administrador'])) {
                // Mostrar opciones adicionales si el usuario está autenticado
                echo '<a href="logout.php">Logout</a>';
                echo '<a href="perfil.php">Perfil</a>';
                echo '<a href="admin_panel.php">Panel de Administración</a>';

            } else {
                echo '<a href="registro_login.php">Registro/Login</a>';
            }
            ?>

            <a href="catalogo.php">Catálogo</a>
        </div>
    </nav>

    <div class="container">
        <!-- Formulario de Login -->
        <section>
            <div class="login-register-container">
                <div id="login-form">
                    <h2>Login</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for="email_login">Email:</label>
                        <input type="email" name="email" id="email_login" required>

                        <label for="contrasena_login">Contraseña:</label>
                        <input type="password" name="contrasena" id="contrasena_login" required>

                        <button type="submit" name="login">Iniciar Sesión</button>
                    </form>
                    <p>¿Aún no tienes una cuenta? <a href="#" onclick="toggleForm('registro-form')">Regístrate</a></p>
                </div>
        </section>

        <!-- Formulario de Registro -->
        <section>
            <div id="registro-form" style="display: none;">
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
                <p>¿Ya tienes una cuenta? <a href="#" onclick="toggleForm('login-form')">Iniciar Sesión</a></p>
            </div>
    </div>
    </section>
    <section>
        <br>
        <button>
        <a style="text-decoration: none; color: #fff;" href="registro_login.php">Vuelve a tu sitio, muggle</a>
        </button>
    </section>
    </div>

    <footer>
        <div class="container">
        <p>&copy; 2024 Kai piercing. Todos los derechos reservados.</p>
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
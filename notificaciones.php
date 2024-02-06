<?php
include 'db.php';
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
$es_admin = true;  // Debes tener tu lógica para verificar si el usuario es administrador

if (!$es_admin) {
    header("Location: index.php");  // Redirigir a la página principal si no es administrador
    exit();
}

// Lógica para manejar notificaciones de cambios de correo electrónico
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['notificar_cambios'])) {
    // Aquí debes implementar la lógica para manejar las notificaciones de cambios de correo electrónico
    $mensaje_notificacion = "Se ha solicitado un cambio de correo electrónico. Usuario: {usuario}, Nuevo Correo: {nuevo_correo}";
    // Enviar notificación al administrador o manejar según tus necesidades
    // ...
    mostrarAlerta("Notificación de Cambios", $mensaje_notificacion);
}

// Función para mostrar una alerta en JavaScript
function mostrarAlerta($titulo, $mensaje)
{
    echo "<script>alert('$titulo: $mensaje');</script>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav>
        <div class="container">
            <?php
            if ($es_admin) {
                // Mostrar opción de panel de administración si el usuario es administrador
                echo '<a href="admin_panel.php">Productos</a>';
                echo '<a href="pedidos.php">Pedidos</a>';
                echo '<a href="notificaciones.php">Notificaciones</a>';
            }

            if (isset($_SESSION['ID_administrador'])) {
                // Mostrar opciones adicionales si el usuario está autenticado
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="registro_login.php">Registro/Login</a>';
            }
            ?>
        </div>
    </nav>

    <div class="container">
        <h1>Notificaciones</h1>

        <!-- Área de Notificaciones -->
        <section>
            <!-- Formulario para notificar cambios de correo electrónico -->
            <form method="post">
                <button type="submit" name="notificar_cambios">Notificar Cambios</button>
            </form>

            <!-- Contenido del área de notificaciones -->
            <?php
            // Consultar notificaciones no leídas
            $sql = "SELECT * FROM notificaciones WHERE estado = 'no leída'";
            $result = $conn->query($sql);

            // Mostrar notificaciones en el panel de administración
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="notification">';
                    echo '<p>Nueva solicitud de cambio de correo electrónico para el usuario ID ' . $row['ID_usuario'] . '</p>';
                    echo '<p>Nuevo correo: ' . $row['nuevo_correo'] . '</p>';
                    // Agregar opciones para gestionar la notificación (marcar como leída, aprobar, rechazar, etc.)
                    echo '</div>';
                }
            } else {
                echo '<p>No hay nuevas notificaciones.</p>';
            }
            ?>
        </section>
    </div>

    <footer>
        <div class="container">
        <p>&copy; 2024 Kai piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>
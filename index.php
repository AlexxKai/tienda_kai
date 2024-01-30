<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tienda de Piercing</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">Inicio</a>
            <a href="contacto.php">Contacto</a>

            <?php
            if (isset($_SESSION['ID_usuario'])) {
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
        <section class="welcome-section">
            <h1>Bienvenido a nuestra Tienda de Piercing</h1>
            <p>Descubre las últimas novedades y ofertas en piercings de alta calidad.</p>
        </section>

        <!-- Mapa -->
        <div class="map">
            <!-- Integra aquí tu mapa, puedes usar servicios como Google Maps -->
        </div>

        <!-- Sección de Novedades -->
        <section class="special-section">
            <h2>Novedades</h2>
            <!-- Contenido de la sección de novedades -->
        </section>

        <!-- Sección de Ofertas -->
        <section class="special-section">
            <h2>Ofertas</h2>
            <!-- Contenido de la sección de ofertas -->
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>
<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet"></script>
    <style>
        .map {
            height: 400px;
            width: 100%;
        }
    </style>
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
                echo '<a href="perfil.php">Perfil</a>';
            } else {
                echo '<a href="registro_login.php">Registro/Login</a>';
            }
            ?>

            <a href="catalogo.php">Catálogo</a>
        </div>
    </nav>

    <div class="container">
        <h1>Contacto</h1>

        <section>
            <h2>Formulario de Contacto</h2>
            <!-- Implementa aquí tu formulario de contacto -->
            <form action="procesar_contacto.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>

                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="mensaje">Mensaje:</label>
                <textarea name="mensaje" required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </section>

        <section>
            <h2>Información de Contacto</h2>
            <p>Dirección: CA 90012, Los Angeles</p>
            <p>Teléfono: 123-456-789</p>
            <p>Email: info@tiendakai.com</p>
        </section>
        <div class="map" id="leaflet-map"></div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Kai piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="./mapa.js"></script>

</body>

</html>
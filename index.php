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
    <!-- Agrega el enlace a Leaflet desde CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet"></script>
    <style>
        /* Estilo básico para el contenedor del mapa */
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
        <section class="welcome-section">
            <h1>Bienvenido a nuestra Tienda de Piercing</h1>
            <p>Descubre las últimas novedades y ofertas en piercings de alta calidad.</p>
        </section>

        <!-- Mapa -->
        <div class="map" id="leaflet-map"></div>

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
            <p>&copy; 2024 Kai piercing. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Función para inicializar el mapa
        function initMap() {
            // Coordenadas de ejemplo (puedes cambiarlas según tu ubicación)
            var myLatLng = [34.094103594220414, -118.34434531553923];

            // Crear un nuevo mapa en el contenedor especificado
            var map = L.map('leaflet-map').setView(myLatLng, 14);

            // Usar un proveedor de mapas (OpenStreetMap en este caso)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Crear un marcador en la ubicación especificada
            L.marker(myLatLng).addTo(map)
                .bindPopup('Kai piercing<br>Los Angeles, CA 90012<br>Estados Unidos')
                .openPopup();
        }
        
        // Llama a la función initMap después de cargar la página
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>

</html>

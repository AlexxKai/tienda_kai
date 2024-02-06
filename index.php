<?php
include 'db.php';
session_start();

// Consulta para obtener un máximo de 4 productos añadidos (puedes ajustarla según tus necesidades)
$sqlNovedades = "SELECT * FROM productos LIMIT 4";
$resultNovedades = $conn->query($sqlNovedades);

$novedades = [];

if ($resultNovedades->num_rows > 0) {
    while ($row = $resultNovedades->fetch_assoc()) {
        $novedades[] = $row;
    }
}

$conn->close();
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

        <!-- Sección de Novedades -->
        <section class="special-section">
            <h2>Novedades</h2>
            <!-- Contenido de la sección de novedades -->
            <?php if (!empty($novedades)) : ?>
                <div class="product-list">
                    <?php foreach ($novedades as $producto) : ?>
                        <div class="product">
                            <h3><?php echo $producto['nombre']; ?></h3>
                            <p>Precio: <?php echo $producto['precio']; ?>€</p>
                            <!-- Agrega más detalles según la estructura de tu base de datos -->
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No hay novedades en este momento.</p>
            <?php endif; ?>
        </section>

        <!-- Sección de Ofertas -->
        <section class="special-section">
            <h2>Ofertas</h2>
            <p>Estamos trabajando para que tengas las mejores ofertas posibles 😊</p>
        </section>
        <!-- Mapa -->
        <div class="map" id="leaflet-map"></div>
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
            var map = L.map('leaflet-map').setView(myLatLng, 15);

            // proveedor de mapas OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // crear marcador
            L.marker(myLatLng).addTo(map)
                .bindPopup('Kai piercing<br>Los Angeles, CA 90012<br>Estados Unidos')
                .openPopup();
        }

        // llama a la función initMap después de cargar la página
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>

</html>

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
    <!-- Leaflet CDN-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet"></script>
    <style>
        /* contenedor del mapa */
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
            <h1>Kai piercing</h1>
            <h2>Bienvenido a nuestra tienda de piercing</h2>
            <p>Descubre las últimas novedades y ofertas en piercings de alta calidad.</p>
        </section>

        <!-- productos -->
        <section class="special-section">
            <h2>Nuestros productos</h2>
            <?php if (!empty($novedades)) : ?>
                <div class="product-list">
                    <?php foreach ($novedades as $producto) : ?>
                        <div class="product">
                            <h3><?php echo $producto['nombre']; ?></h3>
                            <p>Precio: <?php echo $producto['precio']; ?>€</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No hay novedades en este momento.</p>
            <?php endif; ?>
        </section>

        <!-- ofertas -->
        <section class="special-section">
            <h2>Ofertas</h2>
            <p>Estamos trabajando para que tengas las mejores ofertas posibles 😊</p>
        </section>
        <!-- Mapa -->
        <h2>Aquí puedes encontrarnos</h2>
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
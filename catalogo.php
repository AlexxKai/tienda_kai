<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo</title>
    <link rel="stylesheet" href="styles.css">
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
                echo '<a href="carrito.php">Carrito de Compras</a>';  // Nuevo enlace al carrito
            } else {
                echo '<a href="registro_login.php">Registro/Login</a>';
            }
            ?>

            <a href="catalogo.php">Catálogo</a>
        </div>
    </nav>

    <div class="container">
        <h1>Catálogo de Productos</h1>

        <div class="product-list">
            <!-- Mostrar productos desde la base de datos -->
            <?php
            $sql = "SELECT * FROM productos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<h2>' . $row['nombre'] . '</h2>';
                    echo '<p>Fabricante: ' . $row['fabricante'] . '</p>';
                    echo '<p>Cantidad: ' . $row['cantidad'] . '</p>';
                    echo '<button onclick="addToCart(' . $row['ID_producto'] . ')">Añadir al Carrito</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay productos disponibles.</p>';
            }
            ?>
        </div>

        <div id="cart">
            <!-- Contenido del carrito de compras -->
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function addToCart(productID) {
            // Implementa la lógica para añadir productos al carrito de compras
            // Puedes usar AJAX para enviar la información al servidor
            alert('Producto añadido al carrito.');
        }
    </script>
</body>

</html>

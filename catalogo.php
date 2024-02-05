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
                echo '<a href="carrito.php">Carrito de compra</a>';  // Nuevo enlace al carrito
            } else {
                echo '<a href="registro_login.php">Registro/Login</a>';
            }
            ?>

            <a href="catalogo.php">Catálogo</a>
        </div>
    </nav>

    <div class="container">
        <h1>Catálogo</h1>

        <div class="product-list">
            <!-- Mostrar productos desde la base de datos -->
            <?php
            $sql = "SELECT * FROM productos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<h2>' . $row['nombre'] . '</h2>';
                    echo '<p>' . $row['precio'] . '€' . '</p>';
                    echo '<p>Cantidad: ' . $row['cantidad'] . '</p>';
                    echo '<input type="number" min="1" value="1" id="quantity_' . $row['ID_producto'] . '">';
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    function addToCart(productID) {
        // Obtén la cantidad deseada
        var quantityInput = document.getElementById('quantity_' + productID);
        var quantity = quantityInput.value;

        // Verifica si la cantidad es válida y no es nula
        if (quantity !== null && !isNaN(quantity) && quantity > 0) {
            // Realiza la solicitud Ajax
            $.ajax({
                type: "POST",
                url: "agregar_al_carrito.php",
                data: {
                    productID: productID,
                    quantity: quantity
                },
                success: function(response) {
                    // Divide la respuesta usando el delimitador "|"
                    var parts = response.split("|");

                    // Verifica si hay al menos dos partes en la respuesta
                    if (parts.length >= 2 && parts[0] === "1") {
                        // Actualiza la cantidad disponible
                        var cantidadDisponible = parts[1];
                        alert("Producto añadido al carrito correctamente.\nCantidad disponible: " + cantidadDisponible);

                        // Restablece la cantidad a 1
                        quantityInput.value = 1;
                    } else {
                        alert(response);
                    }
                },
                error: function() {
                    alert("Error al agregar el producto al carrito.");
                }
            });
        }
    }
</script>

</body>

</html>
<?php
session_start();
include 'db.php';

// Verificar si el usuario está autenticado
if (isset($_SESSION['ID_usuario'])) {
    $userID = $_SESSION['ID_usuario'];

    // Obtener detalles del pedido para el usuario actual
    $sql = "SELECT productos.nombre, productos.fabricante, productos.precio, detalles_pedido.cantidad
        FROM detalles_pedido
        INNER JOIN productos ON detalles_pedido.ID_producto = productos.ID_producto
        INNER JOIN pedidos ON detalles_pedido.ID_pedido = pedidos.ID_pedido
        WHERE pedidos.ID_usuario = $userID";
    $result = $conn->query($sql);

    $productosEnPedido = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['precio_total'] = $row['precio'] * $row['cantidad']; // Calcular el precio total
            $productosEnPedido[] = $row;
        }
    }
} else {
    // Redirigir si el usuario no está autenticado
    header("Location: catalogo.php");
    exit();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Confirmación de Compra</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<nav>
        <div class="container">
            <a href="catalogo.php">Catálogo</a>
            <a href="carrito.php">Volver</a>
        </div>
    </nav>

    <div class="container">
        <h1>Confirmación de Compra</h1>

        <?php if (!empty($productosEnPedido)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productosEnPedido as $producto) : ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['precio_total'] . '€'; ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No hay productos en el pedido.</p>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>

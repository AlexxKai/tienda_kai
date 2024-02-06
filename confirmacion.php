<?php
session_start();
include 'db.php';

if (isset($_SESSION['ID_usuario'])) {
    $userID = $_SESSION['ID_usuario'];

    // Obtener productos del pedido para el usuario actual
    $sql = "SELECT productos.nombre, productos.fabricante, productos.precio, detalles_pedido.cantidad
        FROM detalles_pedido
        INNER JOIN productos ON detalles_pedido.ID_producto = productos.ID_producto
        WHERE detalles_pedido.ID_pedido IN (
            SELECT pedidos.ID_pedido
            FROM pedidos
            WHERE pedidos.ID_usuario = $userID
        )";
    $result = $conn->query($sql);

    $productosEnPedido = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['precio_total'] = $row['precio'] * $row['cantidad']; // Calcular el precio total
            $productosEnPedido[] = $row;
        }
    }
} else {
    header("Location: catalogo.php"); // Redirigir si el usuario no está autenticado
    exit();
}

// Resto del código...

// Finalizar compra
if (isset($_POST['finalizar'])) {
    // Insertar pedido en la tabla de pedidos
    $insertarPedidoSQL = "INSERT INTO pedidos (ID_usuario) VALUES ($userID)";
    $conn->query($insertarPedidoSQL);

    // Obtener el ID del último pedido insertado
    $ultimoPedidoID = $conn->insert_id;

    // Mover los productos del carrito al pedido
    $moverProductosSQL = "INSERT INTO detalles_pedido (ID_pedido, ID_producto, cantidad)
        SELECT $ultimoPedidoID, ID_producto, cantidad FROM carrito_compras WHERE ID_usuario = $userID";
    $conn->query($moverProductosSQL);

    // Vaciar el carrito de compras
    $vaciarCarritoSQL = "DELETE FROM carrito_compras WHERE ID_usuario = $userID";
    $conn->query($vaciarCarritoSQL);
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
    <!-- Agrega cualquier estilo adicional que desees -->
</head>

<body>
    <nav>
        <div class="container">
            <!-- Puedes incluir enlaces de navegación aquí si es necesario -->
        </div>
    </nav>

    <div class="container">
        <h1>Compra Realizada</h1>

        <?php if (!empty($productosEnCarrito)) : ?>
            <p>Gracias por tu compra. Aquí está el resumen de tu pedido:</p>

            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <!-- Agrega cualquier otra columna que desees mostrar -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productosEnCarrito as $producto) : ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['precio_total'].'€'; ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>
                            <!-- Agrega cualquier otra celda que desees mostrar -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p>¡Esperamos que disfrutes de tus productos!</p>
        <?php else : ?>
            <p>No hay productos en el carrito.</p>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>

<?php
session_start();
include 'db.php';

if (isset($_SESSION['ID_usuario'])) {
    $userID = $_SESSION['ID_usuario'];

    // Obtener productos del carrito para el usuario actual
    $sql = "SELECT carrito_compras.ID_producto, productos.nombre, productos.fabricante, productos.precio, carrito_compras.cantidad
        FROM carrito_compras
        INNER JOIN productos ON carrito_compras.ID_producto = productos.ID_producto
        WHERE carrito_compras.ID_usuario = $userID";
    $result = $conn->query($sql);

    $productosEnCarrito = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['precio_total'] = $row['precio'] * $row['cantidad']; // Calcular el precio total
            $productosEnCarrito[] = $row;
        }
    }
} else {
    header("Location: catalogo.php"); // Redirigir si el usuario no está autenticado
    exit();
}

// Modificar cantidad de producto en el carrito
if (isset($_POST['modificar'])) {
    $productoID = $_POST['productoID'];
    $nuevaCantidad = $_POST['nuevaCantidad'];

    // Actualizar la cantidad del producto en el carrito
    $modificarSQL = "UPDATE carrito_compras SET cantidad = $nuevaCantidad WHERE ID_producto = $productoID AND ID_usuario = $userID";
    $conn->query($modificarSQL);

    // Redirigir a la página del carrito actualizada
    header("Location: carrito.php");
    exit();
}

// Eliminar producto del carrito
if (isset($_GET['eliminar'])) {
    $productoID = $_GET['eliminar'];

    // Realizar la eliminación del producto del carrito
    $eliminarSQL = "DELETE FROM carrito_compras WHERE ID_producto = $productoID AND ID_usuario = $userID";
    $conn->query($eliminarSQL);

    // Redirigir a la página del carrito actualizada
    header("Location: carrito.php");
    exit();
}

// Finalizar compra
if (isset($_POST['finalizar'])) {
    // Insertar pedido en la tabla de pedidos
    $insertarPedidoSQL = "INSERT INTO pedidos (ID_usuario) VALUES ($userID)";
    $conn->query($insertarPedidoSQL);

    // Vaciar el carrito de compras
    $vaciarCarritoSQL = "DELETE FROM carrito_compras WHERE ID_usuario = $userID";
    $conn->query($vaciarCarritoSQL);

    // Redirigir a la página de confirmación de compra
    header("Location: confirmacion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">Inicio</a>
            <a href="contacto.php">Contacto</a>
            <a href="logout.php">Logout</a>
            <a href="perfil.php">Perfil</a>
            <a href="catalogo.php">Catálogo</a>
        </div>
    </nav>

    <div class="container">
        <h1>Carrito de Compras</h1>

        <?php if (!empty($productosEnCarrito)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productosEnCarrito as $producto) : ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['precio_total'].'€'; ?></td>
                            <td>
                                <form method="post" action="carrito.php">
                                    <input type="hidden" name="productoID" value="<?php echo $producto['ID_producto']; ?>">
                                    <input type="number" name="nuevaCantidad" value="<?php echo $producto['cantidad']; ?>">
                            </td>
                            <td>
                                    <input type="submit" name="modificar" value="Modificar">
                                </form>
                                <a href="carrito.php?eliminar=<?php echo $producto['ID_producto']; ?>">Quitar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form method="post" action="carrito.php">
                <input type="submit" name="finalizar" value="Finalizar Compra">
            </form>
        <?php else : ?>
            <p>El carrito de compras está vacío.</p>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>

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
            $productosEnCarrito[] = $row;
        }
    }
} else {
    header("Location: catalogo.php"); // Redirigir si el usuario no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
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
            <a href="mostrar_carrito.php">Carrito</a>
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productosEnCarrito as $producto) : ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['precio'].'€'; ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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

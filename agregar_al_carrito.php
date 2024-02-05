<?php
session_start();
include 'db.php';

if (isset($_SESSION['ID_usuario']) && isset($_POST['productID']) && isset($_POST['quantity'])) {
    $userID = $_SESSION['ID_usuario'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];

    // Obtener la cantidad disponible del producto desde la base de datos
    $sqlCantidad = "SELECT cantidad FROM productos WHERE ID_producto = $productID";
    $resultCantidad = $conn->query($sqlCantidad);

    if ($resultCantidad->num_rows > 0) {
        $rowCantidad = $resultCantidad->fetch_assoc();
        $cantidadDisponible = $rowCantidad['cantidad'];

        // Verificar si la cantidad deseada es válida y no excede la cantidad disponible
        if ($quantity > 0 && $quantity <= $cantidadDisponible) {
            // Verifica si el producto ya está en el carrito
            $sqlCarrito = "SELECT * FROM carrito_compras WHERE ID_usuario = $userID AND ID_producto = $productID";
            $resultCarrito = $conn->query($sqlCarrito);

            if ($resultCarrito->num_rows > 0) {
                // Si el producto ya está en el carrito, actualiza la cantidad
                $sqlUpdate = "UPDATE carrito_compras SET cantidad = cantidad + $quantity WHERE ID_usuario = $userID AND ID_producto = $productID";
            } else {
                // Si el producto no está en el carrito, inserta un nuevo registro
                $sqlUpdate = "INSERT INTO carrito_compras (ID_usuario, ID_producto, cantidad) VALUES ($userID, $productID, $quantity)";
            }

            if ($conn->query($sqlUpdate) === TRUE) {
                // Producto añadido al carrito correctamente
                echo "1|$cantidadDisponible";
            } else {
                echo "Error al agregar el producto al carrito: " . $conn->error;
            }
        } else {
            echo "Error: La cantidad deseada no es válida o excede la cantidad disponible del producto.";
        }
    } else {
        echo "Error: No se pudo obtener la información del producto.";
    }
} else {
    echo "Acceso no autorizado.";
}
?>

<?php
session_start();
include 'db.php';

if (isset($_SESSION['ID_usuario']) && isset($_POST['productID']) && isset($_POST['quantity'])) {
    $userID = $_SESSION['ID_usuario'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];

    // Verifica si el producto ya está en el carrito
    $sql = "SELECT * FROM carrito_compras WHERE ID_usuario = $userID AND ID_producto = $productID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si el producto ya está en el carrito, actualiza la cantidad
        $sql = "UPDATE carrito_compras SET cantidad = cantidad + $quantity WHERE ID_usuario = $userID AND ID_producto = $productID";
    } else {
        // Si el producto no está en el carrito, inserta un nuevo registro
        $sql = "INSERT INTO carrito_compras (ID_usuario, ID_producto, cantidad) VALUES ($userID, $productID, $quantity)";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Producto añadido al carrito correctamente.";
    } else {
        echo "Error al agregar el producto al carrito: " . $conn->error;
    }
} else {
    echo "Acceso no autorizado.";
}

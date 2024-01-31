<?php
// Comprueba si la sesión ya está activa
if (session_status() === PHP_SESSION_NONE) {
    // Si no está activa, inicia la sesión
    session_start();
}

include 'db.php';

if (isset($_SESSION['ID_usuario'])) {
    $userID = $_SESSION['ID_usuario'];

    // Consulta para obtener los productos en el carrito del usuario
    $sql = "SELECT productos.nombre, carrito_compras.cantidad
            FROM productos
            JOIN carrito_compras ON productos.ID_producto = carrito_compras.ID_producto
            WHERE carrito_compras.ID_usuario = $userID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h2>Carrito de Compras</h2>';
        echo '<table>';
        echo '<tr><th>Producto</th><th>Cantidad</th></tr>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['nombre'] . '</td>';
            echo '<td>' . $row['cantidad'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>Tu carrito de compras está vacío.</p>';
    }
} else {
    echo '<p>Debes iniciar sesión para ver tu carrito.</p>';
}
?>

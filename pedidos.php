<?php
include 'db.php';
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
$es_admin = true;  // Debes tener tu lógica para verificar si el usuario es administrador

if (!$es_admin) {
    header("Location: index.php");  // Redirigir a la página principal si no es administrador
    exit();
}

// Lógica para manejar notificaciones de cambios de correo electrónico
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['notificar_cambios'])) {
    // Aquí debes implementar la lógica para manejar las notificaciones de cambios de correo electrónico
    $mensaje_notificacion = "Se ha solicitado un cambio de correo electrónico. Usuario: {usuario}, Nuevo Correo: {nuevo_correo}";
    // Enviar notificación al administrador o manejar según tus necesidades
    // ...
    mostrarAlerta("Notificación de Cambios", $mensaje_notificacion);
}

// Lógica para gestionar el catálogo (añadir, eliminar, modificar y consultar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (Código anterior para gestionar el catálogo)
}

// Lógica para consultar pedidos realizados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar_pedidos'])) {
    // Consultar pedidos en la base de datos
    $sql_pedidos = "SELECT * FROM pedidos";
    $result_pedidos = $conn->query($sql_pedidos);

    $pedidosRealizados = [];
    if ($result_pedidos->num_rows > 0) {
        while ($row_pedido = $result_pedidos->fetch_assoc()) {
            $id_pedido = $row_pedido['ID_pedido'];
            $id_usuario_pedido = $row_pedido['ID_usuario'];
            
            // Consultar detalles del pedido para cada pedido
            $sql_detalles = "SELECT productos.nombre, productos.precio, detalles_pedido.cantidad
                FROM detalles_pedido
                INNER JOIN productos ON detalles_pedido.ID_producto = productos.ID_producto
                WHERE detalles_pedido.ID_pedido = $id_pedido";

            $result_detalles = $conn->query($sql_detalles);

            $detallesPedido = [];
            if ($result_detalles->num_rows > 0) {
                while ($row_detalle = $result_detalles->fetch_assoc()) {
                    $detallesPedido[] = $row_detalle;
                }
            }

            // Agregar información del pedido y detalles al arreglo
            $pedidoActual = [
                'ID_pedido' => $id_pedido,
                'ID_usuario' => $id_usuario_pedido,
                'detalles' => $detallesPedido,
            ];

            $pedidosRealizados[] = $pedidoActual;
        }
    }
}

// Función para mostrar una alerta en JavaScript
function mostrarAlerta($titulo, $mensaje)
{
    echo "<script>alert('$titulo: $mensaje');</script>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav>
        <div class="container">
            <?php
            if ($es_admin) {
                // Mostrar opción de panel de administración si el usuario es administrador
                echo '<a href="admin_panel.php">Productos</a>';
                echo '<a href="pedidos.php">Pedidos</a>';
                echo '<a href="notificaciones.php">Notificaciones</a>';
            }

            if (isset($_SESSION['ID_administrador'])) {
                // Mostrar opciones adicionales si el usuario está autenticado
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="registro_login.php">Registro/Login</a>';
            }
            ?>
        </div>
    </nav>

    <div class="container">
        <!-- Consultar Pedidos Realizados -->
        <section>
            <h2>Consultar Pedidos Realizados</h2>
            <form method="post">
                <button type="submit" name="consultar_pedidos">Consultar Pedidos</button>
            </form>

            <!-- Contenido del área de consultas de pedidos -->
            <?php if (!empty($pedidosRealizados)) : ?>
                <h3>Pedidos Realizados:</h3>
                <ul>
                    <?php foreach ($pedidosRealizados as $pedido) : ?>
                        <li>
                            <strong>ID Pedido:</strong> <?php echo $pedido['ID_pedido']; ?><br>
                            <strong>ID Usuario:</strong> <?php echo $pedido['ID_usuario']; ?><br>
                            <strong>Detalles del Pedido:</strong>
                            <ul>
                                <?php foreach ($pedido['detalles'] as $detalle) : ?>
                                    <li><?php echo "{$detalle['nombre']} - {$detalle['cantidad']} unidades"; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No hay pedidos realizados.</p>
            <?php endif; ?>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Kai piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>

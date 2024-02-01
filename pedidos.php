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
    // Añadir producto al catálogo
    if (isset($_POST['añadir_producto'])) {
        $nombre_producto = isset($_POST['nombre_producto']) ? $_POST['nombre_producto'] : "";
        $cantidad_producto = isset($_POST['cantidad_producto']) ? $_POST['cantidad_producto'] : "";
        $fabricante_producto = isset($_POST['fabricante_producto']) ? $_POST['fabricante_producto'] : "";

        // Verificar si los campos numéricos no están vacíos
        if ($nombre_producto != "" && $cantidad_producto != "" && $fabricante_producto != "") {
            // Insertar nuevo producto en la base de datos
            $sql = "INSERT INTO productos (cantidad, nombre, fabricante) VALUES ('$cantidad_producto', '$nombre_producto', '$fabricante_producto')";

            if ($conn->query($sql) === TRUE) {
                // Éxito al añadir el producto
                mostrarAlerta("Añadir Producto", "Producto añadido exitosamente.");
            } else {
                // Error al añadir el producto
                mostrarAlerta("Añadir Producto", "Error al añadir el producto: " . $conn->error);
            }
        } else {
            mostrarAlerta("Añadir Producto", "Por favor, completa todos los campos antes de añadir el producto.");
        }
    }

    // Eliminar producto del catálogo
    if (isset($_POST['eliminar_producto'])) {
        $id_producto_eliminar = isset($_POST['id_producto_eliminar']) ? $_POST['id_producto_eliminar'] : "";

        // Verificar si el campo numérico no está vacío
        if ($id_producto_eliminar != "") {
            // Eliminar producto de la base de datos
            $sql = "DELETE FROM productos WHERE ID_producto='$id_producto_eliminar'";

            if ($conn->query($sql) === TRUE) {
                // Éxito al eliminar el producto
                mostrarAlerta("Eliminar Producto", "Producto eliminado exitosamente.");
            } else {
                // Error al eliminar el producto
                mostrarAlerta("Eliminar Producto", "Error al eliminar el producto: " . $conn->error);
            }
        } else {
            mostrarAlerta("Eliminar Producto", "Por favor, ingresa el ID del producto antes de intentar eliminarlo.");
        }
    }

    // Modificar producto en el catálogo
    if (isset($_POST['modificar_producto'])) {
        $id_producto_modificar = isset($_POST['id_producto_modificar']) ? $_POST['id_producto_modificar'] : "";
        $nuevo_nombre_producto = isset($_POST['nuevo_nombre_producto']) ? $_POST['nuevo_nombre_producto'] : "";
        $nueva_cantidad_producto = isset($_POST['nueva_cantidad_producto']) ? $_POST['nueva_cantidad_producto'] : "";
        $nuevo_fabricante_producto = isset($_POST['nuevo_fabricante_producto']) ? $_POST['nuevo_fabricante_producto'] : "";

        // Verificar si los campos numéricos no están vacíos
        if ($id_producto_modificar != "") {
            // Modificar producto en la base de datos
            $sql = "UPDATE productos SET nombre='$nuevo_nombre_producto', cantidad='$nueva_cantidad_producto', fabricante='$nuevo_fabricante_producto' WHERE ID_producto='$id_producto_modificar'";

            if ($conn->query($sql) === TRUE) {
                // Éxito al modificar el producto
                mostrarAlerta("Modificar Producto", "Producto modificado exitosamente.");
            } else {
                // Error al modificar el producto
                mostrarAlerta("Modificar Producto", "Error al modificar el producto: " . $conn->error);
            }
        } else {
            mostrarAlerta("Modificar Producto", "Por favor, ingresa el ID del producto antes de intentar modificarlo.");
        }
    }

    // Consultar productos en el catálogo
    if (isset($_POST['consultar_productos'])) {
        // Consultar productos en la base de datos
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        $productosEnCarrito = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productosEnCarrito[] = $row;
            }
        }
    } else {
    }
}


// Lógica para consultar pedidos realizados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar_pedidos'])) {
    // Aquí debes implementar la lógica para consultar pedidos realizados
    // Puedes hacer consultas a la base de datos y mostrar los resultados
    mostrarAlerta("Consultar Pedidos", "Aquí deberías mostrar la información de los pedidos realizados.");
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
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>
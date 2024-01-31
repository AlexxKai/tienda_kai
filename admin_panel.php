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

        if ($result->num_rows > 0) {
            // Mostrar resultados de la consulta
            $productos_consultados = "";
            while ($row = $result->fetch_assoc()) {
                $productos_consultados .= "ID: " . $row["ID_producto"] . " - Nombre: " . $row["nombre"] . " - Cantidad: " . $row["cantidad"] . " - Fabricante: " . $row["fabricante"] . "\n";
            }
            mostrarAlerta("Consultar Productos", $productos_consultados);
        } else {
            mostrarAlerta("Consultar Productos", "No hay productos en el catálogo.");
        }
    }
}

// Lógica para consultar pedidos realizados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar_pedidos'])) {
    // Aquí debes implementar la lógica para consultar pedidos realizados
    // Puedes hacer consultas a la base de datos y mostrar los resultados
    // ...
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
                echo '<a href="admin_panel.php">Panel de Administración</a>';
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
        <h1>Panel de Administración</h1>

        <!-- Área de Notificaciones -->
        <section>
            <h2>Notificaciones</h2>

            <!-- Formulario para notificar cambios de correo electrónico -->
            <form method="post">
                <button type="submit" name="notificar_cambios">Notificar Cambios</button>
            </form>

            <!-- Contenido del área de notificaciones -->
            <?php
            // Consultar notificaciones no leídas
            $sql = "SELECT * FROM notificaciones WHERE estado = 'no leída'";
            $result = $conn->query($sql);

            // Mostrar notificaciones en el panel de administración
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="notification">';
                    echo '<p>Nueva solicitud de cambio de correo electrónico para el usuario ID ' . $row['ID_usuario'] . '</p>';
                    echo '<p>Nuevo correo: ' . $row['nuevo_correo'] . '</p>';
                    // Agregar opciones para gestionar la notificación (marcar como leída, aprobar, rechazar, etc.)
                    echo '</div>';
                }
            } else {
                echo '<p>No hay nuevas notificaciones.</p>';
            }
            ?>
        </section>


        <!-- Gestión del Catálogo -->
        <section>
            <h2>Gestión del Catálogo</h2>

            <!-- Añadir Producto -->
            <form method="post">
                <h3>Añadir Producto</h3>
                <label for="nombre_producto">Nombre del Producto:</label>
                <input type="text" name="nombre_producto" required>

                <label for="cantidad_producto">Cantidad:</label>
                <input type="number" name="cantidad_producto" required>

                <label for="fabricante_producto">Fabricante:</label>
                <input type="text" name="fabricante_producto">

                <button type="submit" name="añadir_producto">Añadir Producto</button>
            </form>

            <!-- Eliminar Producto -->
            <form method="post">
                <h3>Eliminar Producto</h3>
                <label for="id_producto_eliminar">ID del Producto:</label>
                <input type="number" name="id_producto_eliminar" required>

                <button type="submit" name="eliminar_producto">Eliminar Producto</button>
            </form>

            <!-- Modificar Producto -->
            <form method="post">
                <h3>Modificar Producto</h3>
                <label for="id_producto_modificar">ID del Producto:</label>
                <input type="number" name="id_producto_modificar" required>

                <label for="nuevo_nombre_producto">Nuevo Nombre:</label>
                <input type="text" name="nuevo_nombre_producto">

                <label for="nueva_cantidad_producto">Nueva Cantidad:</label>
                <input type="number" name="nueva_cantidad_producto">

                <label for="nuevo_fabricante_producto">Nuevo Fabricante:</label>
                <input type="text" name="nuevo_fabricante_producto">

                <button type="submit" name="modificar_producto">Modificar Producto</button>
            </form>

            <!-- Consultar Productos -->
            <form method="post">
                <h3>Consultar Productos</h3>
                <button type="submit" name="consultar_productos">Consultar Productos</button>
            </form>

            <!-- Contenido del área de gestión del catálogo -->
        </section>

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
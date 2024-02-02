<?php
include 'db.php';
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
$es_admin = true;  // Debes tener tu lógica para verificar si el usuario es administrador

if (!$es_admin) {
    header("Location: index.php");  // Redirigir a la página principal si no es administrador
    exit();
}

// Lógica para gestionar el catálogo (añadir, eliminar, modificar y consultar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Añadir producto al catálogo
    if (isset($_POST['añadir_producto'])) {
        $nombre_producto = isset($_POST['nombre_producto']) ? $_POST['nombre_producto'] : "";
        $cantidad_producto = isset($_POST['cantidad_producto']) ? $_POST['cantidad_producto'] : "";
        $fabricante_producto = isset($_POST['fabricante_producto']) ? $_POST['fabricante_producto'] : "";
        $precio_producto = isset($_POST['precio_producto']) ? $_POST['precio_producto'] : "";

        // Verificar si los campos numéricos no están vacíos
        if ($nombre_producto != "" && $cantidad_producto != "" && $fabricante_producto != "" && $precio_producto != "") {
            // Insertar nuevo producto en la base de datos
            $sql = "INSERT INTO productos (cantidad, nombre, fabricante, precio) VALUES ('$cantidad_producto', '$nombre_producto', '$fabricante_producto', '$precio_producto')";

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
        $nuevo_precio_producto = isset($_POST['nuevo_precio_producto']) ? $_POST['nuevo_precio_producto'] : "";

        // Verificar si los campos numéricos no están vacíos
        if ($id_producto_modificar != "") {
            // Modificar producto en la base de datos
            $sql = "UPDATE productos SET nombre='$nuevo_nombre_producto', cantidad='$nueva_cantidad_producto', fabricante='$nuevo_fabricante_producto', precio='$nuevo_precio_producto' WHERE ID_producto='$id_producto_modificar'";

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

    <!-- Gestión del Catálogo -->

    <div class="container">
        <h1>Gestión del Catálogo</h1>
        <section>
            <!-- Consultar Productos -->
            <form method="post">
                <h3>Catálogo</h3>
                <button type="submit" name="consultar_productos">Actualizar catálogo</button>
            </form>

            <!-- Contenido del área de gestión del catálogo -->
            <div class="container">
                <?php if (!empty($productosEnCarrito)) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID_producto</th>
                                <th>Producto</th>
                                <th>Fabricante</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productosEnCarrito as $producto) : ?>
                                <tr>
                                    <td><?php echo $producto['ID_producto']; ?></td>
                                    <td><?php echo $producto['nombre']; ?></td>
                                    <td><?php echo $producto['fabricante']; ?></td>
                                    <td><?php echo $producto['cantidad']; ?></td>
                                    <td><?php echo $producto['precio'] . '€'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <!-- Formulario para gestionar el catálogo -->
            <div class="container">
                <h1>Selecciona el Tipo de Formulario</h1>

                <label for="tipo_formulario">Tipo de Formulario:</label>
                <select id="tipo_formulario" onchange="mostrarFormulario()">
                    <option value="#">Selecciona:</option>
                    <option value="formulario1">Añadir producto</option>
                    <option value="formulario2">Eliminar producto</option>
                    <option value="formulario3">Modificar producto</option>

                </select>
                <!-- Añadir Producto -->
                <div id="formulario1" style="display: none;">
                    <form method="post">
                        <h3>Añadir Producto</h3>
                        <label for="nombre_producto">Nombre del Producto:</label>
                        <input type="text" name="nombre_producto" required>

                        <label for="cantidad_producto">Cantidad:</label>
                        <input type="number" name="cantidad_producto" required>

                        <label for="fabricante_producto">Fabricante:</label>
                        <input type="text" name="fabricante_producto">

                        <label for="precio_producto">Precio:</label>
                        <input type="text" name="precio_producto">

                        <button type="submit" name="añadir_producto">Añadir Producto</button>
                    </form>
                </div>


                <!-- Eliminar Producto -->
                <div id="formulario2" style="display: none;">
                    <form method="post">
                        <h3>Eliminar Producto</h3>
                        <label for="id_producto_eliminar">ID del Producto:</label>
                        <input type="number" name="id_producto_eliminar" required>

                        <button type="submit" name="eliminar_producto">Eliminar Producto</button>
                    </form>
                </div>

                <!-- Modificar Producto -->
                <div id="formulario3" style="display: none;">
                    <form method="post">
                        <h3>Modificar Producto</h3>
                        <label for="id_producto_modificar">ID del Producto:</label>
                        <input type="number" name="id_producto_modificar" required>

                        <label for="nuevo_nombre_producto">Nuevo nombre:</label>
                        <input type="text" name="nuevo_nombre_producto">

                        <label for="nueva_cantidad_producto">Nueva cantidad:</label>
                        <input type="number" name="nueva_cantidad_producto">

                        <label for="nuevo_fabricante_producto">Nuevo fabricante:</label>
                        <input type="text" name="nuevo_fabricante_producto">

                        <label for="nuevo_precio_producto">Nuevo precio:</label>
                        <input type="text" name="nuevo_precio_producto">

                        <button type="submit" name="modificar_producto">Modificar Producto</button>
                    </form>
                </div>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Tienda de Piercing. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function mostrarFormulario() {
            // Obtén el valor seleccionado en el elemento select
            var tipoFormulario = document.getElementById("tipo_formulario").value;

            // Oculta todos los formularios
            var formularios = document.querySelectorAll('[id^="formulario"]');
            formularios.forEach(function(formulario) {
                formulario.style.display = "none";
            });

            // Muestra el formulario seleccionado
            document.getElementById(tipoFormulario).style.display = "block";
        }
    </script>

</body>

</html>
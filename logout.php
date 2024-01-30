<?php
session_start();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio u otra página después de cerrar sesión
header("Location: index.php");
exit();

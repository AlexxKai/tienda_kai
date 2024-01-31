<!-- Mostrar Notificaciones en el Panel de Administración:
En el panel de administración (admin_panel.php), agrega una sección para gestionar las notificaciones. Puedes consultar la tabla notificaciones y mostrar las notificaciones pendientes.

php
Copy code -->
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


<!-- Gestión de Notificaciones:
Agrega opciones en el panel de administración para gestionar las notificaciones. Por ejemplo, podrías tener botones para marcar una notificación como leída, aprobar el cambio de correo o rechazar la solicitud.

php
Copy code -->
// Agregar botones y lógica para gestionar notificaciones
echo '<button onclick="markAsRead(' . $row['ID_notificacion'] . ')">Marcar como Leída</button>';
echo '<button onclick="approveEmailChange(' . $row['ID_notificacion'] . ')">Aprobar Cambio de Correo</button>';
echo '<button onclick="rejectEmailChange(' . $row['ID_notificacion'] . ')">Rechazar Cam


<!-- Lógica JavaScript (Ajax):
Implementa funciones JavaScript (puedes utilizar Ajax) para manejar las acciones de los botones en el panel de administración.

javascript
Copy code -->
function markAsRead(notificationID) {
    // Implementa la lógica para marcar la notificación como leída (actualizar en la base de datos)
    // Puedes usar Ajax para enviar la información al servidor
}

function approveEmailChange(notificationID) {
    // Implementa la lógica para aprobar el cambio de correo electrónico
    // Puedes usar Ajax para enviar la información al servidor
}

function rejectEmailChange(notificationID) {
    // Implementa la lógica para rechazar el cambio de correo electrónico
    // Puedes usar Ajax para enviar la información al servidor
}
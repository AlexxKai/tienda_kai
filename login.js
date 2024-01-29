const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

// Función para enviar los datos del formulario por Ajax (simulado)
function sendData(formData, endpoint) {
    // Aquí iría tu lógica para enviar los datos al servidor
    // Puedes usar Fetch API o XMLHttpRequest para hacer una petición al servidor
    console.log('Enviando datos al servidor:', formData);
    // Simulación de petición de envío de datos
    setTimeout(() => {
        console.log('Datos enviados correctamente.');
        // Simulación de redirección después del envío de datos
        window.location.href = endpoint;
    }, 1500); // Simula un tiempo de espera de 1.5 segundos
}

// Manejo del envío del formulario de inicio de sesión
document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar el envío por defecto del formulario

    const formData = new FormData(this);
    sendData(formData, '/login'); // Envia los datos al servidor (simulado)
});

// Manejo del envío del formulario de registro
document.getElementById('registerForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar el envío por defecto del formulario

    const formData = new FormData(this);
    sendData(formData, '/register'); // Envia los datos al servidor (simulado)
});
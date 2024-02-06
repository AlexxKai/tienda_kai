        // Función para inicializar el mapa
        function initMap() {
            // Coordenadas de ejemplo (puedes cambiarlas según tu ubicación)
            var myLatLng = [34.094103594220414, -118.34434531553923];

            // Crear un nuevo mapa en el contenedor especificado
            var map = L.map('leaflet-map').setView(myLatLng, 15);

            // proveedor de mapas OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // crear marcador
            L.marker(myLatLng).addTo(map)
                .bindPopup('Kai piercing<br>Los Angeles, CA 90012<br>Estados Unidos')
                .openPopup();
        }

        // llama a la función initMap después de cargar la página
        document.addEventListener('DOMContentLoaded', initMap);

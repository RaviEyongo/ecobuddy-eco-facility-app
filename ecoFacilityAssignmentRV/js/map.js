const map = L.map('mapDiv').setView([53.4808, -2.2426], 13);  //Initialize the map on Manchester

// Initialize OpenStreetMap tiles for the map's background
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Fetch facilities from backend usin AJAX
async function fetchFacilities(){
    const response = await fetch('fetchFacilities.php');
    return response.json();
}

// Validate latitude & longitude
function isValidLatLng(lat, lng){
    return isFinite(lat) && isFinite(lng) && Math.abs(lat) <= 90 && Math.abs(lng) <= 180;
}

// Add markers dynamically to map
async function displayFacilitiesOnMap(){
    const facilities = await fetchFacilities();

    facilities.forEach(facility => {
        // Check if the latitude and longitude are valid
        if(isValidLatLng(facility.latitude, facility.longitude)){
            //Add a marker to the map at the facility's coordinates with a popup too when clicked
            L.marker([facility.latitude, facility.longitude])
                .addTo(map)
                .bindPopup(`📍<b>${facility.name}</b>`);
        }
    });
}

// Current user's location
map.locate({setView: true, maxZoom: 15});

// Handle the error if the user's location cannot be determined
map.on('locationerror', (e) => alert(`Could not get your location: ${e.message}`));

// When the user's location is found, add a marker at their location with a popup saying "📍Your location!"
map.on('locationfound', (e) => L.marker(e.latlng).addTo(map).bindPopup('📍Your location!'));

// Initialize
displayFacilitiesOnMap();
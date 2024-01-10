<!DOCTYPE html>
<html>
<head>
<title>Geolocation Example</title>
<script>
    function geocodeLatLng(lat, lng) {
        var url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data && data.address) {
                    var address = data.display_name;
                    document.getElementById("location").textContent = `Address: ${address}`;
                    document.getElementById("latitude").textContent = `Latitude: ${lat}`;
                    document.getElementById("longitude").textContent = `Longitude: ${lng}`;
                } else {
                    document.getElementById("location").textContent = 'No results found';
                    document.getElementById("latitude").textContent = '';
                    document.getElementById("longitude").textContent = '';
                }
            })
            .catch(error => {
                console.log('Geocoding failed due to:', error);
            });
    }

    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    geocodeLatLng(latitude, longitude);
                },
                error => {
                    console.log('Geolocation error:', error);
                }
            );
        } else {
            console.log('Geolocation is not supported by this browser.');
        }
    }

    // Usage example
    getCurrentLocation();
</script>
</head>
<body>
<h1>Geolocation Example</h1>
<p id="location"></p>
<p id="latitude"></p>
<p id="longitude"></p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Geofencing Example</title>
    <style>
        #status {
        font-weight: bold;
        }
    </style>
    </head>
    <body>
    <h1>Geofencing Example</h1>
    <div id="status">Waiting for user's location...</div>
    <div id="currentLongitude"></div>
    <div id="currentLatitude"></div>

    <script>
        // Obtain the user's location
        if (navigator.geolocation) {
        navigator.geolocation.watchPosition(success, error);
        } else {
        document.getElementById('status').textContent = 'Geolocation is not supported by this browser.';
        }

        function success(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        document.getElementById('currentLongitude').textContent = 'Longitude: ' + longitude;
        document.getElementById('currentLatitude').textContent = 'Latitude: ' + latitude;
        checkGeofence(latitude, longitude);
        }

        function error() {
        document.getElementById('status').textContent = 'Unable to retrieve the user\'s location.';
        }

        // Define geofence boundaries
        const geofence = {
        latitude: 14.6116487,
        longitude: 121.0449656,
        radius: 100 // in meters
        };

        // Check geofence crossing
        function checkGeofence(latitude, longitude) {
        const distance = getDistance(latitude, longitude, geofence.latitude, geofence.longitude);
        if (distance <= geofence.radius) {
            document.getElementById('status').textContent = 'User is inside the geofenced area.';
            // Perform desired actions here
        } else {
            document.getElementById('status').textContent = 'User is outside the geofenced area.';
        }
        }

        function getDistance(lat1, lon1, lat2, lon2) {
  const earthRadius = 6371; // Earth's radius in kilometers

  // Convert latitude and longitude values from degrees to radians
    const lat1Rad = toRadians(lat1);
    const lon1Rad = toRadians(lon1);
    const lat2Rad = toRadians(lat2);
    const lon2Rad = toRadians(lon2);

    // Calculate the differences between the latitudes and longitudes
    const latDiff = lat2Rad - lat1Rad;
    const lonDiff = lon2Rad - lon1Rad;

  // Apply the Haversine formula
  const a = Math.sin(latDiff / 2) * Math.sin(latDiff / 2) +
            Math.cos(lat1Rad) * Math.cos(lat2Rad) *
            Math.sin(lonDiff / 2) * Math.sin(lonDiff / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  const distance = earthRadius * c;

  return distance * 1000; // Convert distance to meters
}

function toRadians(degrees) {
  return degrees * (Math.PI / 180);
}

    </script>
</body>
</html>

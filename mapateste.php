<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Display a map</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <script>
        // TO MAKE THE MAP APPEAR YOU MUST
        // ADD YOUR ACCESS TOKEN FROM
        // https://account.mapbox.com
        mapboxgl.accessToken = 'pk.eyJ1IjoiaXZhbmlsZG9lZSIsImEiOiJja2hmYWwxcWkwYWptMnhwYzk2c3lmNWJxIn0.MG7-GSqPrk3JCepjLMSB9Q';
        var map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [-23.664849, 15.882756], // starting position [lng, lat]
            zoom: 7 // starting zoom
        });
        var marker = new mapboxgl.Marker()
            .setLngLat([-23.664849, 15.882756])
            .addTo(map)
    </script>

</body>

</html>
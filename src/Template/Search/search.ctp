<link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1/leaflet.css" />
<script src="https://cdn.jsdelivr.net/leaflet/1/leaflet.js"></script>

<div id="map-example-container"></div>
<input type="search" id="input-map" class="form-control" placeholder="Where are we going?" />

<style>
    #map-example-container {height: 300px};
</style>

<script src="https://cdn.jsdelivr.net/npm/places.js@1.4.15"></script>
<script>
    (function() {
        var latlng = {
            lat: 40.7116,
            lng: -74.0648
        };

        var placesAutoComplete = places({
            container: document.querySelector('#input-map')
        });

        var map = L.map('map-example-container', {
            scrollWheelZoom: false,
            zoomControl: false
        });

        var osmLayer = new L.TileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                minZoom: 1,
                maxZoom: 13,
                attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
            }
        );

        var markers = [];

        map.setView(new L.LatLng(0, 0), 1);
        map.addLayer(osmLayer);

        placesAutoComplete.on('suggestions', handleOnSuggestions);
        placesAutoComplete.on('cursorchanged', handleOnCursorchanged);
        placesAutoComplete.on('change', handleOnChange);
        placesAutoComplete.on('clear', handleOnClear);

        function handleOnSuggestions(e) {
            markers.forEach(removeMarker);
            markers = [];

            if (e.suggestions.length === 0) {
                map.setView(new L.LatLng(0, 0), 1);
                return;
            }

            e.suggestions.forEach(addMarker);
            findBestZoom();
        }

        function handleOnChange(e) {
            markers
                .forEach(function(marker, markerIndex) {
                    if (markerIndex === e.suggestionIndex) {
                        markers = [marker];
                        marker.setOpacity(1);
                        findBestZoom();
                    } else {
                        removeMarker(marker);
                    }
                });
        }

        function handleOnClear() {
            map.setView(new L.LatLng(0, 0), 1);
            markers.forEach(removeMarker);
        }

        function handleOnCursorchanged(e) {
            markers
                .forEach(function(marker, markerIndex) {
                    if (markerIndex === e.suggestionIndex) {
                        marker.setOpacity(1);
                        marker.setZIndexOffset(1000);
                    } else {
                        marker.setZIndexOffset(0);
                        marker.setOpacity(0.5);
                    }
                });
        }

        function addMarker(suggestion) {
            var marker = L.marker(suggestion.latlng, {opacity: .4});
            marker.addTo(map);
            markers.push(marker);
        }

        function removeMarker(marker) {
            map.removeLayer(marker);
        }

        function findBestZoom() {
            var featureGroup = L.featureGroup(markers);
            map.fitBounds(featureGroup.getBounds().pad(0.5), {animate: false});
        }
    })();
</script>

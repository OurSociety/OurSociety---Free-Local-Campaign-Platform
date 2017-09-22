<link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js" integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log==" crossorigin=""></script>
<style>
    .map {
        /*width: 300px;*/
        height: 170px;
    }
</style>
<script>
    drawMap = function(id, municipalityData, zipData) {
        var map = L.map(id, { attributionControl: false }).setView([40.0583, -74.4057], 6);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: '',
            //attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
            //'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            //'Imagery © <a href="http://mapbox.com">Mapbox</a>',
            id: 'mapbox.light'
        }).addTo(map);

        if (municipalityData) {
            var municipalityLayer = L.geoJSON(municipalityData);
            municipalityLayer.addTo(map);
            map.fitBounds(municipalityLayer.getBounds());
        }

        if (zipData) {
            var zipLayer = L.geoJSON(zipData, {style:  {
                "color": "#ff7800",
                "weight": 5,
                "opacity": 0.65
            }});
            zipLayer.addTo(map);
            //if (!municipalityData) {
            map.fitBounds(zipLayer.getBounds());
            //}
        }
    };
</script>

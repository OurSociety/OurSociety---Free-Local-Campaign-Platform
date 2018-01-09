<script>
    import Vue2Leaflet from 'vue2-leaflet';
    import geojsonExtent from 'geojson-extent';

    export default {
        props: {
            polygon: {
                type: Object,
                required: true
            },
        },
        components: {
            'v-map': Vue2Leaflet.Map,
            'v-tilelayer': Vue2Leaflet.TileLayer,
            'v-geojson': Vue2Leaflet.GeoJSON,
        },
        data() {
            const extent = geojsonExtent(this.polygon);
            const bounds = L.latLngBounds(
                L.latLng(extent[2], extent[3]),
                L.latLng(extent[0], extent[1]),
            );
            const center = [
                (extent[1] + extent[3]) / 2,
                (extent[2] + extent[0]) / 2,
            ]

            return {
                mapOptions: {
                    bounds: bounds,
                    center: center,
                    zoomControl: false,
                    zoom: 7,
                },
                // tileLayerUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                tileLayerUrl: 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
                tileLayerOptions: {
                    maxZoom: 18,
                    attribution: `
                        Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors,
                        <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>,
                        Imagery © <a href="http://mapbox.com">Mapbox</a>
                    `,
                    id: 'mapbox.light'
                },
                geojsonGeojson: this.polygon,
                geojsonOptions: {
                    style: {
                        color: '#871898',
                    },
                },
            };
        }
    }
</script>

<template>
    <div class="card-img-top map pull-right" style="height:100px">
        <v-map :options="mapOptions">
            <v-tilelayer :url="tileLayerUrl" :options="tileLayerOptions"></v-tilelayer>
            <v-geojson :geojson="geojsonGeojson" :options="geojsonOptions"></v-geojson>
        </v-map>
    </div>
</template>

<style type="scss">
    @import "~leaflet/dist/leaflet.css";

    .leaflet-control-attribution {
        display: none;
    }
</style>
